document.addEventListener('DOMContentLoaded', function() {
    const profileView = document.getElementById('profileView');
    const editView = document.getElementById('editView');
    const btnEditProfile = document.getElementById('btnEditProfile');
    const btnCancelEdit = document.getElementById('btnCancelEdit');
    const fotoInput = document.getElementById('fotoInput');
    const imagePreview = document.getElementById('imagePreview');

    const btnGetGPS = document.getElementById('btnGetGPS');
    const alamatInput = document.getElementById('alamatInput');
    const mapContainer = document.getElementById('mapContainer');
    const locationLabel = document.getElementById('locationLabel');
    let map, marker, currentLat, currentLng;

    // View Transitions
    if (btnEditProfile) {
        btnEditProfile.addEventListener('click', () => {
            profileView.classList.add('hidden');
            editView.classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    if (btnCancelEdit) {
        btnCancelEdit.addEventListener('click', () => {
            editView.classList.add('hidden');
            profileView.classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Image Preview
    if (fotoInput && imagePreview) {
        fotoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = `<img src="${e.target.result}" class="object-cover w-full h-full transform hover:scale-110 transition-transform duration-500">`;
                    imagePreview.classList.remove('bg-slate-100', 'border-dashed');
                    imagePreview.classList.add('border-solid', 'border-primary/20');
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Map Functionality
    function showInlineMap() {
        if (mapContainer) {
            mapContainer.classList.add('active');
            if (map) {
                setTimeout(() => {
                    map.invalidateSize();
                }, 100);
            }
        }
    }

    function initMap(lat, lng) {
        currentLat = lat;
        currentLng = lng;

        showInlineMap();

        if (!map) {
            map = L.map('map', {
                zoomControl: false // Custom zoom control position if needed
            }).setView([lat, lng], 17);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);

            L.control.zoom({ position: 'bottomright' }).addTo(map);

            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);

            marker.on('dragend', function(e) {
                const newPos = marker.getLatLng();
                currentLat = newPos.lat;
                currentLng = newPos.lng;
                if (locationLabel) {
                    locationLabel.innerHTML = `<i class='mr-1 bx bx-sync bx-spin'></i> Memperbarui Alamat...`;
                }
                reverseGeocode(currentLat, currentLng);
            });
        } else {
            map.setView([lat, lng], 17);
            marker.setLatLng([lat, lng]);
        }
        
        if (locationLabel) {
            locationLabel.innerHTML = `<i class='mr-1 text-green-500 bx bx-check-double'></i> Lokasi Terdeteksi`;
        }
    }

    async function reverseGeocode(lat, lng) {
        try {
            const response = await fetch(
                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`
            );
            const data = await response.json();
            if (data.display_name && alamatInput) {
                alamatInput.value = data.display_name;
                if (locationLabel) {
                    locationLabel.innerHTML = `<i class='mr-1 text-green-500 bx bxs-check-circle'></i> Alamat Tersinkronisasi`;
                }
            }
        } catch (error) {
            console.error('Error reverse geocoding:', error);
            if (locationLabel) {
                locationLabel.innerHTML = `<i class='mr-1 text-red-500 bx bx-error-circle'></i> Gagal Mendapatkan Alamat`;
            }
        }
    }

    if (btnGetGPS) {
        btnGetGPS.addEventListener('click', function() {
            if (!navigator.geolocation) {
                alert('Geolocation tidak didukung oleh browser Anda.');
                return;
            }

            btnGetGPS.disabled = true;
            btnGetGPS.innerHTML = "<i class='bx bx-loader-alt bx-spin'></i> Mencari...";

            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    const { latitude, longitude } = position.coords;
                    initMap(latitude, longitude);
                    await reverseGeocode(latitude, longitude);

                    btnGetGPS.disabled = false;
                    btnGetGPS.innerHTML = "<i class='bx bx-check'></i> Berhasil";
                    setTimeout(() => {
                        btnGetGPS.innerHTML = "<i class='text-base bx bx-map-pin'></i> Ambil dari GPS";
                    }, 3000);
                },
                (error) => {
                    btnGetGPS.disabled = false;
                    btnGetGPS.innerHTML = "<i class='text-base bx bx-map-pin'></i> Ambil dari GPS";
                    alert('Gagal mengambil lokasi: ' + error.message);
                }, {
                    enableHighAccuracy: true
                }
            );
        });
    }
});
