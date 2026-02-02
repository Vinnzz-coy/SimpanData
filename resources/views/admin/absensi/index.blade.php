@extends('layouts.app')

@section('title', 'Absensi Peserta')

@section('content')
<div class="space-y-6">

    <div class="mb-4 md:mb-6 card">
        <div class="p-4 border-b border-gray-200 md:p-5">
            <h2 class="text-base font-semibold text-gray-800 md:text-lg">
                Statistik Kehadiran
            </h2>
        </div>

        <div class="p-4 md:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                <div class="overflow-hidden rounded-lg shadow-sm bg-gradient-to-br from-emerald-500 to-teal-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">Hadir Hari Ini</p>
                                
                                <div class="flex items-center mt-2">
                                    <div class="text-center flex-1">
                                        <p class="text-xs text-white/70">Masuk</p>
                                        <h3 class="text-3xl font-bold text-white">
                                            {{ $hadirMasuk }}
                                        </h3>
                                    </div>

                                    <div class="h-10 w-px bg-white/30 mx-3"></div>

                                    <div class="text-center flex-1">
                                        <p class="text-xs text-white/70">Pulang</p>
                                        <h3 class="text-3xl font-bold text-white">
                                            {{ $hadirPulang }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg shadow-sm bg-gradient-to-br from-amber-500 to-orange-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">Izin</p>
                                <h3 class="text-3xl font-bold text-white">{{ $izin }}</h3>
                                <p class="mt-1 text-xs text-white/70">Peserta</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg shadow-sm bg-gradient-to-br from-rose-500 to-pink-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">Sakit</p>
                                <h3 class="text-3xl font-bold text-white">{{ $sakit }}</h3>
                                <p class="mt-1 text-xs text-white/70">Peserta</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg shadow-sm bg-gradient-to-br from-blue-500 to-indigo-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">WFO</p>
                                <h3 class="text-3xl font-bold text-white">{{ $wfo }}</h3>
                                <p class="mt-1 text-xs text-white/70">Peserta</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg shadow-sm bg-gradient-to-br from-indigo-500 to-purple-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">WFA</p>
                                <h3 class="text-3xl font-bold text-white">{{ $wfa }}</h3>
                                <p class="mt-1 text-xs text-white/70">Peserta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-xl shadow">
        <form method="GET" id="filterForm"
            class="grid grid-cols-1 md:grid-cols-5 gap-3">

            <input type="date"
                name="tanggal"
                value="{{ $tanggal }}"
                onchange="this.form.submit()"
                class="border rounded-lg px-3 py-2 text-sm">

            <select name="asal_sekolah_universitas"
                onchange="this.form.submit()"
                class="border rounded-lg px-3 py-2 text-sm">
                <option value="">Semua Sekolah</option>
                @foreach ($sekolahs as $item)
                    <option value="{{ $item->asal_sekolah_universitas }}"
                        {{ $sekolah == $item->asal_sekolah_universitas ? 'selected' : '' }}>
                        {{ $item->asal_sekolah_universitas }}
                    </option>
                @endforeach
            </select>

            <select name="jenis_absen"
                onchange="this.form.submit()"
                class="border rounded-lg px-3 py-2 text-sm">
                <option value="">Jenis Absen</option>
                <option value="Masuk" {{ $jenis == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                <option value="Pulang" {{ $jenis == 'Pulang' ? 'selected' : '' }}>Pulang</option>
            </select>

            <select name="status"
                onchange="this.form.submit()"
                class="border rounded-lg px-3 py-2 text-sm">
                <option value="">Status</option>
                <option value="Hadir" {{ $status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="Izin" {{ $status == 'Izin' ? 'selected' : '' }}>Izin</option>
                <option value="Sakit" {{ $status == 'Sakit' ? 'selected' : '' }}>Sakit</option>
            </select>

            <div class="flex gap-12 items-center">
                <a href="{{ url()->current() }}"
                class="px-3 py-2 rounded-lg bg-gray-500 text-white text-sm
                        hover:bg-gray-600 flex items-center gap-1">
                    <i class='bx bx-reset'></i>
                    Reset
                </a>

                <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}"
                class="px-3 py-2 rounded-lg bg-green-500 text-white text-sm
                        hover:bg-green-600 flex items-center gap-1">
                    <i class='bx bxs-file-export'></i>
                    Excel
                </a>
            </div>
        </form>
    </div>


    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Nama Peserta</th>
                <th class="px-4 py-3 text-left">Jenis</th>
                <th class="px-4 py-3 text-left">Waktu Absen</th>
                <th class="px-4 py-3 text-left">Mode</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-left">WA Pengirim</th>
            </tr>
            </thead>
            <tbody class="divide-y">
            @forelse ($absensis as $index => $item)
            <tr>
                <td class="px-4 py-3">{{ $index + 1 }}</td>

                <td class="px-4 py-3 font-medium">
                    {{ $item->peserta->nama ?? '-' }}
                </td>

                <td class="px-4 py-3">{{ $item->jenis_absen ?? '-' }}</td>

                <td class="px-4 py-3 whitespace-nowrap">
                    {{ $item->waktu_absen
                        ? \Carbon\Carbon::parse($item->waktu_absen)->format('Y-m-d H:i')
                        : '-' }}
                </td>

                <td class="px-4 py-3">
                    @if ($item->mode_kerja === 'WFO')
                        <span class="px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700">
                            WFO
                        </span>
                    @elseif ($item->mode_kerja === 'WFA')
                        <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-700">
                            WFA
                        </span>
                    @else
                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-500">
                            -
                        </span>
                    @endif
                </td>

                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs
                        {{ $item->status === 'Hadir' ? 'bg-green-100 text-green-700'
                            : ($item->status === 'Izin' ? 'bg-yellow-100 text-yellow-700'
                            : 'bg-red-100 text-red-700') }}">
                        {{ $item->status }}
                    </span>
                </td>

                <td class="px-4 py-3">
                    {{ $item->wa_pengirim ?? '-' }}
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="9" class="px-4 py-6 text-center text-gray-500">
                    Tidak ada data absensi
                </td>
            </tr>
            @endforelse
            </tbody>

            <div class="p-4">
                {{ $absensis->links() }}
            </div>
        </table>
    </div>

</div>
@endsection
