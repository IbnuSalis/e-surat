@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas')
@section('page-subtitle', 'Riwayat seluruh aktivitas pengguna dalam sistem')

@section('content')
<div class="fade-in-up">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <p class="text-gray-500 text-sm">Total: <strong class="text-gray-900">{{ $logs->total() }}</strong> entri log</p>
        <form id="clear-form" action="{{ route('log-aktivitas.clear') }}" method="POST">
            @csrf @method('DELETE')
            <button type="button" onclick="confirmDelete('clear-form')" class="btn-danger">
                <span class="material-symbols-outlined text-lg">delete_sweep</span>
                Bersihkan Log Lama
            </button>
        </form>
    </div>

    <!-- Filters -->
    <div class="card p-5 mb-5">
        <form action="{{ route('log-aktivitas.index') }}" method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="form-label">Cari Aktivitas</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 text-lg">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi aktivitas..." class="form-input pl-10"/>
                </div>
            </div>
            <div class="min-w-[180px]">
                <label class="form-label">Jenis Aksi</label>
                <select name="aksi" class="form-input">
                    <option value="">Semua Aksi</option>
                    <option value="login"        {{ request('aksi') === 'login'        ? 'selected' : '' }}>Login</option>
                    <option value="logout"       {{ request('aksi') === 'logout'       ? 'selected' : '' }}>Logout</option>
                    <option value="create_surat" {{ request('aksi') === 'create_surat' ? 'selected' : '' }}>Upload Surat</option>
                    <option value="update_surat" {{ request('aksi') === 'update_surat' ? 'selected' : '' }}>Edit Surat</option>
                    <option value="delete_surat" {{ request('aksi') === 'delete_surat' ? 'selected' : '' }}>Hapus Surat</option>
                    <option value="create_user"  {{ request('aksi') === 'create_user'  ? 'selected' : '' }}>Buat User</option>
                    <option value="delete_user"  {{ request('aksi') === 'delete_user'  ? 'selected' : '' }}>Hapus User</option>
                    <option value="create_agenda"{{ request('aksi') === 'create_agenda'? 'selected' : '' }}>Buat Agenda</option>
                </select>
            </div>
            <div class="min-w-[180px]">
                <label class="form-label">Pengguna</label>
                <select name="user_id" class="form-input">
                    <option value="">Semua Pengguna</option>
                    @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[150px]">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-input"/>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn-primary">
                    <span class="material-symbols-outlined text-lg">filter_list</span>
                    Filter
                </button>
                @if(request()->hasAny(['search','aksi','user_id','tanggal']))
                <a href="{{ route('log-aktivitas.index') }}" class="btn-secondary">
                    <span class="material-symbols-outlined text-lg">clear</span>
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Timeline Log -->
    <div class="card overflow-hidden">
        @if($logs->isEmpty())
        <div class="text-center py-16">
            <span class="material-symbols-outlined text-6xl text-gray-200">manage_search</span>
            <h3 class="font-heading font-semibold text-gray-500 mt-3">Tidak ada log aktivitas</h3>
            <p class="text-sm text-gray-400 mt-1">Belum ada aktivitas yang tercatat.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="data-table w-full">
                <thead>
                    <tr>
                        <th class="text-left w-12">#</th>
                        <th class="text-left">Pengguna</th>
                        <th class="text-left">Aktivitas</th>
                        <th class="text-left">Deskripsi</th>
                        <th class="text-left">IP Address</th>
                        <th class="text-left">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $i => $log)
                    @php
                        $colorMap = [
                            'error'   => ['bg' => '#fee2e2', 'text' => '#dc2626', 'ring' => '#fecaca'],
                            'success' => ['bg' => '#d1fae5', 'text' => '#059669', 'ring' => '#a7f3d0'],
                            'warning' => ['bg' => '#fef3c7', 'text' => '#d97706', 'ring' => '#fde68a'],
                            'info'    => ['bg' => '#dbeafe', 'text' => '#2563eb', 'ring' => '#bfdbfe'],
                            'default' => ['bg' => '#f3f4f6', 'text' => '#6b7280', 'ring' => '#e5e7eb'],
                        ];
                        $c = $colorMap[$log->aksi_color] ?? $colorMap['default'];
                    @endphp
                    <tr>
                        <td class="text-gray-400 text-xs">{{ $logs->firstItem() + $i }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold font-heading flex-shrink-0" style="background: #002147">
                                    {{ $log->user->initials ?? '?' }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $log->user->name ?? 'System' }}</p>
                                    <span class="badge badge-{{ $log->user->role ?? 'staff' }}" style="font-size: 10px; padding: 2px 7px;">
                                        {{ $log->user->role_label ?? '—' }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background: {{ $c['bg'] }}">
                                    <span class="material-symbols-outlined text-sm" style="color: {{ $c['text'] }}; font-variation-settings:'FILL' 1">{{ $log->aksi_icon }}</span>
                                </div>
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-lg" style="background: {{ $c['bg'] }}; color: {{ $c['text'] }}">
                                    {{ $log->aksi_label }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <p class="text-sm text-gray-700 max-w-sm">{{ $log->deskripsi }}</p>
                            @if($log->model_type && $log->model_id)
                            <p class="text-xs text-gray-400 mt-0.5">{{ $log->model_type }} #{{ $log->model_id }}</p>
                            @endif
                        </td>
                        <td>
                            <span class="font-mono text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">{{ $log->ip_address ?? '—' }}</span>
                        </td>
                        <td>
                            <p class="text-sm text-gray-700">{{ $log->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $log->created_at->format('H:i:s') }}</p>
                            <p class="text-xs text-gray-300 mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-sm text-gray-500">Menampilkan {{ $logs->firstItem() }}–{{ $logs->lastItem() }} dari {{ $logs->total() }} entri</p>
            <div class="flex items-center gap-1">
                @if($logs->onFirstPage())
                <span class="px-3 py-1.5 rounded-lg text-sm text-gray-300 border border-gray-100">‹</span>
                @else
                <a href="{{ $logs->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-sm text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">‹</a>
                @endif
                @foreach($logs->getUrlRange(max(1,$logs->currentPage()-2), min($logs->lastPage(),$logs->currentPage()+2)) as $page => $url)
                <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg text-sm border transition-colors {{ $page == $logs->currentPage() ? 'text-white' : 'text-gray-600 border-gray-200 hover:bg-gray-50' }}" style="{{ $page == $logs->currentPage() ? 'background:#002147;border-color:#002147' : '' }}">{{ $page }}</a>
                @endforeach
                @if($logs->hasMorePages())
                <a href="{{ $logs->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-sm text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">›</a>
                @else
                <span class="px-3 py-1.5 rounded-lg text-sm text-gray-300 border border-gray-100">›</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
