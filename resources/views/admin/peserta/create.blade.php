@extends('layouts.app')

@section('title', 'Tambah Peserta')

@section('content')
<div class="p-4 md:p-6">
    <div class="mb-4 md:mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('admin.peserta.index') }}"
                class="p-2 text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100">
                <i class='text-xl bx bx-arrow-back'></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tambah Peserta Baru</h1>
                <p class="mt-1 text-gray-600">Masukkan data peserta PKL atau Magang</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl">
        <div class="card">
            <div class="p-4 md:p-6">
        <form action="{{ route('admin.peserta.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="p-4 border border-gray-200 rounded-lg md:p-6 bg-gray-50">
                <h2 class="flex items-center gap-2 mb-4 text-lg font-semibold text-gray-800">
                    <i class='text-indigo-600 bx bx-user'></i>
                    Data Akun
                </h2>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-700">Username *</label>
                        <input type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('username') @enderror">
                        @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email *</label>
                        <input type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password *</label>
                        <input type="password"
                                id="password"
                                name="password"
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('password') @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h2 class="flex items-center gap-2 mb-4 text-lg font-semibold text-gray-800">
                    <i class='text-indigo-600 bx bx-id-card'></i>
                    Data Peserta
                </h2>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-700">Nama Lengkap *</label>
                        <input type="text"
                                id="nama"
                                name="nama"
                                value="{{ old('nama') }}"
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nama') @enderror">
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="asal_sekolah_universitas" class="block mb-2 text-sm font-medium text-gray-700">Asal Sekolah/Universitas *</label>
                        <input type="text"
                                id="asal_sekolah_universitas"
                                name="asal_sekolah_universitas"
                                value="{{ old('asal_sekolah_universitas') }}"
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('asal_sekolah_universitas') @enderror">
                        @error('asal_sekolah_universitas')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jurusan" class="block mb-2 text-sm font-medium text-gray-700">Jurusan *</label>
                        <input type="text"
                                id="jurusan"
                                name="jurusan"
                                value="{{ old('jurusan') }}"
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('jurusan') @enderror">
                        @error('jurusan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="alamat" class="block mb-2 text-sm font-medium text-gray-700">Alamat</label>
                        <textarea id="alamat"
                                    name="alamat"
                                    rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('alamat') @enderror">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="no_telepon" class="block mb-2 text-sm font-medium text-gray-700">No. Telepon</label>
                        <input type="text"
                                id="no_telepon"
                                name="no_telepon"
                                value="{{ old('no_telepon') }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('no_telepon') @enderror">
                        @error('no_telepon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="foto" class="block mb-2 text-sm font-medium text-gray-700">Foto</label>
                        <input type="file"
                                id="foto"
                                name="foto"
                                accept="image/*"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('foto') @enderror">
                        @error('foto')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="p-4 border border-gray-200 rounded-lg md:p-6 bg-gray-50">
                <h2 class="flex items-center gap-2 mb-4 text-lg font-semibold text-gray-800">
                    <i class='text-indigo-600 bx bx-calendar'></i>
                    Data Kegiatan
                </h2>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="jenis_kegiatan" class="block mb-2 text-sm font-medium text-gray-700">Jenis Kegiatan *</label>
                        <select id="jenis_kegiatan"
                                name="jenis_kegiatan"
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('jenis_kegiatan') @enderror">
                            <option value="">Pilih Jenis</option>
                            <option value="PKL" {{ old('jenis_kegiatan') == 'PKL' ? 'selected' : '' }}>PKL</option>
                            <option value="Magang" {{ old('jenis_kegiatan') == 'Magang' ? 'selected' : '' }}>Magang</option>
                        </select>
                        @error('jenis_kegiatan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-700">Status *</label>
                        <select id="status"
                                name="status"
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('status') @enderror">
                            <option value="">Pilih Status</option>
                            <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_mulai" class="block mb-2 text-sm font-medium text-gray-700">Tanggal Mulai *</label>
                        <input type="date"
                                id="tanggal_mulai"
                                name="tanggal_mulai"
                                value="{{ old('tanggal_mulai') }}"
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('tanggal_mulai') @enderror">
                        @error('tanggal_mulai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_selesai" class="block mb-2 text-sm font-medium text-gray-700">Tanggal Selesai *</label>
                        <input type="date"
                                id="tanggal_selesai"
                                name="tanggal_selesai"
                                value="{{ old('tanggal_selesai') }}"
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('tanggal_selesai') @enderror">
                        @error('tanggal_selesai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('admin.peserta.index') }}"
                    class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class='mr-2 bx bx-save'></i>
                    Simpan Peserta
                </button>
            </div>
        </form>
            </div>
        </div>
    </div>
</div>
@endsection
