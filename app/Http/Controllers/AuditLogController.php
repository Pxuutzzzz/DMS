<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAuditLogs', \App\Models\User::class);

        $logs = AuditLog::with('user')
            ->when($request->search, function ($q, $s) {
                $q->where('description', 'like', "%{$s}%")
                  ->orWhere('action', 'like', "%{$s}%");
            })
            ->when($request->user_id, fn($q, $u) => $q->where('user_id', $u))
            ->when($request->action, fn($q, $a) => $q->where('action', $a))
            ->when($request->date_from, fn($q, $d) => $q->whereDate('created_at', '>=', $d))
            ->when($request->date_to, fn($q, $d) => $q->whereDate('created_at', '<=', $d))
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $users = \App\Models\User::orderBy('name')->get();
        $actions = AuditLog::distinct('action')->pluck('action')->sort();

        return view('audit-logs.index', compact('logs', 'users', 'actions'));
    }
}
