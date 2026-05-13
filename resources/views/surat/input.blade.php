@extends('layouts.app')

@section('title', 'Input Surat Baru')
@section('page-title', 'Input Surat Baru')
@section('page-subtitle', 'Tambahkan surat masuk atau surat keluar baru ke sistem')

@section('content')
<div class="fade-in-up max-w-3xl">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-navy-900 transition-colors">Dashboard</a>
        <span class="material-symbols-outlined text-sm text-gray-300">chevron_right</span>
        <span class="text-gray-700 font-medium">Input Surat</span>
    </div>

    <div class="card p-7">
        <div class="flex items-center gap-3 mb-7 pb-5 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: #e8f0ff">
                <span class="material-symbols-outlined" style="color: #002147; font-variation-settings:'FILL' 1">edit_document</span>
            </div>
            <div>
                <h3 class="font-heading font-semibold text-gray-900">Form Input Surat</h3>
                <p class="text-sm text-gray-400">Isi semua informasi surat dengan lengkap dan benar</p>
            </div>
        </div>

        <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data" id="suratForm">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

                <!-- Kode Surat -->
                <div>
                    <label for="kode_surat" class="form-label">Kode Surat <span class="text-red-500">*</span></label>
                    <input type="text" id="kode_surat" name="kode_surat" value="{{ old('kode_surat') }}"
                        placeholder="Contoh: SM/2024/001"
                        class="form-input {{ $errors->has('kode_surat') ? 'border-red-400' : '' }}"/>
                    @error('kode_surat')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Jenis Surat -->
                <div>
                    <label for="jenis_surat" class="form-label">Jenis Surat <span class="text-red-500">*</span></label>
                    <select id="jenis_surat" name="jenis_surat" class="form-input {{ $errors->has('jenis_surat') ? 'border-red-400' : '' }}">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="masuk"  {{ old('jenis_surat') === 'masuk'  ? 'selected' : '' }}>Surat Masuk</option>
                        <option value="keluar" {{ old('jenis_surat') === 'keluar' ? 'selected' : '' }}>Surat Keluar</option>
                    </select>
                    @error('jenis_surat')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Nama Surat -->
                <div class="md:col-span-2">
                    <label for="nama_surat" class="form-label">Nama / Perihal Surat <span class="text-red-500">*</span></label>
                    <input type="text" id="nama_surat" name="nama_surat" value="{{ old('nama_surat') }}"
                        placeholder="Masukkan nama atau perihal surat..."
                        class="form-input {{ $errors->has('nama_surat') ? 'border-red-400' : '' }}"/>
                    @error('nama_surat')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="kategori" class="form-label">Kategori Surat <span class="text-red-500">*</span></label>
                    <div class="flex gap-3 mt-2">
                        @foreach(['umum' => ['Umum', 'bg-blue-50 border-blue-200 text-blue-700'], 'penting' => ['Penting', 'bg-amber-50 border-amber-200 text-amber-700'], 'rahasia' => ['Rahasia', 'bg-red-50 border-red-200 text-red-700']] as $val => $data)
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="kategori" value="{{ $val }}" class="sr-only kategori-radio" {{ old('kategori') === $val ? 'checked' : '' }}/>
                            <div class="border-2 rounded-xl p-3 text-center transition-all hover:scale-105 kategori-card {{ old('kategori') === $val ? $data[1] : 'border-gray-200 bg-white' }}">
                                <p class="text-xs font-bold uppercase tracking-wider">{{ $data[0] }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('kategori')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Tanggal -->
                <div>
                    <label for="tanggal_surat" class="form-label">Tanggal Surat <span class="text-red-500">*</span></label>
                    <input type="date" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat', date('Y-m-d')) }}"
                        class="form-input {{ $errors->has('tanggal_surat') ? 'border-red-400' : '' }}"/>
                    @error('tanggal_surat')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Keterangan -->
                <div class="md:col-span-2">
                    <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                    <textarea id="keterangan" name="keterangan" rows="3"
                        placeholder="Tambahkan keterangan atau catatan tambahan..."
                        class="form-input resize-none">{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <!-- File Upload -->
            <div class="mb-7">
                <label class="form-label">Upload File Surat (Opsional)</label>
                <div class="dropzone" id="dropzone" onclick="document.getElementById('file').click()">
                    <div id="dropzone-content">
                        <span class="material-symbols-outlined text-5xl text-gray-300 mb-3 block" style="font-variation-settings:'FILL' 1">cloud_upload</span>
                        <p class="font-heading font-semibold text-gray-600 mb-1">Klik atau drag & drop file di sini</p>
                        <p class="text-sm text-gray-400">Semua format didukung (PDF, Word, Excel, gambar, dll) — Maks. 20MB</p>
                    </div>
                    <!-- Preview after file selected -->
                    <div id="file-preview" class="hidden">
                        <div class="flex items-center gap-4 justify-center">
                            <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center">
                                <span class="material-symbols-outlined text-blue-600 text-3xl" style="font-variation-settings:'FILL' 1">description</span>
                            </div>
                            <div class="text-left">
                                <p id="file-name" class="font-semibold text-gray-800 text-sm"></p>
                                <p id="file-size" class="text-xs text-gray-500 mt-0.5"></p>
                                <button type="button" onclick="clearFile()" class="text-xs text-red-500 hover:text-red-700 mt-1 font-medium">Hapus file</button>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="file" id="file" name="file" class="hidden" onchange="handleFileSelect(this)"/>
                @error('file')<p class="form-error mt-2">{{ $message }}</p>@enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3 pt-5 border-t border-gray-100">
                <button type="submit" class="btn-primary">
                    <span class="material-symbols-outlined text-xl">save</span>
                    Simpan Surat
                </button>
                <a href="{{ route('dashboard') }}" class="btn-secondary">
                    <span class="material-symbols-outlined text-xl">arrow_back</span>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Kategori radio card
document.querySelectorAll('.kategori-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        const styles = {
            umum:    'bg-blue-50 border-blue-200 text-blue-700',
            penting: 'bg-amber-50 border-amber-200 text-amber-700',
            rahasia: 'bg-red-50 border-red-200 text-red-700',
        };
        document.querySelectorAll('.kategori-card').forEach(card => {
            card.className = 'border-2 rounded-xl p-3 text-center transition-all hover:scale-105 kategori-card border-gray-200 bg-white';
        });
        const style = styles[this.value] || '';
        this.nextElementSibling.className = `border-2 rounded-xl p-3 text-center transition-all hover:scale-105 kategori-card ${style}`;
    });
});

// Dropzone
const dropzone = document.getElementById('dropzone');
dropzone.addEventListener('dragover', e => { e.preventDefault(); dropzone.classList.add('dragover'); });
dropzone.addEventListener('dragleave', () => dropzone.classList.remove('dragover'));
dropzone.addEventListener('drop', e => {
    e.preventDefault();
    dropzone.classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (file) {
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('file').files = dt.files;
        showFilePreview(file);
    }
});

function handleFileSelect(input) {
    if (input.files[0]) showFilePreview(input.files[0]);
}

function showFilePreview(file) {
    document.getElementById('dropzone-content').classList.add('hidden');
    document.getElementById('file-preview').classList.remove('hidden');
    document.getElementById('file-name').textContent = file.name;
    const size = file.size >= 1048576 ? (file.size/1048576).toFixed(2)+' MB' : (file.size/1024).toFixed(2)+' KB';
    document.getElementById('file-size').textContent = size;
}

function clearFile() {
    document.getElementById('file').value = '';
    document.getElementById('dropzone-content').classList.remove('hidden');
    document.getElementById('file-preview').classList.add('hidden');
}
</script>
@endsection
