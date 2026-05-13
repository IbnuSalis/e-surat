<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id',
        'aksi',
        'deskripsi',
        'model_type',
        'model_id',
        'ip_address',
        'user_agent',
        'data_lama',
        'data_baru',
    ];

    protected function casts(): array
    {
        return [
            'data_lama' => 'array',
            'data_baru' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAksiLabelAttribute(): string
    {
        return match ($this->aksi) {
            'login'        => 'Login',
            'logout'       => 'Logout',
            'create_surat' => 'Upload Surat',
            'update_surat' => 'Edit Surat',
            'delete_surat' => 'Hapus Surat',
            'create_user'  => 'Buat User',
            'update_user'  => 'Edit User',
            'delete_user'  => 'Hapus User',
            'create_agenda'=> 'Buat Agenda',
            'update_agenda'=> 'Edit Agenda',
            'delete_agenda'=> 'Hapus Agenda',
            default        => ucfirst(str_replace('_', ' ', $this->aksi)),
        };
    }

    public function getAksiIconAttribute(): string
    {
        return match ($this->aksi) {
            'login'        => 'login',
            'logout'       => 'logout',
            'create_surat' => 'upload_file',
            'update_surat' => 'edit_document',
            'delete_surat' => 'delete',
            'create_user'  => 'person_add',
            'update_user'  => 'manage_accounts',
            'delete_user'  => 'person_remove',
            'create_agenda'=> 'event',
            default        => 'info',
        };
    }

    public function getAksiColorAttribute(): string
    {
        return match (true) {
            str_contains($this->aksi, 'delete') => 'error',
            str_contains($this->aksi, 'create') => 'success',
            str_contains($this->aksi, 'update') => 'warning',
            in_array($this->aksi, ['login', 'logout']) => 'info',
            default => 'default',
        };
    }

    // Static helper to log activity
    public static function log(string $aksi, string $deskripsi, ?int $modelId = null, ?string $modelType = null): void
    {
        if (auth()->check()) {
            static::create([
                'user_id'    => auth()->id(),
                'aksi'       => $aksi,
                'deskripsi'  => $deskripsi,
                'model_id'   => $modelId,
                'model_type' => $modelType,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }
}
