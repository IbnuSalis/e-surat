@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('page-subtitle', $user->name)

@section('content')
<div class="fade-in-up max-w-2xl">
    <div class="card p-7">
        <div class="flex items-center gap-3 mb-7 pb-5 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                <span class="material-symbols-outlined text-amber-600" style="font-variation-settings:'FILL' 1">manage_accounts</span>
            </div>
            <div>
                <h3 class="font-heading font-semibold text-gray-900">Edit User</h3>
                <p class="text-sm text-gray-400">{{ $user->email }}</p>
            </div>
        </div>

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="flex flex-col gap-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-input {{ $errors->has('name') ? 'border-red-400' : '' }}"/>
                        @error('name')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-input {{ $errors->has('email') ? 'border-red-400' : '' }}"/>
                        @error('email')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}" class="form-input"/>
                    </div>
                    <div>
                        <label for="role" class="form-label">Role / Hak Akses <span class="text-red-500">*</span></label>
                        <select id="role" name="role" class="form-input" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                        @if($user->id === auth()->id())
                        <p class="text-xs text-amber-600 mt-1.5 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">warning</span>
                            Anda tidak dapat mengubah role akun sendiri
                        </p>
                        <input type="hidden" name="role" value="{{ $user->role }}"/>
                        @endif
                        @error('role')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="phone" class="form-label">No. Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input"/>
                    </div>
                </div>

                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3">
                    <span class="material-symbols-outlined text-amber-600 text-lg mt-0.5 flex-shrink-0" style="font-variation-settings:'FILL' 1">info</span>
                    <div>
                        <p class="text-sm font-semibold text-amber-800">Ganti Password</p>
                        <p class="text-xs text-amber-700 mt-0.5">Untuk mereset password, gunakan tombol "Reset Password" di halaman daftar user. Password tidak dapat diubah di halaman ini.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-5 border-t border-gray-100">
                    <button type="submit" class="btn-primary">
                        <span class="material-symbols-outlined text-xl">save</span>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('users.index') }}" class="btn-secondary">
                        <span class="material-symbols-outlined text-xl">arrow_back</span>
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
