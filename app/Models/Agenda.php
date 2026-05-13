<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agenda';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi',
        'penanggung_jawab',
        'status',
        'warna',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai'   => 'datetime',
            'tanggal_selesai' => 'datetime',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'upcoming'   => 'Akan Datang',
            'ongoing'    => 'Berlangsung',
            'completed'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
            default      => 'Akan Datang',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'upcoming'  => 'badge-upcoming',
            'ongoing'   => 'badge-ongoing',
            'completed' => 'badge-completed',
            'cancelled' => 'badge-cancelled',
            default     => 'badge-upcoming',
        };
    }

    public function scopeUpcoming($query)
    {
        return $query->where('tanggal_mulai', '>=', now())->orderBy('tanggal_mulai');
    }

    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal_mulai', now()->month)
                     ->whereYear('tanggal_mulai', now()->year);
    }
}