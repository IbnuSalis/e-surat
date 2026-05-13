<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Login — E-Surat | Sistem Informasi Manajemen Surat Desa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-heading { font-family: 'Poppins', sans-serif; }

        .bg-kediri {
            background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuABF9dSuimZeuBjNcEK0SGOzddmCTKJHYY3E9ll0ANoHIfxNhVfuRgjpg9bvaY1p2P17tWY9fFxcvCtVCpJAW2pfLxM47zf_AwYorlct2uWkOHMSWEbqMa-WZMsca3BeFsOBxUEIykX67MEFWJkv0ZiuSBzI_yurSWxg4crIMBzx27cPid95O4nBSndNXXSeJsF3ZK9wEworRqFtdxWuNe22WYSL2c6_iQf1exdST1cehtcOiZrVz5KjdsEBtsJpR8B1ELYydVP_4I');
            background-size: cover;
            background-position: center;
        }

        .glass-card {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.5);
        }

        .form-input {
            border: 1.5px solid #d3e4fe;
            border-radius: 10px;
            padding: 11px 14px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: #0b1c30;
            background: #fff;
            transition: all 0.2s;
            width: 100%;
        }
        .form-input:focus {
            outline: none;
            border-color: #002147;
            box-shadow: 0 0 0 3px rgba(0,33,71,0.10);
        }
        .form-input.error {
            border-color: #dc2626;
        }

        .btn-login {
            background: #002147;
            color: #fff;
            padding: 13px 24px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            border: none;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.25s;
            letter-spacing: 0.01em;
        }
        .btn-login:hover {
            background: #001632;
            box-shadow: 0 8px 24px rgba(0,33,71,0.30);
            transform: translateY(-1px);
        }
        .btn-login:active {
            transform: translateY(0);
        }

        .logo-circle {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,33,71,0.15);
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(254,214,91,0.15);
            animation: float linear infinite;
        }
        @keyframes float {
            0%   { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up { animation: fadeInUp 0.5s ease both; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden bg-kediri">

    <!-- Dark Overlay -->
    <div class="absolute inset-0 z-0" style="background: linear-gradient(135deg, rgba(0,10,30,0.75) 0%, rgba(0,33,71,0.65) 100%)"></div>

    <!-- Floating Particles -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="particle" style="width:60px;height:60px;left:10%;animation-duration:15s;animation-delay:0s"></div>
        <div class="particle" style="width:40px;height:40px;left:30%;animation-duration:12s;animation-delay:3s"></div>
        <div class="particle" style="width:80px;height:80px;left:60%;animation-duration:18s;animation-delay:1s"></div>
        <div class="particle" style="width:30px;height:30px;left:80%;animation-duration:10s;animation-delay:5s"></div>
        <div class="particle" style="width:50px;height:50px;left:50%;animation-duration:14s;animation-delay:2s"></div>
    </div>

    <!-- Login Card -->
    <main class="relative z-10 w-full max-w-[460px] fade-in-up">
        <div class="glass-card rounded-3xl p-8 shadow-2xl">

            <!-- Logos -->
            <div class="flex items-center justify-center gap-4 mb-7 fade-in-up delay-1">
                <div class="logo-circle bg-navy-50" style="background: #e8f0ff; border: 2px solid rgba(0,33,71,0.12)">
                    <span class="material-symbols-outlined text-4xl" style="color: #002147; font-variation-settings: 'FILL' 1">account_balance</span>
                </div>
                <div class="w-px h-12 bg-gray-200"></div>
                <div class="logo-circle" style="background: #fffde7; border: 2px solid rgba(254,214,91,0.40)">
                    <span class="material-symbols-outlined text-4xl" style="color: #b45309; font-variation-settings: 'FILL' 1">other_houses</span>
                </div>
            </div>

            <!-- Title -->
            <div class="text-center mb-7 fade-in-up delay-2">
                <h1 class="font-heading font-bold text-2xl leading-tight mb-2" style="color: #000a1e">E-Surat</h1>
                <p class="text-sm text-gray-500 leading-relaxed">Sistem Informasi Manajemen Surat<br/>Pemerintah Desa Kabupaten Kediri</p>
            </div>

            <!-- Errors -->
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5 flex items-start gap-3 fade-in-up">
                <span class="material-symbols-outlined text-red-500 text-lg mt-0.5 flex-shrink-0" style="font-variation-settings:'FILL' 1">error</span>
                <div>
                    @foreach($errors->all() as $error)
                        <p class="text-sm text-red-600">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
            @endif

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-5 flex items-center gap-3 fade-in-up">
                <span class="material-symbols-outlined text-green-500 text-lg" style="font-variation-settings:'FILL' 1">check_circle</span>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
            @endif

            <!-- Form -->
            <form action="{{ route('login') }}" method="POST" class="fade-in-up delay-3">
                @csrf

                <!-- Email -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold mb-2" style="color: #0b1c30; font-family: 'Inter'">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-gray-400 text-xl">mail</span>
                        </div>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            placeholder="admin@kediri.go.id"
                            class="form-input pl-12 {{ $errors->has('email') ? 'error' : '' }}"
                            autocomplete="email"
                            required
                        />
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold mb-2" style="color: #0b1c30; font-family: 'Inter'">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-gray-400 text-xl">lock</span>
                        </div>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="••••••••"
                            class="form-input pl-12 pr-12 {{ $errors->has('password') ? 'error' : '' }}"
                            autocomplete="current-password"
                            required
                        />
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                            <span class="material-symbols-outlined text-xl" id="password-eye">visibility_off</span>
                        </button>
                    </div>
                </div>

                <!-- Remember + Forgot -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2.5 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 accent-navy-900" style="accent-color: #002147"/>
                        <span class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors font-inter">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm font-semibold hover:underline transition-colors" style="color: #002147; font-family: 'Inter'">Lupa password?</a>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-login">
                    <span>Masuk ke Sistem</span>
                    <span class="material-symbols-outlined text-xl">login</span>
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-7 pt-5 border-t border-gray-100 text-center fade-in-up delay-4">
                <p class="text-xs text-gray-400">
                    © {{ date('Y') }} Pemerintah Kabupaten Kediri<br/>
                    Dilindungi oleh sistem keamanan berlapis
                </p>
                <div class="flex items-center justify-center gap-3 mt-3">
                    <span class="flex items-center gap-1 text-xs text-gray-400">
                        <span class="material-symbols-outlined text-sm text-green-500">shield</span>
                        SSL Secured
                    </span>
                    <span class="w-px h-3 bg-gray-200"></span>
                    <span class="flex items-center gap-1 text-xs text-gray-400">
                        <span class="material-symbols-outlined text-sm text-blue-500">verified_user</span>
                        Data Terenkripsi
                    </span>
                </div>
            </div>
        </div>

        <!-- Demo credentials -->
        <div class="mt-4 glass-card rounded-2xl p-4 text-center" style="background: rgba(0,33,71,0.7); border-color: rgba(254,214,91,0.3)">
            <p class="text-xs text-gold-300 font-semibold mb-2" style="color: #fed65b; font-family: 'Inter'">🔑 Demo Credentials</p>
            <div class="flex gap-4 justify-center text-xs" style="color: rgba(255,255,255,0.8); font-family: 'Inter'">
                <div>
                    <p class="font-semibold text-white">Admin:</p>
                    <p>admin@kediri.go.id</p>
                    <p>password</p>
                </div>
                <div class="w-px bg-white/20"></div>
                <div>
                    <p class="font-semibold text-white">Staff:</p>
                    <p>budi@kediri.go.id</p>
                    <p>password</p>
                </div>
            </div>
        </div>
    </main>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const eye = document.getElementById('password-eye');
            if (input.type === 'password') {
                input.type = 'text';
                eye.textContent = 'visibility';
            } else {
                input.type = 'password';
                eye.textContent = 'visibility_off';
            }
        }
    </script>
</body>
</html>
