@extends('layouts.app')

@section('title', 'Edit Laporan')

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

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit Laporan</h1>
            <p class="mt-1 text-sm text-slate-600">Perbaiki laporan harian Anda sesuai catatan admin</p>
        </div>
        <a href="{{ route('peserta.laporan.index') }}"
            class="px-4 py-2 text-sm font-bold transition-all duration-200 border-2 rounded-lg text-slate-700 border-slate-300 hover:bg-slate-50 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
            <div class="flex items-center gap-2">
                <i class='text-base bx bx-arrow-back'></i>
                <span>Kembali</span>
            </div>
        </a>
    </div>

        <form action="{{ route('peserta.laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data" id="report-form">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" id="status-field" value="Dikirim">

        <div class="p-6 card shadow-soft md:p-8">
            <h2 class="mb-6 text-xl font-bold tracking-tight uppercase text-slate-800">Form Edit Laporan</h2>

            <div class="space-y-6">
                <div>
                    <label for="judul" class="block mb-3 text-sm font-bold tracking-widest uppercase text-slate-700">
                        Judul Laporan <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                            id="judul"
                            name="judul"
                            value="{{ old('judul', $laporan->judul) }}"
                            class="w-full px-4 py-3 transition-colors border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 {{ $errors->has('judul') ? 'border-red-500' : 'border-gray-300' }}"
                            placeholder="Contoh: Membuat Fitur Login Sistem"
                            required>
                    @error('judul')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs font-medium text-slate-500">Berikan judul yang jelas dan deskriptif untuk laporan Anda.</p>
                </div>

                <div>
                    <label for="deskripsi" class="block mb-3 text-sm font-bold tracking-widest uppercase text-slate-700">
                        Deskripsi Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="deskripsi"
                                name="deskripsi"
                                rows="8"
                                class="w-full px-4 py-3 transition-colors border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 {{ $errors->has('deskripsi') ? 'border-red-500' : 'border-gray-300' }}"
                                placeholder="Jelaskan secara detail kegiatan yang Anda lakukan hari ini..."
                                required>{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs font-medium text-slate-500">Jelaskan kegiatan yang Anda lakukan secara detail dan terstruktur.</p>
                </div>

                <div>
                    <label for="file" class="block mb-3 text-sm font-bold tracking-widest uppercase text-slate-700">
                        Lampiran File (Opsional)
                    </label>
                    <div class="relative">
                        <input type="file"
                                id="file"
                                name="file"
                                accept="application/pdf"
                                class="w-full px-4 py-3 transition-colors border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 {{ $errors->has('file') ? 'border-red-500' : 'border-gray-300' }}">
                        @error('file')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @if($laporan->file_path)
                        <div class="flex items-center gap-2 p-3 mt-3 border rounded-lg bg-slate-50 border-slate-200">
                            <i class='text-lg bx bx-file text-slate-600'></i>
                            <a href="{{ Storage::url($laporan->file_path) }}"
                                target="_blank"
                                class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline">
                                File saat ini: {{ basename($laporan->file_path) }}
                            </a>
                        </div>
                    @endif
                    <p class="mt-2 text-xs font-medium text-slate-500">Format: PDF | Maksimal 5MB. Upload file baru untuk mengganti file lama.</p>
                </div>



                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('peserta.laporan.show', $laporan->id) }}"
                        class="px-6 py-3 text-sm font-bold transition-all duration-200 border-2 rounded-lg text-slate-700 border-slate-300 hover:bg-slate-50 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
                        <div class="flex items-center gap-2">
                            <i class='text-base bx bx-x'></i>
                            <span>Batal</span>
                        </div>
                    </a>
                    <button type="submit" name="status" value="Dikirim"
                        class="px-8 py-3 text-sm font-extrabold text-white transition-all duration-200 bg-purple-600 rounded-xl hover:bg-purple-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        <div class="flex items-center gap-2">
                            <i class='text-lg bx bx-send'></i>
                            <span>Update & Kirim</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@vite('resources/js/peserta/laporan.js')
@endsection
