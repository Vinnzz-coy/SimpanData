@extends('layouts.app')

@section('title', 'Tambah Partner')

@section('content')
<div class="p-4 md:p-6">
    <div class="mb-4 md:mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('admin.partners.index') }}"
                class="p-2 text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100">
                <i class='text-xl bx bx-arrow-back'></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tambah Partner Baru</h1>
                <p class="mt-1 text-gray-600">Masukkan informasi partner institusi atau perusahaan</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl">
        <div class="card">
            <div class="p-4 md:p-6">
                <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="p-4 border border-gray-200 rounded-lg md:p-6 bg-gray-50">
                        <h2 class="flex items-center gap-2 mb-4 text-lg font-semibold text-gray-800">
                            <i class='text-indigo-600 bx bx-buildings'></i>
                            Informasi Institusi
                        </h2>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label for="nama" class="block mb-2 text-sm font-medium text-gray-700">Nama Instansi *</label>
                                <input type="text"
                                        id="nama"
                                        name="nama"
                                        value="{{ old('nama') }}"
                                        required
                                        placeholder="Contoh: Universitas Indonesia"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nama') @enderror">
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="logo" class="block mb-2 text-sm font-medium text-gray-700">Logo Instansi *</label>
                                <div class="relative">
                                    <input type="file"
                                            id="logo"
                                            name="logo"
                                            required
                                            accept="image/*"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('logo') @enderror">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF. Maks: 2MB.</p>
                                @error('logo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="alamat" class="block mb-2 text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                <textarea id="alamat"
                                            name="alamat"
                                            rows="3"
                                            placeholder="Alamat lengkap instansi..."
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('alamat') @enderror">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                                <textarea id="deskripsi"
                                            name="deskripsi"
                                            rows="4"
                                            placeholder="Deskripsi singkat tentang partner..."
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('deskripsi') @enderror">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('admin.partners.index') }}"
                            class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class='mr-2 bx bx-save'></i>
                            Simpan Partner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
