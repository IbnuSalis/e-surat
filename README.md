# 📮 E-Surat — Sistem Informasi Manajemen Surat Desa

<div align="center">

![E-Surat Banner](https://img.shields.io/badge/E--Surat-v1.0.0-002147?style=for-the-badge&logo=laravel&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

**Sistem Informasi Manajemen Surat Desa berbasis web modern untuk Pemerintah Desa Kabupaten Kediri**

</div>

---

## 🎯 Deskripsi

**E-Surat** adalah sistem digital yang dirancang untuk mempermudah pengelolaan administrasi surat menyurat di lingkungan pemerintahan desa. Dibangun dengan Laravel 12 dan tampilan SaaS dashboard modern yang elegan.

---

## ✨ Fitur Utama

### 🔐 Authentication & Authorization
- Login modern dengan glassmorphism UI (background foto Kota Kediri)
- Remember Me & Forgot Password
- Toggle show/hide password
- Role-based access control (Admin & Staff)
- Middleware proteksi halaman per role

### 📊 Dashboard
- Statistik real-time (surat masuk, keluar, rahasia, agenda)
- Grafik statistik surat 6 bulan terakhir (Chart.js)
- Upcoming agenda acara
- Aktivitas terbaru pengguna (timeline)
- Berita acara terbaru
- Notifikasi dropdown

### 📄 Manajemen Surat
| Fitur | Admin | Staff |
|-------|-------|-------|
| Lihat surat masuk | ✅ | ✅ |
| Lihat surat keluar | ✅ | ✅ |
| Input surat baru | ✅ | ✅ |
| Edit surat | ✅ | ✅ |
| Hapus surat | ✅ | ❌ |
| Akses surat rahasia | ✅ | ✅* |

*Memerlukan verifikasi password

- Upload semua format file (PDF, Word, Excel, gambar, dll)
- Drag & drop upload dengan preview
- Download file surat
- Search, filter kategori & tanggal
- Badge warna kategori (Umum / Penting / Rahasia)
- Pagination modern

### 🔒 Surat Rahasia
- Halaman terproteksi dengan verifikasi password
- UI lock screen khusus
- Aktivitas tercatat di log

### 📅 Agenda Acara
- CRUD agenda kegiatan desa
- Status agenda (Akan Datang / Berlangsung / Selesai / Dibatalkan)
- Color label agenda
- Upcoming agenda widget di dashboard
- Filter berdasarkan status

### 📝 Berita Acara
- CRUD berita acara
- Status (Draft / Final / Disetujui)
- Tampil di dashboard (terbaru)

### 👥 Manajemen User (Admin Only)
- CRUD pengguna
- Assign role (Admin / Staff)
- Reset password otomatis
- Toggle status aktif/nonaktif
- Upload foto profil

### 📋 Log Aktivitas (Admin Only)
- Catat semua aktivitas: login, logout, upload, edit, delete
- Timeline UI modern dengan warna per jenis aksi
- Filter berdasarkan aksi, pengguna, tanggal
- Auto-clean log > 30 hari

### 👤 Profil
- Edit informasi profil
- Upload/ganti foto profil
- Ubah password dengan password strength meter
- Riwayat aktivitas pribadi

---

## 🎨 Desain & UI/UX

- **Warna dominan**: Navy (#002147), Putih, Emas (#FED65B)
- **Font**: Inter (body) + Poppins (heading)
- **Style**: Modern SaaS admin dashboard
- **Komponen**: Soft shadow, rounded corners, smooth hover animation
- **Sidebar**: Gradient navy, active state dengan gold highlight
- **Responsive**: Mobile-first dengan sidebar overlay
- **Toast notification** otomatis 5 detik

---

## 🛠 Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Backend Framework | Laravel 12 |
| PHP Version | 8.2.12 |
| Database | MySQL 8.0+ |
| Frontend CSS | Tailwind CSS (via CDN) |
| Template Engine | Laravel Blade |
| Charts | Chart.js |
| Icons | Google Material Symbols |
| Fonts | Google Fonts (Inter + Poppins) |
| File Storage | Laravel Storage (public disk) |

---

## 📦 Instalasi

### Prasyarat
- PHP >= 8.2 dengan ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `fileinfo`
- Composer >= 2.x
- MySQL >= 8.0
- Node.js (opsional, untuk pengembangan)

### Langkah Instalasi

**1. Clone atau ekstrak project**
```bash
# Clone (jika dari git)
git clone https://github.com/pemdes/e-surat.git
cd e-surat

# Atau ekstrak ZIP dan masuk ke folder
cd e-surat
```

**2. Install dependencies PHP**
```bash
composer install
```

**3. Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Konfigurasi database di `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e_surat
DB_USERNAME=root
DB_PASSWORD=your_password
```

**5. Buat database**
```sql
CREATE DATABASE e_surat CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**6. Jalankan migrasi & seeder**
```bash
php artisan migrate
php artisan db:seed
```

**7. Setup storage symlink**
```bash
php artisan storage:link
```

**8. Set permission (Linux/Mac)**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**9. Jalankan server**
```bash
php artisan serve
```

Akses di: **http://localhost:8000**

---

## 🔑 Akun Default

| Role | Email | Password |
|------|-------|----------|
| **Administrator** | admin@kediri.go.id | password |
| **Staff** | budi@kediri.go.id | password |
| **Staff** | siti@kediri.go.id | password |

> ⚠️ **PENTING**: Segera ganti password default setelah pertama kali login di production!

---

## 📁 Struktur Direktori

```
e-surat/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/LoginController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── SuratController.php
│   │   │   ├── AgendaController.php
│   │   │   ├── BeritaAcaraController.php
│   │   │   ├── UserController.php
│   │   │   ├── LogAktivitasController.php
│   │   │   └── ProfileController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Surat.php
│   │   ├── Agenda.php
│   │   ├── BeritaAcara.php
│   │   └── LogAktivitas.php
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_users_table.php
│   │   ├── 2024_01_01_000002_create_surats_table.php
│   │   └── 2024_01_01_000003_create_supporting_tables.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── forgot-password.blade.php
│   ├── dashboard/index.blade.php
│   ├── surat/
│   │   ├── masuk.blade.php
│   │   ├── keluar.blade.php
│   │   ├── rahasia.blade.php
│   │   ├── rahasia-lock.blade.php
│   │   ├── input.blade.php
│   │   ├── show.blade.php
│   │   └── edit.blade.php
│   ├── agenda/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── show.blade.php
│   │   └── edit.blade.php
│   ├── berita-acara/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── show.blade.php
│   │   └── edit.blade.php
│   ├── user/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── log-aktivitas/index.blade.php
│   ├── profile/index.blade.php
│   └── errors/403.blade.php
├── routes/
│   ├── web.php
│   └── console.php
├── bootstrap/app.php
└── .env.example
```

---

## 🔧 Konfigurasi Tambahan

### Scheduled Tasks (Opsional)
Tambahkan cron job untuk auto-update status agenda & bersihkan log lama:
```bash
# Crontab
* * * * * cd /path/to/e-surat && php artisan schedule:run >> /dev/null 2>&1
```

### Konfigurasi Email (Forgot Password)
Edit `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your_app_password
MAIL_FROM_ADDRESS=noreply@kediri.go.id
MAIL_FROM_NAME="E-Surat Kediri"
```

### Upload File Size
Edit `php.ini` untuk ukuran upload lebih besar:
```ini
upload_max_filesize = 20M
post_max_size = 25M
```

---

## 🚀 Pengembangan Lebih Lanjut

Project ini dirancang scalable untuk dikembangkan menjadi SaaS multi-tenant:

- [ ] Multi-tenant (satu instance untuk banyak desa)
- [ ] API REST untuk mobile app
- [ ] Integrasi Google Calendar API
- [ ] Export PDF / Excel laporan surat
- [ ] Digital signature surat
- [ ] Notifikasi email & WhatsApp
- [ ] Dark mode toggle
- [ ] Barcode/QR Code surat
- [ ] Dashboard analytics lanjutan
- [ ] Audit trail lengkap

---

## 📞 Dukungan

Untuk pertanyaan dan dukungan teknis:
- Email: admin@kediri.go.id
- Sistem: E-Surat v1.0.0

---

## 📄 Lisensi

Project ini dikembangkan untuk keperluan Pemerintah Desa Kabupaten Kediri.

---

<div align="center">

**E-Surat** — Digitalisasi Administrasi Surat Desa 🏛️

*Dibuat dengan ❤️ untuk Pemerintahan Desa yang Modern*

</div>
