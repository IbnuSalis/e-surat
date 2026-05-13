<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Auto-update agenda status daily
Schedule::call(function () {
    \App\Models\Agenda::where('tanggal_mulai', '<=', now())
        ->where('tanggal_selesai', '>=', now())
        ->where('status', 'upcoming')
        ->update(['status' => 'ongoing']);

    \App\Models\Agenda::where('tanggal_selesai', '<', now())
        ->where('status', 'ongoing')
        ->update(['status' => 'completed']);
})->daily()->name('update-agenda-status');

// Auto clean log older than 90 days
Schedule::call(function () {
    \App\Models\LogAktivitas::where('created_at', '<', now()->subDays(90))->delete();
})->weekly()->name('clean-old-logs');
