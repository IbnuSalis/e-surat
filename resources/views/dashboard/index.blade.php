@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Utama')
@section('page-subtitle', 'Ringkasan aktivitas dan administrasi desa hari ini')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="fade-in-up">

    <!-- Welcome Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-7">
        <div>
            <h2 class="font-heading font-bold text-2xl text-gray-900">Selamat datang, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-gray-500 text-sm mt-1">{{ now()->translatedFormat('l, d F Y') }} — Sistem berjalan normal</p>
        </div>
        <a href="{{ route('surat.input') }}" class="btn-primary flex-shrink-0">
            <span class="material-symbols-outlined text-xl">add</span>
            Input Surat Baru
        </a>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-7">

        <!-- Surat Masuk -->
        <div class="stat-card card p-6 border-t-4 border-blue-500 group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute -right-3 -top-3 w-20 h-20 bg-blue-50 rounded-full opacity-60 group-hover:scale-125 transition-transform duration-500"></div>
            <div class="flex justify-between items-start relative">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Surat Masuk</p>
                    <h3 class="font-heading font-bold text-4xl text-gray-900">{{ number_format($stats['surat_masuk']) }}</h3>
                    <p class="text-xs text-blue-600 flex items-center gap-1 mt-2 font-medium">
                        <span class="material-symbols-outlined text-sm">trending_up</span>
                        Total keseluruhan
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings:'FILL' 1">mail</span>
                </div>
            </div>
        </div>

        <!-- Surat Keluar -->
        <div class="stat-card card p-6 border-t-4 group hover:-translate-y-1 transition-transform duration-300" style="border-color: #002147">
            <div class="absolute -right-3 -top-3 w-20 h-20 rounded-full opacity-60 group-hover:scale-125 transition-transform duration-500" style="background: #e8f0ff"></div>
            <div class="flex justify-between items-start relative">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Surat Keluar</p>
                    <h3 class="font-heading font-bold text-4xl text-gray-900">{{ number_format($stats['surat_keluar']) }}</h3>
                    <p class="text-xs text-gray-500 flex items-center gap-1 mt-2 font-medium">
                        <span class="material-symbols-outlined text-sm">horizontal_rule</span>
                        Total keseluruhan
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: #e8f0ff; color: #002147">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings:'FILL' 1">send</span>
                </div>
            </div>
        </div>

        <!-- Surat Rahasia -->
        <div class="stat-card card p-6 border-t-4 border-red-500 group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute -right-3 -top-3 w-20 h-20 bg-red-50 rounded-full opacity-60 group-hover:scale-125 transition-transform duration-500"></div>
            <div class="flex justify-between items-start relative">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Surat Rahasia</p>
                    <h3 class="font-heading font-bold text-4xl text-gray-900">{{ number_format($stats['surat_rahasia']) }}</h3>
                    <p class="text-xs text-red-600 flex items-center gap-1 mt-2 font-medium">
                        <span class="material-symbols-outlined text-sm">warning</span>
                        Perlu tinjauan
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center text-red-600 flex-shrink-0">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings:'FILL' 1">security</span>
                </div>
            </div>
        </div>

        <!-- Agenda Bulan Ini -->
        <div class="stat-card p-6 group hover:-translate-y-1 transition-transform duration-300" style="background: linear-gradient(135deg, #002147 0%, #003366 100%); border-radius: 16px; box-shadow: 0 10px 30px rgba(0,33,71,0.20)">
            <div class="absolute right-0 top-0 w-28 h-28 rounded-bl-full opacity-20" style="background: #fed65b"></div>
            <div class="flex justify-between items-start relative">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(174,199,246,0.7)">Agenda Bulan Ini</p>
                    <h3 class="font-heading font-bold text-4xl text-white">{{ number_format($stats['agenda_bulan']) }}</h3>
                    <p class="text-xs flex items-center gap-1 mt-2 font-medium" style="color: #fed65b">
                        <span class="material-symbols-outlined text-sm">event_upcoming</span>
                        Kegiatan terjadwal
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(254,214,91,0.2)">
                    <span class="material-symbols-outlined text-2xl" style="color: #fed65b; font-variation-settings:'FILL' 1">calendar_month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Middle Row: Chart + Agenda -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

        <!-- Chart -->
        <div class="lg:col-span-2 card p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-heading font-semibold text-gray-900 text-base">Statistik Surat Bulanan</h3>
                    <p class="text-xs text-gray-500 mt-0.5">6 bulan terakhir</p>
                </div>
                <div class="flex gap-4 text-xs font-semibold">
                    <span class="flex items-center gap-1.5 text-blue-600">
                        <span class="w-3 h-3 rounded-full bg-blue-500 inline-block"></span> Surat Masuk
                    </span>
                    <span class="flex items-center gap-1.5" style="color: #002147">
                        <span class="w-3 h-3 rounded-full inline-block" style="background: #002147"></span> Surat Keluar
                    </span>
                </div>
            </div>
            <canvas id="suratChart" height="200"></canvas>
        </div>

        <!-- Upcoming Agenda -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-heading font-semibold text-gray-900 text-base">Agenda Mendatang</h3>
                <a href="{{ route('agenda.index') }}" class="text-xs font-semibold hover:underline" style="color: #002147">Lihat semua</a>
            </div>
            @if($upcomingAgenda->isEmpty())
            <div class="text-center py-8">
                <span class="material-symbols-outlined text-5xl text-gray-300">event_busy</span>
                <p class="text-sm text-gray-400 mt-2">Tidak ada agenda mendatang</p>
            </div>
            @else
            <div class="flex flex-col gap-3">
                @foreach($upcomingAgenda as $agenda)
                <div class="flex gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                    <div class="flex-shrink-0 w-11 h-11 rounded-xl flex flex-col items-center justify-center text-white text-xs font-bold" style="background: {{ $agenda->warna }}">
                        <span class="text-lg leading-none font-heading">{{ $agenda->tanggal_mulai->format('d') }}</span>
                        <span class="text-[9px] opacity-80">{{ $agenda->tanggal_mulai->format('M') }}</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate font-heading">{{ $agenda->judul }}</p>
                        <p class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                            <span class="material-symbols-outlined text-sm">location_on</span>
                            {{ $agenda->lokasi ?? 'Lokasi belum ditentukan' }}
                        </p>
                        <p class="text-xs text-gray-400 flex items-center gap-1 mt-0.5">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            {{ $agenda->tanggal_mulai->format('H:i') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- Bottom Row: Recent Surat + Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <!-- Recent Surat -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-heading font-semibold text-gray-900 text-base">Surat Terbaru</h3>
                <a href="{{ route('surat.masuk') }}" class="text-xs font-semibold hover:underline" style="color: #002147">Lihat semua</a>
            </div>
            @if($recentSurat->isEmpty())
            <div class="text-center py-8">
                <span class="material-symbols-outlined text-5xl text-gray-300">inbox</span>
                <p class="text-sm text-gray-400 mt-2">Belum ada surat</p>
            </div>
            @else
            <div class="flex flex-col gap-2">
                @foreach($recentSurat as $surat)
                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ $surat->jenis_surat === 'masuk' ? 'bg-blue-100' : 'bg-purple-100' }}">
                        <span class="material-symbols-outlined text-lg {{ $surat->jenis_surat === 'masuk' ? 'text-blue-600' : 'text-purple-600' }}" style="font-variation-settings:'FILL' 1">
                            {{ $surat->jenis_surat === 'masuk' ? 'mail' : 'send' }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate font-heading">{{ $surat->nama_surat }}</p>
                        <p class="text-xs text-gray-400">{{ $surat->kode_surat }} · {{ $surat->tanggal_surat->format('d M Y') }}</p>
                    </div>
                    <span class="badge badge-{{ $surat->kategori }}">{{ $surat->kategori_label }}</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Recent Activity -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-heading font-semibold text-gray-900 text-base">Aktivitas Terbaru</h3>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('log-aktivitas.index') }}" class="text-xs font-semibold hover:underline" style="color: #002147">Lihat semua</a>
                @endif
            </div>
            @if($recentActivity->isEmpty())
            <div class="text-center py-8">
                <span class="material-symbols-outlined text-5xl text-gray-300">timeline</span>
                <p class="text-sm text-gray-400 mt-2">Belum ada aktivitas</p>
            </div>
            @else
            <div class="relative">
                <div class="absolute left-4 top-2 bottom-2 w-px bg-gray-100"></div>
                <div class="flex flex-col gap-3">
                    @foreach($recentActivity as $log)
                    @php
                        $colorMap = ['error' => 'red', 'success' => 'green', 'warning' => 'amber', 'info' => 'blue', 'default' => 'gray'];
                        $color = $colorMap[$log->aksi_color] ?? 'gray';
                    @endphp
                    <div class="flex gap-3 pl-2">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 z-10 bg-{{ $color }}-100 ring-2 ring-white">
                            <span class="material-symbols-outlined text-{{ $color }}-600 text-sm" style="font-variation-settings:'FILL' 1">{{ $log->aksi_icon }}</span>
                        </div>
                        <div class="min-w-0 pb-1">
                            <p class="text-sm text-gray-700 leading-snug">{{ $log->deskripsi }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                <span class="font-medium text-gray-600">{{ $log->user->name ?? 'System' }}</span>
                                · {{ $log->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Berita Acara Terbaru -->
    @if($recentBeritaAcara->isNotEmpty())
    <div class="card p-6 mt-5">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-heading font-semibold text-gray-900 text-base">Berita Acara Terbaru</h3>
            <a href="{{ route('berita-acara.index') }}" class="text-xs font-semibold hover:underline" style="color: #002147">Lihat semua</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($recentBeritaAcara as $ba)
            <div class="border border-gray-100 rounded-xl p-4 hover:border-blue-200 hover:bg-blue-50/30 transition-all cursor-pointer">
                <div class="flex items-start justify-between gap-2 mb-2">
                    <span class="text-xs font-mono text-gray-400">{{ $ba->nomor }}</span>
                    <span class="badge badge-{{ $ba->status }}">{{ $ba->status_label }}</span>
                </div>
                <h4 class="font-heading font-semibold text-sm text-gray-900 mb-1 line-clamp-2">{{ $ba->judul }}</h4>
                <p class="text-xs text-gray-500 flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                    {{ $ba->tanggal->format('d M Y') }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
const ctx = document.getElementById('suratChart').getContext('2d');
const chartData = @json($chartData);

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: chartData.labels,
        datasets: [
            {
                label: 'Surat Masuk',
                data: chartData.masuk,
                backgroundColor: 'rgba(59, 130, 246, 0.80)',
                borderRadius: 6,
                borderSkipped: false,
            },
            {
                label: 'Surat Keluar',
                data: chartData.keluar,
                backgroundColor: 'rgba(0, 33, 71, 0.80)',
                borderRadius: 6,
                borderSkipped: false,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#fff',
                titleColor: '#0b1c30',
                bodyColor: '#44474e',
                borderColor: '#e5eeff',
                borderWidth: 1,
                padding: 12,
                boxPadding: 6,
                callbacks: {
                    title: (items) => items[0].label,
                    label: (item) => ` ${item.dataset.label}: ${item.raw} surat`
                }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: { font: { family: 'Inter', size: 12 }, color: '#74777f' },
                border: { display: false },
            },
            y: {
                grid: { color: '#f0f4ff' },
                ticks: { font: { family: 'Inter', size: 12 }, color: '#74777f', stepSize: 1 },
                border: { display: false },
            }
        },
        interaction: { mode: 'index', intersect: false },
        barPercentage: 0.65,
        categoryPercentage: 0.80,
    }
});
</script>
@endsection
