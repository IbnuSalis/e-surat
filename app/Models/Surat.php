<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_surat',
        'nama_surat',
        'jenis_surat',
        'kategori',
        'tanggal_surat',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'keterangan',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
        ];
    }

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeMasuk($query)
    {
        return $query->where('jenis_surat', 'masuk');
    }

    public function scopeKeluar($query)
    {
        return $query->where('jenis_surat', 'keluar');
    }

    public function scopeRahasia($query)
    {
        return $query->where('kategori', 'rahasia');
    }

    // Helpers
    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'umum'    => 'Umum',
            'penting' => 'Penting',
            'rahasia' => 'Rahasia',
            default   => 'Umum',
        };
    }

    public function getKategoriBadgeClassAttribute(): string
    {
        return match ($this->kategori) {
            'umum'    => 'badge-umum',
            'penting' => 'badge-penting',
            'rahasia' => 'badge-rahasia',
            default   => 'badge-umum',
        };
    }

    public function getJenisLabelAttribute(): string
    {
        return match ($this->jenis_surat) {
            'masuk'  => 'Surat Masuk',
            'keluar' => 'Surat Keluar',
            default  => $this->jenis_surat,
        };
    }

    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) return '-';
        $bytes = $this->file_size;
        if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return round($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }
}
