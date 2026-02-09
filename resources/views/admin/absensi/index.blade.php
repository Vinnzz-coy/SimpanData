@extends('layouts.app')

@section('title', 'Data Absensi')

@section('content')
    <div class="space-y-6">
        <div class="mb-4 md:mb-6 card">
            <div class="p-4 border-b border-gray-200 md:p-5">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-gray-800 md:text-lg">
                            Statistik Kehadiran
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Pantau dan kelola data kehadiran harian peserta
                        </p>
                    </div>
                    <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-500 border border-emerald-500 rounded-lg hover:bg-emerald-600 transition-colors duration-200 shadow-md whitespace-nowrap">
                        <i class='bx bxs-file-export'></i>
                        <span>Excel</span>
                    </a>
                </div>
            </div>

            <div class="p-4 md:p-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    <div
                        class="overflow-hidden transition-all duration-300 rounded-lg shadow-sm bg-gradient-to-br from-emerald-500 to-teal-500 hover:shadow-xl hover:-translate-y-1 group">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">Hadir Hari
                                        Ini</p>
                                    <div class="flex items-center mt-2">
                                        <div class="flex-1 text-center">
                                            <p class="text-xs text-white/70">Masuk</p>
                                            <h3 class="text-3xl font-bold text-white">{{ $hadirMasuk }}</h3>
                                        </div>
                                        <div class="w-px h-10 mx-3 bg-white/30"></div>
                                        <div class="flex-1 text-center">
                                            <p class="text-xs text-white/70">Pulang</p>
                                            <h3 class="text-3xl font-bold text-white">{{ $hadirPulang }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div
                                        class="flex items-center justify-center w-12 h-12 transition-colors rounded-lg bg-white/20 group-hover:bg-white/30">
                                        <i class="text-2xl text-white bx bx-user-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="overflow-hidden transition-all duration-300 rounded-lg shadow-sm bg-gradient-to-br from-amber-500 to-orange-500 hover:shadow-xl hover:-translate-y-1 group">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">Izin</p>
                                    <h3 class="text-3xl font-bold text-white">{{ $izin }}</h3>
                                    <p class="mt-1 text-xs text-white/70">Peserta</p>
                                </div>
                                <div class="ml-4">
                                    <div
                                        class="flex items-center justify-center w-12 h-12 transition-colors rounded-lg bg-white/20 group-hover:bg-white/30">
                                        <i class="text-2xl text-white bx bx-envelope"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="overflow-hidden transition-all duration-300 rounded-lg shadow-sm bg-gradient-to-br from-rose-500 to-pink-500 hover:shadow-xl hover:-translate-y-1 group">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">Sakit</p>
                                    <h3 class="text-3xl font-bold text-white">{{ $sakit }}</h3>
                                    <p class="mt-1 text-xs text-white/70">Peserta</p>
                                </div>
                                <div class="ml-4">
                                    <div
                                        class="flex items-center justify-center w-12 h-12 transition-colors rounded-lg bg-white/20 group-hover:bg-white/30">
                                        <i class="text-2xl text-white bx bx-plus-medical"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="overflow-hidden transition-all duration-300 rounded-lg shadow-sm bg-gradient-to-br from-blue-500 to-indigo-500 hover:shadow-xl hover:-translate-y-1 group">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">WFO</p>
                                    <h3 class="text-3xl font-bold text-white">{{ $wfo }}</h3>
                                    <p class="mt-1 text-xs text-white/70">Peserta</p>
                                </div>
                                <div class="ml-4">
                                    <div
                                        class="flex items-center justify-center w-12 h-12 transition-colors rounded-lg bg-white/20 group-hover:bg-white/30">
                                        <i class="text-2xl text-white bx bx-building-house"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="overflow-hidden transition-all duration-300 rounded-lg shadow-sm bg-gradient-to-br from-indigo-500 to-purple-500 hover:shadow-xl hover:-translate-y-1 group">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">WFA</p>
                                    <h3 class="text-3xl font-bold text-white">{{ $wfa }}</h3>
                                    <p class="mt-1 text-xs text-white/70">Peserta</p>
                                </div>
                                <div class="ml-4">
                                    <div
                                        class="flex items-center justify-center w-12 h-12 transition-colors rounded-lg bg-white/20 group-hover:bg-white/30">
                                        <i class="text-2xl text-white bx bx-home-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6 card">
            <div class="p-4 md:p-5">
                <form method="GET" id="filterForm" class="grid grid-cols-1 gap-4 lg:grid-cols-[1fr_auto]">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                        <div class="space-y-1">
                            <label class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggalFilter" value="{{ $tanggal ?? '' }}"
                                onchange="this.form.submit()"
                                class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white">
                        </div>

                        <div class="space-y-1">
                            <label class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">Rentang</label>
                            <label
                                class="flex items-center gap-3 w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg bg-white text-gray-700 font-medium focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all duration-200">
                                <input type="checkbox" name="all_dates" id="allDatesFilter" value="1"
                                    {{ $allDates ? 'checked' : '' }} onchange="toggleAllDates(this)"
                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                Semua Tanggal
                            </label>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">Sekolah</label>
                            <div class="relative">
                                <select name="asal_sekolah_universitas" onchange="this.form.submit()"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white pr-10">
                                    <option value="">Semua Sekolah</option>
                                    @foreach ($sekolahs as $item)
                                        <option value="{{ $item->asal_sekolah_universitas }}"
                                            {{ $sekolah == $item->asal_sekolah_universitas ? 'selected' : '' }}>
                                            {{ $item->asal_sekolah_universitas }}
                                        </option>
                                    @endforeach
                                </select>
                                <i
                                    class='absolute text-gray-400 transform -translate-y-1/2 right-3 top-1/2 bx bx-chevron-down'></i>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">Jenis</label>
                            <div class="relative">
                                <select name="jenis_absen" onchange="this.form.submit()"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white pr-10">
                                    <option value="">Jenis Absen</option>
                                    <option value="Masuk" {{ $jenis == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                                    <option value="Pulang" {{ $jenis == 'Pulang' ? 'selected' : '' }}>Pulang</option>
                                </select>
                                <i
                                    class='absolute text-gray-400 transform -translate-y-1/2 right-3 top-1/2 bx bx-chevron-down'></i>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">Status</label>
                            <div class="relative">
                                <select name="status" onchange="this.form.submit()"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white pr-10">
                                    <option value="">Status</option>
                                    <option value="Hadir" {{ $status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="Izin" {{ $status == 'Izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="Sakit" {{ $status == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                </select>
                                <i
                                    class='absolute text-gray-400 transform -translate-y-1/2 right-3 top-1/2 bx bx-chevron-down'></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row lg:flex-col lg:items-stretch lg:justify-end">
                        <a href="{{ url()->current() }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 transition-colors duration-200 whitespace-nowrap">
                            <i class='bx bx-reset'></i>
                            <span>Reset</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>


        <div class="card">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="text-gray-600 border-b bg-gray-50/50">
                            <th class="px-4 py-3 font-semibold uppercase tracking-wider text-[11px]">No</th>
                            <th class="px-4 py-3 font-semibold uppercase tracking-wider text-[11px]">Nama Peserta</th>
                            <th class="px-4 py-3 font-semibold uppercase tracking-wider text-[11px]">Jenis</th>
                            <th class="px-4 py-3 font-semibold uppercase tracking-wider text-[11px]">Waktu Absen</th>
                            <th class="px-4 py-3 font-semibold uppercase tracking-wider text-[11px]">Mode</th>
                            <th class="px-4 py-3 font-semibold uppercase tracking-wider text-[11px]">Status</th>
                            <th class="px-4 py-3 font-semibold uppercase tracking-wider text-[11px]">WA Pengirim</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($absensis as $index => $item)
                            <tr class="transition-colors hover:bg-gray-50/50">
                                <td class="px-4 py-3 text-gray-500">{{ $index + $absensis->firstItem() }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900">
                                    {{ $item->peserta->nama ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2.5 py-1 text-xs font-medium rounded-lg
                                    {{ $item->jenis_absen === 'Masuk' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' }}">
                                        {{ $item->jenis_absen ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                                    {{ $item->waktu_absen ? \Carbon\Carbon::parse($item->waktu_absen)->format('Y-m-d H:i') : '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($item->mode_kerja === 'WFO')
                                        <span
                                            class="px-2.5 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-lg">
                                            WFO
                                        </span>
                                    @elseif ($item->mode_kerja === 'WFA')
                                        <span
                                            class="px-2.5 py-1 text-xs font-medium text-purple-700 bg-purple-100 rounded-lg">
                                            WFA
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-medium text-gray-500 bg-gray-100 rounded-lg">
                                            -
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2.5 py-1 rounded-lg text-xs font-medium
                                    {{ $item->status === 'Hadir'
                                        ? 'bg-emerald-100 text-emerald-700'
                                        : ($item->status === 'Izin'
                                            ? 'bg-amber-100 text-amber-700'
                                            : 'bg-rose-100 text-rose-700') }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $item->peserta->no_telepon ?? ($item->wa_pengirim ?? '-') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class='mb-2 text-4xl text-gray-300 bx bx-info-circle'></i>
                                        <p>Tidak ada data absensi untuk filter yang dipilih</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($absensis->hasPages())
                <div class="px-4 py-4 border-t border-gray-100 md:px-5">
                    {{ $absensis->onEachSide(1)->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        function toggleAllDates(checkbox) {
            const form = checkbox.form;
            const dateInput = form.querySelector('#tanggalFilter');
            if (!dateInput) return;

            if (checkbox.checked) {
                dateInput.value = '';
                dateInput.disabled = true;
            } else {
                dateInput.disabled = false;
                if (!dateInput.value) {
                    dateInput.value = '{{ \Carbon\Carbon::today()->toDateString() }}';
                }
            }

            form.submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('allDatesFilter');
            const dateInput = document.getElementById('tanggalFilter');
            if (checkbox && dateInput && checkbox.checked) {
                dateInput.disabled = true;
            }
        });
    </script>
@endsection
