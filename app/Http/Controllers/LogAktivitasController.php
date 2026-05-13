<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user');

        if ($request->filled('search')) {
            $query->where('deskripsi', 'like', "%{$request->search}%");
        }

        if ($request->filled('aksi')) {
            $query->where('aksi', $request->aksi);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $logs = $query->latest()->paginate(20)->withQueryString();
        $users = \App\Models\User::select('id', 'name')->get();

        return view('log-aktivitas.index', compact('logs', 'users'));
    }

    public function clear()
    {
        LogAktivitas::where('created_at', '<', now()->subDays(30))->delete();
        return back()->with('success', 'Log aktivitas lama (>30 hari) berhasil dihapus!');
    }
}
