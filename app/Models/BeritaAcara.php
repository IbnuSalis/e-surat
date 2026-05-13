<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    use HasFactory;

    protected $table = 'berita_acara';

    protected $fillable = [
        'nomor',
        'judul',
        'tanggal',
        'lokasi',
        'isi',
        'peserta',
        'status',
        'file_path',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft'     => 'Draft',
            'final'     => 'Final',
            'approved'  => 'Disetujui',
            default     => 'Draft',
        };
    }
}
