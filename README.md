# SimpanData - Sistem Manajemen PKL & Magang

SimpanData adalah aplikasi berbasis web yang dirancang untuk mempermudah manajemen administrasi peserta PKL (Praktik Kerja Lapangan) dan Magang. Aplikasi ini menyediakan fitur lengkap mulai dari absensi, penilaian, hingga pelaporan kinerja peserta secara digital.

---

## 🚀 Fitur Utama

### 👑 Panel Admin
- **Dashboard Statistik**: Visualisasi data peserta (PKL, Magang, Aktif, Selesai) menggunakan Chart.js.
- **Manajemen Peserta**: Kelola data lengkap peserta termasuk profil, asal instansi, dan status.
- **Monitoring Absensi**: Pantau kehadiran peserta secara real-time dengan status (Hadir, Izin, Sakit, Alpa).
- **Penilaian Digital**: Input dan rekap nilai peserta berdasarkan kinerja mereka.
- **Laporan & Feedback**: Pantau laporan berkala dari peserta dan kelola feedback yang masuk.

### 👤 Panel Peserta
- **Dashboard Personal**: Ringkasan aktivitas dan status harian peserta.
- **Absensi Mandiri**: Melakukan presensi masuk dan pulang melalui sistem.
- **Manajemen Profil**: Lengkapi data diri dan foto profil.
- **Laporan Harian**: Kirim laporan aktivitas harian langsung ke admin.
- **Feedback & Penilaian**: Lihat hasil penilaian dari admin dan berikan masukan.

---

## 🛠️ Tech Stack

- **Framework**: [Laravel 12](https://laravel.com)
- **Database**: [PostgreSQL](https://www.postgresql.org/) / SQLite
- **Styling**: [Tailwind CSS](https://tailwindcss.com/)
- **Bundler**: [Vite](https://vitejs.dev/)
- **Interactivity**: [Alpine.js](https://alpinejs.dev/) & Vanilla JavaScript
- **Icons**: [Boxicons](https://boxicons.com/) & Font Awesome
- **Other**: Phpspreadsheet (untuk export/rekap data)

---

## ⚙️ Persyaratan Sistem

Pastikan perangkat Anda sudah terinstall:
- PHP >= 8.2
- Composer
- Node.js & NPM
- Database (PostgreSQL direkomendasikan, atau SQLite)

---

## 📥 Instalasi & Setup Lokal

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer Anda:

### 1. Clone Repositori
```bash
git clone https://github.com/username/SimpanData.git
cd SimpanData
```

### 2. Instalasi Dependensi (Backend)
```bash
composer install
```

### 3. Instalasi Dependensi (Frontend)
```bash
npm install
```

### 4. Setup Environment File
Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda.
```bash
copy .env.example .env
```
_Edit file `.env` dan sesuaikan bagian `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD`._

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Migrasi & Seeding Database
Jalankan migrasi untuk membuat tabel dan seeder untuk data awal.
```bash
php artisan migrate --seed
```
_Gunakan `--seed` untuk menyertakan data dummy (Admin, Peserta, dll) agar aplikasi bisa langsung dicoba._

### 7. Build Assets & Jalankan Server
Buka dua terminal berbeda:

**Terminal 1 (Vite Dev Server):**
```bash
npm run dev
```

**Terminal 2 (Laravel Server):**
```bash
php artisan serve
```

Aplikasi dapat diakses melalui `http://127.0.0.1:8000`.

---

## 🔑 Akun Default (Seeder)

Jika Anda menggunakan `--seed`, Anda bisa masuk dengan akun berikut:

- **Admin**: `admin@simpandata.com` / Password: `password`
- **Peserta**: `peserta@simpandata.com` / Password: `password`

---

## 📄 Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE).
