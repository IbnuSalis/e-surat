<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>403 — Akses Ditolak | E-Surat</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center" style="background: #f0f4ff; font-family: 'Inter', sans-serif">
    <div class="text-center p-8 max-w-md">
        <div class="w-24 h-24 rounded-3xl mx-auto mb-6 flex items-center justify-center" style="background: #fee2e2">
            <span class="material-symbols-outlined text-5xl text-red-600" style="font-variation-settings:'FILL' 1">block</span>
        </div>
        <h1 class="font-bold text-7xl mb-3" style="font-family: 'Poppins'; color: #002147">403</h1>
        <h2 class="font-bold text-xl text-gray-800 mb-3" style="font-family: 'Poppins'">Akses Ditolak</h2>
        <p class="text-gray-500 text-sm mb-8 leading-relaxed">
            Anda tidak memiliki izin untuk mengakses halaman ini. Hubungi administrator jika Anda merasa ini adalah kesalahan.
        </p>
        <div class="flex items-center justify-center gap-3">
            <a href="{{ url()->previous() }}" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold transition-all hover:-translate-y-0.5" style="background: #002147">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali
            </a>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-gray-700 text-sm font-semibold border border-gray-200 hover:bg-gray-50 transition-all">
                <span class="material-symbols-outlined text-lg">home</span>
                Dashboard
            </a>
        </div>
    </div>
</body>
</html>
