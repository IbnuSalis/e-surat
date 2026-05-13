@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi dan keamanan akun Anda')

@section('content')
<div class="fade-in-up">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left: Profile Card -->
        <div class="lg:col-span-1 flex flex-col gap-5">

            <!-- Avatar + Info -->
            <div class="card p-6 text-center">
                <!-- Avatar -->
                <div class="relative inline-block mb-4">
                    <div class="w-24 h-24 rounded-2xl mx-auto overflow-hidden border-4 border-white shadow-medium" style="box-shadow: 0 8px 24px rgba(0,33,71,0.12)">
                        @if($user->foto && file_exists(storage_path('app/public/' . $user->foto)))
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->name }}" class="w-full h-full object-cover"/>
                        @else
                        <div class="w-full h-full flex items-center justify-center text-white font-heading font-bold text-3xl" style="background: #002147">
                            {{ $user->initials }}
                        </div>
                        @endif
                    </div>
                    <!-- Upload trigger -->
                    <label for="foto-upload" class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full flex items-center justify-center cursor-pointer shadow-md border-2 border-white" style="background: #fed65b">
                        <span class="material-symbols-outlined text-sm" style="color: #002147">photo_camera</span>
                    </label>
                </div>

                <h3 class="font-heading font-bold text-xl text-gray-900">{{ $user->name }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $user->jabatan ?? 'Tidak ada jabatan' }}</p>
                <div class="flex items-center justify-center gap-2 mt-2">
                    <span class="badge badge-{{ $user->role }}">{{ $user->role_label }}</span>
                    <span class="badge badge-{{ $user->status }}">{{ $user->status === 'active' ? 'Aktif' : 'Nonaktif' }}</span>
                </div>

                <div class="mt-5 pt-5 border-t border-gray-100 space-y-3 text-left">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-gray-400 text-lg flex-shrink-0">mail</span>
                        <p class="text-sm text-gray-600 truncate">{{ $user->email }}</p>
                    </div>
                    @if($user->phone)
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-gray-400 text-lg flex-shrink-0">phone</span>
                        <p class="text-sm text-gray-600">{{ $user->phone }}</p>
                    </div>
                    @endif
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-gray-400 text-lg flex-shrink-0">login</span>
                        <p class="text-sm text-gray-600">
                            {{ $user->last_login_at ? 'Login terakhir ' . $user->last_login_at->diffForHumans() : 'Belum pernah login' }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-gray-400 text-lg flex-shrink-0">calendar_today</span>
                        <p class="text-sm text-gray-600">Bergabung {{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card p-6">
                <h4 class="font-heading font-semibold text-gray-900 mb-4">Aktivitas Saya</h4>
                @if($recentActivity->isEmpty())
                <div class="text-center py-6">
                    <span class="material-symbols-outlined text-4xl text-gray-200">timeline</span>
                    <p class="text-sm text-gray-400 mt-2">Belum ada aktivitas</p>
                </div>
                @else
                <div class="relative">
                    <div class="absolute left-3.5 top-2 bottom-2 w-px bg-gray-100"></div>
                    <div class="flex flex-col gap-3">
                        @foreach($recentActivity->take(6) as $log)
                        @php
                            $c = match($log->aksi_color){
                                'error' => 'red','success' => 'green','warning' => 'amber','info' => 'blue',default => 'gray'
                            };
                        @endphp
                        <div class="flex gap-3 pl-1">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 z-10 bg-{{ $c }}-100 ring-2 ring-white mt-0.5">
                                <span class="material-symbols-outlined text-{{ $c }}-600 text-xs" style="font-variation-settings:'FILL' 1; font-size: 14px">{{ $log->aksi_icon }}</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-gray-700">{{ $log->aksi_label }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Right: Forms -->
        <div class="lg:col-span-2 flex flex-col gap-5">

            <!-- Upload Photo Form (hidden, triggered from avatar) -->
            <form action="{{ route('profile.photo') }}" method="POST" enctype="multipart/form-data" id="photo-form">
                @csrf
                <input type="file" id="foto-upload" name="foto" class="hidden" accept="image/jpeg,image/png,image/jpg" onchange="document.getElementById('photo-form').submit()"/>
            </form>

            <!-- Edit Profile -->
            <div class="card p-6">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background: #e8f0ff">
                        <span class="material-symbols-outlined text-lg" style="color: #002147; font-variation-settings:'FILL' 1">person_edit</span>
                    </div>
                    <div>
                        <h4 class="font-heading font-semibold text-gray-900">Informasi Profil</h4>
                        <p class="text-xs text-gray-400">Perbarui data diri Anda</p>
                    </div>
                </div>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
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
                            <label for="phone" class="form-label">No. Telepon</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx" class="form-input"/>
                        </div>
                        <div class="md:col-span-2">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}" placeholder="Jabatan di pemerintahan desa..." class="form-input"/>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary">
                        <span class="material-symbols-outlined text-xl">save</span>
                        Simpan Profil
                    </button>
                </form>
            </div>

            <!-- Change Password -->
            <div class="card p-6">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                    <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-lg text-red-600" style="font-variation-settings:'FILL' 1">lock_reset</span>
                    </div>
                    <div>
                        <h4 class="font-heading font-semibold text-gray-900">Ubah Password</h4>
                        <p class="text-xs text-gray-400">Pastikan password baru kuat dan tidak mudah ditebak</p>
                    </div>
                </div>

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="flex flex-col gap-4 mb-5">
                        <div>
                            <label for="current_password" class="form-label">Password Saat Ini <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" id="current_password" name="current_password" placeholder="••••••••" class="form-input pr-10 {{ $errors->has('current_password') ? 'border-red-400' : '' }}"/>
                                <button type="button" onclick="toggleP('current_password','ep1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 focus:outline-none">
                                    <span class="material-symbols-outlined text-lg" id="ep1">visibility_off</span>
                                </button>
                            </div>
                            @error('current_password')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="new_password" class="form-label">Password Baru <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="password" id="new_password" name="password" placeholder="Min. 8 karakter" class="form-input pr-10 {{ $errors->has('password') ? 'border-red-400' : '' }}"/>
                                    <button type="button" onclick="toggleP('new_password','ep2')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 focus:outline-none">
                                        <span class="material-symbols-outlined text-lg" id="ep2">visibility_off</span>
                                    </button>
                                </div>
                                @error('password')<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" class="form-input pr-10"/>
                                    <button type="button" onclick="toggleP('password_confirmation','ep3')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 focus:outline-none">
                                        <span class="material-symbols-outlined text-lg" id="ep3">visibility_off</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div id="strength-wrap" class="hidden">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="flex gap-1 flex-1">
                                    <div id="s1" class="h-1.5 flex-1 rounded-full bg-gray-200 transition-all duration-300"></div>
                                    <div id="s2" class="h-1.5 flex-1 rounded-full bg-gray-200 transition-all duration-300"></div>
                                    <div id="s3" class="h-1.5 flex-1 rounded-full bg-gray-200 transition-all duration-300"></div>
                                    <div id="s4" class="h-1.5 flex-1 rounded-full bg-gray-200 transition-all duration-300"></div>
                                </div>
                                <span id="strength-label" class="text-xs font-semibold text-gray-400 w-16 text-right"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Security tips -->
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-5">
                        <p class="text-xs font-semibold text-blue-800 mb-2">💡 Tips Keamanan Password:</p>
                        <ul class="text-xs text-blue-700 space-y-1">
                            <li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-sm">check</span>Gunakan minimal 8 karakter</li>
                            <li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-sm">check</span>Kombinasikan huruf besar, kecil, angka, dan simbol</li>
                            <li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-sm">check</span>Jangan gunakan informasi pribadi yang mudah ditebak</li>
                        </ul>
                    </div>

                    <button type="submit" class="btn-primary" style="background: #dc2626">
                        <span class="material-symbols-outlined text-xl">lock_reset</span>
                        Ubah Password
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function toggleP(inputId, eyeId) {
    const input = document.getElementById(inputId);
    const eye = document.getElementById(eyeId);
    input.type = input.type === 'password' ? 'text' : 'password';
    eye.textContent = input.type === 'password' ? 'visibility_off' : 'visibility';
}

// Password strength meter
document.getElementById('new_password').addEventListener('input', function() {
    const pw = this.value;
    const wrap = document.getElementById('strength-wrap');
    const label = document.getElementById('strength-label');
    const bars = ['s1','s2','s3','s4'].map(id => document.getElementById(id));

    if (!pw) { wrap.classList.add('hidden'); return; }
    wrap.classList.remove('hidden');

    let score = 0;
    if (pw.length >= 8) score++;
    if (/[A-Z]/.test(pw)) score++;
    if (/[0-9]/.test(pw)) score++;
    if (/[^A-Za-z0-9]/.test(pw)) score++;

    const configs = [
        { color: '#ef4444', label: 'Lemah' },
        { color: '#f97316', label: 'Cukup' },
        { color: '#eab308', label: 'Baik' },
        { color: '#22c55e', label: 'Kuat' },
    ];
    bars.forEach((bar, i) => {
        bar.style.background = i < score ? configs[score - 1]?.color || '#e5e7eb' : '#e5e7eb';
    });
    label.textContent = configs[score - 1]?.label || '';
    label.style.color = configs[score - 1]?.color || '#9ca3af';
});
</script>
@endsection
