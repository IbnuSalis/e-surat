<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('penanggung_jawab')->nullable();
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->string('warna', 20)->default('#002147');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('berita_acara', function (Blueprint $table) {
            $table->id();
            $table->string('nomor', 100)->unique();
            $table->string('judul');
            $table->date('tanggal');
            $table->string('lokasi')->nullable();
            $table->text('isi');
            $table->text('peserta')->nullable();
            $table->enum('status', ['draft', 'final', 'approved'])->default('draft');
            $table->string('file_path')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('aksi', 50);
            $table->text('deskripsi');
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('data_lama')->nullable();
            $table->json('data_baru')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index('aksi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
        Schema::dropIfExists('berita_acara');
        Schema::dropIfExists('agenda');
    }
};
