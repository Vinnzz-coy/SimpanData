document.addEventListener('DOMContentLoaded', function () {
    updateTime();
    setInterval(updateTime, 1000);
    getLocation();
    setupEventListeners();
});

function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });

    const timeElement = document.getElementById('current-time');
    if (timeElement) {
        timeElement.textContent = timeString;
    }

    const attendanceTimeInput = document.getElementById('attendance-time');
    if (attendanceTimeInput) {
        attendanceTimeInput.value = now.toISOString();
    }
}

function getLocation() {
    const locationStatus = document.getElementById('location-status');
    const refreshBtn = document.getElementById('refresh-location-btn');

    if (locationStatus) {
        locationStatus.textContent = 'Mendeteksi lokasi...';
        locationStatus.className = 'text-lg font-medium text-gray-800';
        locationStatus.classList.remove('text-green-600', 'text-red-600', 'text-yellow-600');
    }

    if (refreshBtn) {
        refreshBtn.disabled = true;
        refreshBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;

                if (locationStatus) {
                    locationStatus.textContent = 'Lokasi terdeteksi';
                    locationStatus.classList.add('text-green-600');
                }

                if (refreshBtn) {
                    refreshBtn.disabled = false;
                    refreshBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }

                validateForm();
            },
            (error) => {
                console.error('Error getting location:', error);
                if (locationStatus) {
                    locationStatus.textContent = 'Gagal mendeteksi lokasi';
                    locationStatus.classList.add('text-red-600');
                }

                if (refreshBtn) {
                    refreshBtn.disabled = false;
                    refreshBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }

                validateForm();
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    } else {
        if (locationStatus) {
            locationStatus.textContent = 'Geolokasi tidak didukung';
            locationStatus.classList.add('text-red-600');
        }
        if (refreshBtn) {
            refreshBtn.disabled = false;
            refreshBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }
}

function setupEventListeners() {
    const checkinBtn = document.getElementById('checkin-btn');
    if (checkinBtn) {
        checkinBtn.addEventListener('click', () => setAttendanceType('checkin'));
    }

    const checkoutBtn = document.getElementById('checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', () => setAttendanceType('checkout'));
    }

    document.querySelectorAll('input[name="mode_kerja"], input[name="status"]').forEach(radio => {
        radio.addEventListener('change', validateForm);
    });

    document.querySelectorAll('input[name="status"]').forEach(radio => {
        radio.addEventListener('change', toggleWorkModeVisibility);
    });

    const refreshBtn = document.getElementById('refresh-location-btn');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', (e) => {
            e.preventDefault();
            getLocation();
        });
    }

    const form = document.getElementById('attendance-form');
    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    }
}

function setAttendanceType(type) {
    document.getElementById('attendance-type').value = type;

    const checkinBtn = document.getElementById('checkin-btn');
    const checkoutBtn = document.getElementById('checkout-btn');

    if (checkinBtn) {
        checkinBtn.classList.remove('border-green-500', 'bg-green-50', 'ring-2', 'ring-green-500');
    }
    if (checkoutBtn) {
        checkoutBtn.classList.remove('border-red-500', 'bg-red-50', 'ring-2', 'ring-red-500');
    }

    if (type === 'checkin' && checkinBtn) {
        checkinBtn.classList.add('border-green-500', 'bg-green-50', 'ring-2', 'ring-green-500');
    } else if (type === 'checkout' && checkoutBtn) {
        checkoutBtn.classList.add('border-red-500', 'bg-red-50', 'ring-2', 'ring-red-500');
    }

    validateForm();
}

function toggleWorkModeVisibility() {
    const status = document.querySelector('input[name="status"]:checked');
    const workModeSection = document.getElementById('work-mode-section');

    if (!workModeSection) return;

    if (status && status.value === 'Hadir') {
        workModeSection.style.display = 'block';
    } else {
        workModeSection.style.display = 'none';
        document.querySelectorAll('input[name="mode_kerja"]').forEach(radio => {
            radio.checked = false;
        });
    }

    validateForm();
}

function validateForm() {
    const attendanceType = document.getElementById('attendance-type').value;
    const status = document.querySelector('input[name="status"]:checked');
    const lat = document.getElementById('latitude').value;
    const lng = document.getElementById('longitude').value;
    const submitBtn = document.getElementById('submit-btn');

    let modeKerjaValid = true;
    if (status && status.value === 'Hadir') {
        const modeKerja = document.querySelector('input[name="mode_kerja"]:checked');
        modeKerjaValid = !!modeKerja;
    }

    if (attendanceType && status && lat && lng && modeKerjaValid) {
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    } else {
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
}

function handleFormSubmit(e) {
    const attendanceType = document.getElementById('attendance-type').value;
    const lat = document.getElementById('latitude').value;
    const lng = document.getElementById('longitude').value;

    if (!attendanceType) {
        e.preventDefault();
        alert('Silakan pilih jenis absensi (Check In atau Check Out)');
        return;
    }

    const status = document.querySelector('input[name="status"]:checked');
    if (!status) {
        e.preventDefault();
        alert('Silakan pilih status kehadiran');
        return;
    }

    if (status.value === 'Hadir' && !document.querySelector('input[name="mode_kerja"]:checked')) {
        e.preventDefault();
        alert('Silakan pilih mode kerja (WFO atau WFA)');
        return;
    }

    if (!lat || !lng) {
        e.preventDefault();
        alert('Lokasi belum terdeteksi. Pastikan Anda mengizinkan akses lokasi dan klik tombol refresh jika perlu.');
        return;
    }

    const typeLabel = attendanceType === 'checkin' ? 'Check In' : 'Check Out';
    if (!confirm(`Apakah Anda yakin ingin melakukan ${typeLabel}?`)) {
        e.preventDefault();
        return;
    }

    const submitBtn = document.getElementById('submit-btn');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Memproses...
        `;
    }
}
