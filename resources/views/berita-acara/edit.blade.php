@extends('layouts.app')

@section('title', 'Edit Berita Acara')
@section('page-title', 'Edit Berita Acara')
@section('page-subtitle', $beritaAcara->nomor)

@section('content')
<div class="fade-in-up max-w-3xl">
    <div class="card p-7">
        <div class="flex items-center gap-3 mb-7 pb-5 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                <span class="material-symbols-outlined text-amber-600" style="font-variation-settings:'FILL' 1">history_edu</span>
            </div>
            <div>
                <h3 class="font-heading font-semibold text-gray-900">Edit Berita Acara</h3>
                <p class="text-sm text-gray-400">{{ $beritaAcara->nomor }}</p>
            </div>
        </div>
        <form action="{{ route('berita-acara.update', $beritaAcara->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="flex flex-col gap-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="nomor" class="form-label">Nomor <span class="text-red-500">*</span></label>
                        <input type="text" id="nomor" name="nomor" value="{{ old('nomor', $beritaAcara->nomor) }}" class="form-input"/>
                        @error('nomor')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="tanggal" class="form-label">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $beritaAcara->tanggal->format('Y-m-d')) }}" class="form-input"/>
                    </div>
                    <div>
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-input">
                            <option value="draft"    {{ old('status', $beritaAcara->status) === 'draft'    ? 'selected' : '' }}>Draft</option>
                            <option value="final"    {{ old('status', $beritaAcara->status) === 'final'    ? 'selected' : '' }}>Final</option>
                            <option value="approved" {{ old('status', $beritaAcara->status) === 'approved' ? 'selected' : '' }}>Disetujui</option>
                        </select>
                    </div>
                    <div>
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $beritaAcara->lokasi) }}" class="form-input"/>
                    </div>
                </div>
                <div>
                    <label for="judul" class="form-label">Judul <span class="text-red-500">*</span></label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul', $beritaAcara->judul) }}" class="form-input"/>
                    @error('judul')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="peserta" class="form-label">Peserta</label>
                    <input type="text" id="peserta" name="peserta" value="{{ old('peserta', $beritaAcara->peserta) }}" class="form-input"/>
                </div>
                <div>
                    <label for="isi" class="form-label">Isi Berita Acara <span class="text-red-500">*</span></label>
                    <textarea id="isi" name="isi" rows="8" class="form-input resize-none">{{ old('isi', $beritaAcara->isi) }}</textarea>
                    @error('isi')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center gap-3 pt-5 border-t border-gray-100">
                    <button type="submit" class="btn-primary">
                        <span class="material-symbols-outlined text-xl">save</span>
                        Simpan Perubahan
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
