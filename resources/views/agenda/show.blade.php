@extends('layouts.app')

@section('title', 'Detail Agenda')
@section('page-title', 'Detail Agenda')
@section('page-subtitle', $agenda->judul)

@section('content')
<div class="fade-in-up max-w-2xl">
    <div class="card overflow-hidden">
        <div class="p-6 flex items-center gap-4" style="background: {{ $agenda->warna }}">
            <div class="w-14 h-14 rounded-2xl bg-white/20 flex flex-col items-center justify-center text-white flex-shrink-0">
                <span class="text-2xl font-heading font-bold leading-none">{{ $agenda->tanggal_mulai->format('d') }}</span>
                <span class="text-xs opacity-80">{{ $agenda->tanggal_mulai->format('M') }}</span>
            </div>
            <div class="flex-1">
                <h2 class="font-heading font-bold text-white text-xl">{{ $agenda->judul }}</h2>
                <div class="flex items-center gap-2 mt-2">
                    <span class="badge badge-{{ $agenda->status }}">{{ $agenda->status_label }}</span>
                </div>
            </div>
        </div>
        <div class="p-7">
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Tanggal Mulai</p>
                    <p class="font-semibold text-gray-900">{{ $agenda->tanggal_mulai->format('d F Y, H:i') }} WIB</p>
                </div>
                @if($agenda->tanggal_selesai)
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Tanggal Selesai</p>
                    <p class="font-semibold text-gray-900">{{ $agenda->tanggal_selesai->format('d F Y, H:i') }} WIB</p>
                </div>
                @endif
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Lokasi</p>
                    <p class="font-semibold text-gray-900">{{ $agenda->lokasi ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Penanggung Jawab</p>
                    <p class="font-semibold text-gray-900">{{ $agenda->penanggung_jawab ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Dibuat Oleh</p>
                    <p class="font-semibold text-gray-900">{{ $agenda->creator->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Tanggal Input</p>
                    <p class="font-semibold text-gray-900">{{ $agenda->created_at->format('d M Y') }}</p>
                </div>
            </div>
            @if($agenda->deskripsi)
            <div class="p-4 bg-gray-50 rounded-xl mb-6">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Deskripsi</p>
                <p class="text-sm text-gray-700 leading-relaxed">{{ $agenda->deskripsi }}</p>
            </div>
            @endif
            <div class="flex items-center gap-3 pt-5 border-t border-gray-100">
                @if(auth()->user()->isAdmin())
                <a href="{{ route('agenda.edit', $agenda->id) }}" class="btn-primary">
                    <span class="material-symbols-outlined text-xl">edit</span>
                    Edit Agenda
                </a>
                @endif
                <a href="{{ route('agenda.index') }}" class="btn-secondary">
                    <span class="material-symbols-outlined text-xl">arrow_back</span>
                    Kembali
                </a>
                @if(auth()->user()->isAdmin())
                <form id="del-agenda" action="{{ route('agenda.destroy', $agenda->id) }}" method="POST" class="ml-auto">
                    @csrf @method('DELETE')
                    <button type="button" onclick="confirmDelete('del-agenda')" class="btn-danger">
                        <span class="material-symbols-outlined text-lg">delete</span>
                        Hapus
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
