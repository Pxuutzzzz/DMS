<x-app-layout>
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex justify-between items-end">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('documents.show', $document) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">&larr; Batal & Kembali ke Detail</a>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Edit Metadata Dokumen</h2>
                <p class="text-sm text-gray-500 mt-1">Perbarui informasi dan metadata untuk: <span class="font-semibold text-gray-700">{{ $document->name }}</span></p>
            </div>
            
            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-{{ $document->status_color }}-50 text-{{ $document->status_color }}-700 ring-1 ring-inset ring-{{ $document->status_color }}-600/20">
                Status Saat Ini: {{ $document->status_label }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <form action="{{ route('documents.update', $document) }}" method="POST" class="divide-y divide-gray-100">
                        @csrf
                        @method('PUT')
                        
                        <div class="p-6 md:p-8 space-y-8">
                            <!-- Metadata Section -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-100 pb-2">Informasi Utama</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4">
                                    
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Nama Dokumen <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" value="{{ old('name', $document->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nomor Dokumen</label>
                                        <input type="text" name="document_number" value="{{ old('document_number', $document->document_number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        @error('document_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Kategori <span class="text-red-500">*</span></label>
                                        <select name="category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $document->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                </div>
                            </div>

                            <!-- Academic Info Section -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-100 pb-2">Informasi Akademik (Opsional)</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4">
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Tahun Akademik</label>
                                        <input type="text" name="academic_year" value="{{ old('academic_year', $document->academic_year) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Semester</label>
                                        <select name="semester" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            <option value="">Pilih Semester</option>
                                            <option value="Ganjil" {{ old('semester', $document->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                            <option value="Genap" {{ old('semester', $document->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                                            <option value="Antara" {{ old('semester', $document->semester) == 'Antara' ? 'selected' : '' }}>Antara</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Mata Kuliah</label>
                                        <input type="text" name="course_name" value="{{ old('course_name', $document->course_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">PIC / Penanggung Jawab</label>
                                        <input type="text" name="pic" value="{{ old('pic', $document->pic) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Unit / Prodi</label>
                                        <input type="text" name="department" value="{{ old('department', $document->department) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    </div>

                                </div>
                            </div>

                            <!-- Date & Additional Section -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-100 pb-2">Waktu & Tambahan</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4">
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Tanggal Dokumen <span class="text-red-500">*</span></label>
                                        <input type="date" name="document_date" value="{{ old('document_date', $document->document_date->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        @error('document_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                                            Tanggal Upload 
                                            @if(!auth()->user()->canEditUploadDate())
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" title="Hanya Admin/Super Admin yang bisa merubah"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            @endif
                                        </label>
                                        <input type="date" name="upload_date" value="{{ old('upload_date', $document->upload_date->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm {{ !auth()->user()->canEditUploadDate() ? 'bg-gray-100 cursor-not-allowed' : '' }}" {{ !auth()->user()->canEditUploadDate() ? 'readonly' : '' }}>
                                        @error('upload_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                                        <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('description', $document->description) }}</textarea>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Tag <span class="text-gray-400 font-normal">(Pisahkan dengan koma)</span></label>
                                        <input type="text" name="tags" value="{{ old('tags', is_array($document->tags) ? implode(', ', $document->tags) : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Status Dokumen (Hanya Admin)</label>
                                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm {{ !auth()->user()->isAdmin() ? 'bg-gray-100 cursor-not-allowed' : '' }}" {{ !auth()->user()->isAdmin() ? 'disabled' : '' }}>
                                            @foreach(\App\Models\Document::STATUSES as $val => $label)
                                                <option value="{{ $val }}" {{ old('status', $document->status) == $val ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @if(!auth()->user()->isAdmin())
                                            <input type="hidden" name="status" value="{{ $document->status }}">
                                        @endif
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3">
                            <a href="{{ route('documents.show', $document) }}" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar Audit Trail for Edit -->
            <div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Log Perubahan Terakhir</h3>
                    </div>
                    <div class="p-6">
                        @if($auditLogs->count() > 0)
                            <div class="flow-root">
                                <ul role="list" class="-mb-8">
                                    @foreach($auditLogs->take(5) as $log)
                                    <li>
                                        <div class="relative pb-8">
                                            @if(!$loop->last)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </span>
                                                </div>
                                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-gray-500">
                                                            @if($log->action == 'document_created') Dibuat awal
                                                            @elseif($log->action == 'document_updated') Diupdate
                                                            @elseif($log->action == 'upload_date_changed') Tgl Upload diubah
                                                            @elseif($log->action == 'document_submitted') Diajukan
                                                            @elseif($log->action == 'document_approved') Disetujui
                                                            @elseif($log->action == 'version_uploaded') Versi baru
                                                            @else {{ $log->action }} @endif
                                                            oleh <span class="font-medium text-gray-900">{{ $log->user->name }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="whitespace-nowrap text-right text-xs text-gray-400">
                                                        <time datetime="{{ $log->created_at->toIso8601String() }}">{{ $log->created_at->diffForHumans() }}</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 text-center py-4">Belum ada riwayat perubahan.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
