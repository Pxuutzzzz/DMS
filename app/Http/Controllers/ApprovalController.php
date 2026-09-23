<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Document;
use App\Models\DocumentApproval;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'pending');

        $query = Document::with(['category', 'creator']);

        if ($tab === 'revision') {
            $query->where('status', Document::STATUS_REVISION);
        } elseif ($tab === 'approved') {
            $query->where('status', Document::STATUS_APPROVED);
        } else {
            $query->whereIn('status', [Document::STATUS_SUBMITTED, Document::STATUS_REVIEW]);
        }

        $documents = $query->orderBy('updated_at', 'desc')->paginate(15)->withQueryString();

        return view('approvals.index', compact('documents', 'tab'));
    }

    public function approve(Request $request, Document $document)
    {
        $request->validate([
            'notes' => 'nullable|string|max:2000',
        ]);

        $document->update([
            'status' => Document::STATUS_APPROVED,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        DocumentApproval::create([
            'document_id' => $document->id,
            'user_id' => auth()->id(),
            'status' => 'approved',
            'notes' => $request->notes,
        ]);

        AuditLog::log(
            'document_approved',
            "Dokumen '{$document->name}' disetujui oleh " . auth()->user()->name . ".",
            Document::class,
            $document->id,
        );

        return back()->with('success', 'Dokumen berhasil disetujui.');
    }

    public function requestRevision(Request $request, Document $document)
    {
        $request->validate([
            'notes' => 'required|string|max:2000',
        ]);

        $document->update([
            'status' => Document::STATUS_REVISION,
        ]);

        DocumentApproval::create([
            'document_id' => $document->id,
            'user_id' => auth()->id(),
            'status' => 'revision',
            'notes' => $request->notes,
        ]);

        AuditLog::log(
            'document_revision_requested',
            "Dokumen '{$document->name}' diminta revisi oleh " . auth()->user()->name . ". Catatan: {$request->notes}",
            Document::class,
            $document->id,
        );

        return back()->with('success', 'Permintaan revisi berhasil dikirim.');
    }

    public function review(Document $document)
    {
        $document->update(['status' => Document::STATUS_REVIEW]);

        DocumentApproval::create([
            'document_id' => $document->id,
            'user_id' => auth()->id(),
            'status' => 'review',
            'notes' => 'Dokumen sedang direview.',
        ]);

        AuditLog::log(
            'document_review_started',
            "Review dokumen '{$document->name}' dimulai oleh " . auth()->user()->name . ".",
            Document::class,
            $document->id,
        );

        return back()->with('success', 'Dokumen sedang direview.');
    }
}
