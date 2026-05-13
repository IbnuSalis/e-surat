@extends('layouts.app')

@section('title', 'Berita Acara')
@section('page-title', 'Berita Acara')
@section('page-subtitle', 'Dokumentasi hasil kegiatan dan rapat')

@section('content')
<div class="fade-in-up">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <p class="text-gray-500 text-sm">Total: <strong class="text-gray-900">{{ $beritaAcaras->total() }}</strong> berita acara</p>
        <a href="{{ route('berita-acara.create') }}" class="btn-primary flex-shrink-0">
            <span class="material-symbols-outlined text-xl">add</span>
            Tambah Berita Acara
        </a>
    </div>

    <!-- Filters -->
    <div class="card p-5 mb-5">
        <form action="{{ route('berita-acara.index') }}" method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="form-label">Cari</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 text-lg">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nomor atau judul..." class="form-input pl-10"/>
                </div>
            </div>
            <div class="min-w-[160px]">
                <label class="form-label">Status</label>
                <select name="status" class="form-input">
                    <option value="">Semua Status</option>
                    <option value="draft"    {{ request('status') === 'draft'    ? 'selected' : '' }}>Draft</option>
                    <option value="final"    {{ request('status') === 'final'    ? 'selected' : '' }}>Final</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">
                <span class="material-symbols-outlined text-lg">filter_list</span>
                Filter
            </button>
            @if(request()->hasAny(['search','status']))
            <a href="{{ route('berita-acara.index') }}" class="btn-secondary">
                <span class="material-symbols-outlined text-lg">clear</span>
                Reset
            </a>
            @endif
        </form>
    </div>

    <div class="card overflow-hidden">
        @if($beritaAcaras->isEmpty())
        <div class="text-center py-16">
            <span class="material-symbols-outlined text-6xl text-gray-200">history_edu</span>
            <h3 class="font-heading font-semibold text-gray-500 mt-3">Tidak ada berita acara</h3>
            <p class="text-sm text-gray-400 mt-1">Belum ada berita acara yang ditambahkan.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="data-table w-full">
                <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">Nomor</th>
                        <th class="text-left">Judul</th>
                        <th class="text-left">Tanggal</th>
                        <th class="text-left">Lokasi</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Dibuat Oleh</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($beritaAcaras as $i => $ba)
                    <tr>
                        <td class="text-gray-400 text-xs">{{ $beritaAcaras->firstItem() + $i }}</td>
                        <td><span class="font-mono text-xs font-semibold bg-indigo-50 text-indigo-800 px-2.5 py-1 rounded-lg">{{ $ba->nomor }}</span></td>
                        <td>
                            <p class="font-semibold text-gray-900 text-sm max-w-xs truncate">{{ $ba->judul }}</p>
                        </td>
                        <td class="text-sm text-gray-700">{{ $ba->tanggal->format('d M Y') }}</td>
                        <td class="text-sm text-gray-600">{{ $ba->lokasi ?? '—' }}</td>
                        <td><span class="badge badge-{{ $ba->status }}">{{ $ba->status_label }}</span></td>
                        <td class="text-sm text-gray-700">{{ $ba->creator->name ?? '—' }}</td>
                        <td>
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('berita-acara.show', $ba->id) }}" class="btn-icon btn-icon-view">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </a>
                                <a href="{{ route('berita-acara.edit', $ba->id) }}" class="btn-icon btn-icon-edit">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <form id="del-ba-{{ $ba->id }}" action="{{ route('berita-acara.destroy', $ba->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('del-ba-{{ $ba->id }}')" class="btn-icon btn-icon-delete">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($beritaAcaras->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-sm text-gray-500">Menampilkan {{ $beritaAcaras->firstItem() }}–{{ $beritaAcaras->lastItem() }} dari {{ $beritaAcaras->total() }} entri</p>
            <div class="flex items-center gap-1">
                @if($beritaAcaras->onFirstPage())<span class="px-3 py-1.5 rounded-lg text-sm text-gray-300 border">‹</span>
                @else<a href="{{ $beritaAcaras->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-sm border hover:bg-gray-50">‹</a>@endif
                @if($beritaAcaras->hasMorePages())<a href="{{ $beritaAcaras->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-sm border hover:bg-gray-50">›</a>
                @else<span class="px-3 py-1.5 rounded-lg text-sm text-gray-300 border">›</span>@endif
            </div>
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
