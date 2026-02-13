@extends('layouts.app')

@section('title', 'Laporan Peserta')

@section('content')
<div class="space-y-6">
<<<<<<< HEAD
    <div class="mb-4 md:mb-6 card">
        <div class="flex flex-col gap-4 p-4 border-b border-gray-200 md:p-5 md:flex-row md:items-center md:justify-between">
=======
    <!-- Header & Statistics -->
    <div class="mb-4 md:mb-6 card">
        <div class="p-4 border-b border-gray-200 md:p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
>>>>>>> main
            <div>
                <h2 class="text-base font-semibold text-gray-800 md:text-lg">Statistik Laporan</h2>
                <p class="text-sm text-gray-600">Pantau progres verifikasi laporan harian peserta.</p>
            </div>
            <div class="flex gap-2">
<<<<<<< HEAD
=======
                <!-- Add any extra buttons here if needed -->
>>>>>>> main
            </div>
        </div>

        <div class="p-4 md:p-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
<<<<<<< HEAD
                <div class="overflow-hidden transition-all duration-300 border rounded-lg shadow-sm bg-gradient-to-br from-indigo-500 to-purple-500 hover:shadow-xl hover:-translate-y-1 group border-white/10">
=======
                <!-- Total Reports -->
                <div class="overflow-hidden transition-all duration-300 rounded-lg shadow-sm bg-gradient-to-br from-indigo-500 to-purple-500 hover:shadow-xl hover:-translate-y-1 group border border-white/10">
>>>>>>> main
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">Total Laporan</p>
                                <h3 class="text-3xl font-bold text-white">{{ $totalReports }}</h3>
                                <p class="mt-1 text-xs text-white/70">Keseluruhan</p>
                            </div>
                            <div class="ml-4">
                                <div class="flex items-center justify-center w-12 h-12 transition-colors rounded-lg bg-white/20 group-hover:bg-white/30">
<<<<<<< HEAD
                                    <i class='text-2xl text-white bx bx-clipboard'></i>
=======
                                    <i class='bx bx-clipboard text-2xl text-white'></i>
>>>>>>> main
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<<<<<<< HEAD
                <div class="overflow-hidden transition-all duration-300 border rounded-lg shadow-sm bg-gradient-to-br from-blue-500 to-indigo-500 hover:shadow-xl hover:-translate-y-1 group border-white/10">
=======
                <!-- Pending -->
                <div class="overflow-hidden transition-all duration-300 rounded-lg shadow-sm bg-gradient-to-br from-blue-500 to-indigo-500 hover:shadow-xl hover:-translate-y-1 group border border-white/10">
>>>>>>> main
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">Dikirim</p>
                                <h3 class="text-3xl font-bold text-white">{{ $pendingReports }}</h3>
                                <p class="mt-1 text-xs text-white/70">Perlu Review</p>
                            </div>
                            <div class="ml-4">
                                <div class="flex items-center justify-center w-12 h-12 transition-colors rounded-lg bg-white/20 group-hover:bg-white/30">
<<<<<<< HEAD
                                    <i class='text-2xl text-white bx bx-send'></i>
=======
                                    <i class='bx bx-send text-2xl text-white'></i>
>>>>>>> main
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<<<<<<< HEAD
                <div class="overflow-hidden transition-all duration-300 border rounded-lg shadow-sm bg-gradient-to-br from-emerald-500 to-teal-500 hover:shadow-xl hover:-translate-y-1 group border-white/10">
=======
                <!-- Approved -->
                <div class="overflow-hidden transition-all duration-300 rounded-lg shadow-sm bg-gradient-to-br from-emerald-500 to-teal-500 hover:shadow-xl hover:-translate-y-1 group border border-white/10">
>>>>>>> main
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">Disetujui</p>
                                <h3 class="text-3xl font-bold text-white">{{ $approvedReports }}</h3>
                                <p class="mt-1 text-xs text-white/70">Laporan Valid</p>
                            </div>
                            <div class="ml-4">
                                <div class="flex items-center justify-center w-12 h-12 transition-colors rounded-lg bg-white/20 group-hover:bg-white/30">
<<<<<<< HEAD
                                    <i class='text-2xl text-white bx bx-check-double'></i>
=======
                                    <i class='bx bx-check-double text-2xl text-white'></i>
>>>>>>> main
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<<<<<<< HEAD
                <div class="overflow-hidden transition-all duration-300 border rounded-lg shadow-sm bg-gradient-to-br from-amber-500 to-orange-500 hover:shadow-xl hover:-translate-y-1 group border-white/10">
=======
                <!-- Revised -->
                <div class="overflow-hidden transition-all duration-300 rounded-lg shadow-sm bg-gradient-to-br from-amber-500 to-orange-500 hover:shadow-xl hover:-translate-y-1 group border border-white/10">
>>>>>>> main
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">Revisi</p>
                                <h3 class="text-3xl font-bold text-white">{{ $revisedReports }}</h3>
                                <p class="mt-1 text-xs text-white/70">Perlu Perbaikan</p>
                            </div>
                            <div class="ml-4">
                                <div class="flex items-center justify-center w-12 h-12 transition-colors rounded-lg bg-white/20 group-hover:bg-white/30">
<<<<<<< HEAD
                                    <i class='text-2xl text-white bx bx-revision'></i>
=======
                                    <i class='bx bx-revision text-2xl text-white'></i>
>>>>>>> main
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<<<<<<< HEAD
=======
    <!-- Filters -->
>>>>>>> main
    <div class="mb-6 card">
        <div class="p-4 md:p-5">
            <form action="{{ route('admin.laporan.index') }}" method="GET" class="grid grid-cols-1 gap-4 lg:grid-cols-[1fr_auto]">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="space-y-1">
                        <label class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}" onchange="this.form.submit()"
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white shadow-sm">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">Asal Sekolah</label>
                        <div class="relative">
                            <select name="asal_sekolah_universitas" onchange="this.form.submit()"
                                class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white pr-10 shadow-sm">
                                <option value="">Semua Sekolah</option>
                                @foreach($sekolahs as $sh)
                                    <option value="{{ $sh->asal_sekolah_universitas }}" {{ request('asal_sekolah_universitas') == $sh->asal_sekolah_universitas ? 'selected' : '' }}>
                                        {{ $sh->asal_sekolah_universitas }}
                                    </option>
                                @endforeach
                            </select>
                            <i class='absolute text-gray-400 transform -translate-y-1/2 right-3 top-1/2 bx bx-chevron-down'></i>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">Status</label>
                        <div class="relative">
                            <select name="status" onchange="this.form.submit()"
                                class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white pr-10 shadow-sm">
                                <option value="">Semua Status</option>
                                <option value="Dikirim" {{ request('status') == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="Revisi" {{ request('status') == 'Revisi' ? 'selected' : '' }}>Revisi</option>
                            </select>
                            <i class='absolute text-gray-400 transform -translate-y-1/2 right-3 top-1/2 bx bx-chevron-down'></i>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row lg:flex-col lg:items-stretch lg:justify-end">
                    <a href="{{ route('admin.laporan.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 transition-colors duration-200 whitespace-nowrap shadow-sm">
                        <i class='bx bx-reset'></i>
                        <span>Reset</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
<<<<<<< HEAD
        <div class="p-4 mb-4 border-l-4 rounded-lg shadow-sm bg-emerald-50 border-emerald-500 animate-fade-in">
            <div class="flex items-center gap-3 text-emerald-700">
                <i class='text-xl bx bx-check-circle'></i>
=======
        <div class="p-4 mb-4 border-l-4 rounded-lg bg-emerald-50 border-emerald-500 animate-fade-in shadow-sm">
            <div class="flex items-center gap-3 text-emerald-700">
                <i class='bx bx-check-circle text-xl'></i>
>>>>>>> main
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

<<<<<<< HEAD
    <div class="overflow-hidden card shadow-soft">
=======
    <!-- Table -->
    <div class="card overflow-hidden shadow-soft">
>>>>>>> main
        <div class="overflow-x-auto no-scrollbar">
            <table class="min-w-full text-sm text-left">
                <thead>
                    <tr class="text-gray-600 border-b bg-gray-50/50">
                        <th class="px-6 py-4 font-semibold uppercase tracking-wider text-[11px]">No</th>
                        <th class="px-6 py-4 font-semibold uppercase tracking-wider text-[11px]">Peserta</th>
                        <th class="px-6 py-4 font-semibold uppercase tracking-wider text-[11px]">Tanggal</th>
                        <th class="px-6 py-4 font-semibold uppercase tracking-wider text-[11px]">Laporan</th>
                        <th class="px-6 py-4 font-semibold uppercase tracking-wider text-[11px] text-center">Status</th>
                        <th class="px-6 py-4 font-semibold uppercase tracking-wider text-[11px] text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($laporans as $index => $laporan)
<<<<<<< HEAD
                        <tr class="transition-colors border-b hover:bg-gray-50/70 border-gray-50 last:border-0">
                            <td class="px-6 py-4 font-medium text-gray-500">
=======
                        <tr class="transition-colors hover:bg-gray-50/70 border-b border-gray-50 last:border-0">
                            <td class="px-6 py-4 text-gray-500 font-medium">
>>>>>>> main
                                {{ $index + $laporans->firstItem() }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
<<<<<<< HEAD
                                    <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 font-bold text-white rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-soft">
                                        {{ strtoupper(substr($laporan->peserta->nama, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold leading-tight text-gray-900">{{ $laporan->peserta->nama }}</div>
=======
                                    <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold shadow-soft">
                                        {{ strtoupper(substr($laporan->peserta->nama, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900 leading-tight">{{ $laporan->peserta->nama }}</div>
>>>>>>> main
                                        <div class="text-xs text-gray-500 mt-0.5 line-clamp-1 italic">{{ $laporan->peserta->asal_sekolah_universitas }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-800">{{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->translatedFormat('d F Y') }}</span>
                                    <span class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->diffForHumans() }}</span>
                                </div>
                            </td>
<<<<<<< HEAD
                            <td class="max-w-xs px-6 py-4">
                                <div class="text-sm font-medium text-gray-800 line-clamp-1">{{ $laporan->judul }}</div>
                                <div class="mt-1 text-xs text-gray-500 truncate">{{ Str::limit($laporan->deskripsi, 50) }}</div>
=======
                            <td class="px-6 py-4 max-w-xs">
                                <div class="text-sm font-medium text-gray-800 line-clamp-1">{{ $laporan->judul }}</div>
                                <div class="text-xs text-gray-500 mt-1 truncate">{{ Str::limit($laporan->deskripsi, 50) }}</div>
>>>>>>> main
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusClasses = [
                                        'Draft' => 'bg-gray-100 text-gray-600',
                                        'Dikirim' => 'bg-blue-100 text-blue-600 shadow-sm shadow-blue-100',
                                        'Disetujui' => 'bg-emerald-100 text-emerald-600 shadow-sm shadow-emerald-100',
                                        'Revisi' => 'bg-amber-100 text-amber-600 shadow-sm shadow-amber-100'
                                    ];
                                @endphp
                                <span class="px-3 py-1.5 rounded-lg text-xs font-bold {{ $statusClasses[$laporan->status] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ $laporan->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
<<<<<<< HEAD
                                    <button onclick="openDetailModal({{ json_encode($laporan->load('peserta')) }})"
                                        class="p-2 text-indigo-600 transition-all duration-200 hover:bg-indigo-50 rounded-xl" title="Lihat Detail">
                                        <i class='text-xl bx bx-show-alt'></i>
                                    </button>
                                    @if(in_array($laporan->status, ['Dikirim', 'Revisi']))
                                        <button type="button" onclick="confirmApprove('{{ route('admin.laporan.update-status', $laporan->id) }}')"
                                            class="p-2 transition-all duration-200 text-emerald-600 hover:bg-emerald-50 rounded-xl"
                                            title="Setujui">
                                            <i class='text-xl bx bx-check-circle'></i>
                                        </button>
                                        <button type="button" onclick="confirmRevise('{{ route('admin.laporan.update-status', $laporan->id) }}')"
                                            class="p-2 transition-all duration-200 text-amber-600 hover:bg-amber-50 rounded-xl"
                                            title="Revisi">
                                            <i class='text-xl bx bx-error-circle'></i>
                                        </button>
=======
                                    <button onclick="openDetailModal({{ json_encode($laporan->load('peserta')) }})" 
                                        class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all duration-200" title="Lihat Detail">
                                        <i class='bx bx-show-alt text-xl'></i>
                                    </button>
                                    @if(in_array($laporan->status, ['Dikirim', 'Revisi']))
                                        <form action="{{ route('admin.laporan.update-status', $laporan->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Disetujui">
                                            <button type="submit" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all duration-200" 
                                                title="Setujui" onclick="return confirm('Setujui laporan ini?')">
                                                <i class='bx bx-check-circle text-xl'></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.laporan.update-status', $laporan->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Revisi">
                                            <button type="submit" class="p-2 text-amber-600 hover:bg-amber-50 rounded-xl transition-all duration-200" 
                                                title="Revisi" onclick="return confirm('Minta revisi untuk laporan ini?')">
                                                <i class='bx bx-error-circle text-xl'></i>
                                            </button>
                                        </form>
>>>>>>> main
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center space-y-3">
<<<<<<< HEAD
                                    <div class="flex items-center justify-center w-16 h-16 border-4 border-white rounded-full bg-gray-50 shadow-soft">
                                        <i class='text-3xl text-gray-300 bx bx-clipboard'></i>
=======
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center border-4 border-white shadow-soft">
                                        <i class='bx bx-clipboard text-3xl text-gray-300'></i>
>>>>>>> main
                                    </div>
                                    <p class="font-medium">Tidak ada laporan ditemukan.</p>
                                    <p class="text-xs text-gray-400">Coba ubah filter atau rentang tanggal Anda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
<<<<<<< HEAD

        @if($laporans->hasPages())
            <div class="px-6 py-5 border-t border-gray-100 bg-gray-50/50">
=======
        
        @if($laporans->hasPages())
            <div class="px-6 py-5 bg-gray-50/50 border-t border-gray-100">
>>>>>>> main
                {{ $laporans->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</div>

<<<<<<< HEAD
<div id="detailModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" onclick="closeDetailModal()"></div>

        <div class="relative w-full max-w-2xl overflow-hidden transition-all transform bg-white shadow-2xl rounded-2xl animate-fade-in-up">
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 text-white bg-indigo-600 shadow-lg rounded-xl shadow-indigo-200">
                        <i class='text-xl bx bx-file'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Detail Laporan Harian</h3>
                        <p class="text-xs font-medium text-gray-500" id="modalStatusBadge"></p>
                    </div>
                </div>
                <button onclick="closeDetailModal()" class="flex items-center justify-center w-8 h-8 text-gray-400 transition-colors rounded-lg hover:bg-gray-100 hover:text-gray-600">
                    <i class='text-2xl bx bx-x'></i>
                </button>
            </div>

            <div class="px-8 space-y-6 py-7">
                <div class="flex items-center gap-4 p-4 border rounded-xl bg-slate-50 border-slate-100">
                    <div id="modalAvatar" class="flex items-center justify-center w-12 h-12 text-lg font-bold text-indigo-700 bg-indigo-100 rounded-xl shadow-soft"></div>
                    <div>
                        <p id="modalPeserta" class="text-base font-bold leading-tight text-gray-900"></p>
=======
<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" onclick="closeDetailModal()"></div>
        
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden transform transition-all animate-fade-in-up">
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-200">
                        <i class='bx bx-file text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Detail Laporan Harian</h3>
                        <p class="text-xs text-gray-500 font-medium" id="modalStatusBadge"></p>
                    </div>
                </div>
                <button onclick="closeDetailModal()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="px-8 py-7 space-y-6">
                <!-- User Info -->
                <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <div id="modalAvatar" class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-lg shadow-soft"></div>
                    <div>
                        <p id="modalPeserta" class="text-base font-bold text-gray-900 leading-tight"></p>
>>>>>>> main
                        <p id="modalSekolah" class="text-xs text-gray-500 font-medium mt-0.5"></p>
                    </div>
                    <div class="ml-auto text-right">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Tanggal Laporan</p>
<<<<<<< HEAD
                        <p id="modalTanggal" class="mt-1 text-sm font-bold text-indigo-600"></p>
                    </div>
                </div>

=======
                        <p id="modalTanggal" class="text-sm font-bold text-indigo-600 mt-1"></p>
                    </div>
                </div>

                <!-- Report Content -->
>>>>>>> main
                <div class="space-y-4">
                    <div>
                        <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">Judul Kegiatan</label>
                        <p id="modalJudul" class="text-base font-bold text-gray-900 mt-1.5 leading-relaxed"></p>
                    </div>
<<<<<<< HEAD

                    <div>
                        <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">Deskripsi Detail</label>
                        <div id="modalDeskripsi" class="p-5 mt-2 overflow-y-auto text-sm leading-relaxed text-gray-700 whitespace-pre-wrap bg-white border border-gray-100 shadow-inner rounded-xl max-h-60 no-scrollbar shadow-gray-50"></div>
                    </div>
                </div>

                <div id="modalFileContainer" class="hidden pt-2">
                    <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">Dokumen Lampiran</label>
                    <div class="mt-2">
                        <a id="modalFileLink" target="_blank"
                            class="inline-flex items-center gap-3 px-5 py-3 text-sm font-bold text-indigo-600 transition-all duration-300 bg-white border-2 shadow-sm border-indigo-50 rounded-xl hover:bg-indigo-50 hover:border-indigo-100 group">
                            <i class='text-xl transition-transform bx bxs-file-pdf group-hover:scale-110'></i>
=======
                    
                    <div>
                        <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">Deskripsi Detail</label>
                        <div id="modalDeskripsi" class="mt-2 p-5 bg-white border border-gray-100 rounded-xl text-sm text-gray-700 leading-relaxed whitespace-pre-wrap max-h-60 overflow-y-auto no-scrollbar shadow-inner shadow-gray-50"></div>
                    </div>
                </div>

                <!-- Attachment -->
                <div id="modalFileContainer" class="hidden pt-2">
                    <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">Dokumen Lampiran</label>
                    <div class="mt-2">
                        <a id="modalFileLink" target="_blank" 
                            class="inline-flex items-center gap-3 px-5 py-3 bg-white border-2 border-indigo-50 text-indigo-600 rounded-xl text-sm font-bold hover:bg-indigo-50 hover:border-indigo-100 transition-all duration-300 group shadow-sm">
                            <i class='bx bxs-file-pdf text-xl group-hover:scale-110 transition-transform'></i>
>>>>>>> main
                            <span>Buka Dokumen Laporan</span>
                        </a>
                    </div>
                </div>
            </div>

<<<<<<< HEAD
            <div class="flex flex-wrap items-center justify-between gap-4 px-8 py-5 border-t border-gray-100 bg-gray-50">
                <div id="modalActionButtons" class="flex gap-2">
=======
            <!-- Modal Footer -->
            <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4">
                <div id="modalActionButtons" class="flex gap-2">
                    <!-- Action buttons injected here -->
>>>>>>> main
                </div>
                <button onclick="closeDetailModal()" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-100 transition-all duration-200 shadow-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<<<<<<< HEAD
@vite('resources/js/admin/laporan.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
=======
<script>
    function openDetailModal(laporan) {
        document.getElementById('modalPeserta').innerText = laporan.peserta.nama;
        document.getElementById('modalSekolah').innerText = laporan.peserta.asal_sekolah_universitas;
        document.getElementById('modalTanggal').innerText = new Date(laporan.tanggal_laporan).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        document.getElementById('modalJudul').innerText = laporan.judul;
        document.getElementById('modalDeskripsi').innerText = laporan.deskripsi;
        document.getElementById('modalAvatar').innerText = laporan.peserta.nama.substring(0, 1).toUpperCase();
        
        const statusBadge = document.getElementById('modalStatusBadge');
        statusBadge.innerText = `Status: ${laporan.status}`;
        
        const fileContainer = document.getElementById('modalFileContainer');
        if (laporan.file_path) {
            fileContainer.classList.remove('hidden');
            document.getElementById('modalFileLink').href = `/storage/${laporan.file_path}`;
        } else {
            fileContainer.classList.add('hidden');
        }

        const actionButtons = document.getElementById('modalActionButtons');
        actionButtons.innerHTML = '';
        
        if (laporan.status === 'Dikirim' || laporan.status === 'Revisi') {
            const approveForm = `
                <form action="/admin/laporan/${laporan.id}/status" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Disetujui">
                    <button type="submit" class="bg-emerald-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-emerald-700 transition shadow-lg shadow-emerald-200 border border-emerald-500">Setujui Laporan</button>
                </form>
            `;
            const reviseForm = `
                <form action="/admin/laporan/${laporan.id}/status" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Revisi">
                    <button type="submit" class="bg-amber-100 text-amber-700 px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-200 transition border border-amber-200">Minta Revisi</button>
                </form>
            `;
            actionButtons.innerHTML = reviseForm + approveForm;
        }

        document.getElementById('detailModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
>>>>>>> main
@endsection
