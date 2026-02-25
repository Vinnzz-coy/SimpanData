@extends('layouts.app')

@section('title', 'Laporan Harian')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col justify-between gap-4 p-6 md:flex-row md:items-center card shadow-soft animate-fade-in">
            <div class="flex items-center space-x-4">
                <div
                    class="flex items-center justify-center w-12 h-12 text-2xl text-purple-600 shadow-inner rounded-xl bg-purple-50">
                    <i class='bx bx-file-blank'></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Laporan Harian</h1>
                    <p class="text-sm font-medium text-slate-500">Laporkan kegiatan yang Anda lakukan hari ini,
                        {{ date('l, j F Y') }}</p>
                </div>
            </div>

            <div class="px-4 py-2 border rounded-xl animate-fade-in {{ isset($todayReport) ? 'border-green-100 bg-green-50' : 'border-orange-100 bg-orange-50' }}"
                style="animation-delay: 200ms">
                <p
                    class="text-xs font-bold tracking-tighter uppercase {{ isset($todayReport) ? 'text-green-600' : 'text-orange-600' }}">
                    Status Laporan</p>
                <p class="text-sm font-extrabold {{ isset($todayReport) ? 'text-green-900' : 'text-orange-900' }}">
                    @if (isset($todayReport))
                        {{ $todayReport->status }}
                    @else
                        Belum Lapor
                    @endif
                </p>
            </div>
        </div>

        @if (session('success'))
            <div class="p-4 mb-6 text-green-700 bg-green-100 border-l-4 border-green-500 rounded-r-lg shadow-sm animate-fade-in"
                role="alert">
                <div class="flex items-center">
                    <i class='mr-2 text-xl bx bx-check-circle'></i>
                    <p class="font-bold">Berhasil!</p>
                </div>
                <p class="mt-1 text-sm">{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-6 text-red-700 bg-red-100 border-l-4 border-red-500 rounded-r-lg shadow-sm animate-fade-in"
                role="alert">
                <div class="flex items-center">
                    <i class='mr-2 text-xl bx bx-error-circle'></i>
                    <p class="font-bold">Terdapat Kesalahan!</p>
                </div>
                <ul class="pl-5 mt-1 text-sm list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (auth()->user()->peserta && auth()->user()->peserta->laporans->where('status', 'Revisi')->count() > 0)
            @foreach (auth()->user()->peserta->laporans->where('status', 'Revisi') as $rev)
                @if (\Carbon\Carbon::parse($rev->tanggal_laporan)->isToday())
                    <div
                        class="flex items-center justify-between p-4 mb-6 border-l-4 rounded-r-lg shadow-sm text-amber-800 bg-amber-50 border-amber-500 animate-fade-in">
                        <div class="flex items-center gap-3">
                            <i class='text-2xl bx bx-revision'></i>
                            <div>
                                <p class="font-bold">Laporan Hari Ini Perlu Revisi!</p>
                                <p class="text-sm">Silakan periksa catatan revisi dan perbaiki laporan Anda.</p>
                            </div>
                        </div>
                        <a href="{{ route('peserta.laporan.edit', $rev->id) }}"
                            class="px-4 py-2 text-xs font-bold transition rounded-lg bg-amber-100 text-amber-800 hover:bg-amber-200 whitespace-nowrap">
                            Edit Laporan
                        </a>
                    </div>
                @endif
            @endforeach
        @endif

        @if(isset($todayReport) && in_array($todayReport->status, ['Dikirim', 'Disetujui']))
            <div class="p-8 text-center border-2 border-dashed rounded-xl border-slate-200 bg-slate-50 animate-fade-in-up">
                <div class="flex flex-col items-center justify-center gap-4">
                    <div class="flex items-center justify-center w-20 h-20 mb-2 rounded-full {{ $todayReport->status == 'Disetujui' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' }}">
                        <i class='text-4xl bx {{ $todayReport->status == 'Disetujui' ? 'bx-check-circle' : 'bx-time-five' }}'></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">
                            {{ $todayReport->status == 'Disetujui' ? 'Laporan Hari Ini Disetujui' : 'Laporan Hari Ini Sudah Dikirim' }}
                        </h3>
                        <p class="mt-2 text-slate-500">
                            {{ $todayReport->status == 'Disetujui' ? 'Laporan Anda telah disetujui oleh pembimbing.' : 'Terima kasih telah mengirimkan laporan. Menunggu review dari pembimbing.' }}
                        </p>
                    </div>
                    <a href="{{ route('peserta.laporan.show', $todayReport->id) }}"
                        class="px-6 py-3 mt-4 text-sm font-bold text-white transition-all duration-200 rounded-lg shadow-lg {{ $todayReport->status == 'Disetujui' ? 'bg-green-600 hover:bg-green-700 focus:ring-green-500' : 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500' }} focus:outline-none focus:ring-2 focus:ring-offset-2">
                        <div class="flex items-center gap-2">
                            <i class='text-lg bx bx-show'></i>
                            <span>Lihat Laporan Saya</span>
                        </div>
                    </a>
                </div>
            </div>
        @else
        <form
            action="{{ isset($todayReport) ? route('peserta.laporan.update', $todayReport->id) : route('peserta.laporan.store') }}"
            method="POST" enctype="multipart/form-data" id="report-form">
            @csrf
            @if (isset($todayReport))
                @method('PUT')
            @endif
            <input type="hidden" name="status" id="status-field" value="Dikirim">
            <input type="hidden" name="tanggal_laporan" value="{{ date('Y-m-d') }}">

            <div class="p-6 card shadow-soft md:p-8 animate-fade-in-up" style="animation-delay: 100ms">
                <div class="flex items-center gap-3 pb-5 mb-8 border-b border-slate-100">
                    <div class="flex items-center justify-center w-10 h-10 text-xl text-purple-600 rounded-lg bg-purple-50">
                        <i class='bx bx-edit'></i>
                    </div>
                    <h4 class="text-lg font-bold uppercase text-slate-800">Form Laporan Harian</h4>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="judul" class="block mb-3 text-xs font-bold tracking-widest uppercase text-slate-500">
                            Judul Laporan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="judul" name="judul"
                            value="{{ old('judul', $todayReport->judul ?? '') }}"
                            class="w-full px-4 py-3 transition-colors border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 {{ $errors->has('judul') ? 'border-red-500' : 'border-gray-300' }}"
                            placeholder="Contoh: Membuat Fitur Login Sistem" required>
                        @error('judul')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="deskripsi"
                            class="block mb-3 text-xs font-bold tracking-widest uppercase text-slate-500">
                            Deskripsi Kegiatan <span class="text-red-500">*</span>
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="8"
                            class="w-full px-4 py-3 transition-colors border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 {{ $errors->has('deskripsi') ? 'border-red-500' : 'border-gray-300' }}"
                            placeholder="Jelaskan secara detail kegiatan yang Anda lakukan hari ini...&#10;&#10;Contoh:&#10;- Menganalisis kebutuhan fitur login&#10;- Membuat database migration untuk tabel users&#10;- Implementasi controller dan view login&#10;- Testing fitur login"
                            required>{{ old('deskripsi', $todayReport->deskripsi ?? '') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="file" class="block mb-3 text-xs font-bold tracking-widest uppercase text-slate-500">
                            Lampiran File (Opsional)
                        </label>
                        <div class="relative">
                            <input type="file" id="file" name="file"
                                accept="application/pdf"
                                class="w-full px-4 py-3 transition-colors border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 {{ $errors->has('file') ? 'border-red-500' : 'border-gray-300' }}">
                            @error('file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @if (isset($todayReport) && $todayReport->file_path)
                            <div class="flex items-center gap-2 p-3 mt-3 border rounded-lg bg-slate-50 border-slate-200">
                                <i class='text-lg bx bx-file text-slate-600'></i>
                                <a href="{{ Storage::url($todayReport->file_path) }}" target="_blank"
                                    class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline">
                                    File saat ini: {{ basename($todayReport->file_path) }}
                                </a>
                            </div>
                        @endif
                        <p class="mt-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Format: PDF | Maksimal 5MB</p>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                        @if (isset($todayReport))
                            <a href="{{ route('peserta.laporan.index') }}"
                                class="px-6 py-3 text-sm font-bold transition-all duration-200 border-2 rounded-xl text-slate-700 border-slate-300 hover:bg-slate-50 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
                                <div class="flex items-center gap-2">
                                    <i class='text-base bx bx-x'></i>
                                    <span>Batal</span>
                                </div>
                            </a>
                        @endif
                        <button type="submit" name="status" value="Dikirim"
                            class="px-8 py-3 text-sm font-extrabold text-white transition-all duration-200 bg-purple-600 rounded-xl hover:bg-purple-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                            <div class="flex items-center gap-2">
                                <i class='text-lg bx bx-send'></i>
                                <span>{{ isset($todayReport) ? 'Update & Kirim' : 'Kirim Laporan' }}</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        @endif

        @if (isset($recentReports) && $recentReports->count() > 0)
            <div class="p-6 card shadow-soft md:p-8 animate-fade-in-up" style="animation-delay: 200ms">
                <div class="flex items-center gap-3 pb-5 mb-6 border-b border-slate-100">
                    <div class="flex items-center justify-center w-10 h-10 text-xl text-blue-600 rounded-lg bg-blue-50">
                        <i class='bx bx-history'></i>
                    </div>
                    <h4 class="text-lg font-bold uppercase text-slate-800">Riwayat Laporan</h4>
                </div>

                <div class="space-y-4">
                    @foreach ($recentReports as $report)
                        <div
                            class="p-4 transition-all duration-200 border-2 border-gray-200 rounded-xl hover:border-purple-300 hover:shadow-md">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-base font-bold text-slate-900">{{ $report->judul }}</h3>
                                        <span
                                            class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full
                                        {{ $report->status == 'Disetujui' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $report->status == 'Dikirim' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $report->status == 'Draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                        {{ $report->status == 'Revisi' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                            {{ $report->status }}
                                        </span>
                                    </div>
                                    <p class="mb-2 text-sm text-slate-600 line-clamp-2">
                                        {{ Str::limit($report->deskripsi, 150) }}</p>
                                    <div class="flex items-center gap-4 text-xs font-medium text-slate-500">
                                        <span class="flex items-center gap-1">
                                            <i class='bx bx-calendar'></i>
                                            {{ \Carbon\Carbon::parse($report->tanggal_laporan)->format('d M Y') }}
                                        </span>
                                        @if ($report->file_path)
                                            <span class="flex items-center gap-1">
                                                <i class='bx bx-paperclip'></i>
                                                Ada lampiran
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 ml-4 sm:flex-row">
                                    <a href="{{ route('peserta.laporan.show', $report->id) }}"
                                        class="flex items-center justify-center gap-2 px-4 py-2 text-xs font-bold text-blue-600 transition-all rounded-lg bg-blue-50 hover:bg-blue-100"
                                        title="Lihat Detail">
                                        <i class='text-lg bx bx-show'></i>
                                        <span>Detail</span>
                                    </a>
                                    @if ($report->status == 'Draft' || $report->status == 'Revisi')
                                        <a href="{{ route('peserta.laporan.edit', $report->id) }}"
                                            class="flex items-center justify-center gap-2 px-4 py-2 text-xs font-bold text-purple-600 transition-all rounded-lg bg-purple-50 hover:bg-purple-100"
                                            title="Edit">
                                            <i class='text-lg bx bx-edit'></i>
                                            <span>Edit</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $recentReports->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@vite('resources/js/peserta/laporan.js')
@endsection
