@extends('layouts.app')

@section('title', 'Detail Peserta')

@section('content')
<div class="p-4 md:p-6">
    <div class="mb-4 md:mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('admin.peserta.index') }}"
                class="p-2 text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100">
                <i class='text-xl bx bx-arrow-back'></i>
            </a>
            <div class="flex items-center justify-between flex-1">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Detail Peserta</h1>
                    <p class="mt-1 text-gray-600">{{ $peserta->nama }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.peserta.edit', $peserta->id) }}"
                        class="px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        <i class='mr-2 bx bx-edit'></i>Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:gap-6 lg:grid-cols-3">
        <div class="space-y-4 lg:col-span-2 md:space-y-6">
            <div class="card">
                <div class="p-4 md:p-6">
                <div class="flex items-start gap-6">
                    @if($peserta->foto)
                    <img src="{{ asset('storage/'.$peserta->foto) }}"
                        alt="{{ $peserta->nama }}"
                        class="object-cover w-24 h-24 border-2 border-gray-200 rounded-lg">
                    @else
                    <div class="flex items-center justify-center w-24 h-24 text-3xl font-bold text-white rounded-lg bg-gradient-to-br from-indigo-500 to-purple-500">
                        {{ strtoupper(substr($peserta->nama, 0, 1)) }}
                    </div>
                    @endif
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $peserta->nama }}</h2>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <span class="px-3 py-1 text-sm font-medium rounded-full {{ $peserta->jenis_kegiatan == 'PKL' ? 'bg-indigo-100 text-indigo-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $peserta->jenis_kegiatan }}
                            </span>
                            <span class="px-3 py-1 text-sm font-medium rounded-full {{ $peserta->status == 'Aktif' ? 'bg-emerald-100 text-emerald-800' : ($peserta->status == 'Selesai' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $peserta->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h3 class="mb-4 text-lg font-semibold text-gray-800">Informasi Peserta</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <p class="text-sm text-gray-500">Asal Sekolah/Universitas</p>
                        <p class="mt-1 font-medium text-gray-800">{{ $peserta->asal_sekolah_universitas }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jurusan</p>
                        <p class="mt-1 font-medium text-gray-800">{{ $peserta->jurusan }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">No. Telepon</p>
                        <p class="mt-1 font-medium text-gray-800">{{ $peserta->no_telepon ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="mt-1 font-medium text-gray-800">{{ $peserta->user->email }}</p>
                    </div>
                    @if($peserta->alamat)
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">Alamat</p>
                        <p class="mt-1 font-medium text-gray-800">{{ $peserta->alamat }}</p>
                    </div>
                    @endif
                </div>
                </div>
            </div>

            <div class="card">
                <div class="p-4 md:p-6">
                <h3 class="mb-4 text-lg font-semibold text-gray-800">Data Kegiatan</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Mulai</p>
                        <p class="mt-1 font-medium text-gray-800">{{ $peserta->tanggal_mulai->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Selesai</p>
                        <p class="mt-1 font-medium text-gray-800">{{ $peserta->tanggal_selesai->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Durasi</p>
                        <p class="mt-1 font-medium text-gray-800">{{ $peserta->tanggal_mulai->diffInDays($peserta->tanggal_selesai) }} hari</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h3 class="mb-4 text-lg font-semibold text-gray-800">Statistik</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Total Absensi</p>
                        <p class="mt-1 text-2xl font-bold text-indigo-600">{{ $peserta->absensis->count() }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Laporan</p>
                        <p class="mt-1 text-2xl font-bold text-purple-600">{{ $peserta->laporans->count() }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Feedback</p>
                        <p class="mt-1 text-2xl font-bold text-green-600">{{ $peserta->feedbacks->count() }}</p>
                    </div>
                </div>
                </div>
            </div>

            <div class="card">
                <div class="p-4 md:p-6">
                <h3 class="mb-4 text-lg font-semibold text-gray-800">Akun</h3>
                <div class="space-y-2">
                    <div>
                        <p class="text-sm text-gray-500">Username</p>
                        <p class="mt-1 font-medium text-gray-800">{{ $peserta->user->username }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Dibuat</p>
                        <p class="mt-1 font-medium text-gray-800">{{ $peserta->created_at->format('d F Y') }}</p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
