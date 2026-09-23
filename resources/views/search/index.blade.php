<x-public-layout>
    <div class="max-w-7xl mx-auto">
        <!-- Hero Search Section -->
        <div class="bg-[#173b30] rounded-2xl p-7 sm:p-10 md:p-12 mb-8 shadow-lg relative overflow-hidden">
            <div class="relative z-10 max-w-3xl mx-auto">
            <p class="text-[#a9d8c1] text-sm font-semibold uppercase tracking-[0.18em] mb-3">Universitas 'Aisyiyah Yogyakarta</p>
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Portal Dokumen PSTI</h1>
            <p class="text-[#d5e9df] mb-8 text-base sm:text-lg">Temukan dokumen akademik dan informasi resmi yang telah dipublikasikan.</p>
                
                <form action="{{ route('search.index') }}" method="GET" class="relative">
                    <div class="flex flex-col sm:flex-row sm:items-center bg-white rounded-xl p-2 shadow-xl gap-2">
                        <div class="hidden sm:block pl-3 pr-1 text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau nomor dokumen..." class="w-full border-none focus:ring-0 text-gray-700 placeholder-gray-400 bg-transparent py-3 text-base" autofocus>
                        <select name="category" class="border border-gray-200 bg-gray-50 text-gray-600 rounded-lg py-2.5 pl-3 pr-8 focus:ring-0 text-sm">
                            <option value="">Semua Kategori</option>
                            @foreach(\App\Models\Category::where('is_active', true)->get() as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-[#00875a] hover:bg-[#006c48] text-white rounded-lg px-6 py-3 font-semibold transition-colors shadow-md whitespace-nowrap">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Results -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">
                    @if(request('q') || request('category'))
                        Hasil Pencarian ({{ $documents->total() }} ditemukan)
                    @else
                        Dokumen Terbaru
                    @endif
                </h2>
            </div>
            
            <div class="p-0">
                <ul class="divide-y divide-gray-100">
                    @forelse($documents as $doc)
                    <li class="p-6 hover:bg-[#f3faf6] transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start flex-1 min-w-0">
                                <div class="mt-1 mr-4 flex-shrink-0">
                                    <div class="w-10 h-10 rounded-lg bg-[#e7f4ee] text-[#00875a] flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('documents.show', $doc) }}" class="text-lg font-bold text-gray-900 hover:text-blue-600 mb-1 truncate block transition-colors">
                                        {{ $doc->name }}
                                    </a>
                                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-2">
                                        <span class="inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            {{ $doc->document_number ?? 'Tanpa Nomor' }}
                                        </span>
                                        <span class="inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ $doc->document_date->format('d M Y') }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                            {{ $doc->category->name }}
                                        </span>
                                    </div>
                                    @if($doc->description)
                                        <p class="text-sm text-gray-600 line-clamp-2 mt-1">{{ $doc->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex flex-col items-end space-y-2">
                                <a href="{{ route('documents.show', $doc) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    Lihat Detail
                                </a>
                                @if($doc->file_path)
                                <a href="{{ route('documents.download', $doc) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Unduh
                                </a>
                                @endif
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="p-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Tidak ada dokumen ditemukan</h3>
                        <p class="mt-1 text-sm text-gray-500">Coba sesuaikan kata kunci atau kategori pencarian Anda.</p>
                    </li>
                    @endforelse
                </ul>
            </div>
            
            @if($documents->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $documents->links() }}
            </div>
            @endif
        </div>
    </div>
</x-public-layout>
