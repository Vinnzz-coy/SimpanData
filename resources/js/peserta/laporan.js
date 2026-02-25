document.addEventListener('DOMContentLoaded', function() {
    const reportForm = document.getElementById('report-form');
    if (reportForm) {
        // Global variable to store clicked button value
        let clickedButtonValue = null;

        const submitButtons = reportForm.querySelectorAll('button[type="submit"]');
        submitButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                clickedButtonValue = this.value;
            });
        });

        reportForm.addEventListener('submit', function(e) {
            const judul = document.getElementById('judul').value.trim();
            const deskripsi = document.getElementById('deskripsi').value.trim();
            
            if (!judul || !deskripsi) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Wajib Diisi!',
                    text: 'Judul dan Deskripsi laporan tidak boleh kosong.',
                    confirmButtonColor: '#7C3AED'
                });
                return false;
            }

            // Sync clicked button value to hidden input if it exists
            const statusInput = document.getElementById('status-field');
            if (statusInput && clickedButtonValue) {
                statusInput.value = clickedButtonValue;
            }

            // Target the specific button that was clicked for the loading state
            const submitBtn = Array.from(submitButtons).find(btn => btn.value === clickedButtonValue) || submitButtons[0];
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<div class="flex items-center gap-2"><i class="bx bx-loader-alt animate-spin"></i><span>Menyimpan...</span></div>';
        });

        const fileInput = document.getElementById('file');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const isLaporanAkhir = window.location.pathname.includes('laporan-akhir');
                    const maxSize = (isLaporanAkhir ? 10 : 5) * 1024 * 1024;
                    const maxSizeText = isLaporanAkhir ? '10MB' : '5MB';

                    if (file.size > maxSize) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Terlalu Besar!',
                            text: `Ukuran file maksimal adalah ${maxSizeText}.`,
                            confirmButtonColor: '#7C3AED'
                        });
                        e.target.value = '';
                    }
                }
            });
        }
    }

    const deleteForm = document.getElementById('delete-form');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Hapus Laporan?',
                text: "Laporan yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    }
});
