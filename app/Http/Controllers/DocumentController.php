<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Document;
use App\Models\DocumentVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        $documents = Document::with(['category', 'creator'])
            ->active()
            ->when($request->search, fn($q, $s) => $q->search($s))
            ->filter($request->only([
                'category_id', 'academic_year', 'semester',
                'status', 'pic', 'department', 'date_from', 'date_to'
            ]))
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $academicYears = Document::distinct()->whereNotNull('academic_year')->pluck('academic_year')->sort()->values();

        return view('documents.index', compact('documents', 'categories', 'academicYears'));
    }

    public function create()
    {
        $this->authorize('upload', Document::class);

        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('upload', Document::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'document_number' => 'nullable|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'department' => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:20',
            'semester' => 'nullable|string|max:20',
            'course_name' => 'nullable|string|max:255',
            'pic' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
            'tags' => 'nullable|string',
            'document_date' => 'required|date',
            'upload_date' => 'required|date',
            'file' => 'required|file|max:20480|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,zip',
        ]);

        $file = $request->file('file');
        $originalFilename = $file->getClientOriginalName();
        $filePath = $file->store('documents/' . date('Y/m'), 'private');

        $tags = null;
        if (!empty($validated['tags'])) {
            $tags = array_map('trim', explode(',', $validated['tags']));
        }

        $document = Document::create([
            'uuid' => (string) Str::uuid(),
            'name' => $validated['name'],
            'document_number' => $validated['document_number'],
            'category_id' => $validated['category_id'],
            'department' => $validated['department'],
            'academic_year' => $validated['academic_year'],
            'semester' => $validated['semester'],
            'course_name' => $validated['course_name'],
            'pic' => $validated['pic'],
            'description' => $validated['description'],
            'tags' => $tags,
            'document_date' => $validated['document_date'],
            'upload_date' => $validated['upload_date'],
            'original_uploaded_at' => now(),
            'status' => Document::STATUS_DRAFT,
            'current_version' => 1,
            'created_by' => auth()->id(),
        ]);

        DocumentVersion::create([
            'document_id' => $document->id,
            'version_number' => 1,
            'file_path' => $filePath,
            'original_filename' => $originalFilename,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_by' => auth()->id(),
            'notes' => 'Upload awal',
        ]);

        AuditLog::log(
            'document_created',
            "Dokumen '{$document->name}' berhasil dibuat.",
            Document::class,
            $document->id,
        );

        return redirect()->route('documents.show', $document)
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function show(Document $document)
    {
        abort_if(auth()->guest() && $document->status !== Document::STATUS_APPROVED, 404);

        $document->load(['category', 'creator', 'approver', 'versions.uploader', 'approvals.user']);

        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $this->authorize('update', $document);

        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $auditLogs = AuditLog::where('model_type', Document::class)
            ->where('model_id', $document->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('documents.edit', compact('document', 'categories', 'auditLogs'));
    }

    public function update(Request $request, Document $document)
    {
        $this->authorize('update', $document);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'document_number' => 'nullable|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'department' => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:20',
            'semester' => 'nullable|string|max:20',
            'course_name' => 'nullable|string|max:255',
            'pic' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
            'tags' => 'nullable|string',
            'document_date' => 'required|date',
            'upload_date' => 'required|date',
            'status' => 'required|in:draft,submitted,review,revision,approved,archived',
        ]);

        $oldValues = $document->only(['name', 'document_number', 'category_id', 'upload_date', 'document_date', 'status']);

        // Check upload_date change - only admin/super_admin can edit
        if ($validated['upload_date'] !== $document->upload_date->format('Y-m-d')) {
            if (!auth()->user()->canEditUploadDate()) {
                return back()->with('error', 'Anda tidak memiliki izin untuk mengubah tanggal upload.');
            }

            AuditLog::log(
                'upload_date_changed',
                "Tanggal upload diubah dari {$document->upload_date->format('d F Y')} menjadi " . \Carbon\Carbon::parse($validated['upload_date'])->format('d F Y') . " oleh " . auth()->user()->name . ".",
                Document::class,
                $document->id,
                ['upload_date' => $document->upload_date->format('Y-m-d')],
                ['upload_date' => $validated['upload_date']],
            );
        }

        $tags = null;
        if (!empty($validated['tags'])) {
            $tags = array_map('trim', explode(',', $validated['tags']));
        }

        $document->update([
            'name' => $validated['name'],
            'document_number' => $validated['document_number'],
            'category_id' => $validated['category_id'],
            'department' => $validated['department'],
            'academic_year' => $validated['academic_year'],
            'semester' => $validated['semester'],
            'course_name' => $validated['course_name'],
            'pic' => $validated['pic'],
            'description' => $validated['description'],
            'tags' => $tags,
            'document_date' => $validated['document_date'],
            'upload_date' => $validated['upload_date'],
            'status' => $validated['status'],
        ]);

        AuditLog::log(
            'document_updated',
            "Dokumen '{$document->name}' diperbarui.",
            Document::class,
            $document->id,
            $oldValues,
            $document->only(['name', 'document_number', 'category_id', 'upload_date', 'document_date', 'status']),
        );

        return redirect()->route('documents.show', $document)
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);

        AuditLog::log(
            'document_deleted',
            "Dokumen '{$document->name}' dihapus.",
            Document::class,
            $document->id,
        );

        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    public function download(Document $document, ?DocumentVersion $version = null)
    {
        abort_if(auth()->guest() && $document->status !== Document::STATUS_APPROVED, 404);

        $ver = $version ?? $document->latestVersion;
        abort_unless($ver && $ver->document_id === $document->id, 404);

        if (!Storage::disk('private')->exists($ver->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        AuditLog::log(
            'document_downloaded',
            "Dokumen '{$document->name}' v{$ver->version_number} diunduh.",
            Document::class,
            $document->id,
        );

        return Storage::disk('private')->download($ver->file_path, $ver->original_filename);
    }

    public function uploadVersion(Request $request, Document $document)
    {
        $this->authorize('update', $document);

        $request->validate([
            'file' => 'required|file|max:20480|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,zip',
            'notes' => 'nullable|string|max:1000',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('documents/' . date('Y/m'), 'private');
        $newVersion = $document->current_version + 1;

        DocumentVersion::create([
            'document_id' => $document->id,
            'version_number' => $newVersion,
            'file_path' => $filePath,
            'original_filename' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_by' => auth()->id(),
            'notes' => $request->notes,
        ]);

        $document->update(['current_version' => $newVersion]);

        AuditLog::log(
            'version_uploaded',
            "Versi {$newVersion} dokumen '{$document->name}' diunggah.",
            Document::class,
            $document->id,
        );

        return back()->with('success', "Versi {$newVersion} berhasil diunggah.");
    }

    public function submit(Document $document)
    {
        if (!$document->isSubmittable()) {
            return back()->with('error', 'Dokumen tidak dapat diajukan.');
        }

        $document->update(['status' => Document::STATUS_SUBMITTED]);

        AuditLog::log(
            'document_submitted',
            "Dokumen '{$document->name}' diajukan untuk review.",
            Document::class,
            $document->id,
        );

        return back()->with('success', 'Dokumen berhasil diajukan untuk review.');
    }

    public function archive(Document $document)
    {
        $this->authorize('update', $document);

        $document->update([
            'status' => Document::STATUS_ARCHIVED,
            'archived_at' => now(),
        ]);

        AuditLog::log(
            'document_archived',
            "Dokumen '{$document->name}' diarsipkan.",
            Document::class,
            $document->id,
        );

        return back()->with('success', 'Dokumen berhasil diarsipkan.');
    }
}
