@extends('layouts.app')

@section('title', 'Surat Rahasia')
@section('page-title', 'Surat Rahasia')
@section('page-subtitle', 'Dokumen dengan klasifikasi rahasia')

@section('content')
<div class="fade-in-up">

    <!-- Security notice -->
    <div class="flex items-center gap-3 p-4 rounded-xl mb-6" style="background: #fff0f0; border: 1.5px solid #fecaca">
        <span class="material-symbols-outlined text-red-600 text-xl flex-shrink-0" style="font-variation-settings:'FILL' 1">security</span>
        <div>
            <p class="text-sm font-semibold text-red-800">Halaman Terproteksi — Surat Rahasia</p>
            <p class="text-xs text-red-600 mt-0.5">Akses halaman ini dicatat dalam log aktivitas. Dilarang mendistribusikan konten kepada pihak yang tidak berwenang.</p>
        </div>
        <form action="{{ route('surat.rahasia') }}" method="GET" class="ml-auto">
            <button type="submit" onclick="clearSession()" class="text-xs text-red-600 hover:text-red-800 font-semibold flex items-center gap-1 flex-shrink-0">
                <span class="material-symbols-outlined text-sm">lock</span>
                Kunci
            </button>
        </form>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <p class="text-gray-500 text-sm">Total: <strong class="text-gray-900">{{ $surats->total() }}</strong> dokumen rahasia</p>
        <a href="{{ route('surat.input') }}" class="btn-primary flex-shrink-0" style="background: #dc2626">
            <span class="material-symbols-outlined text-xl">add</span>
            Tambah Dokumen Rahasia
        </a>
    </div>

    <div class="card overflow-hidden">
        @if($surats->isEmpty())
        <div class="text-center py-16">
            <span class="material-symbols-outlined text-6xl text-gray-200">shield</span>
            <h3 class="font-heading font-semibold text-gray-500 mt-3">Tidak ada dokumen rahasia</h3>
            <p class="text-sm text-gray-400 mt-1">Belum ada surat dengan kategori rahasia.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="data-table w-full">
                <thead>
                    <tr>
                        <th class="text-left w-12">#</th>
                        <th class="text-left">Kode Surat</th>
                        <th class="text-left">Nama Surat</th>
                        <th class="text-left">Jenis</th>
                        <th class="text-left">Tanggal</th>
                        <th class="text-left">Dibuat Oleh</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surats as $i => $surat)
                    <tr>
                        <td class="text-gray-400 text-xs">{{ $surats->firstItem() + $i }}</td>
                        <td>
                            <span class="font-mono text-xs font-semibold bg-red-50 text-red-800 px-2.5 py-1 rounded-lg">{{ $surat->kode_surat }}</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-red-500 text-sm" style="font-variation-settings:'FILL' 1">lock</span>
                                <p class="font-semibold text-gray-900 text-sm">{{ $surat->nama_surat }}</p>
                            </div>
                        </td>
                        <td><span class="badge badge-{{ $surat->jenis_surat }}">{{ $surat->jenis_label }}</span></td>
                        <td>
                            <p class="text-sm text-gray-700">{{ $surat->tanggal_surat->format('d M Y') }}</p>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold font-heading flex-shrink-0" style="background: #002147">
                                    {{ $surat->creator->initials ?? '?' }}
                                </div>
                                <span class="text-sm text-gray-700">{{ $surat->creator->name ?? 'Unknown' }}</span>
                            </div>
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
        @if($surats->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-sm text-gray-500">Menampilkan {{ $surats->firstItem() }}–{{ $surats->lastItem() }} dari {{ $surats->total() }} entri</p>
            {{ $surats->links() }}
        </div>
        @endif
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
function clearSession() {
    // Expire the session flag via AJAX or reload
    fetch('/surat/store', { method: 'GET' }); // Just navigate away, session clears on next visit
}
</script>
@endsection
