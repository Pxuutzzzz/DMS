<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Document;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $documents = Document::with(['category', 'creator'])
            ->archived()
            ->when($request->search, fn($q, $s) => $q->search($s))
            ->orderBy('archived_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('archives.index', compact('documents'));
    }

    public function restore(Document $document)
    {
        $this->authorize('update', $document);

        $document->update([
            'status' => Document::STATUS_APPROVED,
            'archived_at' => null,
        ]);

        AuditLog::log(
            'document_restored',
            "Dokumen '{$document->name}' dikembalikan dari arsip.",
            Document::class,
            $document->id,
        );

        return back()->with('success', 'Dokumen berhasil dikembalikan dari arsip.');
    }
}
