@extends('layouts.app')

@section('title', 'Edit Agenda')
@section('page-title', 'Edit Agenda')
@section('page-subtitle', $agenda->judul)

@section('content')
<div class="fade-in-up max-w-2xl">
    <div class="card p-7">
        <div class="flex items-center gap-3 mb-7 pb-5 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                <span class="material-symbols-outlined text-amber-600" style="font-variation-settings:'FILL' 1">edit_calendar</span>
            </div>
            <div>
                <h3 class="font-heading font-semibold text-gray-900">Edit Agenda</h3>
                <p class="text-sm text-gray-400">Perbarui informasi agenda</p>
            </div>
        </div>

        <form action="{{ route('agenda.update', $agenda->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="flex flex-col gap-5">
                <div>
                    <label for="judul" class="form-label">Judul Agenda <span class="text-red-500">*</span></label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul', $agenda->judul) }}" class="form-input"/>
                    @error('judul')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="tanggal_mulai" class="form-label">Tanggal & Jam Mulai <span class="text-red-500">*</span></label>
                        <input type="datetime-local" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $agenda->tanggal_mulai->format('Y-m-d\TH:i')) }}" class="form-input"/>
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="form-label">Tanggal & Jam Selesai</label>
                        <input type="datetime-local" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $agenda->tanggal_selesai?->format('Y-m-d\TH:i')) }}" class="form-input"/>
                    </div>
                    <div>
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $agenda->lokasi) }}" class="form-input"/>
                    </div>
                    <div>
                        <label for="penanggung_jawab" class="form-label">Penanggung Jawab</label>
                        <input type="text" id="penanggung_jawab" name="penanggung_jawab" value="{{ old('penanggung_jawab', $agenda->penanggung_jawab) }}" class="form-input"/>
                    </div>
                    <div>
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-input">
                            @foreach(['upcoming' => 'Akan Datang', 'ongoing' => 'Berlangsung', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $val => $label)
                            <option value="{{ $val }}" {{ old('status', $agenda->status) === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Warna Label</label>
                        <div class="flex gap-3 flex-wrap mt-1">
                            @foreach(['#002147' => 'Navy', '#2563eb' => 'Biru', '#16a34a' => 'Hijau', '#d97706' => 'Amber', '#dc2626' => 'Merah', '#7c3aed' => 'Ungu', '#0891b2' => 'Cyan'] as $hex => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="warna" value="{{ $hex }}" class="sr-only" {{ old('warna', $agenda->warna) === $hex ? 'checked' : '' }}/>
                                <div class="w-8 h-8 rounded-full ring-2 ring-transparent hover:ring-offset-2 hover:ring-gray-300 {{ old('warna', $agenda->warna) === $hex ? 'ring-offset-2 ring-gray-500' : '' }}" style="background: {{ $hex }}" title="{{ $label }}"></div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div>
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" class="form-input resize-none">{{ old('deskripsi', $agenda->deskripsi) }}</textarea>
                </div>
                <div class="flex items-center gap-3 pt-5 border-t border-gray-100">
                    <button type="submit" class="btn-primary">
                        <span class="material-symbols-outlined text-xl">save</span>
                        Simpan Perubahan
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
