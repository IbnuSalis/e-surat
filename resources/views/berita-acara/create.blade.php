@extends('layouts.app')

@section('title', 'Tambah Berita Acara')
@section('page-title', 'Tambah Berita Acara')
@section('page-subtitle', 'Dokumentasikan hasil kegiatan atau rapat')

@section('content')
<div class="fade-in-up max-w-3xl">
    <div class="card p-7">
        <div class="flex items-center gap-3 mb-7 pb-5 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                <span class="material-symbols-outlined text-indigo-600" style="font-variation-settings:'FILL' 1">history_edu</span>
            </div>
            <div>
                <h3 class="font-heading font-semibold text-gray-900">Form Berita Acara</h3>
                <p class="text-sm text-gray-400">Isi seluruh informasi dengan lengkap dan benar</p>
            </div>
        </div>

        <form action="{{ route('berita-acara.store') }}" method="POST">
            @csrf
            <div class="flex flex-col gap-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="nomor" class="form-label">Nomor Berita Acara <span class="text-red-500">*</span></label>
                        <input type="text" id="nomor" name="nomor" value="{{ old('nomor') }}" placeholder="BA/2024/001" class="form-input {{ $errors->has('nomor') ? 'border-red-400' : '' }}"/>
                        @error('nomor')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="tanggal" class="form-label">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="form-input {{ $errors->has('tanggal') ? 'border-red-400' : '' }}"/>
                        @error('tanggal')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label for="judul" class="form-label">Judul Berita Acara <span class="text-red-500">*</span></label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul') }}" placeholder="Judul berita acara..." class="form-input {{ $errors->has('judul') ? 'border-red-400' : '' }}"/>
                    @error('judul')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" placeholder="Tempat pelaksanaan kegiatan..." class="form-input"/>
                </div>
                <div>
                    <label for="peserta" class="form-label">Peserta / Yang Hadir</label>
                    <input type="text" id="peserta" name="peserta" value="{{ old('peserta') }}" placeholder="Kepala Desa, BPD, Kaur Keuangan, dst..." class="form-input"/>
                </div>
                <div>
                    <label for="isi" class="form-label">Isi Berita Acara <span class="text-red-500">*</span></label>
                    <textarea id="isi" name="isi" rows="8" placeholder="Uraikan isi/hasil berita acara secara lengkap..." class="form-input resize-none {{ $errors->has('isi') ? 'border-red-400' : '' }}">{{ old('isi') }}</textarea>
                    @error('isi')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center gap-3 pt-5 border-t border-gray-100">
                    <button type="submit" class="btn-primary">
                        <span class="material-symbols-outlined text-xl">save</span>
                        Simpan Berita Acara
                    </button>
                    <a href="{{ route('berita-acara.index') }}" class="btn-secondary">
                        <span class="material-symbols-outlined text-xl">arrow_back</span>
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
