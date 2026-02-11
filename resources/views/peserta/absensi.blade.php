@extends('layouts.app')

@section('title', 'Data Absensi')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="flex items-center justify-between p-4 border-l-4 border-green-500 rounded-lg shadow-sm bg-green-50 animate-fade-in">
            <div class="flex items-center space-x-3">
                <i class='text-xl text-green-500 bx bxs-check-circle'></i>
                <div>
                    <p class="text-base font-bold text-green-900">Berhasil!</p>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center justify-between p-4 border-l-4 border-red-500 rounded-lg shadow-sm bg-red-50 animate-fade-in">
            <div class="flex items-center space-x-3">
                <i class='text-xl text-red-500 bx bxs-error-circle'></i>
                <div>
                    <p class="text-base font-bold text-red-900">Gagal!</p>
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="p-6 card shadow-soft">
        <div class="flex items-start">
            <div class="flex items-center justify-center w-12 h-12 mr-4 text-2xl text-blue-600 rounded-lg bg-blue-50">
                <i class='bx bx-calendar-check'></i>
            </div>
            <div>
                <h3 class="text-xl font-bold tracking-tight text-slate-900">Halo, {{ $peserta->nama ?? 'Peserta' }}!</h3>
                <p class="mt-1 text-sm font-medium text-slate-600">Silakan lakukan presensi kehadiran untuk hari ini, {{ date('l, j F Y') }}.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="p-6 card shadow-soft">
            <h4 class="mb-5 text-sm font-bold tracking-widest uppercase text-slate-500">Waktu Sekarang</h4>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-4xl font-bold text-slate-900" id="current-time">00:00:00</p>
                    <p class="mt-2 text-sm font-medium text-slate-500" id="current-date">{{ date('j F Y') }}</p>
                </div>
                <div class="flex items-center justify-center w-16 h-16 text-3xl rounded-lg text-slate-400 bg-slate-50">
                    <i class='bx bx-time-five'></i>
                </div>
            </div>
        </div>

        <div class="p-6 card shadow-soft">
            <h4 class="mb-5 text-sm font-bold tracking-widest uppercase text-slate-500">Status Lokasi</h4>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-bold text-slate-800" id="location-status">Mendeteksi lokasi...</p>
                    <button type="button" id="refresh-location-btn" class="mt-2 text-xs font-bold text-blue-600 uppercase transition-colors hover:text-blue-800 focus:outline-none">
                        <i class='mr-1 bx bx-refresh'></i> Refresh Lokasi
                    </button>
                </div>
                <div class="flex items-center justify-center w-16 h-16 text-3xl rounded-lg text-slate-400 bg-slate-50">
                    <i class='bx bx-map'></i>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('absensi.store') }}" method="POST" id="attendance-form">
        @csrf
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <input type="hidden" name="attendance_time" id="attendance-time">
        <input type="hidden" name="type" id="attendance-type">

        <div class="p-6 card shadow-soft md:p-8">
            <h2 class="mb-6 text-xl font-bold tracking-tight uppercase text-slate-800">Form Absensi Harian</h2>

            <div>
                <label class="block mb-3 text-sm font-bold tracking-widest uppercase text-slate-700">Status Kehadiran</label>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <label class="relative flex items-center p-5 transition-all duration-200 border-2 border-green-200 rounded-xl cursor-pointer hover:border-green-400 hover:bg-green-50/50 group">
                        <input type="radio" name="status" value="Hadir" class="w-5 h-5 text-green-600 focus:ring-green-500">
                        <div class="ml-4">
                            <span class="text-base font-bold text-slate-800">Hadir</span>
                            <p class="text-sm text-slate-500">Kehadiran normal</p>
                        </div>
                        <i class='absolute text-2xl transition-opacity opacity-0 bx bx-check-circle text-green-600 right-4 group-has-[:checked]:opacity-100'></i>
                    </label>

                    <label class="relative flex items-center p-5 transition-all duration-200 border-2 border-yellow-200 rounded-xl cursor-pointer hover:border-yellow-400 hover:bg-yellow-50/50 group">
                        <input type="radio" name="status" value="Izin" class="w-5 h-5 text-yellow-600 focus:ring-yellow-500">
                        <div class="ml-4">
                            <span class="text-base font-bold text-slate-800">Izin</span>
                            <p class="text-sm text-slate-500">Dengan izin</p>
                        </div>
                        <i class='absolute text-2xl transition-opacity opacity-0 bx bx-check-circle text-yellow-600 right-4 group-has-[:checked]:opacity-100'></i>
                    </label>

                    <label class="relative flex items-center p-5 transition-all duration-200 border-2 border-red-200 rounded-xl cursor-pointer hover:border-red-400 hover:bg-red-50/50 group">
                        <input type="radio" name="status" value="Sakit" class="w-5 h-5 text-red-600 focus:ring-red-500">
                        <div class="ml-4">
                            <span class="text-base font-bold text-slate-800">Sakit</span>
                            <p class="text-sm text-slate-500">Tidak masuk sakit</p>
                        </div>
                        <i class='absolute text-2xl transition-opacity opacity-0 bx bx-check-circle text-red-600 right-4 group-has-[:checked]:opacity-100'></i>
                    </label>
                </div>
            </div>

            <div class="mt-8 space-y-6">
                <div id="work-mode-section">
                    <label class="block mb-3 text-sm font-bold tracking-widest uppercase text-slate-700">Mode Kerja</label>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <label class="relative flex items-center p-5 transition-all duration-200 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 hover:bg-blue-50/30 group">
                            <input type="radio" name="mode_kerja" value="WFO" class="w-5 h-5 text-blue-600 focus:ring-blue-500">
                            <div class="ml-4">
                                <span class="text-base font-bold text-slate-800">WFO</span>
                                <p class="text-sm text-slate-500">Work From Office</p>
                            </div>
                            <i class='absolute text-2xl transition-opacity opacity-0 bx bx-check-circle text-blue-600 right-4 group-has-[:checked]:opacity-100'></i>
                        </label>

                        <label class="relative flex items-center p-5 transition-all duration-200 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 hover:bg-blue-50/30 group">
                            <input type="radio" name="mode_kerja" value="WFA" class="w-5 h-5 text-blue-600 focus:ring-blue-500">
                            <div class="ml-4">
                                <span class="text-base font-bold text-slate-800">WFA</span>
                                <p class="text-sm text-slate-500">Work From Anywhere</p>
                            </div>
                            <i class='absolute text-2xl transition-opacity opacity-0 bx bx-check-circle text-blue-600 right-4 group-has-[:checked]:opacity-100'></i>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block mb-3 text-sm font-bold tracking-widest uppercase text-slate-700">Jenis Absensi</label>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <button type="button" id="checkin-btn" 
                                class="p-4 transition-all duration-200 border-2 border-green-200 rounded-lg hover:border-green-400 hover:bg-green-50/50 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                            <div class="flex items-center justify-center gap-3">
                                <div class="flex items-center justify-center w-10 h-10 text-xl text-green-600 bg-green-100 rounded-lg">
                                    <i class='bx bx-log-in'></i>
                                </div>
                                <div class="text-left">
                                    <span class="block text-sm font-bold text-green-700">Absensi Masuk</span>
                                    <span class="block text-xs text-slate-500">Check In</span>
                                </div>
                            </div>
                        </button>

                        <button type="button" id="checkout-btn" 
                                class="p-4 transition-all duration-200 border-2 border-red-200 rounded-lg hover:border-red-400 hover:bg-red-50/50 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                            <div class="flex items-center justify-center gap-3">
                                <div class="flex items-center justify-center w-10 h-10 text-xl text-red-600 bg-red-100 rounded-lg">
                                    <i class='bx bx-log-out'></i>
                                </div>
                                <div class="text-left">
                                    <span class="block text-sm font-bold text-red-700">Absensi Pulang</span>
                                    <span class="block text-xs text-slate-500">Check Out</span>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="notes" class="block mb-3 text-sm font-bold tracking-widest uppercase text-slate-700">
                        Catatan (Opsional)
                    </label>
                    <textarea id="notes" name="notes" rows="4" 
                              class="w-full px-4 py-3 transition-colors border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    <p class="mt-2 text-xs font-medium text-slate-500">Catatan akan disimpan sebagai informasi tambahan.</p>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <button type="submit" id="submit-btn"
                            class="px-6 py-3 text-sm font-bold text-white transition-all duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                        <div class="flex items-center gap-2">
                            <i class='text-base bx bx-send'></i>
                            <span>Kirim Absensi</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
    @vite('resources/js/peserta/absensi.js')
@endsection
