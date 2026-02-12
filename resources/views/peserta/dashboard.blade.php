@extends('layouts.app')

@section('title', 'Dashboard Peserta')

@section('content')
    @php
        /** @var \App\Models\User $user */
        $jenisKegiatan = $peserta->jenis_kegiatan ?? 'Kegiatan';
    @endphp

    <div class="space-y-6">
        <div class="space-y-3 animate-fade-in">
            @if (!$peserta)
                <div class="flex items-center justify-between p-4 border-l-4 border-red-500 rounded-lg shadow-sm bg-red-50">
                    <div class="flex items-center space-x-3">
                        <i class='text-xl text-red-500 bx bxs-error-circle'></i>
                        <div>
                            <p class="text-base font-bold text-red-900">Lengkapi Profil Anda</p>
                            <p class="text-sm text-red-700">Data diri diperlukan untuk memproses progres dan verifikasi
                                kehadiran Anda.</p>
                        </div>
                    </div>
                    <a href="{{ route('peserta.profil') }}"
                        class="px-4 py-1.5 bg-red-500 text-white text-xs font-semibold rounded-lg hover:bg-red-600 transition-all">Lengkapi
                        Sekarang</a>
                </div>
            @elseif(!$absensiHariIni)
                <div
                    class="flex items-center justify-between p-4 border-l-4 border-orange-500 rounded-lg shadow-sm bg-orange-50">
                    <div class="flex items-center space-x-3">
                        <i class='text-xl text-orange-500 bx bxs-time-five'></i>
                        <div>
                            <p class="text-base font-bold text-orange-900">Belum Ada Presensi Hari Ini</p>
                            <p class="text-sm text-orange-700">Silakan lakukan presensi kehadiran agar data terhitung dalam
                                sistem analitik.</p>
                        </div>
                    </div>
                    <a href="{{ route('peserta.absensi') }}"
                        class="px-4 py-1.5 bg-orange-500 text-white text-xs font-semibold rounded-lg hover:bg-orange-600 transition-all">Absen
                        Sekarang</a>
                </div>
            @endif
        </div>

        <div class="flex flex-col justify-between gap-6 p-6 md:flex-row md:items-center card shadow-soft">
            <div class="flex items-center space-x-5">
                <div class="relative">
                    @if ($peserta && $peserta->foto)
                        <img src="{{ asset('storage/' . $peserta->foto) }}"
                            class="object-cover w-16 h-16 border-2 border-gray-100 shadow-sm rounded-xl">
                    @else
                        <div
                            class="flex items-center justify-center w-16 h-16 text-2xl font-bold border bg-primary-light text-primary rounded-xl border-primary/5">
                            {{ strtoupper(substr($user->username, 0, 1)) }}
                        </div>
                    @endif
                    <div class="absolute w-4 h-4 bg-green-500 border-2 border-white rounded-full -bottom-1 -right-1"></div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Halo,
                        {{ $peserta->nama ?? $user->username }}!</h1>
                    <p class="text-base font-medium text-slate-600">Selamat datang di sistem monitoring {{ $jenisKegiatan }}
                        Anda.</p>
                </div>
            </div>
            <div
                class="flex items-center justify-between w-full gap-3 px-4 py-3 border border-blue-100 md:w-auto bg-blue-50/50 rounded-xl">
                <div>
                    <p class="text-xs font-bold leading-none tracking-widest text-blue-500 uppercase">Status Program</p>
                    <p class="mt-1 text-base font-bold text-blue-900 uppercase">{{ $progress >= 100 ? 'Selesai' : 'Aktif' }}
                    </p>
                </div>
                <div class="flex items-center justify-center w-10 h-10 text-blue-600 bg-blue-100 rounded-lg">
                    <i class='text-2xl bx bx-check-shield'></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            <div class="p-5 transition-all duration-300 card group">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center justify-center w-10 h-10 text-xl text-blue-600 rounded-lg bg-blue-50">
                        <i class='bx bx-check-square'></i>
                    </div>
                    <span class="text-xs font-bold tracking-widest uppercase text-slate-500">Presensi</span>
                </div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalHadir }} <span
                        class="text-sm font-medium text-slate-400">presensi</span></h3>
                <p class="mt-1 text-xs font-medium text-slate-500">Total kehadiran terverifikasi</p>
            </div>

            <div class="p-5 transition-all duration-300 card group">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center justify-center w-10 h-10 text-xl text-orange-500 rounded-lg bg-orange-50">
                        <i class='bx bx-cloud-upload'></i>
                    </div>
                    <span class="text-xs font-bold tracking-widest uppercase text-slate-500">Laporan</span>
                </div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalLaporan }} <span
                        class="text-sm font-medium text-slate-400">Berkas</span></h3>
                <p class="mt-1 text-xs font-medium text-slate-500">Total laporan terkirim</p>
            </div>

            <div class="p-5 transition-all duration-300 card group">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center justify-center w-10 h-10 text-xl text-green-500 rounded-lg bg-green-50">
                        <i class='bx bx-calendar-check'></i>
                    </div>
                    <span class="text-xs font-bold tracking-widest uppercase text-slate-500">Hari</span>
                </div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $passedDays ?? 0 }} <span
                        class="text-sm font-medium text-slate-400">/ {{ $totalDays ?? 0 }} Hari</span></h3>
                <div class="w-full bg-gray-100 h-1.5 rounded-full mt-2">
                    <div class="h-full transition-all duration-700 bg-green-500 rounded-full"
                        style="width: {{ $progress }}%"></div>
                </div>
            </div>

            <div class="relative p-5 overflow-hidden bg-white border card border-slate-200 shadow-soft group">
                <div class="relative z-10">
                    <p class="mb-3 text-xs font-extrabold tracking-widest uppercase text-slate-500">Periode
                        {{ $jenisKegiatan }}</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase text-slate-500">Mulai</p>
                            <p class="text-base font-bold text-slate-800 mt-0.5">
                                {{ $peserta && $peserta->tanggal_mulai ? \Carbon\Carbon::parse($peserta->tanggal_mulai)->format('d M Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase text-slate-500">Selesai</p>
                            <p class="text-base font-bold text-slate-800 mt-0.5">
                                {{ $peserta && $peserta->tanggal_selesai ? \Carbon\Carbon::parse($peserta->tanggal_selesai)->format('d M Y') : '-' }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-bold uppercase text-slate-500">Masa {{ $jenisKegiatan }}</span>
                            <span class="text-xs font-bold text-primary">{{ $progress }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-primary h-full rounded-full transition-all duration-1000 shadow-[0_0_10px_rgba(16,54,125,0.2)]"
                                style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                </div>
                <i
                    class='absolute transition-colors bx bx-calendar -right-4 -bottom-4 text-7xl text-slate-50 group-hover:text-slate-100'></i>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 pb-6 lg:grid-cols-12">
            <div class="p-6 lg:col-span-8 card md:p-8 shadow-soft">
                <div class="flex flex-col justify-between gap-4 mb-8 md:flex-row md:items-center">
                    <div>
                        <h4 class="text-lg font-bold tracking-tight uppercase text-slate-800">Analisa Kehadiran</h4>
                        <p class="text-xs font-medium text-slate-400 whitespace-nowrap">Statistik aktivitas harian dalam
                            satu periode</p>
                    </div>

                    <div class="flex flex-col gap-2 md:flex-row md:items-center">
                        <select id="weekSelector"
                            class="hidden w-full px-3 py-2 text-xs font-bold bg-white border border-gray-200 rounded-xl text-slate-600 focus:outline-none focus:border-primary md:w-auto md:py-1.5">
                            @foreach ($availableWeeks as $wk)
                                <option value="{{ $wk['value'] }}" {{ $weekFilter == $wk['value'] ? 'selected' : '' }}>
                                    {{ $wk['label'] }}</option>
                            @endforeach
                        </select>
                        <div class="flex items-center gap-1 p-1 overflow-x-auto border border-gray-200 bg-gray-50 rounded-xl no-scrollbar md:overflow-visible"
                            id="chartFilter">
                            <button data-filter="hari"
                                class="filter-btn shrink-0 px-4 py-1.5 text-xs font-bold uppercase rounded-lg transition-all {{ $filter == 'hari' ? 'bg-white text-primary shadow-sm border border-gray-100' : 'text-slate-500 hover:text-slate-700' }}">Hari</button>
                            <button data-filter="minggu"
                                class="filter-btn shrink-0 px-4 py-1.5 text-xs font-bold uppercase rounded-lg transition-all {{ $filter == 'minggu' ? 'bg-white text-primary shadow-sm border border-gray-100' : 'text-slate-500 hover:text-slate-700' }}">Minggu</button>
                            <button data-filter="bulan"
                                class="filter-btn shrink-0 px-4 py-1.5 text-xs font-bold uppercase rounded-lg transition-all {{ $filter == 'bulan' ? 'bg-white text-primary shadow-sm border border-gray-100' : 'text-slate-500 hover:text-slate-700' }}">Bulan</button>
                        </div>
                    </div>
                </div>
                <div class="h-64 md:h-[320px] w-full relative">
                    <div id="chartLoading"
                        class="absolute inset-0 bg-white/50 backdrop-blur-[1px] items-center justify-center z-10 hidden">
                        <div class="w-8 h-8 border-4 rounded-full border-primary/20 border-t-primary animate-spin"></div>
                    </div>
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>

            <div class="flex flex-col p-6 lg:col-span-4 card md:p-8 shadow-soft">
                <h4 class="w-full mb-6 text-lg font-bold tracking-tight uppercase text-slate-800">Statistik Kehadiran</h4>

                <div class="relative w-full aspect-square flex items-center justify-center max-w-[280px] mx-auto mb-8">
                    <canvas id="attendanceDonutChart"></canvas>
                    <div class="absolute flex flex-col items-center justify-center text-center">
                        <h2 class="text-3xl font-extrabold leading-none tracking-tighter text-slate-900">
                            {{ array_sum($attendanceBreakdown) }}
                        </h2>
                        <p class="mt-1 text-[10px] font-bold tracking-widest uppercase text-slate-500">Total Hari</p>
                    </div>
                </div>

                <div class="w-full space-y-3">
                    <div class="flex items-center justify-between p-3 border border-slate-50 bg-slate-50/50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-xs font-bold text-slate-700">Hadir</span>
                        </div>
                        <span class="text-sm font-bold text-slate-900">{{ $attendanceBreakdown['Hadir'] }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 border border-slate-50 bg-slate-50/50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <span class="text-xs font-bold text-slate-700">Izin</span>
                        </div>
                        <span class="text-sm font-bold text-slate-900">{{ $attendanceBreakdown['Izin'] }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 border border-slate-50 bg-slate-50/50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="text-xs font-bold text-slate-700">Sakit</span>
                        </div>
                        <span class="text-sm font-bold text-slate-900">{{ $attendanceBreakdown['Sakit'] }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 border border-slate-50 bg-slate-50/50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 bg-slate-400 rounded-full"></div>
                            <span class="text-xs font-bold text-slate-700">Alpha</span>
                        </div>
                        <span class="text-sm font-bold text-slate-900">{{ $attendanceBreakdown['Alpha'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        window.attendanceData = @json($absensiData);
        window.attendanceBreakdown = @json($attendanceBreakdown);
        window.routes = {
            dashboard: "{{ route('peserta.dashboard') }}"
        };
        window.initialFilter = "{{ $filter }}";
    </script>
    @vite('resources/js/peserta/dashboard.js')
@endsection
