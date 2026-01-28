<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimpanData - Sistem Pengelolaan PKL & Magang</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                        secondary: '#64748b',
                        background: '#ffffff',
                        surface: '#f8fafc',
                        'text-primary': '#1e293b',
                        'text-secondary': '#64748b',
                        border: '#e2e8f0',
                    },
                    boxShadow: {
                        'custom': '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
                        'custom-lg': '0 10px 15px -3px rgba(0, 0, 0, 0.1)',
                    },
                    animation: {
                        'scroll-left': 'scroll-left 35s linear infinite',
                        'blob': 'blob 7s infinite',
                        'float': 'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        'scroll-left': {
                            '0%': {
                                transform: 'translateX(0)'
                            },
                            '100%': {
                                transform: 'translateX(-50%)'
                            },
                        },
                        'blob': {
                            '0%, 100%': {
                                transform: 'translate(0, 0) scale(1)'
                            },
                            '33%': {
                                transform: 'translate(30px, -50px) scale(1.1)'
                            },
                            '66%': {
                                transform: 'translate(-20px, 20px) scale(0.9)'
                            },
                        },
                        'float': {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-10px)'
                            },
                        },
                    },
                }
            }
        }
    </script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            line-height: 1.6;
            color: #1e293b;
            overflow-x: hidden;
        }

        .gradient-text {
            background: linear-gradient(135deg, #3b82f6, #1e40af, #1e3a8a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .feedback-container::before,
        .feedback-container::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100px;
            z-index: 10;
            pointer-events: none;
        }

        .feedback-container::before {
            left: 0;
            background: linear-gradient(90deg, #f8fafc 0%, transparent 100%);
        }

        .feedback-container::after {
            right: 0;
            background: linear-gradient(270deg, #f8fafc 0%, transparent 100%);
        }

        .progress-track {
            height: 8px;
            background: #e2e8f0;
            border-radius: 9999px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 9999px;
            transition: width 1s ease;
        }

        .mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            padding: 1rem;
        }

        .mobile-menu.active {
            display: block;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .animation-delay-1000 {
            animation-delay: 1s;
        }

        .feedback-track {
            display: flex;
            gap: 1.5rem;
            width: max-content;
            will-change: transform;
        }

        .feedback-track.paused {
            animation-play-state: paused !important;
        }

        @media (max-width: 768px) {

            .feedback-container::before,
            .feedback-container::after {
                width: 50px;
            }
        }
    </style>
</head>

<body class="font-inter">
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 py-4 transition-all duration-300 bg-white/90 backdrop-blur-sm">
        <div class="flex items-center justify-between px-6 mx-auto max-w-7xl">
            <a href="#home" class="flex items-center gap-3 no-underline">
                <img src="{{ asset('storage/logo/logo_simpandata.webp') }}" alt="SimpanData Logo"
                    class="object-contain w-10 h-10 border-2 rounded-lg border-primary">
                <span class="text-xl font-extrabold text-text-primary">SimpanData</span>
            </a>

            <ul class="hidden gap-8 list-none md:flex">
                <li><a href="#home"
                        class="no-underline text-text-secondary font-medium transition-colors duration-300 relative hover:text-primary after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-primary after:transition-all after:duration-300 hover:after:w-full">Beranda</a>
                </li>
                <li><a href="#features"
                        class="no-underline text-text-secondary font-medium transition-colors duration-300 relative hover:text-primary after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-primary after:transition-all after:duration-300 hover:after:w-full">Fitur</a>
                </li>
                <li><a href="#feedback"
                        class="no-underline text-text-secondary font-medium transition-colors duration-300 relative hover:text-primary after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-primary after:transition-all after:duration-300 hover:after:w-full">Testimoni</a>
                </li>
            </ul>

            <div class="items-center hidden gap-4 md:flex">
                <a href="{{ route('auth') }}"
                    class="px-5 py-2 rounded-lg font-medium no-underline transition-all duration-300 text-white bg-gradient-to-br from-primary to-primary-dark shadow-lg shadow-blue-500/30 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-blue-500/40 text-sm">Masuk</a>
            </div>

            <button id="mobileMenuBtn"
                class="text-2xl bg-transparent border-none cursor-pointer md:hidden text-text-primary">
                <i class='bx bx-menu'></i>
            </button>
        </div>

        <div id="mobileMenu" class="mobile-menu">
            <ul class="p-0 list-none">
                <li class="mb-2"><a href="#home" class="block p-3 no-underline text-text-primary">Beranda</a></li>
                <li class="mb-2"><a href="#features" class="block p-3 no-underline text-text-primary">Fitur</a></li>
                <li class="mb-2"><a href="#feedback" class="block p-3 no-underline text-text-primary">Testimoni</a>
                </li>
            </ul>
            <div class="flex flex-col gap-3 pt-4 mt-4 border-t border-border">
                <a href="{{ route('auth') }}"
                    class="px-5 py-2 font-medium text-center no-underline transition-all duration-300 bg-transparent border rounded-lg border-border text-text-primary hover:bg-surface hover:border-primary hover:text-primary">Masuk</a>
                <a href="{{ route('auth') }}"
                    class="px-5 py-2 rounded-lg font-medium no-underline transition-all duration-300 text-white bg-gradient-to-br from-primary to-primary-dark shadow-lg shadow-blue-500/30 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-blue-500/40 text-center">Daftar
                    Sekarang</a>
            </div>
        </div>
    </nav>

    <section id="home"
        class="relative flex items-center min-h-screen pt-20 overflow-hidden bg-gradient-to-br from-slate-50 via-blue-50 to-slate-50">
        <div class="grid items-center grid-cols-1 gap-16 px-6 mx-auto max-w-7xl lg:grid-cols-2">
            <div class="hero-content">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 mb-6 text-sm font-medium bg-blue-100 rounded-full reveal text-primary">
                    <i class='bx bx-check-circle'></i>
                    Sistem Terintegrasi
                </div>

                <h1 class="mb-6 text-5xl font-extrabold leading-tight reveal md:text-6xl text-text-primary">
                    Kelola PKL & Magang
                    <span class="block mt-2 gradient-text">Jadi Lebih Mudah</span>
                </h1>

                <p class="mb-8 text-lg leading-relaxed reveal text-text-secondary">
                    SimpanData menghilangkan cara kerja manual yang membuat data peserta tercecer.
                    Semua informasi penting dikumpulkan dalam satu sistem yang konsisten, terstruktur,
                    dan dapat diandalkan.
                </p>

                <div class="flex flex-col gap-4 mb-12 reveal sm:flex-row">
                    <a href="{{ route('auth') }}"
                        class="px-8 py-3 rounded-lg font-medium no-underline transition-all duration-300 text-white bg-gradient-to-br from-primary to-primary-dark shadow-lg shadow-blue-500/30 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-blue-500/40 text-base flex items-center justify-center">
                        Mulai Sekarang
                        <i class='ml-2 bx bx-right-arrow-alt'></i>
                    </a>
                    <a href="#features"
                        class="px-8 py-3 text-base font-medium no-underline transition-all duration-300 bg-transparent border rounded-lg border-border text-text-primary hover:bg-surface hover:border-primary hover:text-primary">Pelajari
                        Lebih Lanjut</a>
                </div>

                <div class="grid grid-cols-2 gap-4 reveal md:grid-cols-4">
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-xl p-4 text-center border border-border transition-all duration-300 hover:-translate-y-0.5 hover:shadow-custom">
                        <i class='mb-2 text-xl bx bx-group text-primary'></i>
                        <div class="text-2xl font-bold text-text-primary">
                            {{ number_format($totalPeserta ?? 0) }}{{ ($totalPeserta ?? 0) >= 1000 ? '+' : '' }}</div>
                        <div class="text-xs text-text-secondary">Peserta Terdaftar</div>
                    </div>
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-xl p-4 text-center border border-border transition-all duration-300 hover:-translate-y-0.5 hover:shadow-custom">
                        <i class='mb-2 text-xl bx bx-file text-primary'></i>
                        <div class="text-2xl font-bold text-text-primary">
                            {{ number_format($totalLaporan ?? 0) }}{{ ($totalLaporan ?? 0) >= 1000 ? '+' : '' }}</div>
                        <div class="text-xs text-text-secondary">Laporan Tersimpan</div>
                    </div>
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-xl p-4 text-center border border-border transition-all duration-300 hover:-translate-y-0.5 hover:shadow-custom">
                        <i class='mb-2 text-xl bx bx-check-circle text-primary"></i>
                        <div class="text-2xl font-bold text-text-primary">{{ $tingkatKehadiran ?? 0 }}%</div>
                        <div class="text-xs text-text-secondary">Tingkat Kehadiran</div>
                    </div>
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-xl p-4 text-center border border-border transition-all duration-300 hover:-translate-y-0.5 hover:shadow-custom">
                        <i class='mb-2 text-xl bx bx-time-five text-primary'></i>
                        <div class="text-2xl font-bold text-text-primary">24/7</div>
                        <div class="text-xs text-text-secondary">Akses Terbuka</div>
                    </div>
                </div>
            </div>

            <div class="relative flex justify-center reveal hero-visual">
                <div
                    class="w-full max-w-md p-6 transition-transform duration-500 bg-white shadow-2xl rounded-2xl rotate-3 hover:rotate-0">
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="flex items-center justify-center w-12 h-12 overflow-hidden bg-white border-2 rounded-xl border-primary">
                            <img src="{{ asset('storage/logo/logo_simpandata.webp') }}" alt="SimpanData Logo"
                                class="object-contain w-full h-full">
                        </div>
                        <div>
                            <h3 class="m-0 font-bold text-text-primary">SimpanData</h3>
                            <p class="m-0 text-sm text-text-secondary">Dashboard Admin</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="p-4 rounded-lg bg-blue-50">
                            <div class="text-2xl font-bold text-primary">{{ $pesertaAktif ?? 0 }}</div>
                            <div class="text-sm text-text-secondary">Peserta Aktif</div>
                        </div>
                        <div class="p-4 rounded-lg bg-green-50">
                            <div class="text-2xl font-bold text-green-500">{{ $tingkatKehadiran ?? 0 }}%</div>
                            <div class="text-sm text-text-secondary">Kehadiran</div>
                        </div>
                    </div>

                    <div>
                        <div class="mb-4">
                            <div class="flex justify-between mb-1 text-sm text-text-secondary">
                                <span>Laporan Masuk</span>
                                <span class="font-medium">{{ $laporanMasuk ?? 0 }}/{{ $pesertaAktif ?? 0 }}</span>
                            </div>
                            <div class="progress-track">
                                <div class="progress-fill bg-gradient-to-r from-primary to-primary-dark"
                                    style="width: {{ $laporanProgress ?? 0 }}%;"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-1 text-sm text-text-secondary">
                                <span>Feedback Selesai</span>
                                <span class="font-medium">{{ $feedbackSelesai ?? 0 }}/{{ $pesertaAktif ?? 0 }}</span>
                            </div>
                            <div class="progress-track">
                                <div class="progress-fill bg-gradient-to-r from-green-500 to-green-600"
                                    style="width: {{ $feedbackProgress ?? 0 }}%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($recentAbsensi ?? null)
                    <div class="absolute p-4 bg-white -top-8 -right-8 animate-float rounded-xl shadow-custom-lg">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex items-center justify-center w-10 h-10 text-green-500 bg-green-100 rounded-full">
                                <i class='bx bx-check'></i>
                            </div>
                            <div>
                                <p class="m-0 text-sm font-medium">Absensi Tercatat</p>
                                <p class="m-0 text-xs text-text-secondary">
                                    {{ $recentAbsensi->peserta ? $recentAbsensi->peserta->nama : 'Peserta' }} -
                                    {{ $recentAbsensi->waktu_absen ? \Carbon\Carbon::parse($recentAbsensi->waktu_absen)->diffForHumans() : 'Baru saja' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($recentLaporan ?? null)
                    <div
                        class="absolute p-4 bg-white -bottom-4 -left-8 animate-float animation-delay-1000 rounded-xl shadow-custom-lg">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full text-primary">
                                <i class='bx bx-file'></i>
                            </div>
                            <div>
                                <p class="m-0 text-sm font-medium">Laporan Baru</p>
                                <p class="m-0 text-xs text-text-secondary">
                                    {{ $recentLaporan->peserta ? $recentLaporan->peserta->nama : 'Peserta' }} -
                                    {{ $recentLaporan->tanggal_laporan ? \Carbon\Carbon::parse($recentLaporan->tanggal_laporan)->diffForHumans() : 'Baru saja' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section id="features" class="py-20 bg-white">
        <div class="px-6 mx-auto max-w-7xl">
            <div class="mb-16 text-center">
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 mb-4 text-sm font-medium bg-blue-100 rounded-full reveal text-primary">
                    <i class='bx bx-bolt'></i>
                    Fitur Unggulan
                </span>
                <h2 class="mb-4 text-4xl font-bold reveal text-text-primary">
                    Mengapa Memilih <span class="gradient-text">SimpanData</span>?
                </h2>
                <p class="max-w-2xl mx-auto text-lg reveal text-text-secondary">
                    SimpanData dirancang untuk menghilangkan cara kerja manual yang selama ini membuat
                    data peserta tercecer, status kegiatan tidak jelas, dan proses administrasi makan waktu.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-8 mb-16 md:grid-cols-2 lg:grid-cols-3">
                <div
                    class="reveal bg-white rounded-2xl p-8 border border-border transition-all duration-300 hover:-translate-y-1 hover:shadow-custom-lg hover:border-primary/30 relative overflow-hidden before:content-[''] before:absolute before:top-0 before:left-0 before:right-0 before:h-1 before:bg-gradient-to-r before:from-primary before:to-primary-dark before:scale-x-0 before:transition-transform before:duration-300 hover:before:scale-x-100">
                    <div
                        class="flex items-center justify-center mb-6 text-2xl transition-transform duration-300 bg-blue-100 w-14 h-14 rounded-xl text-primary group-hover:scale-110">
                        <i class='bx bx-data'></i>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-text-primary">Sistem Pusat Terintegrasi</h3>
                    <p class="leading-relaxed text-text-secondary">
                        Semua informasi penting peserta dikumpulkan dalam satu sistem yang konsisten.
                        Tidak ada lagi kebingungan soal data mana yang benar. Data terstruktur, rapi,
                        dan selalu dapat diakses kapan saja.
                    </p>
                </div>

                <div
                    class="reveal bg-white rounded-2xl p-8 border border-border transition-all duration-300 hover:-translate-y-1 hover:shadow-custom-lg hover:border-primary/30 relative overflow-hidden before:content-[''] before:absolute before:top-0 before:left-0 before:right-0 before:h-1 before:bg-gradient-to-r before:from-primary before:to-primary-dark before:scale-x-0 before:transition-transform before:duration-300 hover:before:scale-x-100">
                    <div
                        class="flex items-center justify-center mb-6 text-2xl text-green-500 transition-transform duration-300 bg-green-100 w-14 h-14 rounded-xl group-hover:scale-110">
                        <i class='bx bx-shield-alt'></i>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-text-primary">Kontrol Penuh untuk Admin</h3>
                    <p class="leading-relaxed text-text-secondary">
                        Admin tidak perlu lagi mengecek absensi satu per satu atau menanyakan laporan lewat chat.
                        Sistem otomatis mencatat kehadiran, menyimpan laporan, dan memperbarui status peserta.
                    </p>
                </div>

                <div
                    class="reveal bg-white rounded-2xl p-8 border border-border transition-all duration-300 hover:-translate-y-1 hover:shadow-custom-lg hover:border-primary/30 relative overflow-hidden before:content-[''] before:absolute before:top-0 before:left-0 before:right-0 before:h-1 before:bg-gradient-to-r before:from-primary before:to-primary-dark before:scale-x-0 before:transition-transform before:duration-300 hover:before:scale-x-100">
                    <div
                        class="flex items-center justify-center mb-6 text-2xl text-purple-500 transition-transform duration-300 bg-purple-100 w-14 h-14 rounded-xl group-hover:scale-110">
                        <i class='bx bx-user'></i>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-text-primary">Kejelasan untuk Peserta</h3>
                    <p class="leading-relaxed text-text-secondary">
                        Peserta bisa melihat status kegiatan mereka sendiri, riwayat absensi, serta kewajiban
                        yang harus dipenuhi tanpa harus terus bertanya ke admin.
                    </p>
                </div>

                <div
                    class="reveal bg-white rounded-2xl p-8 border border-border transition-all duration-300 hover:-translate-y-1 hover:shadow-custom-lg hover:border-primary/30 relative overflow-hidden before:content-[''] before:absolute before:top-0 before:left-0 before:right-0 before:h-1 before:bg-gradient-to-r before:from-primary before:to-primary-dark before:scale-x-0 before:transition-transform before:duration-300 hover:before:scale-x-100">
                    <div
                        class="flex items-center justify-center mb-6 text-2xl transition-transform duration-300 bg-orange-100 w-14 h-14 rounded-xl text-amber-500 group-hover:scale-110">
                        <i class='bx bx-search'></i>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-text-primary">Jejak Data yang Dapat Diaudit</h3>
                    <p class="leading-relaxed text-text-secondary">
                        Setiap absensi, laporan, dan feedback tersimpan dengan waktu dan identitas yang jelas.
                        Sistem ini adalah alat pembuktian yang objektif.
                    </p>
                </div>

                <div
                    class="reveal bg-white rounded-2xl p-8 border border-border transition-all duration-300 hover:-translate-y-1 hover:shadow-custom-lg hover:border-primary/30 relative overflow-hidden before:content-[''] before:absolute before:top-0 before:left-0 before:right-0 before:h-1 before:bg-gradient-to-r before:from-primary before:to-primary-dark before:scale-x-0 before:transition-transform before:duration-300 hover:before:scale-x-100">
                    <div
                        class="flex items-center justify-center mb-6 text-2xl text-pink-500 transition-transform duration-300 bg-pink-100 w-14 h-14 rounded-xl group-hover:scale-110">
                        <i class='bx bx-cog'></i>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-text-primary">Sederhana</h3>
                    <p class="leading-relaxed text-text-secondary">
                        Tidak berisik secara tampilan, tidak ribet secara alur, namun kuat secara logika.
                        Pengelolaan PKL dan magang tidak perlu bergantung pada banyak aplikasi terpisah.
                    </p>
                </div>

                <div
                    class="reveal bg-white rounded-2xl p-8 border border-border transition-all duration-300 hover:-translate-y-1 hover:shadow-custom-lg hover:border-primary/30 relative overflow-hidden before:content-[''] before:absolute before:top-0 before:left-0 before:right-0 before:h-1 before:bg-gradient-to-r before:from-primary before:to-primary-dark before:scale-x-0 before:transition-transform before:duration-300 hover:before:scale-x-100">
                    <div
                        class="flex items-center justify-center mb-6 text-2xl text-indigo-500 transition-transform duration-300 bg-indigo-100 w-14 h-14 rounded-xl group-hover:scale-110">
                        <i class='bx bx-check-shield'></i>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-text-primary">Sistem yang Dapat Diandalkan</h3>
                    <p class="leading-relaxed text-text-secondary">
                        Ini bukan project hiasan, tapi sistem yang memecahkan masalah nyata dengan aturan,
                        otomasi, dan struktur data yang jelas. Dibangun untuk dipakai, diuji, dan dipertanggungjawabkan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="feedback" class="py-20 overflow-hidden bg-gradient-to-b from-white to-slate-50">
        <div class="px-6 mx-auto max-w-7xl">
            <div class="mb-16 text-center">
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 mb-4 text-sm font-medium bg-blue-100 rounded-full reveal text-primary">
                    <i class='bx bx-star'></i>
                    Testimoni Pengguna
                </span>
                <h2 class="mb-4 text-4xl font-bold reveal text-text-primary">
                    Apa Kata Mereka tentang <span class="gradient-text">SimpanData</span>?
                </h2>
                <p class="max-w-2xl mx-auto text-lg reveal text-text-secondary">
                    Banyak pengguna yang sudah merasakan kemudahan dalam mengelola program PKL dan magang
                    dengan SimpanData. Berikut adalah beberapa testimoni dari mereka.
                </p>
            </div>
        </div>

        <div class="relative py-8 overflow-hidden feedback-container" id="feedbackContainer1">
            <div class="feedback-track animate-scroll-left" id="feedbackTrack1">
            </div>
        </div>

        <div class="relative py-8 mt-8 overflow-hidden feedback-container" id="feedbackContainer2">
            <div class="feedback-track animate-scroll-left"
                style="animation-duration: 40s; animation-direction: reverse;" id="feedbackTrack2">
            </div>
        </div>
    </section>

    <footer class="text-white bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <div class="px-6 mx-auto max-w-7xl">
            <div class="py-16">
                <div class="grid grid-cols-1 gap-12 mb-12 md:grid-cols-2 lg:grid-cols-4">
                    <div class="lg:col-span-1">
                        <a href="#home" class="flex items-center gap-3 mb-6 no-underline group">
                            <img src="{{ asset('storage/logo/logo_simpandata.webp') }}"
                                alt="SimpanData Logo"
                                class="object-contain w-12 h-12 transition-transform duration-300 border-2 rounded-lg border-primary group-hover:scale-110">
                            <span class="text-2xl font-extrabold text-white">SimpanData</span>
                        </a>

                        <p class="mb-6 text-sm leading-relaxed text-slate-300">
                            Sistem pengelolaan kegiatan PKL dan magang yang rapi, terstruktur,
                            dan dapat diandalkan untuk institusi pendidikan dan perusahaan.
                        </p>

                        <div class="flex gap-3">
                            <a href="https://github.com"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center justify-center text-white no-underline transition-all duration-300 rounded-lg w-11 h-11 bg-slate-800 hover:bg-primary hover:scale-110 hover:shadow-lg hover:shadow-primary/50"
                                title="GitHub">
                                <i class='bx bxl-github'></i>
                            </a>
                            <a href="https://twitter.com"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center justify-center text-white no-underline transition-all duration-300 rounded-lg w-11 h-11 bg-slate-800 hover:bg-blue-500 hover:scale-110 hover:shadow-lg hover:shadow-blue-500/50"
                                title="Twitter">
                                <i class='bx bxl-twitter'></i>
                            </a>
                            <a href="https://linkedin.com"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center justify-center text-white no-underline transition-all duration-300 rounded-lg w-11 h-11 bg-slate-800 hover:bg-blue-600 hover:scale-110 hover:shadow-lg hover:shadow-blue-600/50"
                                title="LinkedIn">
                                <i class='bx bxl-linkedin'></i>
                            </a>
                        </div>
                    </div>

                    <div>
                        <h3 class="mb-6 text-lg font-bold text-white">Tautan Cepat</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="#home"
                                    class="flex items-center gap-2 text-sm no-underline transition-all duration-300 text-slate-300 hover:text-primary hover:translate-x-1">
                                    <i class='bx bx-chevron-right'></i>
                                    <span>Beranda</span>
                                </a>
                            </li>
                            <li>
                                <a href="#features"
                                    class="flex items-center gap-2 text-sm no-underline transition-all duration-300 text-slate-300 hover:text-primary hover:translate-x-1">
                                    <i class='bx bx-chevron-right'></i>
                                    <span>Fitur</span>
                                </a>
                            </li>
                            <li>
                                <a href="#feedback"
                                    class="flex items-center gap-2 text-sm no-underline transition-all duration-300 text-slate-300 hover:text-primary hover:translate-x-1">
                                    <i class='bx bx-chevron-right'></i>
                                    <span>Testimoni</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('auth') }}"
                                    class="flex items-center gap-2 text-sm no-underline transition-all duration-300 text-slate-300 hover:text-primary hover:translate-x-1">
                                    <i class='bx bx-chevron-right'></i>
                                    <span>Masuk</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="mb-6 text-lg font-bold text-white">Legal</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('privacy.policy') }}"
                                    class="flex items-center gap-2 text-sm no-underline transition-all duration-300 text-slate-300 hover:text-primary hover:translate-x-1">
                                    <i class='bx bx-chevron-right'></i>
                                    <span>Privacy Policy</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('terms.of.service') }}"
                                    class="flex items-center gap-2 text-sm no-underline transition-all duration-300 text-slate-300 hover:text-primary hover:translate-x-1">
                                    <i class='bx bx-chevron-right'></i>
                                    <span>Terms of Service</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-700">
                    <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
                        <p class="text-sm text-slate-400">
                            &copy; {{ date('Y') }} <span class="font-semibold text-white">SimpanData</span>. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const feedbacks = @json($feedbacks ?? []);

        function renderFeedbacks() {
            const track1 = document.getElementById('feedbackTrack1');
            const track2 = document.getElementById('feedbackTrack2');

            if (!track1 || !track2 || !feedbacks || feedbacks.length === 0) {
                if (track1) track1.innerHTML = '<div class="flex-shrink-0 w-full max-w-sm p-6 text-center text-gray-500 bg-white border rounded-2xl shadow-custom border-border">Belum ada testimoni</div>';
                if (track2) track2.innerHTML = '<div class="flex-shrink-0 w-full max-w-sm p-6 text-center text-gray-500 bg-white border rounded-2xl shadow-custom border-border">Belum ada testimoni</div>';
                return;
            }

            const allFeedbacks = [...feedbacks, ...feedbacks];

            allFeedbacks.forEach(feedback => {
                const card = document.createElement('div');
                card.className = 'flex-shrink-0 w-full max-w-sm p-6 bg-white border rounded-2xl shadow-custom border-border';

                const initial = (feedback.peserta && feedback.peserta.nama) ? feedback.peserta.nama.charAt(0).toUpperCase() : 'U';
                const nama = (feedback.peserta && feedback.peserta.nama) ? feedback.peserta.nama : 'Pengguna';
                const jenis = (feedback.peserta && feedback.peserta.jenis_kegiatan) ? feedback.peserta.jenis_kegiatan : 'Peserta';
                const pesan = feedback.pesan || '';

                card.innerHTML = `
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex items-center justify-center w-12 h-12 font-bold text-white rounded-full bg-gradient-to-br from-primary to-primary-dark">
                            ${initial}
                        </div>
                        <div>
                            <h4 class="m-0 font-bold text-text-primary">${nama}</h4>
                            <p class="m-0 text-sm text-text-secondary">${jenis}</p>
                        </div>
                    </div>
                    <p class="text-text-secondary line-clamp-3">${pesan}</p>
                `;

                track1.appendChild(card.cloneNode(true));
                track2.appendChild(card.cloneNode(true));
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            renderFeedbacks();
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');

            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('active');
                    const icon = mobileMenuBtn.querySelector('i');
                    if (mobileMenu.classList.contains('active')) {
                        icon.classList.remove('bx-menu');
                        icon.classList.add('bx-x');
                    } else {
                        icon.classList.remove('bx-x');
                        icon.classList.add('bx-menu');
                    }
                });
            }

            const navbar = document.getElementById('navbar');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('shadow-md', 'bg-white');
                    navbar.classList.remove('bg-white/90');
                } else {
                    navbar.classList.remove('shadow-md', 'bg-white');
                    navbar.classList.add('bg-white/90');
                }
            });

            const reveals = document.querySelectorAll('.reveal');
            const revealOnScroll = function() {
                reveals.forEach(element => {
                    const windowHeight = window.innerHeight;
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;

                    if (elementTop < windowHeight - elementVisible) {
                        element.classList.add('active');
                    }
                });
            };

            window.addEventListener('scroll', revealOnScroll);
            revealOnScroll();

            const feedbackTracks = document.querySelectorAll('.feedback-track');
            feedbackTracks.forEach(track => {
                track.addEventListener('mouseenter', () => {
                    track.classList.add('paused');
                });
                track.addEventListener('mouseleave', () => {
                    track.classList.remove('paused');
                });
            });

            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;

                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });

                        if (mobileMenu && mobileMenu.classList.contains('active')) {
                            mobileMenu.classList.remove('active');
                            const icon = mobileMenuBtn.querySelector('i');
                            icon.classList.remove('bx-x');
                            icon.classList.add('bx-menu');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
