<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - SimpanData</title>
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
            <a href="{{ route('index') }}"
                class="px-5 py-2 text-sm font-medium no-underline transition-all duration-300 bg-transparent border rounded-lg border-gray-300 text-gray-700 hover:bg-gray-100 hover:border-primary hover:text-primary">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </nav>

    <div class="pt-24 pb-16">
        <div class="px-6 mx-auto max-w-4xl">
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
                <h1 class="mb-4 text-4xl font-bold text-gray-900">Privacy Policy</h1>
                <p class="mb-8 text-gray-600">Terakhir diperbarui: {{ date('d F Y') }}</p>

                <div class="prose prose-lg max-w-none">
                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">1. Pengenalan</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            SimpanData ("kami", "kita", atau "platform") menghormati privasi pengguna kami. Kebijakan
                            Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi
                            informasi pribadi Anda ketika menggunakan layanan kami.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">2. Informasi yang Kami Kumpulkan</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Kami mengumpulkan informasi berikut:
                        </p>
                        <ul class="mb-4 ml-6 list-disc text-gray-700">
                            <li class="mb-2">Informasi akun (nama, email, password terenkripsi)</li>
                            <li class="mb-2">Data peserta PKL/Magang (nama, asal sekolah, jurusan, alamat)</li>
                            <li class="mb-2">Data absensi dan laporan kegiatan</li>
                            <li class="mb-2">Data feedback dan komunikasi</li>
                            <li class="mb-2">Informasi teknis (IP address, browser, perangkat)</li>
                        </ul>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">3. Cara Kami Menggunakan Informasi</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Kami menggunakan informasi yang dikumpulkan untuk:
                        </p>
                        <ul class="mb-4 ml-6 list-disc text-gray-700">
                            <li class="mb-2">Menyediakan dan meningkatkan layanan platform</li>
                            <li class="mb-2">Mengelola akun pengguna dan autentikasi</li>
                            <li class="mb-2">Memproses dan menyimpan data kegiatan PKL/Magang</li>
                            <li class="mb-2">Mengirim notifikasi dan komunikasi penting</li>
                            <li class="mb-2">Meningkatkan keamanan dan mencegah penipuan</li>
                        </ul>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">4. Perlindungan Data</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang sesuai untuk
                            melindungi data pribadi Anda dari akses, pengungkapan, perubahan, atau penghancuran yang
                            tidak sah. Data disimpan di server yang aman dengan enkripsi.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">5. Pembagian Data</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Kami tidak menjual, menyewakan, atau membagikan data pribadi Anda kepada pihak ketiga,
                            kecuali:
                        </p>
                        <ul class="mb-4 ml-6 list-disc text-gray-700">
                            <li class="mb-2">Dengan persetujuan Anda</li>
                            <li class="mb-2">Untuk mematuhi kewajiban hukum</li>
                            <li class="mb-2">Untuk melindungi hak dan keamanan kami</li>
                        </ul>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">6. Hak Anda</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Anda memiliki hak untuk:
                        </p>
                        <ul class="mb-4 ml-6 list-disc text-gray-700">
                            <li class="mb-2">Mengakses data pribadi Anda</li>
                            <li class="mb-2">Memperbarui atau memperbaiki data</li>
                            <li class="mb-2">Menghapus akun dan data Anda</li>
                            <li class="mb-2">Menolak pemrosesan data tertentu</li>
                        </ul>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">7. Kontak</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini, silakan hubungi kami di:
                            <a href="mailto:privacy@simpandata.com" class="text-primary hover:underline">privacy@simpandata.com</a>
                        </p>
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
