function openDetailModal(laporan) {
    document.getElementById("modalPeserta").innerText = laporan.peserta.nama;
    document.getElementById("modalSekolah").innerText =
        laporan.peserta.asal_sekolah_universitas;
    document.getElementById("modalTanggal").innerText = new Date(
        laporan.tanggal_laporan,
    ).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "long",
        year: "numeric",
    });
    document.getElementById("modalJudul").innerText = laporan.judul;
    document.getElementById("modalDeskripsi").innerText = laporan.deskripsi;
    document.getElementById("modalAvatar").innerText = laporan.peserta.nama
        .substring(0, 1)
        .toUpperCase();

    const statusBadge = document.getElementById("modalStatusBadge");
    statusBadge.innerText = `Status: ${laporan.status}`;

    const fileContainer = document.getElementById("modalFileContainer");
    if (laporan.file_path) {
        fileContainer.classList.remove("hidden");
        document.getElementById("modalFileLink").href =
            `/storage/${laporan.file_path}`;
    } else {
        fileContainer.classList.add("hidden");
    }

    const actionButtons = document.getElementById("modalActionButtons");
    actionButtons.innerHTML = "";

    if (laporan.status === "Dikirim" || laporan.status === "Revisi") {
        const approveBtn = document.createElement("button");
        approveBtn.className =
            "bg-emerald-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-emerald-700 transition shadow-lg shadow-emerald-200 border border-emerald-500";
        approveBtn.innerText = "Setujui Laporan";
        approveBtn.onclick = function () {
            confirmApprove(`/admin/laporan/${laporan.id}/status`);
        };

        const reviseBtn = document.createElement("button");
        reviseBtn.className =
            "bg-amber-100 text-amber-700 px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-200 transition border border-amber-200";
        reviseBtn.innerText = "Revisi";
        reviseBtn.onclick = function () {
            confirmRevise(`/admin/laporan/${laporan.id}/status`);
        };

        actionButtons.appendChild(reviseBtn);
        actionButtons.appendChild(approveBtn);
    }

    document.getElementById("detailModal").classList.remove("hidden");
    document.body.classList.add("overflow-hidden");
}

function closeDetailModal() {
    document.getElementById("detailModal").classList.add("hidden");
    document.body.classList.remove("overflow-hidden");
}

function confirmApprove(url) {
    Swal.fire({
        title: "Setujui Laporan?",
        text: "Laporan ini akan ditandai sebagai disetujui.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#10B981",
        cancelButtonColor: "#6B7280",
        confirmButtonText: "Ya, Setujui",
        cancelButtonText: "Batal",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            submitForm(url, "Disetujui");
        }
    });
}

function confirmRevise(url) {
    Swal.fire({
        title: "Revisi Laporan?",
        text: "Laporan akan dikembalikan ke peserta untuk diperbaiki.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#F59E0B",
        cancelButtonColor: "#6B7280",
        confirmButtonText: "Ya, Revisi",
        cancelButtonText: "Batal",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            submitForm(url, "Revisi");
        }
    });
}

function submitForm(url, status) {
    const form = document.createElement("form");
    form.method = "POST";
    form.action = url;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const csrfInput = document.createElement("input");
    csrfInput.type = "hidden";
    csrfInput.name = "_token";
    csrfInput.value = csrfToken;

    const methodInput = document.createElement("input");
    methodInput.type = "hidden";
    methodInput.name = "_method";
    methodInput.value = "PATCH";

    const statusInput = document.createElement("input");
    statusInput.type = "hidden";
    statusInput.name = "status";
    statusInput.value = status;

    form.appendChild(csrfInput);
    form.appendChild(methodInput);
    form.appendChild(statusInput);
    document.body.appendChild(form);
    form.submit();
}
window.openDetailModal = openDetailModal;
window.closeDetailModal = closeDetailModal;
window.confirmApprove = confirmApprove;
window.confirmRevise = confirmRevise;
