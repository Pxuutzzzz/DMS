<x-app-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Laporan & Statistik</h2>
        <p class="text-sm text-gray-500 mt-1">Lihat ringkasan data dokumen dalam sistem.</p>
    </div>

    <!-- Filter Form -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Dari Tanggal Dokumen</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ $dateTo }}" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <button type="submit" class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Terapkan Filter
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        <!-- Summary Stats -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-800">Ringkasan Dokumen</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg mb-6">
                    <span class="text-sm font-medium text-blue-800">Total Dokumen pada periode terpilih:</span>
                    <span class="text-2xl font-bold text-blue-900">{{ $totalDocuments }}</span>
                </div>

                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Berdasarkan Status</h4>
                <div class="space-y-4">
                    @foreach($byStatus as $stat)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-gray-700">{{ $stat->label }}</span>
                            <span class="font-semibold text-gray-900">{{ $stat->count }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-{{ $stat->color }}-500 h-2 rounded-full" style="width: {{ $totalDocuments > 0 ? ($stat->count / $totalDocuments) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- By Category -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-800">Berdasarkan Kategori</h3>
            </div>
            <div class="p-6">
                <div class="overflow-y-auto max-h-[300px] pr-2">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="text-left text-xs font-semibold text-gray-500 pb-2">Kategori</th>
                                <th class="text-right text-xs font-semibold text-gray-500 pb-2">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($byCategory as $cat)
                                @if($cat->count > 0)
                                <tr>
                                    <td class="py-3 text-sm text-gray-900">{{ $cat->name }}</td>
                                    <td class="py-3 text-sm font-semibold text-gray-900 text-right">{{ $cat->count }}</td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Monthly Trend -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">Tren Bulanan (Tanggal Dokumen)</h3>
        </div>
        <div class="p-6 overflow-x-auto">
            <div class="flex items-end space-x-2 min-h-[200px] pt-4">
                @php 
                    $maxCount = $byYearMonth->max('count') ?: 1; 
                    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
                @endphp
                
                @foreach($byYearMonth as $ym)
                    <div class="flex flex-col items-center flex-1 min-w-[40px] max-w-[60px]">
                        <div class="text-xs font-semibold text-gray-600 mb-2">{{ $ym->count }}</div>
                        <div class="w-full bg-blue-500 rounded-t-md hover:bg-blue-600 transition-colors" style="height: {{ ($ym->count / $maxCount) * 150 }}px"></div>
                        <div class="text-[10px] text-gray-500 mt-2 rotate-45 origin-left whitespace-nowrap">{{ $months[$ym->month - 1] }} {{ substr($ym->year, 2) }}</div>
                    </div>
                @endforeach
                
                @if($byYearMonth->isEmpty())
                    <div class="w-full text-center text-sm text-gray-500 self-center">Tidak ada data untuk periode ini.</div>
                @endif
            </div>
            <div class="h-10"></div> <!-- padding for rotated text -->
        </div>
    </div>

</x-app-layout>
