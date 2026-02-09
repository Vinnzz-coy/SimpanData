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
- **Database**: [PostgreSQL](https://www.postgresql.org/)
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

## 📊 Sistem Penilaian Peserta

SimpanData menggunakan sistem penilaian kinerja yang canggih untuk mengevaluasi peserta PKL dan Magang secara objektif dan transparan.

### 📐 Aspek Penilaian Utama
Terdapat **5 Pilar Utama** yang dinilai dengan rentang skor **1 - 100**:

| Aspek | Deskripsi Kompetensi |
| :--- | :--- |
| 🕒 **Kedisiplinan** | Ketepatan waktu, tingkat kehadiran, dan kepatuhan terhadap SOP perusahaan. |
| 🛠️ **Keterampilan** | Penguasaan teknis tools, kualitas hasil kerja, dan efisiensi penyelesaian tugas. |
| 🤝 **Kerjasama** | Kemampuan berkoordinasi dalam tim, proaktif membantu rekan, dan etika kolaborasi. |
| 💡 **Inisiatif** | Kemampuan mencari solusi mandiri, memberikan ide kreatif, dan sikap proaktif. |
| 💬 **Komunikasi** | Kejelasan penyampaian informasi, etika berbicara, dan kemampuan mendengarkan. |

---

### 🔄 Alur Kerja Penilaian (Sederhana)
Proses penilaian dirancang agar cepat dan instan dengan langkah berikut:

1.  **Pilih Peserta**: Admin memilih peserta dari daftar (otomatis terfilter berdasarkan status aktif/selesai).
2.  **Input Nilai**: Masukkan skor (1-100) menggunakan slider atau tombol cepat kategori.
3.  **Live Preview**: Sistem langsung menghitung **Nilai Akhir** dan menentukan **Grade** (A-E) secara otomatis di layar.
4.  **Simpan**: Klik simpan, data dikirim via AJAX, dan seluruh halaman (tabel & statistik) akan diperbarui saat itu juga tanpa reload.

---

### 🔢 Mekanisme Perhitungan

Logika perhitungan menggunakan metode **Mean Average** untuk memastikan keadilan bagi seluruh peserta:

> [!TIP]
> **Rumus Nilai Akhir:**
> $$\text{Nilai Akhir} = \frac{\sum(\text{Kedisiplinan, Keterampilan, Kerjasama, Inisiatif, Komunikasi})}{5}$$

**Klasifikasi Predikat & Grade:**

| Rentang Nilai | Grade | Status | Warna Indikator |
| :--- | :---: | :--- | :--- |
| **90 - 100** | <kbd>A</kbd> | 🌟 Sangat Memuaskan | **Hijau (Emerald)** |
| **80 - 89** | <kbd>B</kbd> | ✅ Memuaskan | **Biru (Blue)** |
| **70 - 79** | <kbd>C</kbd> | ⚠️ Cukup | **Kuning (Amber)** |
| **60 - 69** | <kbd>D</kbd> | ❌ Kurang | **Oranye (Orange)** |
| **0 - 59** | <kbd>E</kbd> | 🆘 Sangat Kurang | **Merah (Red)** |

---

### 🚀 Fitur Canggih UI Penilaian
Aplikasi ini dilengkapi dengan fitur UI/UX modern untuk mempermudah tugas Admin:

*   **⚡ Intelligent Filtering**: Filter data secara instan berdasarkan *Nama, Sekolah/Universitas, Jenis Kegiatan (PKL/Magang),* dan *Status Penilaian*.
*   **📊 Dynamic Stats Sync**: Kartu statistik (Total, Sudah Dinilai, Belum Dinilai, Rata-rata) akan **otomatis menyinkronkan angkanya** sesuai dengan filter yang aktif secara real-time tanpa reload halaman.
*   **🎨 Color-Coded Indicators**: Slider penilaian berubah warna secara dinamis memberikan feedback psikologis yang cepat kepada penilai.
*   **🔘 Quick Value Presets**: Tombol cepat untuk kategori (Kurang, Cukup, Baik, Sangat Baik) untuk pengisian nilai instan.
*   **🛡️ Clean Code Architecture**: Logika penilaian dipisahkan ke dalam [penilaian.js](public/js/admin/penilaian.js) untuk menjaga performa dan kemudahan maintenance.

---

## 📁 Struktur Folder Proyek

Organisasi file dalam sistem **SipanData** dirancang untuk skalabilitas dan kemudahan pemeliharaan:

```text
SipanData/
├── app/
│   ├── Http/Controllers/        # Logika Navigasi & Request Handler
│   │   ├── Admin/               # Pengelolaan Dashboard, Peserta, Absensi, Penilaian
│   │   │   ├── AbsensiController.php
│   │   │   ├── ArsipController.php
│   │   │   ├── PenilaianController.php
│   │   │   └── UserController.php
│   │   └── Peserta/             # Fitur mandiri Peserta (Absensi, Laporan, Profile)
│   │       ├── DashboardController.php
│   │       └── PenilaianController.php
│   ├── Models/                  # Definisi Entitas & Relasi Database (Eloquent)
│   │   ├── User.php
│   │   ├── Peserta.php
│   │   ├── Penilaian.php
│   │   └── Absensi.php
│   └── Providers/               # Konfigurasi Service Providers sistem
├── bootstrap/                   # Inisialisasi framework Laravel
├── config/                      # Kumpulan file konfigurasi (App, DB, Auth, Mail)
├── database/
│   ├── migrations/              # Definisi struktur tabel (Blueprint)
│   ├── seeders/                 # Pengisian data awal otomatis
│   └── factories/               # Generator data dummy untuk testing
├── public/                      # Direktori Akses Publik
│   ├── build/                   # Hasil kompilasi aset oleh Vite
│   ├── css/                     # File styling eksternal (termasuk penilaian peserta)
│   └── js/                      # Script interaktif sistem
├── resources/
│   ├── css/                     # Sumber asli Tailwind & Global CSS
│   ├── js/                      # Sumber asli JavaScript (Vite entry points)
│   └── views/                   # Template Antarmuka (Blade Engine)
│       ├── admin/               # Halaman khusus pengelolaan Admin
│       ├── peserta/             # Halaman portal mandiri Peserta
│       ├── layouts/             # Master template (App structure)
│       ├── partials/            # Komponen kecil yang dapat digunakan ulang (Reusable)
│       └── auth/                # Halaman Login & Registrasi
├── routes/                      # Definisi URL & Middleware Security
│   ├── web.php                  # Rute navigasi browser
│   └── console.php              # Perintah CLI kustom
├── storage/                     # Penyimpanan log, cache, dan file upload peserta
└── vite.config.js               # Konfigurasi Asset Bundler (Vite)
```

---

## 🔑 Akun Default (Seeder)

Jika Anda menggunakan `--seed`, Anda bisa masuk dengan akun berikut:

- **Admin**: `admin@simpandata.com` / Password: `admin123`

---

## 📄 Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE).
