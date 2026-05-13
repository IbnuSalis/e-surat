@extends('layouts.app')

@section('title', 'Edit Surat')
@section('page-title', 'Edit Surat')
@section('page-subtitle', $surat->kode_surat)

@section('content')
<div class="fade-in-up max-w-3xl">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-navy-900">Dashboard</a>
        <span class="material-symbols-outlined text-sm text-gray-300">chevron_right</span>
        <a href="{{ route('surat.' . $surat->jenis_surat) }}" class="hover:text-navy-900">Surat {{ ucfirst($surat->jenis_surat) }}</a>
        <span class="material-symbols-outlined text-sm text-gray-300">chevron_right</span>
        <span class="text-gray-700">Edit</span>
    </div>

    <div class="card p-7">
        <div class="flex items-center gap-3 mb-7 pb-5 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-amber-50">
                <span class="material-symbols-outlined text-amber-600" style="font-variation-settings:'FILL' 1">edit_document</span>
            </div>
            <div>
                <h3 class="font-heading font-semibold text-gray-900">Edit Surat</h3>
                <p class="text-sm text-gray-400">{{ $surat->kode_surat }} — {{ $surat->nama_surat }}</p>
            </div>
        </div>

        <form action="{{ route('surat.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="kode_surat" class="form-label">Kode Surat <span class="text-red-500">*</span></label>
                    <input type="text" id="kode_surat" name="kode_surat" value="{{ old('kode_surat', $surat->kode_surat) }}" class="form-input {{ $errors->has('kode_surat') ? 'border-red-400' : '' }}"/>
                    @error('kode_surat')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="jenis_surat" class="form-label">Jenis Surat <span class="text-red-500">*</span></label>
                    <select id="jenis_surat" name="jenis_surat" class="form-input">
                        <option value="masuk"  {{ old('jenis_surat', $surat->jenis_surat) === 'masuk'  ? 'selected' : '' }}>Surat Masuk</option>
                        <option value="keluar" {{ old('jenis_surat', $surat->jenis_surat) === 'keluar' ? 'selected' : '' }}>Surat Keluar</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="nama_surat" class="form-label">Nama / Perihal Surat <span class="text-red-500">*</span></label>
                    <input type="text" id="nama_surat" name="nama_surat" value="{{ old('nama_surat', $surat->nama_surat) }}" class="form-input {{ $errors->has('nama_surat') ? 'border-red-400' : '' }}"/>
                    @error('nama_surat')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Kategori Surat <span class="text-red-500">*</span></label>
                    <div class="flex gap-3 mt-2">
                        @foreach(['umum' => ['Umum','bg-blue-50 border-blue-200 text-blue-700'], 'penting' => ['Penting','bg-amber-50 border-amber-200 text-amber-700'], 'rahasia' => ['Rahasia','bg-red-50 border-red-200 text-red-700']] as $val => $data)
                        @php $current = old('kategori', $surat->kategori); @endphp
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="kategori" value="{{ $val }}" class="sr-only kategori-radio" {{ $current === $val ? 'checked' : '' }}/>
                            <div class="border-2 rounded-xl p-3 text-center transition-all hover:scale-105 kategori-card {{ $current === $val ? $data[1] : 'border-gray-200 bg-white' }}">
                                <p class="text-xs font-bold uppercase tracking-wider">{{ $data[0] }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label for="tanggal_surat" class="form-label">Tanggal Surat <span class="text-red-500">*</span></label>
                    <input type="date" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat', $surat->tanggal_surat->format('Y-m-d')) }}" class="form-input"/>
                </div>
                <div class="md:col-span-2">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" rows="3" class="form-input resize-none">{{ old('keterangan', $surat->keterangan) }}</textarea>
                </div>
            </div>

            <!-- File Upload -->
            <div class="mb-7">
                <label class="form-label">Ganti File (Opsional)</label>
                @if($surat->file_path)
                <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl mb-3">
                    <span class="material-symbols-outlined text-green-600" style="font-variation-settings:'FILL' 1">check_circle</span>
                    <div>
                        <p class="text-sm font-semibold text-green-800">{{ $surat->file_name }}</p>
                        <p class="text-xs text-green-600">{{ $surat->file_size_formatted }} — File saat ini. Upload baru untuk mengganti.</p>
                    </div>
                </div>
                @endif
                <div class="dropzone" onclick="document.getElementById('file').click()">
                    <span class="material-symbols-outlined text-4xl text-gray-300 mb-2 block" style="font-variation-settings:'FILL' 1">cloud_upload</span>
                    <p class="text-sm text-gray-500">Klik untuk upload file pengganti</p>
                    <p class="text-xs text-gray-400 mt-1">Semua format · Maks. 20MB</p>
                </div>
                <input type="file" id="file" name="file" class="hidden"/>
            </div>

            <div class="flex items-center gap-3 pt-5 border-t border-gray-100">
                <button type="submit" class="btn-primary">
                    <span class="material-symbols-outlined text-xl">save</span>
                    Simpan Perubahan
                </button>
                <a href="{{ route('surat.' . $surat->jenis_surat) }}" class="btn-secondary">
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
document.querySelectorAll('.kategori-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        const styles = { umum: 'bg-blue-50 border-blue-200 text-blue-700', penting: 'bg-amber-50 border-amber-200 text-amber-700', rahasia: 'bg-red-50 border-red-200 text-red-700' };
        document.querySelectorAll('.kategori-card').forEach(card => card.className = 'border-2 rounded-xl p-3 text-center transition-all hover:scale-105 kategori-card border-gray-200 bg-white');
        this.nextElementSibling.className = `border-2 rounded-xl p-3 text-center transition-all hover:scale-105 kategori-card ${styles[this.value] || ''}`;
    });
});
document.getElementById('file').addEventListener('change', function() {
    if (this.files[0]) {
        const dropzone = this.previousElementSibling;
        dropzone.innerHTML = `<div class="flex items-center justify-center gap-3"><span class="material-symbols-outlined text-green-500 text-3xl" style="font-variation-settings:'FILL' 1">check_circle</span><div><p class="font-semibold text-green-700 text-sm">${this.files[0].name}</p><p class="text-xs text-gray-500">${(this.files[0].size/1024).toFixed(0)} KB</p></div></div>`;
    }
});
</script>
@endsection
