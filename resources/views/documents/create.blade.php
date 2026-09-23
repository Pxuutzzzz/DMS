<x-app-layout>
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('documents.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">&larr; Kembali ke Daftar Dokumen</a>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Tambah Dokumen Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Lengkapi form berikut untuk mengunggah dokumen baru ke sistem.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-100">
                @csrf
                
                <div class="p-6 md:p-8 space-y-8">
                    <!-- File Upload Section -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-100 pb-2">1. File Dokumen <span class="text-red-500">*</span></h3>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-500 hover:bg-blue-50/50 transition-colors bg-gray-50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload a file</span>
                                        <input id="file-upload" name="file" type="file" class="sr-only" required>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG, ZIP up to 20MB</p>
                            </div>
                        </div>
                        @error('file') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Metadata Section -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-100 pb-2">2. Informasi Utama</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4">
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Nama Dokumen <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Dokumen</label>
                                <input type="text" name="document_number" value="{{ old('document_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('document_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kategori <span class="text-red-500">*</span></label>
                                <select name="category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                        </div>
                    </div>

                    <!-- Academic Info Section -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-100 pb-2">3. Informasi Akademik (Opsional)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4">
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tahun Akademik</label>
                                <input type="text" name="academic_year" value="{{ old('academic_year') }}" placeholder="Contoh: 2026/2027" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Semester</label>
                                <select name="semester" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="">Pilih Semester</option>
                                    <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                                    <option value="Antara" {{ old('semester') == 'Antara' ? 'selected' : '' }}>Antara</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Mata Kuliah</label>
                                <input type="text" name="course_name" value="{{ old('course_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">PIC / Penanggung Jawab</label>
                                <input type="text" name="pic" value="{{ old('pic') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Unit / Prodi</label>
                                <input type="text" name="department" value="{{ old('department', auth()->user()->department) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>

                        </div>
                    </div>

                    <!-- Date & Additional Section -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-100 pb-2">4. Waktu & Tambahan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4">
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Dokumen <span class="text-red-500">*</span></label>
                                <input type="date" name="document_date" value="{{ old('document_date', date('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <p class="mt-1 text-[11px] text-gray-500">Tanggal yang tertera pada isi dokumen fisik/digital.</p>
                                @error('document_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Upload <span class="text-red-500">*</span></label>
                                <input type="date" name="upload_date" value="{{ old('upload_date', date('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-gray-50" readonly>
                                <p class="mt-1 text-[11px] text-gray-500">Otomatis diisi hari ini (Drafting). Hanya Admin yang dapat merubah nanti.</p>
                                @error('upload_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                                <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('description') }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Tag <span class="text-gray-400 font-normal">(Pisahkan dengan koma)</span></label>
                                <input type="text" name="tags" value="{{ old('tags') }}" placeholder="Kurikulum, 2026, Revisi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>

                        </div>
                    </div>

                </div>

                <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3">
                    <a href="{{ route('documents.index') }}" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan Sebagai Draft
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
