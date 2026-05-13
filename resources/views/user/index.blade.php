@extends('layouts.app')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')
@section('page-subtitle', 'Kelola akun dan hak akses pengguna')

@section('content')
<div class="fade-in-up">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <p class="text-gray-500 text-sm">Total: <strong class="text-gray-900">{{ $users->total() }}</strong> pengguna</p>
        <a href="{{ route('users.create') }}" class="btn-primary flex-shrink-0">
            <span class="material-symbols-outlined text-xl">person_add</span>
            Tambah User
        </a>
    </div>

    <!-- Filters -->
    <div class="card p-5 mb-5">
        <form action="{{ route('users.index') }}" method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="form-label">Cari User</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 text-lg">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau email..." class="form-input pl-10"/>
                </div>
            </div>
            <div class="min-w-[160px]">
                <label class="form-label">Role</label>
                <select name="role" class="form-input">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn-primary">
                    <span class="material-symbols-outlined text-lg">filter_list</span>
                    Filter
                </button>
                @if(request()->hasAny(['search','role']))
                <a href="{{ route('users.index') }}" class="btn-secondary">
                    <span class="material-symbols-outlined text-lg">clear</span>
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <div class="card overflow-hidden">
        @if($users->isEmpty())
        <div class="text-center py-16">
            <span class="material-symbols-outlined text-6xl text-gray-200">group</span>
            <h3 class="font-heading font-semibold text-gray-500 mt-3">Tidak ada pengguna</h3>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="data-table w-full">
                <thead>
                    <tr>
                        <th class="text-left w-12">#</th>
                        <th class="text-left">Pengguna</th>
                        <th class="text-left">Role</th>
                        <th class="text-left">Jabatan</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Login Terakhir</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $i => $user)
                    <tr>
                        <td class="text-gray-400 text-xs">{{ $users->firstItem() + $i }}</td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-sm font-heading flex-shrink-0" style="background: #002147">
                                    {{ $user->initials }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm flex items-center gap-1.5">
                                        {{ $user->name }}
                                        @if($user->id === auth()->id())
                                        <span class="text-xs bg-yellow-100 text-yellow-700 px-1.5 py-0.5 rounded-md font-medium">Anda</span>
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-{{ $user->role }}">{{ $user->role_label }}</span></td>
                        <td class="text-sm text-gray-700">{{ $user->jabatan ?? '—' }}</td>
                        <td>
                            <span class="badge badge-{{ $user->status }}">
                                {{ $user->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="text-sm text-gray-500">
                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah' }}
                        </td>
                        <td>
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn-icon btn-icon-edit" title="Edit">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <!-- Reset Password -->
                                <form id="reset-{{ $user->id }}" action="{{ route('users.reset-password', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="button" onclick="confirmDelete('reset-{{ $user->id }}')" class="btn-icon" style="background: #fef3c7; color: #92400e" title="Reset Password">
                                        <span class="material-symbols-outlined text-lg">key</span>
                                    </button>
                                </form>
                                <!-- Toggle Status -->
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.toggle-status', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-icon {{ $user->status === 'active' ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }}" title="{{ $user->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <span class="material-symbols-outlined text-lg">{{ $user->status === 'active' ? 'person_off' : 'person' }}</span>
                                    </button>
                                </form>
                                <!-- Delete -->
                                <form id="del-user-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('del-user-{{ $user->id }}')" class="btn-icon btn-icon-delete" title="Hapus">
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
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-sm text-gray-500">Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} entri</p>
            <div class="flex items-center gap-1">
                @if($users->onFirstPage())<span class="px-3 py-1.5 rounded-lg text-sm text-gray-300 border">‹</span>
                @else<a href="{{ $users->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-sm border hover:bg-gray-50">‹</a>@endif
                @if($users->hasMorePages())<a href="{{ $users->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-sm border hover:bg-gray-50">›</a>
                @else<span class="px-3 py-1.5 rounded-lg text-sm text-gray-300 border">›</span>@endif
            </div>
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
