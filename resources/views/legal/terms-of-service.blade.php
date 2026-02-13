<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - SimpanData</title>
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
                <h1 class="mb-4 text-4xl font-bold text-gray-900">Terms of Service</h1>
                <p class="mb-8 text-gray-600">Terakhir diperbarui: {{ date('d F Y') }}</p>

                <div class="prose prose-lg max-w-none">
                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">1. Penerimaan Syarat</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Dengan mengakses dan menggunakan platform SimpanData, Anda menyetujui untuk terikat oleh
                            Syarat Layanan ini. Jika Anda tidak setuju dengan syarat-syarat ini, harap jangan
                            menggunakan layanan kami.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">2. Penggunaan Platform</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Anda setuju untuk:
                        </p>
                        <ul class="mb-4 ml-6 list-disc text-gray-700">
                            <li class="mb-2">Menyediakan informasi yang akurat dan terkini</li>
                            <li class="mb-2">Menjaga kerahasiaan akun dan kata sandi Anda</li>
                            <li class="mb-2">Tidak menggunakan platform untuk tujuan ilegal atau tidak sah</li>
                            <li class="mb-2">Tidak mencoba mengakses sistem atau data tanpa izin</li>
                            <li class="mb-2">Menghormati hak kekayaan intelektual</li>
                        </ul>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">3. Akun Pengguna</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Anda bertanggung jawab untuk:
                        </p>
                        <ul class="mb-4 ml-6 list-disc text-gray-700">
                            <li class="mb-2">Memelihara keamanan akun Anda</li>
                            <li class="mb-2">Segera memberitahu kami tentang penggunaan yang tidak sah</li>
                            <li class="mb-2">Memastikan bahwa semua aktivitas di bawah akun Anda sesuai dengan syarat ini</li>
                        </ul>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">4. Konten dan Data</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Anda mempertahankan kepemilikan atas konten yang Anda unggah. Namun, dengan menggunakan
                            platform, Anda memberikan kami lisensi untuk menyimpan, memproses, dan menampilkan konten
                            tersebut sesuai dengan fungsi platform.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">5. Larangan</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Anda dilarang untuk:
                        </p>
                        <ul class="mb-4 ml-6 list-disc text-gray-700">
                            <li class="mb-2">Mengunggah konten yang melanggar hukum atau hak orang lain</li>
                            <li class="mb-2">Mengganggu atau merusak operasi platform</li>
                            <li class="mb-2">Menggunakan bot, script, atau alat otomatis tanpa izin</li>
                            <li class="mb-2">Mencoba mendapatkan akses tidak sah ke sistem</li>
                        </ul>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">6. Penghentian Layanan</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Kami berhak untuk menghentikan atau menangguhkan akses Anda ke platform jika Anda
                            melanggar syarat-syarat ini atau terlibat dalam aktivitas yang merugikan platform atau
                            pengguna lain.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">7. Penolakan Jaminan</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Platform disediakan "sebagaimana adanya" tanpa jaminan apa pun. Kami tidak menjamin bahwa
                            platform akan selalu tersedia, bebas dari kesalahan, atau aman sepenuhnya.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">8. Batasan Tanggung Jawab</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Kami tidak bertanggung jawab atas kerugian langsung, tidak langsung, insidental, atau
                            konsekuensial yang timbul dari penggunaan atau ketidakmampuan menggunakan platform.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">9. Perubahan Syarat</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Kami berhak untuk mengubah Syarat Layanan ini kapan saja. Perubahan akan diberitahukan
                            melalui platform atau email. Penggunaan berkelanjutan setelah perubahan berarti Anda
                            menerima syarat yang baru.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-900">10. Kontak</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Jika Anda memiliki pertanyaan tentang Syarat Layanan ini, silakan hubungi kami di:
                            <a href="mailto:legal@simpandata.com" class="text-primary hover:underline">legal@simpandata.com</a>
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
