<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Lupa Password — E-Surat</title>
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
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-blue-950 to-navy-950 p-4" style="background: linear-gradient(135deg, #000a1e 0%, #002147 60%, #001a3a 100%)">
    <div class="w-full max-w-[440px]">
        <div class="bg-white/95 backdrop-blur rounded-3xl p-8 shadow-2xl border border-white/30">
            <!-- Back -->
            <a href="{{ route('login') }}" class="flex items-center gap-2 text-sm text-gray-500 hover:text-navy-900 mb-6 transition-colors">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali ke Login
            </a>

            <!-- Icon -->
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5 mx-auto" style="background: #e8f0ff">
                <span class="material-symbols-outlined text-3xl" style="color: #002147; font-variation-settings:'FILL' 1">lock_reset</span>
            </div>

            <h2 class="font-heading font-bold text-2xl text-gray-900 text-center mb-2">Lupa Password?</h2>
            <p class="text-sm text-gray-500 text-center mb-7 leading-relaxed">
                Masukkan email akun Anda dan kami akan mengirimkan link untuk mereset password.
            </p>

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-5 flex items-center gap-3">
                <span class="material-symbols-outlined text-green-500" style="font-variation-settings:'FILL' 1">check_circle</span>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5">
                @foreach($errors->all() as $error)
                <p class="text-sm text-red-600">{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 text-xl">mail</span>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@kediri.go.id"
                            class="form-input pl-12" required/>
                    </div>
                </div>
                <button type="submit" class="w-full py-3 rounded-xl text-white font-semibold text-base flex items-center justify-center gap-2 transition-all hover:-translate-y-0.5 hover:shadow-lg" style="background: #002147">
                    <span class="material-symbols-outlined text-xl">send</span>
                    Kirim Link Reset
                </button>
            </form>

            <p class="text-center text-xs text-gray-400 mt-6">
                Ingat password Anda?
                <a href="{{ route('login') }}" class="text-navy-900 font-semibold hover:underline" style="color: #002147">Masuk di sini</a>
            </p>
        </div>
    </div>
</body>
</html>
