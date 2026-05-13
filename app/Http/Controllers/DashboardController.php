<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\BeritaAcara;
use App\Models\LogAktivitas;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'surat_masuk'   => Surat::masuk()->count(),
            'surat_keluar'  => Surat::keluar()->count(),
            'surat_rahasia' => Surat::rahasia()->count(),
            'agenda_bulan'  => Agenda::bulanIni()->count(),
        ];

        // Chart data - last 6 months
        $chartData = $this->getChartData();

        // Upcoming agendas
        $upcomingAgenda = Agenda::upcoming()->limit(5)->get();

        // Recent activities
        $recentActivity = LogAktivitas::with('user')
            ->latest()
            ->limit(8)
            ->get();

        // Recent berita acara
        $recentBeritaAcara = BeritaAcara::with('creator')
            ->latest()
            ->limit(5)
            ->get();

        // Recent surat
        $recentSurat = Surat::with('creator')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'stats',
            'chartData',
            'upcomingAgenda',
            'recentActivity',
            'recentBeritaAcara',
            'recentSurat'
        ));
    }

    private function getChartData(): array
    {
        $months = [];
        $masukData = [];
        $keluarData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->translatedFormat('M Y');

            $masukData[] = Surat::masuk()
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $keluarData[] = Surat::keluar()
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return [
            'labels'      => $months,
            'masuk'       => $masukData,
            'keluar'      => $keluarData,
        ];
    }
}
