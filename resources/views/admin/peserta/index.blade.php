@extends('layouts.app')

@section('title', 'Data Peserta')

@section('content')
<div class="p-4 md:p-6">

    <div class="mb-6 card">
        <div class="p-4 border-b border-gray-200 md:p-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-800 md:text-2xl">Data Peserta</h1>
                    <p class="mt-1 text-sm text-gray-600 md:text-base">Kelola data peserta PKL dan Magang</p>
                </div>
                <button onclick="openCreateModal()"
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class='text-lg bx bx-plus'></i>
                    <span>Tambah Peserta</span>
                </button>
            </div>
        </div>
    </div>

    <div class="mb-6">
        <div class="p-4 border-b border-gray-200 md:p-5">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="card bg-gradient-to-br from-indigo-500 to-purple-500">
                    <div class="p-4 md:p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-xs font-semibold tracking-wider uppercase text-white/80">Total Peserta</p>
                                <h3 class="mt-1 text-3xl font-bold text-white">{{ $peserta->total() }}</h3>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-white/20">
                                    <i class='text-2xl text-white bx bx-user'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-gradient-to-br from-blue-500 to-indigo-500">
                    <div class="p-4 md:p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-xs font-semibold tracking-wider uppercase text-white/80">PKL</p>
                                <h3 class="mt-1 text-3xl font-bold text-white">{{ $totalPkl ?? 0 }}</h3>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-white/20">
                                    <i class='text-2xl text-white bx bx-book'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-gradient-to-br from-emerald-500 to-teal-500">
                    <div class="p-4 md:p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-xs font-semibold tracking-wider uppercase text-white/80">Magang</p>
                                <h3 class="mt-1 text-3xl font-bold text-white">{{ $totalMagang ?? 0 }}</h3>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-white/20">
                                    <i class='text-2xl text-white bx bx-briefcase-alt'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-gradient-to-br from-amber-500 to-orange-500">
                    <div class="p-4 md:p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-xs font-semibold tracking-wider uppercase text-white/80">Aktif</p>
                                <h3 class="mt-1 text-3xl font-bold text-white">{{ $aktif ?? 0 }}</h3>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-white/20">
                                    <i class='text-2xl text-white bx bx-time-five'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-6 card">
        <div class="p-4 md:p-5">
            <div class="flex flex-col gap-4 md:flex-row">
                <div class="flex-1">
                    <div class="relative">
                        <i class='absolute text-gray-400 transform -translate-y-1/2 left-3 top-1/2 bx bx-search'></i>
                        <input type="text"
                                id="searchInput"
                                value="{{ request('search') }}"
                                placeholder="Cari nama, sekolah, atau jurusan..."
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <div class="relative">
                        <select id="filterJenisKegiatan"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white pr-10">
                            <option value="">Semua Jenis</option>
                            <option value="PKL" {{ request('jenis_kegiatan') == 'PKL' ? 'selected' : '' }}>PKL</option>
                            <option value="Magang" {{ request('jenis_kegiatan') == 'Magang' ? 'selected' : '' }}>Magang</option>
                        </select>
                        <i class='absolute text-gray-400 transform -translate-y-1/2 right-3 top-1/2 bx bx-chevron-down'></i>
                    </div>

                    <div class="relative">
                        <select id="filterStatus"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white pr-10">
                            <option value="">Semua Status</option>
                            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <i class='absolute text-gray-400 transform -translate-y-1/2 right-3 top-1/2 bx bx-chevron-down'></i>
                    </div>

                    <button onclick="resetFilters()"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200 whitespace-nowrap">
                        <i class='bx bx-refresh'></i>
                        <span>Reset</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="p-4 md:p-5" id="pesertaGridContainer">
            @include('admin.peserta.partials.peserta-grid', ['peserta' => $peserta])
        </div>
    </div>
</div>

<div id="createModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeCreateModal()"></div>
        <div class="inline-block w-full max-w-4xl p-0 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Tambah Peserta Baru</h3>
                    <p class="mt-1 text-gray-600">Masukkan data peserta PKL atau Magang</p>
                </div>
                <button onclick="closeCreateModal()"
                        class="p-2 text-gray-400 transition-colors rounded-lg hover:text-gray-600 hover:bg-gray-100">
                    <i class='text-2xl bx bx-x'></i>
                </button>
            </div>
            <div class="p-6">
                <div id="createModalContent">
                    <div class="py-12 text-center">
                        <i class="text-4xl text-indigo-600 bx bx-loader-alt bx-spin"></i>
                        <p class="mt-3 text-gray-600">Memuat formulir...</p>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3 p-6 bg-gray-50 rounded-b-2xl">
                <button onclick="closeCreateModal()"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </button>
                <button onclick="submitCreateForm()"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg inline-flex items-center gap-2">
                    <i class='bx bx-save'></i>
                    <span>Simpan Peserta</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeEditModal()"></div>
        <div class="inline-block w-full max-w-4xl p-0 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Edit Peserta</h3>
                    <p class="mt-1 text-gray-600">Perbarui data peserta</p>
                </div>
                <button onclick="closeEditModal()"
                        class="p-2 text-gray-400 transition-colors rounded-lg hover:text-gray-600 hover:bg-gray-100">
                    <i class='text-2xl bx bx-x'></i>
                </button>
            </div>
            <div class="p-6">
                <div id="editModalContent">
                    <div class="py-12 text-center">
                        <i class="text-4xl text-indigo-600 bx bx-loader-alt bx-spin"></i>
                        <p class="mt-3 text-gray-600">Memuat formulir...</p>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3 p-6 bg-gray-50 rounded-b-2xl">
                <button onclick="closeEditModal()"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </button>
                <button onclick="submitEditForm()"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg inline-flex items-center gap-2">
                    <i class='bx bx-save'></i>
                    <span>Update Peserta</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="showModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeShowModal()"></div>
        <div class="inline-block w-full max-w-4xl p-0 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Detail Peserta</h3>
                    <p class="mt-1 text-gray-600">Informasi lengkap peserta</p>
                </div>
                <button onclick="closeShowModal()"
                        class="p-2 text-gray-400 transition-colors rounded-lg hover:text-gray-600 hover:bg-gray-100">
                    <i class='text-2xl bx bx-x'></i>
                </button>
            </div>
            <div class="p-6">
                <div id="showModalContent">
                    <div class="py-12 text-center">
                        <i class="text-4xl text-indigo-600 bx bx-loader-alt bx-spin"></i>
                        <p class="mt-3 text-gray-600">Memuat data...</p>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3 p-6 bg-gray-50 rounded-b-2xl">
                <button onclick="closeShowModal()"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .peserta-grid {
        opacity: 0;
        animation: fadeIn 0.5s ease-out forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    .modal-enter {
        animation: modalEnter 0.3s ease-out;
    }

    @keyframes modalEnter {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .hover-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let currentEditId = null;
let currentPage = 1;

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

document.getElementById('searchInput').addEventListener('input', debounce(() => {
    currentPage = 1;
    loadData();
}, 100));

document.getElementById('filterJenisKegiatan').addEventListener('change', () => {
    currentPage = 1;
    loadData();
});

document.getElementById('filterStatus').addEventListener('change', () => {
    currentPage = 1;
    loadData();
});

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('filterJenisKegiatan').selectedIndex = 0;
    document.getElementById('filterStatus').selectedIndex = 0;
    currentPage = 1;

    const resetBtn = document.querySelector('[onclick="resetFilters()"]');
    const originalHTML = resetBtn.innerHTML;
    resetBtn.innerHTML = '<i class="bx bx-check"></i><span>Berhasil</span>';
    resetBtn.classList.add('bg-green-100', 'text-green-700', 'border-green-200');

    setTimeout(() => {
        resetBtn.innerHTML = originalHTML;
        resetBtn.classList.remove('bg-green-100', 'text-green-700', 'border-green-200');
    }, 2000);

    loadData();
}

function loadData(page = currentPage) {
    currentPage = page;
    const search = document.getElementById('searchInput').value;
    const jenisKegiatan = document.getElementById('filterJenisKegiatan').value;
    const status = document.getElementById('filterStatus').value;

    const params = new URLSearchParams({
        search: search,
        jenis_kegiatan: jenisKegiatan,
        status: status,
        page: page
    });

    const container = document.getElementById('pesertaGridContainer');
    const currentContent = container.innerHTML;
    container.innerHTML = `
        <div class="py-16 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-indigo-50">
                <i class="text-3xl text-indigo-600 bx bx-loader-alt bx-spin spinner"></i>
            </div>
            <h3 class="mb-2 text-lg font-semibold text-gray-800">Memuat Data</h3>
            <p class="text-gray-600">Mohon tunggu sebentar...</p>
        </div>
    `;

    fetch(`{{ route('admin.peserta.index') }}?${params}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.grid) {
            container.innerHTML = data.grid;
            bindPaginationLinks();
            bindActionButtons();

            container.style.opacity = '0';
            container.style.transform = 'translateY(10px)';
            setTimeout(() => {
                container.style.transition = 'all 0.3s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 50);

            if (data.stats) {
                updateStats(data.stats);
            }
        } else {
            throw new Error('Invalid response format');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        container.innerHTML = `
            <div class="py-16 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-red-50">
                    <i class="text-3xl text-red-600 bx bx-error"></i>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-red-800">Gagal Memuat Data</h3>
                <p class="mb-4 text-gray-600">Terjadi kesalahan saat memuat data</p>
                <button onclick="loadData()" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                    <i class="mr-2 bx bx-refresh"></i>Coba Lagi
                </button>
            </div>
        `;
    });
}

function bindPaginationLinks() {
    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            loadData(page);

            window.scrollTo({
                top: document.getElementById('pesertaGridContainer').offsetTop - 100,
                behavior: 'smooth'
            });
        });
    });
}

function bindActionButtons() {
    document.querySelectorAll('[data-edit-id]').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-edit-id');
            openEditModal(id);
        });
    });

    document.querySelectorAll('[data-show-id]').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-show-id');
            openShowModal(id);
        });
    });

    document.querySelectorAll('[data-delete-id]').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-delete-id');
            deletePeserta(id);
        });
    });
}

function openCreateModal() {
    const modal = document.getElementById('createModal');
    const content = document.getElementById('createModalContent');

    content.innerHTML = `
        <div class="py-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-indigo-50">
                <i class="text-3xl text-indigo-600 bx bx-loader-alt bx-spin spinner"></i>
            </div>
            <h3 class="mb-2 text-lg font-semibold text-gray-800">Memuat Formulir</h3>
            <p class="text-gray-600">Mohon tunggu sebentar...</p>
        </div>
    `;

    modal.classList.remove('hidden');
    modal.classList.add('modal-enter');

    const today = new Date().toISOString().split('T')[0];

    fetch('{{ route('admin.peserta.create') }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.html) {
            content.innerHTML = data.html;

            setTimeout(() => {
                const tanggalMulai = document.querySelector('#create_tanggal_mulai');
                const tanggalSelesai = document.querySelector('#create_tanggal_selesai');

                if (tanggalMulai) {
                    tanggalMulai.min = today;
                    tanggalMulai.addEventListener('change', function() {
                        if (tanggalSelesai) {
                            tanggalSelesai.min = this.value;
                            if (tanggalSelesai.value && tanggalSelesai.value < this.value) {
                                tanggalSelesai.value = this.value;
                            }
                        }
                    });
                }

                if (tanggalSelesai) {
                    tanggalSelesai.min = today;
                }
            }, 100);
        } else {
            throw new Error('Invalid response format');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        content.innerHTML = `
            <div class="py-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-red-50">
                    <i class="text-3xl text-red-600 bx bx-error"></i>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-red-800">Gagal Memuat Formulir</h3>
                <p class="mb-4 text-gray-600">Terjadi kesalahan saat memuat formulir</p>
                <button onclick="openCreateModal()" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                    <i class="mr-2 bx bx-refresh"></i>Coba Lagi
                </button>
            </div>
        `;
    });
}

function closeCreateModal() {
    const modal = document.getElementById('createModal');
    modal.style.opacity = '1';

    const fadeOut = () => {
        modal.style.opacity = '0';
        modal.style.transform = 'scale(0.95)';
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.style.opacity = '';
            modal.style.transform = '';
            document.getElementById('createModalContent').innerHTML = '';
        }, 300);
    };

    fadeOut();
}

function submitCreateForm() {
    const form = document.getElementById('createPesertaForm');
    if (!form) {
        console.error('Create form not found');
        return;
    }

    const submitBtn = document.querySelector('#createModal button[onclick="submitCreateForm()"]');
    const originalHTML = submitBtn.innerHTML;

    submitBtn.innerHTML = '<i class="mr-2 bx bx-loader-alt bx-spin"></i>Menyimpan...';
    submitBtn.disabled = true;

    const formData = new FormData(form);

    fetch('{{ route('admin.peserta.store') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                background: '#f0f9ff',
                iconColor: '#10b981'
            });

            closeCreateModal();
            loadData();
        } else {
            showFormErrors('createPesertaForm', data.errors || {});

            if (data.message) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message,
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Terjadi kesalahan saat menyimpan data',
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    })
    .finally(() => {
        if (submitBtn) {
            submitBtn.innerHTML = originalHTML;
            submitBtn.disabled = false;
        }
    });
}

function openEditModal(id) {
    currentEditId = id;
    const modal = document.getElementById('editModal');
    const content = document.getElementById('editModalContent');

    content.innerHTML = `
        <div class="py-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-indigo-50">
                <i class="text-3xl text-indigo-600 bx bx-loader-alt bx-spin spinner"></i>
            </div>
            <h3 class="mb-2 text-lg font-semibold text-gray-800">Memuat Formulir</h3>
            <p class="text-gray-600">Mohon tunggu sebentar...</p>
        </div>
    `;

    modal.classList.remove('hidden');
    modal.classList.add('modal-enter');

    fetch(`{{ url('admin/peserta') }}/${id}/edit`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.html) {
            content.innerHTML = data.html;

            setTimeout(() => {
                const tanggalMulai = document.querySelector('#edit_tanggal_mulai');
                const tanggalSelesai = document.querySelector('#edit_tanggal_selesai');

                if (tanggalMulai && tanggalSelesai) {
                    tanggalMulai.addEventListener('change', function() {
                        tanggalSelesai.min = this.value;
                        if (tanggalSelesai.value && tanggalSelesai.value < this.value) {
                            tanggalSelesai.value = this.value;
                        }
                    });
                }
            }, 100);
        } else {
            throw new Error('Invalid response format');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        content.innerHTML = `
            <div class="py-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-red-50">
                    <i class="text-3xl text-red-600 bx bx-error"></i>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-red-800">Gagal Memuat Formulir</h3>
                <p class="mb-4 text-gray-600">Terjadi kesalahan saat memuat formulir</p>
                <button onclick="openEditModal(${id})" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                    <i class="mr-2 bx bx-refresh"></i>Coba Lagi
                </button>
            </div>
        `;
    });
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.style.opacity = '1';

    const fadeOut = () => {
        modal.style.opacity = '0';
        modal.style.transform = 'scale(0.95)';
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.style.opacity = '';
            modal.style.transform = '';
            document.getElementById('editModalContent').innerHTML = '';
            currentEditId = null;
        }, 300);
    };

    fadeOut();
}

function submitEditForm() {
    const form = document.getElementById('editPesertaForm');
    if (!form) {
        console.error('Edit form not found');
        return;
    }

    const submitBtn = document.querySelector('#editModal button[onclick="submitEditForm()"]');
    const originalHTML = submitBtn.innerHTML;

    submitBtn.innerHTML = '<i class="mr-2 bx bx-loader-alt bx-spin"></i>Memperbarui...';
    submitBtn.disabled = true;

    const formData = new FormData(form);
    formData.append('_method', 'PUT');

    fetch(`{{ url('admin/peserta') }}/${currentEditId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                background: '#f0f9ff',
                iconColor: '#10b981'
            });

            closeEditModal();
            loadData();
        } else {
            showFormErrors('editPesertaForm', data.errors || {});

            if (data.message) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message,
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Terjadi kesalahan saat memperbarui data',
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    })
    .finally(() => {
        if (submitBtn) {
            submitBtn.innerHTML = originalHTML;
            submitBtn.disabled = false;
        }
    });
}

function openShowModal(id) {
    const modal = document.getElementById('showModal');
    const content = document.getElementById('showModalContent');

    content.innerHTML = `
        <div class="py-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-indigo-50">
                <i class="text-3xl text-indigo-600 bx bx-loader-alt bx-spin spinner"></i>
            </div>
            <h3 class="mb-2 text-lg font-semibold text-gray-800">Memuat Data</h3>
            <p class="text-gray-600">Mohon tunggu sebentar...</p>
        </div>
    `;

    modal.classList.remove('hidden');
    modal.classList.add('modal-enter');

    fetch(`{{ url('admin/peserta') }}/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.html) {
            content.innerHTML = data.html;
        } else {
            throw new Error('Invalid response format');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        content.innerHTML = `
            <div class="py-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-red-50">
                    <i class="text-3xl text-red-600 bx bx-error"></i>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-red-800">Gagal Memuat Data</h3>
                <p class="mb-4 text-gray-600">Terjadi kesalahan saat memuat data</p>
                <button onclick="openShowModal(${id})" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                    <i class="mr-2 bx bx-refresh"></i>Coba Lagi
                </button>
            </div>
        `;
    });
}

function closeShowModal() {
    const modal = document.getElementById('showModal');
    modal.style.opacity = '1';

    const fadeOut = () => {
        modal.style.opacity = '0';
        modal.style.transform = 'scale(0.95)';
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.style.opacity = '';
            modal.style.transform = '';
            document.getElementById('showModalContent').innerHTML = '';
        }, 300);
    };

    fadeOut();
}

function deletePeserta(id) {
    Swal.fire({
        title: 'Hapus Peserta?',
        text: "Data peserta akan dihapus permanen dan tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        backdrop: 'rgba(0,0,0,0.8)',
        customClass: {
            popup: 'modal-enter'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Menghapus...',
                text: 'Sedang menghapus data peserta',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`{{ url('admin/peserta') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.close();
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        background: '#f0f9ff',
                        iconColor: '#10b981'
                    });
                    loadData();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Terjadi kesalahan',
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menghapus data',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            });
        }
    });
}

function showFormErrors(formId, errors) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.querySelectorAll('.error-message').forEach(el => {
        el.textContent = '';
        el.classList.remove('text-red-600');
    });

    form.querySelectorAll('input, select, textarea').forEach(el => {
        el.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
    });

    Object.keys(errors).forEach(key => {
        const field = form.querySelector(`[name="${key}"]`);
        if (field) {
            field.classList.add('border-red-500', 'ring-2', 'ring-red-200');

            let errorDiv = field.parentElement.querySelector('.error-message');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'error-message text-sm text-red-600 mt-1';
                field.parentElement.appendChild(errorDiv);
            }

            errorDiv.textContent = errors[key][0];
            errorDiv.classList.add('text-red-600');

            if (Object.keys(errors)[0] === key) {
                field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                field.focus();
            }
        }
    });
}

function updateStats(stats) {
    const statsCards = document.querySelectorAll('.stat-card');
    if (statsCards.length > 0) {
    }
}

document.addEventListener('DOMContentLoaded', function() {
    bindPaginationLinks();
    bindActionButtons();

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCreateModal();
            closeEditModal();
            closeShowModal();
        }
    });

    document.querySelectorAll('[class*="bg-opacity-75"]').forEach(overlay => {
        overlay.addEventListener('click', function() {
            if (this.closest('#createModal')) closeCreateModal();
            if (this.closest('#editModal')) closeEditModal();
            if (this.closest('#showModal')) closeShowModal();
        });
    });

    const today = new Date().toISOString().split('T')[0];
    document.querySelectorAll('input[type="date"]').forEach(input => {
        if (!input.value) {
            input.min = today;
        }
    });
});
</script>
@endsection
