@extends('layouts.app')

@section('title', 'Detail Surat')
@section('page-title', 'Detail Surat')
@section('page-subtitle', $surat->kode_surat)

@section('content')
<div class="fade-in-up max-w-3xl">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-navy-900">Dashboard</a>
        <span class="material-symbols-outlined text-sm text-gray-300">chevron_right</span>
        <a href="{{ route('surat.' . $surat->jenis_surat) }}" class="hover:text-navy-900 capitalize">Surat {{ ucfirst($surat->jenis_surat) }}</a>
        <span class="material-symbols-outlined text-sm text-gray-300">chevron_right</span>
        <span class="text-gray-700">Detail</span>
    </div>

    <div class="card overflow-hidden">
        <!-- Header Banner -->
        <div class="p-6 flex items-center gap-4" style="background: linear-gradient(135deg, #002147 0%, #003366 100%)">
            <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-3xl text-white" style="font-variation-settings:'FILL' 1">
                    {{ $surat->jenis_surat === 'masuk' ? 'mail' : ($surat->kategori === 'rahasia' ? 'lock' : 'send') }}
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-mono text-blue-200 mb-1">{{ $surat->kode_surat }}</p>
                <h2 class="font-heading font-bold text-white text-xl leading-tight">{{ $surat->nama_surat }}</h2>
                <div class="flex flex-wrap items-center gap-2 mt-2">
                    <span class="badge badge-{{ $surat->jenis_surat }}">{{ $surat->jenis_label }}</span>
                    <span class="badge badge-{{ $surat->kategori }}">{{ $surat->kategori_label }}</span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-7">
            <div class="grid grid-cols-2 gap-6 mb-7">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Tanggal Surat</p>
                    <p class="font-semibold text-gray-900">{{ $surat->tanggal_surat->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Tanggal Input</p>
                    <p class="font-semibold text-gray-900">{{ $surat->created_at->format('d F Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Diinput Oleh</p>
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background: #002147">
                            {{ $surat->creator->initials ?? '?' }}
                        </div>
                        <p class="font-semibold text-gray-900">{{ $surat->creator->name ?? 'Unknown' }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Status</p>
                    <span class="badge badge-{{ $surat->status }}">{{ ucfirst($surat->status) }}</span>
                </div>
            </div>

            @if($surat->keterangan)
            <div class="mb-7 p-4 bg-gray-50 rounded-xl">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Keterangan</p>
                <p class="text-sm text-gray-700 leading-relaxed">{{ $surat->keterangan }}</p>
            </div>
            @endif

            <!-- File Section -->
            @if($surat->file_path)
            <div class="border border-gray-200 rounded-xl p-5 mb-7">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">File Terlampir</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-blue-600 text-2xl" style="font-variation-settings:'FILL' 1">description</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-900 text-sm truncate">{{ $surat->file_name }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $surat->file_size_formatted }} · {{ $surat->file_type }}</p>
                    </div>
                    <a href="{{ route('surat.download', $surat->id) }}" class="btn-primary text-sm px-4 py-2">
                        <span class="material-symbols-outlined text-lg">download</span>
                        Unduh
                    </a>
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-3 pt-5 border-t border-gray-100">
                <a href="{{ route('surat.edit', $surat->id) }}" class="btn-primary">
                    <span class="material-symbols-outlined text-xl">edit</span>
                    Edit Surat
                </a>
                <a href="{{ route('surat.' . $surat->jenis_surat) }}" class="btn-secondary">
                    <span class="material-symbols-outlined text-xl">arrow_back</span>
                    Kembali
                </a>
                @if(auth()->user()->isAdmin())
                <form id="del-{{ $surat->id }}" action="{{ route('surat.destroy', $surat->id) }}" method="POST" class="ml-auto">
                    @csrf @method('DELETE')
                    <button type="button" onclick="confirmDelete('del-{{ $surat->id }}')" class="btn-danger">
                        <span class="material-symbols-outlined text-lg">delete</span>
                        Hapus Surat
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
