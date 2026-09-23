<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isUser()) {
            return redirect()->route('search.index');
        }
        $stats = [
            'total' => Document::count(),
            'pending_review' => Document::whereIn('status', [Document::STATUS_SUBMITTED, Document::STATUS_REVIEW])->count(),
            'approved' => Document::where('status', Document::STATUS_APPROVED)->count(),
            'archived' => Document::where('status', Document::STATUS_ARCHIVED)->count(),
        ];

        $recentDocuments = Document::with(['category', 'creator'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $statusFlow = [
            ['key' => 'draft', 'label' => 'Draft', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'color' => 'gray'],
            ['key' => 'submitted', 'label' => 'Diajukan', 'icon' => 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8', 'color' => 'yellow'],
            ['key' => 'review', 'label' => 'Direview', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'color' => 'blue'],
            ['key' => 'revision', 'label' => 'Revisi', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', 'color' => 'red'],
            ['key' => 'approved', 'label' => 'Disetujui', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'green'],
            ['key' => 'archived', 'label' => 'Arsip', 'icon' => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4', 'color' => 'purple'],
        ];

        return view('dashboard', compact('stats', 'recentDocuments', 'statusFlow'));
    }
}
