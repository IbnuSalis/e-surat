@extends('layouts.app')

@section('title', 'Surat Masuk')
@section('page-title', 'Surat Masuk')
@section('page-subtitle', 'Daftar seluruh surat masuk')

@section('content')
<div class="fade-in-up">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-gray-500 text-sm">Total: <strong class="text-gray-900">{{ $surats->total() }}</strong> surat masuk</p>
        </div>
        <a href="{{ route('surat.input') }}" class="btn-primary flex-shrink-0">
            <span class="material-symbols-outlined text-xl">add</span>
            Tambah Surat Masuk
        </a>
    </div>

    <!-- Filters -->
    <div class="card p-5 mb-5">
        <form action="{{ route('surat.masuk') }}" method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="form-label">Cari Surat</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 text-lg">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode atau nama surat..." class="form-input pl-10"/>
                </div>
            </div>
            <div class="min-w-[160px]">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-input">
                    <option value="">Semua Kategori</option>
                    <option value="umum"    {{ request('kategori') === 'umum'    ? 'selected' : '' }}>Umum</option>
                    <option value="penting" {{ request('kategori') === 'penting' ? 'selected' : '' }}>Penting</option>
                    <option value="rahasia" {{ request('kategori') === 'rahasia' ? 'selected' : '' }}>Rahasia</option>
                </select>
            </div>
            <div class="min-w-[150px]">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="form-input"/>
            </div>
            <div class="min-w-[150px]">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="form-input"/>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn-primary">
                    <span class="material-symbols-outlined text-lg">filter_list</span>
                    Filter
                </button>
                @if(request()->hasAny(['search','kategori','tanggal_dari','tanggal_sampai']))
                <a href="{{ route('surat.masuk') }}" class="btn-secondary">
                    <span class="material-symbols-outlined text-lg">clear</span>
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="card overflow-hidden">
        @if($surats->isEmpty())
        <div class="text-center py-16">
            <span class="material-symbols-outlined text-6xl text-gray-200">inbox</span>
            <h3 class="font-heading font-semibold text-gray-500 mt-3">Tidak ada surat masuk</h3>
            <p class="text-sm text-gray-400 mt-1">Belum ada surat masuk yang ditambahkan.</p>
            <a href="{{ route('surat.input') }}" class="btn-primary mt-5 inline-flex">
                <span class="material-symbols-outlined text-xl">add</span>
                Tambah Surat
            </a>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="data-table w-full">
                <thead>
                    <tr>
                        <th class="text-left w-12">#</th>
                        <th class="text-left">Kode Surat</th>
                        <th class="text-left">Nama Surat</th>
                        <th class="text-left">Kategori</th>
                        <th class="text-left">Tanggal</th>
                        <th class="text-left">Diupload Oleh</th>
                        <th class="text-left">File</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surats as $i => $surat)
                    <tr>
                        <td class="text-gray-400 text-xs">{{ $surats->firstItem() + $i }}</td>
                        <td>
                            <span class="font-mono text-xs font-semibold text-navy-900 bg-blue-50 px-2.5 py-1 rounded-lg">{{ $surat->kode_surat }}</span>
                        </td>
                        <td>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $surat->nama_surat }}</p>
                                @if($surat->keterangan)
                                <p class="text-xs text-gray-400 mt-0.5 truncate max-w-xs">{{ $surat->keterangan }}</p>
                                @endif
                            </div>
                        </td>
                        <td><span class="badge badge-{{ $surat->kategori }}">{{ $surat->kategori_label }}</span></td>
                        <td>
                            <p class="text-sm text-gray-700">{{ $surat->tanggal_surat->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $surat->created_at->diffForHumans() }}</p>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-navy-900 flex items-center justify-center text-white text-xs font-bold font-heading flex-shrink-0">
                                    {{ $surat->creator->initials ?? '?' }}
                                </div>
                                <span class="text-sm text-gray-700">{{ $surat->creator->name ?? 'Unknown' }}</span>
                            </div>
                        </td>
                        <td>
                            @if($surat->file_path)
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-green-500 text-lg" style="font-variation-settings:'FILL' 1">attach_file</span>
                                <span class="text-xs text-gray-500">{{ $surat->file_size_formatted }}</span>
                            </div>
                            @else
                            <span class="text-xs text-gray-300">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('surat.show', $surat->id) }}" class="btn-icon btn-icon-view" title="Detail">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </a>
                                @if($surat->file_path)
                                <a href="{{ route('surat.download', $surat->id) }}" class="btn-icon" style="background: #eff4ff; color: #002147" title="Download">
                                    <span class="material-symbols-outlined text-lg">download</span>
                                </a>
                                @endif
                                <a href="{{ route('surat.edit', $surat->id) }}" class="btn-icon btn-icon-edit" title="Edit">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                @if(auth()->user()->isAdmin())
                                <form id="del-{{ $surat->id }}" action="{{ route('surat.destroy', $surat->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('del-{{ $surat->id }}')" class="btn-icon btn-icon-delete" title="Hapus">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($surats->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-sm text-gray-500">
                Menampilkan {{ $surats->firstItem() }}–{{ $surats->lastItem() }} dari {{ $surats->total() }} entri
            </p>
            <div class="flex items-center gap-1">
                @if($surats->onFirstPage())
                <span class="px-3 py-1.5 rounded-lg text-sm text-gray-300 border border-gray-100">‹</span>
                @else
                <a href="{{ $surats->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-sm text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">‹</a>
                @endif

                @foreach($surats->getUrlRange(max(1,$surats->currentPage()-2), min($surats->lastPage(),$surats->currentPage()+2)) as $page => $url)
                <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg text-sm border transition-colors {{ $page == $surats->currentPage() ? 'text-white border-navy-900' : 'text-gray-600 border-gray-200 hover:bg-gray-50' }}" style="{{ $page == $surats->currentPage() ? 'background: #002147' : '' }}">{{ $page }}</a>
                @endforeach

                @if($surats->hasMorePages())
                <a href="{{ $surats->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-sm text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">›</a>
                @else
                <span class="px-3 py-1.5 rounded-lg text-sm text-gray-300 border border-gray-100">›</span>
                @endif
            </div>
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
