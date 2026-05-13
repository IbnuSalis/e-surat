@extends('layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User Baru')
@section('page-subtitle', 'Buat akun pengguna baru')

@section('content')
<div class="fade-in-up max-w-2xl">
    <div class="card p-7">
        <div class="flex items-center gap-3 mb-7 pb-5 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: #e8f0ff">
                <span class="material-symbols-outlined" style="color: #002147; font-variation-settings:'FILL' 1">person_add</span>
            </div>
            <div>
                <h3 class="font-heading font-semibold text-gray-900">Form Tambah User</h3>
                <p class="text-sm text-gray-400">Isi data pengguna baru dengan lengkap</p>
            </div>
        </div>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="flex flex-col gap-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nama lengkap..." class="form-input {{ $errors->has('name') ? 'border-red-400' : '' }}"/>
                        @error('name')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@kediri.go.id" class="form-input {{ $errors->has('email') ? 'border-red-400' : '' }}"/>
                        @error('email')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" placeholder="Sekretaris Desa, Staff, dll" class="form-input"/>
                    </div>
                    <div>
                        <label for="role" class="form-label">Role / Hak Akses <span class="text-red-500">*</span></label>
                        <select id="role" name="role" class="form-input {{ $errors->has('role') ? 'border-red-400' : '' }}">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                        @error('role')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="phone" class="form-label">No. Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" class="form-input"/>
                    </div>
                    <div>
                        <label for="password" class="form-label">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="password" id="password" name="password" placeholder="Min. 8 karakter" class="form-input pr-10 {{ $errors->has('password') ? 'border-red-400' : '' }}"/>
                            <button type="button" onclick="togglePass('password','eye1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 focus:outline-none">
                                <span class="material-symbols-outlined text-lg" id="eye1">visibility_off</span>
                            </button>
                        </div>
                        @error('password')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" class="form-input pr-10"/>
                            <button type="button" onclick="togglePass('password_confirmation','eye2')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 focus:outline-none">
                                <span class="material-symbols-outlined text-lg" id="eye2">visibility_off</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Role Description -->
                <div id="role-desc" class="hidden p-4 bg-blue-50 border border-blue-100 rounded-xl">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-blue-600 text-lg mt-0.5" style="font-variation-settings:'FILL' 1">info</span>
                        <div id="role-desc-text" class="text-sm text-blue-800"></div>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-5 border-t border-gray-100">
                    <button type="submit" class="btn-primary">
                        <span class="material-symbols-outlined text-xl">person_add</span>
                        Buat Akun
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

@section('scripts')
<script>
function togglePass(id, eyeId) {
    const input = document.getElementById(id);
    const eye = document.getElementById(eyeId);
    input.type = input.type === 'password' ? 'text' : 'password';
    eye.textContent = input.type === 'password' ? 'visibility_off' : 'visibility';
}
document.getElementById('role').addEventListener('change', function() {
    const desc = document.getElementById('role-desc');
    const text = document.getElementById('role-desc-text');
    const descriptions = {
        admin: '<strong>Administrator</strong> — Akses penuh: mengelola seluruh data, user, role, agenda, dan melihat log aktivitas.',
        staff: '<strong>Staff</strong> — Akses terbatas: upload surat, melihat daftar surat. Tidak dapat mengelola user atau role.'
    };
    if (descriptions[this.value]) {
        text.innerHTML = descriptions[this.value];
        desc.classList.remove('hidden');
    } else {
        desc.classList.add('hidden');
    }
});
</script>
@endsection
