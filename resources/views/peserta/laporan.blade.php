@extends('layouts.app')

@section('title', 'Laporan Harian')

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

    @if(isset($todayReport) && $todayReport->status == 'Revisi')
        <div class="flex items-center justify-between p-4 border-l-4 border-amber-500 rounded-lg shadow-sm bg-amber-50 animate-fade-in">
            <div class="flex items-center space-x-3">
                <i class='text-xl text-amber-500 bx bxs-info-circle'></i>
                <div>
                    <p class="text-base font-bold text-amber-900">Perhatian: Revisi Diperlukan (Hari Ini)</p>
                    <p class="text-sm text-amber-700">Admin meminta Anda untuk memperbaiki laporan harian ini. Silakan perbarui konten form di bawah lalu kirim kembali.</p>
                </div>
            </div>
        </div>
    @endif

    @if(isset($pendingRevisions))
        @foreach($pendingRevisions as $rev)
            @if($rev->tanggal_laporan != date('Y-m-d'))
                <div class="flex items-center justify-between p-4 border-l-4 border-amber-500 rounded-lg shadow-sm bg-amber-50 animate-fade-in">
                    <div class="flex items-center space-x-3">
                        <i class='text-xl text-amber-500 bx bxs-time-five'></i>
                        <div>
                            <p class="text-base font-bold text-amber-900">Revisi Belum Selesai ({{ \Carbon\Carbon::parse($rev->tanggal_laporan)->translatedFormat('d F Y') }})</p>
                            <p class="text-sm text-amber-700">Laporan Anda pada tanggal ini perlu diperbaiki.</p>
                        </div>
                    </div>
                    <a href="{{ route('laporan.edit', $rev->id) }}" class="px-4 py-2 bg-amber-100 text-amber-800 rounded-lg text-xs font-bold hover:bg-amber-200 transition whitespace-nowrap">
                        Edit Laporan
                    </a>
                </div>
            @endif
        @endforeach
    @endif

    <div class="p-6 card shadow-soft">
        <div class="flex items-start">
            <div class="flex items-center justify-center w-12 h-12 mr-4 text-2xl text-purple-600 rounded-lg bg-purple-50">
                <i class='bx bx-file-blank'></i>
            </div>
            <div>
                <h3 class="text-xl font-bold tracking-tight text-slate-900">Halo, {{ $peserta->nama ?? 'Peserta' }}!</h3>
                <p class="mt-1 text-sm font-medium text-slate-600">Laporkan kegiatan yang Anda lakukan hari ini, {{ date('l, j F Y') }}.</p>
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
            <h4 class="mb-5 text-sm font-bold tracking-widest uppercase text-slate-500">Status Laporan Hari Ini</h4>
            <div class="flex items-center justify-between">
                <div>
                    @if(isset($todayReport))
                        <p class="text-lg font-bold text-green-800">Sudah Dilaporkan</p>
                        <p class="mt-1 text-sm text-slate-500">Status: <span class="font-semibold">{{ $todayReport->status }}</span></p>
                    @else
                        <p class="text-lg font-bold text-orange-800">Belum Dilaporkan</p>
                        <p class="mt-1 text-sm text-slate-500">Segera buat laporan harian Anda</p>
                    @endif
                </div>
                <div class="flex items-center justify-center w-16 h-16 text-3xl rounded-lg text-slate-400 bg-slate-50">
                    <i class='bx bx-clipboard'></i>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ isset($todayReport) ? route('laporan.update', $todayReport->id) : route('laporan.store') }}" method="POST" enctype="multipart/form-data" id="report-form">
        @csrf
        @if(isset($todayReport))
            @method('PUT')
        @endif
        <input type="hidden" name="tanggal_laporan" value="{{ date('Y-m-d') }}">

        <div class="p-6 card shadow-soft md:p-8">
            <h2 class="mb-6 text-xl font-bold tracking-tight uppercase text-slate-800">Form Laporan Harian</h2>

            <div class="space-y-6">
                <div>
                    <label for="judul" class="block mb-3 text-sm font-bold tracking-widest uppercase text-slate-700">
                        Judul Laporan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="judul" 
                           name="judul" 
                           value="{{ old('judul', $todayReport->judul ?? '') }}"
                           class="w-full px-4 py-3 transition-colors border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('judul') border-red-500 @enderror"
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
                              class="w-full px-4 py-3 transition-colors border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('deskripsi') border-red-500 @enderror"
                              placeholder="Jelaskan secara detail kegiatan yang Anda lakukan hari ini...&#10;&#10;Contoh:&#10;- Menganalisis kebutuhan fitur login&#10;- Membuat database migration untuk tabel users&#10;- Implementasi controller dan view login&#10;- Testing fitur login"
                              required>{{ old('deskripsi', $todayReport->deskripsi ?? '') }}</textarea>
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
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip"
                               class="w-full px-4 py-3 transition-colors border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 @error('file') border-red-500 @enderror">
                        @error('file')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @if(isset($todayReport) && $todayReport->file_path)
                        <div class="flex items-center gap-2 p-3 mt-3 border rounded-lg bg-slate-50 border-slate-200">
                            <i class='text-lg bx bx-file text-slate-600'></i>
                            <a href="{{ Storage::url($todayReport->file_path) }}" 
                               target="_blank" 
                               class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline">
                                File saat ini: {{ basename($todayReport->file_path) }}
                            </a>
                        </div>
                    @endif
                    <p class="mt-2 text-xs font-medium text-slate-500">Format yang didukung: PDF, DOC, DOCX, JPG, PNG, ZIP (Maks. 5MB)</p>
                </div>

                <div>
                    <label class="block mb-3 text-sm font-bold tracking-widest uppercase text-slate-700">Status Laporan</label>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <label class="relative flex items-center p-5 transition-all duration-200 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-purple-300 hover:bg-purple-50/30 group">
                            <input type="radio" 
                                   name="status" 
                                   value="Draft" 
                                   class="w-5 h-5 text-purple-600 focus:ring-purple-500"
                                   {{ old('status', $todayReport->status ?? 'Draft') == 'Draft' ? 'checked' : '' }}>
                            <div class="ml-4">
                                <span class="text-base font-bold text-slate-800">Draft</span>
                                <p class="text-sm text-slate-500">Simpan sebagai draft</p>
                            </div>
                            <i class='absolute text-2xl transition-opacity opacity-0 bx bx-check-circle text-purple-600 right-4 group-has-[:checked]:opacity-100'></i>
                        </label>

                        <label class="relative flex items-center p-5 transition-all duration-200 border-2 border-green-200 rounded-xl cursor-pointer hover:border-green-400 hover:bg-green-50/50 group">
                            <input type="radio" 
                                   name="status" 
                                   value="Dikirim" 
                                   class="w-5 h-5 text-green-600 focus:ring-green-500"
                                   {{ in_array(old('status', $todayReport->status ?? ''), ['Dikirim', 'Revisi']) ? 'checked' : '' }}>
                            <div class="ml-4">
                                <span class="text-base font-bold text-slate-800">Kirim</span>
                                <p class="text-sm text-slate-500">Kirim untuk review</p>
                            </div>
                            <i class='absolute text-2xl transition-opacity opacity-0 bx bx-check-circle text-green-600 right-4 group-has-[:checked]:opacity-100'></i>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    @if(isset($todayReport))
                        <a href="{{ route('laporan.index') }}" 
                           class="px-6 py-3 text-sm font-bold transition-all duration-200 border-2 rounded-lg text-slate-700 border-slate-300 hover:bg-slate-50 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
                            <div class="flex items-center gap-2">
                                <i class='text-base bx bx-x'></i>
                                <span>Batal</span>
                            </div>
                        </a>
                    @endif
                    <button type="submit"
                            class="px-6 py-3 text-sm font-bold text-white transition-all duration-200 bg-purple-600 rounded-lg hover:bg-purple-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        <div class="flex items-center gap-2">
                            <i class='text-base bx bx-save'></i>
                            <span>{{ isset($todayReport) ? 'Update Laporan' : 'Simpan Laporan' }}</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </form>

    @if(isset($recentReports) && $recentReports->count() > 0)
        <div class="p-6 card shadow-soft md:p-8">
            <h2 class="mb-6 text-xl font-bold tracking-tight uppercase text-slate-800">Riwayat Laporan</h2>
            
            <div class="space-y-4">
                @foreach($recentReports as $report)
                    <div class="p-4 transition-all duration-200 border-2 border-gray-200 rounded-xl hover:border-purple-300 hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-base font-bold text-slate-900">{{ $report->judul }}</h3>
                                    <span class="px-3 py-1 text-xs font-bold rounded-full
                                        {{ $report->status == 'Disetujui' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $report->status == 'Dikirim' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $report->status == 'Draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                        {{ $report->status == 'Revisi' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                        {{ $report->status }}
                                    </span>
                                </div>
                                <p class="mb-2 text-sm text-slate-600 line-clamp-2">{{ Str::limit($report->deskripsi, 150) }}</p>
                                <div class="flex items-center gap-4 text-xs text-slate-500">
                                    <span class="flex items-center gap-1">
                                        <i class='bx bx-calendar'></i>
                                        {{ \Carbon\Carbon::parse($report->tanggal_laporan)->format('d M Y') }}
                                    </span>
                                    @if($report->file_path)
                                        <span class="flex items-center gap-1">
                                            <i class='bx bx-paperclip'></i>
                                            Ada lampiran
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex gap-2 ml-4">
                                <a href="{{ route('laporan.show', $report->id) }}" 
                                   class="flex items-center justify-center w-8 h-8 text-blue-600 transition-colors rounded-lg hover:bg-blue-50"
                                   title="Lihat Detail">
                                    <i class='text-lg bx bx-show'></i>
                                </a>
                                @if($report->status == 'Draft' || $report->status == 'Revisi')
                                    <a href="{{ route('laporan.edit', $report->id) }}" 
                                       class="flex items-center justify-center w-8 h-8 text-purple-600 transition-colors rounded-lg hover:bg-purple-50"
                                       title="Edit">
                                        <i class='text-lg bx bx-edit'></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if(isset($hasMoreReports) && $hasMoreReports)
                <div class="mt-6 text-center">
                    <a href="{{ route('laporan.index') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold transition-all duration-200 border-2 rounded-lg text-purple-700 border-purple-300 hover:bg-purple-50 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        <i class='text-base bx bx-list-ul'></i>
                        <span>Lihat Semua Laporan</span>
                    </a>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection

@section('scripts')
    <script>
        // Update current time
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            });
            document.getElementById('current-time').textContent = timeString;
        }

        // Update time every second
        setInterval(updateTime, 1000);
        updateTime();

        // Form validation
        const form = document.getElementById('report-form');
        form.addEventListener('submit', function(e) {
            const judul = document.getElementById('judul').value.trim();
            const deskripsi = document.getElementById('deskripsi').value.trim();

            if (!judul || !deskripsi) {
                e.preventDefault();
                alert('Judul dan Deskripsi harus diisi!');
                return false;
            }

            // Prevent double submission
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<div class="flex items-center gap-2"><i class="bx bx-loader-alt animate-spin"></i><span>Menyimpan...</span></div>';
        });

        // File input validation
        const fileInput = document.getElementById('file');
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar! Maksimal 5MB.');
                    e.target.value = '';
                }
            }
        });
    </script>
@endsection
