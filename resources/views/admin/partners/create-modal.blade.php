<form id="createPartnerForm" enctype="multipart/form-data" class="space-y-6">
    <div class="p-4 border border-gray-200 rounded-lg md:p-6 bg-gray-50">
        <h2 class="flex items-center gap-2 mb-4 text-lg font-semibold text-gray-800">
            <i class='text-indigo-600 bx bx-buildings'></i>
            Informasi Institusi
        </h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="md:col-span-2">
                <label for="create_nama" class="block mb-2 text-sm font-medium text-gray-700">Nama Instansi *</label>
                <input type="text"
                        id="create_nama"
                        name="nama"
                        required
                        placeholder="Contoh: Universitas Indonesia"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="md:col-span-2">
                <label for="create_logo" class="block mb-2 text-sm font-medium text-gray-700">Logo Instansi *</label>
                <div class="relative">
                    <input type="file"
                            id="create_logo"
                            name="logo"
                            required
                            accept="image/*"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF. Maks: 2MB.</p>
            </div>

            <div class="md:col-span-2">
                <label for="create_alamat" class="block mb-2 text-sm font-medium text-gray-700">Alamat Lengkap</label>
                <textarea id="create_alamat"
                            name="alamat"
                            rows="3"
                            placeholder="Alamat lengkap instansi..."
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <div class="md:col-span-2">
                <label for="create_deskripsi" class="block mb-2 text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                <textarea id="create_deskripsi"
                            name="deskripsi"
                            rows="4"
                            placeholder="Deskripsi singkat tentang partner..."
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end gap-4">
        <button type="button" onclick="closeCreateModal()"
            class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
            Batal
        </button>
        <button type="button" onclick="submitCreateForm()"
                class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg">
            <i class='mr-2 bx bx-save'></i>
            Simpan Partner
        </button>
    </div>
</form>
