<div class="space-y-6">
    {{-- Header Section --}}
    <div class="p-5 border border-gray-200 rounded-lg bg-gradient-to-br from-gray-50 to-white">
        <div class="flex items-center gap-4 mb-4">
            @if($peserta->foto)
            <div class="relative flex-shrink-0">
                <img src="{{ asset('storage/'.$peserta->foto) }}"
                    alt="{{ $peserta->nama }}"
                    class="object-cover w-20 h-20 border-4 border-white rounded-full shadow-lg">
                <div class="absolute bottom-0 right-0 flex items-center justify-center w-6 h-6 border-2 border-white rounded-full {{ $peserta->status == 'Aktif' ? 'bg-emerald-500' : ($peserta->status == 'Selesai' ? 'bg-amber-500' : 'bg-gray-400') }}">
                    @if($peserta->status == 'Aktif')
                        <i class='text-xs text-white bx bx-check'></i>
                    @elseif($peserta->status == 'Selesai')
                        <i class='text-xs text-white bx bx-check-double'></i>
                    @else
                        <i class='text-xs text-white bx bx-minus'></i>
                    @endif
                </div>
            </div>
            @else
            <div class="relative flex items-center justify-center flex-shrink-0 w-20 h-20 text-3xl font-bold text-white rounded-full shadow-lg bg-gradient-to-br from-indigo-500 to-purple-500">
                {{ strtoupper(substr($peserta->nama, 0, 1)) }}
                <div class="absolute bottom-0 right-0 flex items-center justify-center w-6 h-6 border-2 border-white rounded-full {{ $peserta->status == 'Aktif' ? 'bg-emerald-500' : ($peserta->status == 'Selesai' ? 'bg-amber-500' : 'bg-gray-400') }}">
                    @if($peserta->status == 'Aktif')
                        <i class='text-xs text-white bx bx-check'></i>
                    @elseif($peserta->status == 'Selesai')
                        <i class='text-xs text-white bx bx-check-double'></i>
                    @else
                        <i class='text-xs text-white bx bx-minus'></i>
                    @endif
                </div>
            </div>
            @endif

            <div class="flex-1">
                <h4 class="text-xl font-bold text-gray-800">{{ $peserta->nama }}</h4>
                <p class="text-sm text-gray-600">{{ $peserta->jurusan }}</p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $peserta->jenis_kegiatan == 'PKL' ? 'bg-indigo-100 text-indigo-700 border border-indigo-200' : 'bg-purple-100 text-purple-700 border border-purple-200' }}">
                        {{ $peserta->jenis_kegiatan }}
                    </span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $peserta->status == 'Aktif' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : ($peserta->status == 'Selesai' ? 'bg-amber-100 text-amber-700 border border-amber-200' : 'bg-gray-100 text-gray-700 border border-gray-200') }}">
                        {{ $peserta->status }}
                    </span>
                </div>
            </div>
        </div>

        {{-- User Account Info --}}
        <div class="grid grid-cols-2 gap-4 pt-4 mt-4 border-t border-gray-200 md:grid-cols-4">
            <div>
                <p class="text-xs font-medium text-gray-500">Username</p>
                <p class="text-sm font-semibold text-gray-800">{{ $peserta->user->username }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500">Role</p>
                <p class="text-sm font-semibold text-gray-800 capitalize">{{ $peserta->user->role }}</p>
            </div>
             <div>
                <p class="text-xs font-medium text-gray-500">ID User</p>
                <p class="text-sm font-semibold text-gray-800">{{ str_pad($peserta->user->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500">Bergabung</p>
                <p class="text-sm font-semibold text-gray-800">{{ $peserta->user->created_at->format('d M Y') }}</p>
            </div>
        </div>

        {{-- Statistics --}}
        <div class="grid grid-cols-3 gap-4 pt-4 mt-4 border-t border-gray-200">
            <div class="text-center">
                <p class="text-xs font-medium text-gray-500">Absensi</p>
                <p class="text-lg font-bold text-indigo-600">{{ $peserta->absensis->count() }}</p>
            </div>
            <div class="text-center">
                <p class="text-xs font-medium text-gray-500">Laporan</p>
                <p class="text-lg font-bold text-purple-600">{{ $peserta->laporans->count() }}</p>
            </div>
            <div class="text-center">
                <p class="text-xs font-medium text-gray-500">Feedback</p>
                <p class="text-lg font-bold text-emerald-600">{{ $peserta->feedbacks->count() }}</p>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <h5 class="flex items-center gap-2 text-lg font-bold text-gray-800">
            <i class='text-indigo-600 bx bx-user-pin'></i>
            Informasi Detail
        </h5>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-1">
            <div class="p-4 transition-colors border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-cyan-500 to-blue-500">
                        <i class='text-lg text-white bx bx-building-house'></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-500">Sekolah/Universitas</p>
                        <p class="font-semibold text-gray-800 truncate">{{ $peserta->asal_sekolah_universitas }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4 transition-colors border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-yellow-500 to-orange-500">
                        <i class='text-lg text-white bx bx-book'></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-500">Jurusan</p>
                        <p class="font-semibold text-gray-800 truncate">{{ $peserta->jurusan }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4 transition-colors border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-green-500 to-emerald-500">
                        <i class='text-lg text-white bx bx-phone'></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-500">No. Telepon</p>
                        <p class="font-semibold text-gray-800 truncate">{{ $peserta->no_telepon ?: 'Tidak ada' }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4 transition-colors border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-pink-500">
                        <i class='text-lg text-white bx bx-envelope'></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-500">Email User</p>
                        <p class="font-semibold text-gray-800 truncate">{{ $peserta->user->email }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4 transition-colors border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-pink-500 to-rose-500">
                        <i class='text-lg text-white bx bx-time'></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-500">Status</p>
                        <p class="font-semibold text-gray-800">{{ $peserta->status }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4 transition-colors border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-violet-500 to-purple-500">
                        <i class='text-lg text-white bx bx-id-card'></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-500">ID Peserta</p>
                        <p class="font-semibold text-gray-800">{{ str_pad($peserta->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4 transition-colors border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-teal-500 to-green-500">
                        <i class='text-lg text-white bx bx-map'></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-500">Alamat</p>
                        <p class="font-semibold text-gray-800 truncate">{{ $peserta->alamat ?: 'Tidak ada' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 border border-indigo-200 rounded-lg bg-indigo-50">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-10 h-10 bg-indigo-100 rounded-lg">
                    <i class='text-lg text-indigo-600 bx bx-calendar'></i>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-medium text-indigo-600">Periode Kegiatan</p>
                    <p class="font-semibold text-gray-800">
                        {{ $peserta->tanggal_mulai->format('d M Y') }} - {{ $peserta->tanggal_selesai->format('d M Y') }}
                    </p>
                    <p class="mt-1 text-xs text-gray-600">
                        Durasi: <span class="font-semibold">{{ $peserta->tanggal_mulai->diffInDays($peserta->tanggal_selesai) }} hari</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
        <h5 class="mb-3 text-sm font-bold text-gray-700">Metadata</h5>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-xs text-gray-500">Dibuat pada</p>
                <p class="font-medium text-gray-800">{{ $peserta->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Terakhir diupdate</p>
                <p class="font-medium text-gray-800">{{ $peserta->updated_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>
</div>
