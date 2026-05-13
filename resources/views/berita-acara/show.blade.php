@extends('layouts.app')

@section('title', 'Detail Berita Acara')
@section('page-title', 'Detail Berita Acara')
@section('page-subtitle', $beritaAcara->nomor)

@section('content')
<div class="fade-in-up max-w-3xl">
    <div class="card overflow-hidden">
        <div class="p-6 flex items-center justify-between" style="background: linear-gradient(135deg, #312e81 0%, #4338ca 100%)">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl text-white" style="font-variation-settings:'FILL' 1">history_edu</span>
                </div>
                <div>
                    <p class="text-xs font-mono text-indigo-200 mb-1">{{ $beritaAcara->nomor }}</p>
                    <h2 class="font-heading font-bold text-white text-xl leading-tight max-w-lg">{{ $beritaAcara->judul }}</h2>
                </div>
            </div>
            <span class="badge badge-{{ $beritaAcara->status }}">{{ $beritaAcara->status_label }}</span>
        </div>
        <div class="p-7">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-5 mb-6">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Tanggal</p>
                    <p class="font-semibold text-gray-900">{{ $beritaAcara->tanggal->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Lokasi</p>
                    <p class="font-semibold text-gray-900">{{ $beritaAcara->lokasi ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Dibuat Oleh</p>
                    <p class="font-semibold text-gray-900">{{ $beritaAcara->creator->name ?? '—' }}</p>
                </div>
                @if($beritaAcara->peserta)
                <div class="col-span-2 md:col-span-3">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Peserta / Yang Hadir</p>
                    <p class="font-semibold text-gray-900">{{ $beritaAcara->peserta }}</p>
                </div>
                @endif
            </div>
            <div class="p-5 bg-gray-50 rounded-xl mb-6">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Isi Berita Acara</p>
                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $beritaAcara->isi }}</p>
            </div>
            <div class="flex items-center gap-3 pt-5 border-t border-gray-100">
                <a href="{{ route('berita-acara.edit', $beritaAcara->id) }}" class="btn-primary">
                    <span class="material-symbols-outlined text-xl">edit</span>
                    Edit
                </a>
                <a href="{{ route('berita-acara.index') }}" class="btn-secondary">
                    <span class="material-symbols-outlined text-xl">arrow_back</span>
                    Kembali
                </a>
                <form id="del-ba" action="{{ route('berita-acara.destroy', $beritaAcara->id) }}" method="POST" class="ml-auto">
                    @csrf @method('DELETE')
                    <button type="button" onclick="confirmDelete('del-ba')" class="btn-danger">
                        <span class="material-symbols-outlined text-lg">delete</span>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
