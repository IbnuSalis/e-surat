@extends('layouts.app')

@section('title', 'Tambah Agenda')
@section('page-title', 'Tambah Agenda')
@section('page-subtitle', 'Jadwalkan kegiatan atau acara baru')

@section('content')
<div class="fade-in-up max-w-2xl">
    <div class="card p-7">
        <div class="flex items-center gap-3 mb-7 pb-5 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-600" style="font-variation-settings:'FILL' 1">event_add</span>
            </div>
            <div>
                <h3 class="font-heading font-semibold text-gray-900">Form Tambah Agenda</h3>
                <p class="text-sm text-gray-400">Isi informasi kegiatan dengan lengkap</p>
            </div>
        </div>

        <form action="{{ route('agenda.store') }}" method="POST">
            @csrf
            <div class="flex flex-col gap-5">
                <div>
                    <label for="judul" class="form-label">Judul Agenda <span class="text-red-500">*</span></label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul agenda..." class="form-input {{ $errors->has('judul') ? 'border-red-400' : '' }}"/>
                    @error('judul')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="tanggal_mulai" class="form-label">Tanggal & Jam Mulai <span class="text-red-500">*</span></label>
                        <input type="datetime-local" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="form-input {{ $errors->has('tanggal_mulai') ? 'border-red-400' : '' }}"/>
                        @error('tanggal_mulai')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="form-label">Tanggal & Jam Selesai</label>
                        <input type="datetime-local" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="form-input"/>
                    </div>
                    <div>
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" placeholder="Balai Desa, Kantor Kecamatan, dll" class="form-input"/>
                    </div>
                    <div>
                        <label for="penanggung_jawab" class="form-label">Penanggung Jawab</label>
                        <input type="text" id="penanggung_jawab" name="penanggung_jawab" value="{{ old('penanggung_jawab') }}" placeholder="Nama penanggung jawab" class="form-input"/>
                    </div>
                </div>

                <div>
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Deskripsi agenda acara..." class="form-input resize-none">{{ old('deskripsi') }}</textarea>
                </div>

                <div>
                    <label class="form-label">Warna Label</label>
                    <div class="flex gap-3 flex-wrap mt-1">
                        @foreach(['#002147' => 'Navy', '#2563eb' => 'Biru', '#16a34a' => 'Hijau', '#d97706' => 'Amber', '#dc2626' => 'Merah', '#7c3aed' => 'Ungu', '#0891b2' => 'Cyan'] as $hex => $label)
                        <label class="cursor-pointer">
                            <input type="radio" name="warna" value="{{ $hex }}" class="sr-only" {{ old('warna', '#002147') === $hex ? 'checked' : '' }}/>
                            <div class="w-8 h-8 rounded-full transition-all ring-2 ring-transparent hover:ring-offset-2 hover:ring-gray-300" style="background: {{ $hex }}" title="{{ $label }}"></div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-5 border-t border-gray-100">
                    <button type="submit" class="btn-primary">
                        <span class="material-symbols-outlined text-xl">save</span>
                        Simpan Agenda
                    </button>
                    <a href="{{ route('agenda.index') }}" class="btn-secondary">
                        <span class="material-symbols-outlined text-xl">arrow_back</span>
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
