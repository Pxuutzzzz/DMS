<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Audit Trail</h2>
            <p class="text-sm text-gray-500 mt-1">Log sistem lengkap untuk pemantauan aktivitas.</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="{{ route('audit-logs.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <div class="lg:col-span-2">
                <label class="block text-xs font-medium text-gray-700 mb-1">Cari Deskripsi/Aksi</label>
                <input type="text" name="search" value="{{ request('search') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Kata kunci...">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Pengguna</label>
                <select name="user_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Semua Pengguna</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Aksi</label>
                <select name="action" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Semua Aksi</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>{{ $action }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="w-full px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Filter Log
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-40">Waktu</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-48">Pengguna</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-40">Aksi (Sistem)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Deskripsi & Perubahan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50 transition-colors align-top">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $log->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500 font-mono mt-0.5">{{ $log->created_at->format('H:i:s') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $log->user ? $log->user->name : 'Sistem' }}</div>
                            <div class="text-[10px] text-gray-400 mt-1 font-mono" title="IP: {{ $log->ip_address }}">{{ $log->ip_address }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-gray-100 text-gray-800 font-mono tracking-tighter">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $log->description }}</div>
                            
                            @if($log->old_values || $log->new_values)
                            <div class="mt-2 text-xs bg-gray-50 border border-gray-200 rounded p-3 overflow-x-auto" x-data="{ expanded: false }">
                                <button @click="expanded = !expanded" type="button" class="text-blue-600 hover:text-blue-800 font-medium flex items-center mb-1">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                    Lihat Data Teknis
                                </button>
                                <div x-show="expanded" class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @if($log->old_values)
                                    <div>
                                        <div class="font-bold text-gray-500 mb-1">Nilai Lama:</div>
                                        <pre class="text-[10px] text-gray-700 bg-white p-2 rounded border border-gray-100">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                    @endif
                                    @if($log->new_values)
                                    <div>
                                        <div class="font-bold text-gray-500 mb-1">Nilai Baru:</div>
                                        <pre class="text-[10px] text-gray-700 bg-white p-2 rounded border border-gray-100">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">
                            Tidak ada log aktivitas yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $logs->links() }}
        </div>
        @endif
    </div>

</x-app-layout>
