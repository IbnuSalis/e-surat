<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\BeritaAcara;
use App\Models\LogAktivitas;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@kediri.go.id',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'jabatan'  => 'Kepala Desa',
            'phone'    => '081234567890',
            'status'   => 'active',
        ]);

        // Create Staff
        $staff1 = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@kediri.go.id',
            'password' => Hash::make('password'),
            'role'     => 'staff',
            'jabatan'  => 'Sekretaris Desa',
            'phone'    => '081234567891',
            'status'   => 'active',
        ]);

        $staff2 = User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'siti@kediri.go.id',
            'password' => Hash::make('password'),
            'role'     => 'staff',
            'jabatan'  => 'Staff Administrasi',
            'phone'    => '081234567892',
            'status'   => 'active',
        ]);

        // Create sample Surats
        $suratData = [
            ['kode_surat' => 'SM/2024/001', 'nama_surat' => 'Surat Undangan Rapat Koordinasi Desa', 'jenis_surat' => 'masuk', 'kategori' => 'penting', 'tanggal_surat' => '2024-11-01', 'created_by' => $staff1->id],
            ['kode_surat' => 'SM/2024/002', 'nama_surat' => 'Surat Permohonan Bantuan Dana BLT', 'jenis_surat' => 'masuk', 'kategori' => 'umum', 'tanggal_surat' => '2024-11-05', 'created_by' => $staff1->id],
            ['kode_surat' => 'SM/2024/003', 'nama_surat' => 'Surat Pemberitahuan Program Posyandu', 'jenis_surat' => 'masuk', 'kategori' => 'umum', 'tanggal_surat' => '2024-11-10', 'created_by' => $staff2->id],
            ['kode_surat' => 'SM/2024/004', 'nama_surat' => 'Dokumen Laporan Anggaran Rahasia', 'jenis_surat' => 'masuk', 'kategori' => 'rahasia', 'tanggal_surat' => '2024-11-12', 'created_by' => $admin->id],
            ['kode_surat' => 'SK/2024/001', 'nama_surat' => 'Surat Balasan Undangan Kecamatan', 'jenis_surat' => 'keluar', 'kategori' => 'umum', 'tanggal_surat' => '2024-11-03', 'created_by' => $admin->id],
            ['kode_surat' => 'SK/2024/002', 'nama_surat' => 'Surat Rekomendasi Warga Berprestasi', 'jenis_surat' => 'keluar', 'kategori' => 'penting', 'tanggal_surat' => '2024-11-07', 'created_by' => $staff1->id],
            ['kode_surat' => 'SK/2024/003', 'nama_surat' => 'Surat Pengumuman Gotong Royong', 'jenis_surat' => 'keluar', 'kategori' => 'umum', 'tanggal_surat' => '2024-11-15', 'created_by' => $staff2->id],
            ['kode_surat' => 'SR/2024/001', 'nama_surat' => 'Dokumen Perjanjian Investasi Desa', 'jenis_surat' => 'masuk', 'kategori' => 'rahasia', 'tanggal_surat' => '2024-11-18', 'created_by' => $admin->id],
        ];

        foreach ($suratData as $data) {
            Surat::create(array_merge($data, ['status' => 'aktif']));
        }

        // Create sample Agendas
        $agendaData = [
            ['judul' => 'Rapat Koordinasi Pembangunan Jalan Desa', 'tanggal_mulai' => now()->addDays(2), 'lokasi' => 'Balai Desa', 'penanggung_jawab' => 'Kepala Desa', 'status' => 'upcoming', 'warna' => '#002147'],
            ['judul' => 'Posyandu Bulanan RT 01-05', 'tanggal_mulai' => now()->addDays(5), 'lokasi' => 'Puskesmas Desa', 'penanggung_jawab' => 'Bidan Desa', 'status' => 'upcoming', 'warna' => '#16a34a'],
            ['judul' => 'Musyawarah Desa Penetapan APBDesa 2025', 'tanggal_mulai' => now()->addDays(10), 'lokasi' => 'Balai Desa', 'penanggung_jawab' => 'Sekretaris Desa', 'status' => 'upcoming', 'warna' => '#d97706'],
            ['judul' => 'Pelatihan Administrasi Digital Desa', 'tanggal_mulai' => now()->subDays(5), 'tanggal_selesai' => now()->subDays(3), 'lokasi' => 'Aula Kecamatan', 'penanggung_jawab' => 'Budi Santoso', 'status' => 'completed', 'warna' => '#6366f1'],
            ['judul' => 'Gotong Royong Kebersihan Lingkungan', 'tanggal_mulai' => now()->addDays(15), 'lokasi' => 'Seluruh Wilayah Desa', 'penanggung_jawab' => 'Kaur Umum', 'status' => 'upcoming', 'warna' => '#0891b2'],
        ];

        foreach ($agendaData as $data) {
            Agenda::create(array_merge($data, ['created_by' => $admin->id, 'deskripsi' => 'Agenda kegiatan desa yang perlu dihadiri oleh seluruh perangkat desa.']));
        }

        // Create sample Berita Acara
        $beritaAcaraData = [
            ['nomor' => 'BA/2024/001', 'judul' => 'Berita Acara Rapat Pembahasan APBDes 2024', 'tanggal' => '2024-10-15', 'lokasi' => 'Balai Desa', 'isi' => 'Pada hari ini telah dilaksanakan rapat pembahasan APBDes 2024 yang dihadiri oleh seluruh perangkat desa dan BPD.', 'peserta' => 'Kepala Desa, BPD, Kaur Keuangan', 'status' => 'approved'],
            ['nomor' => 'BA/2024/002', 'judul' => 'Berita Acara Serah Terima Bantuan Sosial', 'tanggal' => '2024-10-28', 'lokasi' => 'Balai Desa', 'isi' => 'Telah dilaksanakan serah terima bantuan sosial kepada warga yang berhak menerima.', 'peserta' => 'Kepala Desa, Tim Verifikasi, Penerima Manfaat', 'status' => 'final'],
            ['nomor' => 'BA/2024/003', 'judul' => 'Berita Acara Musyawarah Perencanaan Desa', 'tanggal' => '2024-11-01', 'lokasi' => 'Balai Desa', 'isi' => 'Musyawarah perencanaan pembangunan desa telah dilaksanakan dengan lancar dan menghasilkan keputusan yang disepakati bersama.', 'peserta' => 'Seluruh perangkat desa dan tokoh masyarakat', 'status' => 'draft'],
        ];

        foreach ($beritaAcaraData as $data) {
            BeritaAcara::create(array_merge($data, ['created_by' => $admin->id]));
        }

        // Create sample Log Aktivitas
        $logData = [
            ['user_id' => $admin->id, 'aksi' => 'login', 'deskripsi' => 'User Administrator berhasil login ke sistem.'],
            ['user_id' => $staff1->id, 'aksi' => 'login', 'deskripsi' => 'User Budi Santoso berhasil login ke sistem.'],
            ['user_id' => $staff1->id, 'aksi' => 'create_surat', 'deskripsi' => 'Upload surat: Surat Undangan Rapat Koordinasi Desa (SM/2024/001)'],
            ['user_id' => $staff2->id, 'aksi' => 'create_surat', 'deskripsi' => 'Upload surat: Surat Pemberitahuan Program Posyandu (SM/2024/003)'],
            ['user_id' => $admin->id, 'aksi' => 'create_agenda', 'deskripsi' => 'Buat agenda: Rapat Koordinasi Pembangunan Jalan Desa'],
            ['user_id' => $admin->id, 'aksi' => 'create_user', 'deskripsi' => 'Buat user baru: Siti Rahayu (staff)'],
        ];

        foreach ($logData as $data) {
            LogAktivitas::create(array_merge($data, ['ip_address' => '127.0.0.1']));
        }
    }
}
