<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Reset Password - E-Surat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1,h2,h3 { font-family: 'Poppins', sans-serif; }
        .form-input { border: 1.5px solid #d3e4fe; border-radius: 10px; padding: 11px 14px; font-size: 14px; color: #0b1c30; background: #fff; transition: all 0.2s; width: 100%; }
        .form-input:focus { outline: none; border-color: #002147; box-shadow: 0 0 0 3px rgba(0,33,71,0.10); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(135deg, #000a1e 0%, #002147 60%, #001a3a 100%)">
    <div class="w-full max-w-[440px]">
        <div class="bg-white/95 backdrop-blur rounded-3xl p-8 shadow-2xl border border-white/30">
            <a href="{{ route('login') }}" class="flex items-center gap-2 text-sm text-gray-500 hover:text-gray-900 mb-6 transition-colors">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali ke Login
            </a>

            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5 mx-auto" style="background: #e8f0ff">
                <span class="material-symbols-outlined text-3xl" style="color: #002147; font-variation-settings:'FILL' 1">password</span>
            </div>

            <h2 class="font-heading font-bold text-2xl text-gray-900 text-center mb-2">Reset Password</h2>
            <p class="text-sm text-gray-500 text-center mb-7 leading-relaxed">
                Masukkan password baru untuk akun Anda.
            </p>

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5">
                @foreach($errors->all() as $error)
                <p class="text-sm text-red-600">{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}"/>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 text-xl">mail</span>
                        <input type="email" name="email" value="{{ old('email', $email) }}" class="form-input pl-12" required autofocus/>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Password Baru</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 text-xl">lock</span>
                        <input type="password" name="password" class="form-input pl-12" required/>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Konfirmasi Password</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 text-xl">lock_reset</span>
                        <input type="password" name="password_confirmation" class="form-input pl-12" required/>
                    </div>
                </div>

                <button type="submit" class="w-full py-3 rounded-xl text-white font-semibold text-base flex items-center justify-center gap-2 transition-all hover:-translate-y-0.5 hover:shadow-lg" style="background: #002147">
                    <span class="material-symbols-outlined text-xl">save</span>
                    Simpan Password Baru
                </button>
            </form>
        </div>
    </div>
</body>
</html>
