<aside class="w-64 bg-[#0f172a] text-white flex flex-col hidden md:flex shrink-0">
    <!-- Logo & Title -->
    <div class="h-16 flex items-center px-6 bg-[#0B1121] border-b border-gray-800">
        <div class="w-8 h-8 rounded bg-blue-500 flex items-center justify-center mr-3 text-white font-bold text-xl shadow-md">
            S
        </div>
        <div>
            <h1 class="text-lg font-bold leading-tight tracking-wide text-gray-100">SIMDOK PSTI</h1>
            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold">Sistem Manajemen Dokumen</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1 px-3">
            @if(!auth()->user()->isUser())
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-600/20 text-blue-400 font-medium' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-blue-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('documents.index') }}" class="flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('documents.*') ? 'bg-blue-600/20 text-blue-400 font-medium' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('documents.*') ? 'text-blue-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Manajemen Dokumen
                </a>
            </li>
            @endif

            <li>
                <a href="{{ route('search.index') }}" class="flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('search.index') ? 'bg-blue-600/20 text-blue-400 font-medium' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('search.index') ? 'text-blue-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Pencarian Dokumen
                </a>
            </li>

            @if(auth()->user()->canManageCategories())
            <li>
                <a href="{{ route('categories.index') }}" class="flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('categories.*') ? 'bg-blue-600/20 text-blue-400 font-medium' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('categories.*') ? 'text-blue-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Kategori
                </a>
            </li>
            @endif

            @if(auth()->user()->canApproveDocuments())
            <li>
                <a href="{{ route('approvals.index') }}" class="flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('approvals.*') ? 'bg-blue-600/20 text-blue-400 font-medium' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('approvals.*') ? 'text-blue-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Approval
                    @php
                        $pendingCount = \App\Models\Document::whereIn('status', [\App\Models\Document::STATUS_SUBMITTED, \App\Models\Document::STATUS_REVIEW])->count();
                    @endphp
                    @if($pendingCount > 0)
                    <span class="ml-auto bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>
            </li>
            @endif

            @if(auth()->user()->isAdmin())
            <li>
                <a href="{{ route('archives.index') }}" class="flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('archives.*') ? 'bg-blue-600/20 text-blue-400 font-medium' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('archives.*') ? 'text-blue-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    Arsip
                </a>
            </li>
            @endif

            @if(auth()->user()->canManageUsers())
            <li>
                <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('users.*') ? 'bg-blue-600/20 text-blue-400 font-medium' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('users.*') ? 'text-blue-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Pengguna
                </a>
            </li>
            @endif

            @if(!auth()->user()->isUser())
            <li>
                <a href="{{ route('reports.index') }}" class="flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('reports.*') ? 'bg-blue-600/20 text-blue-400 font-medium' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('reports.*') ? 'text-blue-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan
                </a>
            </li>
            @endif

            @if(auth()->user()->canViewAuditTrail())
            <li>
                <a href="{{ route('audit-logs.index') }}" class="flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('audit-logs.*') ? 'bg-blue-600/20 text-blue-400 font-medium' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('audit-logs.*') ? 'text-blue-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Audit Trail
                </a>
            </li>
            @endif
        </ul>
    </nav>

    <!-- Footer Sidebar -->
    <div class="p-4 border-t border-gray-800 bg-[#0B1121] text-center">
        <div class="text-xs text-gray-400 mb-1">
            <span class="font-semibold text-blue-400">Dokumen Tertata</span><br>
            Akademik Berkualitas
        </div>
        <div class="text-[10px] text-gray-500 mt-2">
            SIMDOK PSTI v1.0.0
        </div>
    </div>
</aside>
