<x-app-layout>
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            Selamat Datang, {{ auth()->user()->name }}!
        </h2>
        <p class="text-gray-500 mt-1">Kelola dokumen dengan lebih mudah, aman, dan terstruktur.</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Dokumen</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</h3>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Menunggu Review</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $stats['pending_review'] }}</h3>
            </div>
        </div>

        <!-- Approved -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-lg bg-green-50 text-green-600 flex items-center justify-center mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Disetujui</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $stats['approved'] }}</h3>
            </div>
        </div>

        <!-- Archived -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Arsip</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $stats['archived'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Workflow section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8 overflow-x-auto">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Alur Proses Dokumen</h3>
        
        <div class="flex items-center min-w-max pb-4 px-2">
            @foreach($statusFlow as $index => $flow)
                <div class="flex flex-col items-center">
                    <div class="w-14 h-14 rounded-full bg-{{ $flow['color'] }}-100 text-{{ $flow['color'] }}-600 flex items-center justify-center mb-3 shadow-sm ring-4 ring-white z-10 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $flow['icon'] }}"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">{{ $flow['label'] }}</span>
                </div>
                
                @if(!$loop->last)
                <div class="w-16 h-1 bg-gray-200 mx-1 mb-8 relative">
                    <div class="absolute right-0 top-1/2 -mt-1 -mr-1 text-gray-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Recent Documents Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">Dokumen Terbaru</h3>
            <a href="{{ route('documents.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">Lihat Semua &rarr;</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Dokumen</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tahun</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Tanggal Dokumen</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Tanggal Upload</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($recentDocuments as $doc)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $doc->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $doc->document_number ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                {{ $doc->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $doc->academic_year ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-{{ $doc->status_color }}-50 text-{{ $doc->status_color }}-700 ring-1 ring-inset ring-{{ $doc->status_color }}-600/20">
                                {{ $doc->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                            {{ $doc->document_date->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden lg:table-cell">
                            {{ $doc->upload_date->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('documents.show', $doc) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-md transition-colors">Lihat</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Belum ada dokumen.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>
