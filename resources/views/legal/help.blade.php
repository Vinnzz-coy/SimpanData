<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Bantuan - SimpanData</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    colors: {
                        primary: '#3b82f6',
                        'primary-dark': '#1e40af',
                    },
                }
            }
        }
    </script>
</head>

<body class="font-inter bg-gray-50">
    <nav class="fixed top-0 left-0 right-0 z-50 py-4 bg-white/95 backdrop-blur-sm shadow-md">
        <div class="flex items-center justify-between px-6 mx-auto max-w-7xl">
            <a href="{{ route('index') }}" class="flex items-center gap-3 no-underline">
                <img src="{{ asset('storage/logo/logo_simpandata.webp') }}" alt="SimpanData Logo"
                    class="object-contain w-10 h-10 border-2 rounded-lg border-primary">
                <span class="text-xl font-extrabold text-gray-900">SimpanData</span>
            </a>
            <a href="javascript:history.back()"
                class="px-5 py-2 text-sm font-medium no-underline transition-all duration-300 bg-transparent border rounded-lg border-gray-300 text-gray-700 hover:bg-gray-100 hover:border-primary hover:text-primary">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </nav>

    <div class="pt-24 pb-16">
        <div class="px-6 mx-auto max-w-4xl">
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
                <h1 class="mb-4 text-4xl font-bold text-gray-900">Pusat Bantuan</h1>
                <p class="mb-8 text-gray-600">Panduan penggunaan sistem pengelolaan PKL & Magang SimpanData.</p>

                <div class="space-y-12">
                    <!-- Untuk Peserta -->
                    <section>
                        <h2 class="mb-6 text-2xl font-bold text-gray-900 flex items-center gap-3">
                            <i class="fas fa-user-graduate text-primary"></i> Panduan Peserta
                        </h2>
                        <div class="space-y-6">
                            <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                                <h3 class="font-bold text-blue-900 mb-2">1. Melakukan Absensi</h3>
                                <p class="text-blue-800 text-sm leading-relaxed">
                                    Masuk ke menu <strong>Absensi</strong>, klik tombol <strong>Check In</strong> saat mulai kegiatan dan <strong>Check Out</strong> saat selesai. Pastikan Anda melakukan absensi setiap hari kerja.
                                </p>
                            </div>
                            <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                                <h3 class="font-bold text-blue-900 mb-2">2. Mengirim Laporan Harian</h3>
                                <p class="text-blue-800 text-sm leading-relaxed">
                                    Buka menu <strong>Laporan</strong>, isi judul kegiatan, deskripsi pekerjaan, dan unggah file pendukung jika ada. Anda bisa menyimpan sebagai <strong>Draft</strong> atau langsung <strong>Kirim</strong>.
                                </p>
                            </div>
                            <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                                <h3 class="font-bold text-blue-900 mb-2">3. Revisi Laporan</h3>
                                <p class="text-blue-800 text-sm leading-relaxed">
                                    Jika laporan Anda ditandai <strong>Revisi</strong> oleh Admin, Anda akan mendapatkan notifikasi. Silakan edit laporan tersebut sesuai instruksi dan kirim kembali.
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Untuk Admin -->
                    <section>
                        <h2 class="mb-6 text-2xl font-bold text-gray-900 flex items-center gap-3">
                            <i class="fas fa-user-shield text-primary"></i> Panduan Admin
                        </h2>
                        <div class="space-y-6">
                            <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                                <h3 class="font-bold text-slate-900 mb-2">1. Manajemen Peserta</h3>
                                <p class="text-slate-800 text-sm leading-relaxed">
                                    Admin dapat menambah, mengubah, atau menghapus data peserta PKL melalui menu <strong>Peserta</strong>. Pastikan data sekolah/instansi sudah benar untuk kemudahan laporan.
                                </p>
                            </div>
                            <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                                <h3 class="font-bold text-slate-900 mb-2">2. Verifikasi Laporan</h3>
                                <p class="text-slate-800 text-sm leading-relaxed">
                                    Pantau laporan masuk di menu <strong>Laporan</strong>. Admin bisa memberikan status <strong>Disetujui</strong> atau meminta <strong>Revisi</strong> jika laporan kurang lengkap.
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- FAQ -->
                    <section>
                        <h2 class="mb-6 text-2xl font-bold text-gray-900">Pertanyaan Umum (FAQ)</h2>
                        <div class="divide-y divide-gray-200">
                            <div class="py-4">
                                <h4 class="font-semibold text-gray-900">Lupa password akun?</h4>
                                <p class="text-gray-600 text-sm mt-1">Gunakan fitur "Lupa Password" di halaman login untuk mengatur ulang kata sandi melalui email Anda.</p>
                            </div>
                            <div class="py-4">
                                <h4 class="font-semibold text-gray-900">Laporan tidak bisa diedit?</h4>
                                <p class="text-gray-600 text-sm mt-1">Laporan yang sudah berstatus "Disetujui" tidak dapat diubah kembali. Hubungi Admin jika diperlukan perubahan mendesak.</p>
                            </div>
                        </div>
                    </section>

                    <section class="bg-gray-900 text-white p-8 rounded-2xl text-center">
                        <h2 class="text-xl font-bold mb-4">Masih butuh bantuan?</h2>
                        <p class="text-gray-400 mb-6">Hubungi tim dukungan kami melalui email di bawah ini.</p>
                        <a href="mailto:support@simpandata.com" class="inline-block px-8 py-3 bg-primary hover:bg-primary-dark transition-colors rounded-lg font-bold">
                            Hubungi Support
                        </a>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-white bg-slate-900 py-8">
        <div class="px-6 mx-auto max-w-7xl text-center">
            <p class="text-sm text-slate-400">
                &copy; {{ date('Y') }} SimpanData. All rights reserved.
            </p>
        </div>
    </footer>
</body>

</html>
