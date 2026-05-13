<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('kode_surat', 50)->unique();
            $table->string('nama_surat');
            $table->enum('jenis_surat', ['masuk', 'keluar']);
            $table->enum('kategori', ['umum', 'penting', 'rahasia'])->default('umum');
            $table->date('tanggal_surat');
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('file_type')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', ['aktif', 'arsip'])->default('aktif');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
