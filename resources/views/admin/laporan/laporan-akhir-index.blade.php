@extends('layouts.app')

@section('title', 'Daftar Laporan Akhir')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col justify-between gap-4 p-6 md:flex-row md:items-center card shadow-soft animate-fade-in">
            <div class="flex items-center space-x-4">
                <div class="flex items-center justify-center w-12 h-12 text-2xl text-purple-600 shadow-inner rounded-xl bg-purple-50">
                    <i class='bx bx-file'></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Review Laporan Akhir</h1>
                    <p class="text-sm font-medium text-slate-500">Kelola dan verifikasi laporan akhir dari para peserta.</p>
                </div>
            </div>
        </div>

        <div class="mb-6 card">
            <div class="p-4 md:p-5">
                <form action="{{ route('admin.laporan.akhir.index') }}" method="GET" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="space-y-1">
                        <label class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">Asal Sekolah</label>
                        <select name="asal_sekolah_universitas" onchange="this.form.submit()"
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 appearance-none bg-white">
                            <option value="">Semua Sekolah</option>
                            @foreach ($sekolahs as $sh)
                                <option value="{{ $sh->asal_sekolah_universitas }}" {{ request('asal_sekolah_universitas') == $sh->asal_sekolah_universitas ? 'selected' : '' }}>
                                    {{ $sh->asal_sekolah_universitas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">Status</label>
                        <select name="status" onchange="this.form.submit()"
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 appearance-none bg-white">
                            <option value="">Semua Status</option>
                            <option value="Dikirim" {{ request('status') == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Revisi" {{ request('status') == 'Revisi' ? 'selected' : '' }}>Revisi</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <a href="{{ route('admin.laporan.akhir.index') }}" class="px-6 py-2.5 text-sm font-bold text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 transition-all shadow-sm">
                            Reset Filter
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="p-4 mb-4 border-l-4 rounded-lg shadow-sm bg-emerald-50 border-emerald-500 animate-fade-in">
                <div class="flex items-center gap-3 text-emerald-700">
                    <i class='text-xl bx bx-check-circle'></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="overflow-hidden card shadow-soft">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="text-gray-600 border-b bg-gray-50/50">
                            <th class="px-6 py-4 font-semibold uppercase tracking-wider text-[11px]">No</th>
                            <th class="px-6 py-4 font-semibold uppercase tracking-wider text-[11px]">Nama Peserta</th>
                            <th class="px-6 py-4 font-semibold uppercase tracking-wider text-[11px]">Judul Laporan</th>
                            <th class="px-6 py-4 font-semibold uppercase tracking-wider text-[11px] text-center">Status</th>
                            <th class="px-6 py-4 font-semibold uppercase tracking-wider text-[11px] text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($laporans as $index => $laporan)
                            <tr class="transition-colors hover:bg-slate-50">
                                <td class="px-6 py-4 text-slate-500">{{ $index + $laporans->firstItem() }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900">{{ $laporan->peserta->nama }}</div>
                                    <div class="text-[11px] text-slate-500">{{ $laporan->peserta->asal_sekolah_universitas }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-slate-800 font-medium">{{ $laporan->judul }}</div>
                                    <div class="text-[11px] text-slate-400 capitalize">{{ $laporan->updated_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $colors = [
                                            'Draft' => 'bg-gray-100 text-gray-700',
                                            'Dikirim' => 'bg-blue-100 text-blue-700',
                                            'Disetujui' => 'bg-green-100 text-green-700',
                                            'Revisi' => 'bg-yellow-100 text-yellow-700',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-bold rounded-full {{ $colors[$laporan->status] }}">
                                        {{ $laporan->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.laporan.akhir.show', $laporan->id) }}" class="inline-flex items-center justify-center p-2 text-purple-600 transition-all rounded-lg hover:bg-purple-50">
                                        <i class='text-xl bx bx-show'></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                    Belum ada laporan akhir yang diajukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($laporans->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/30">
                    {{ $laporans->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
