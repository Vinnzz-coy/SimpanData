const { sendOtpUrl, verifyOtpUrl, csrfToken, hasRegisterErrors } =
    window.AUTH_CONFIG;

let currentStep = 1;
let emailVerified = false;
let resendTimer = null;

function showLogin() {
    document.getElementById("loginForm").classList.remove("hidden");
    document.getElementById("registerForm").classList.add("hidden");

    document.getElementById("loginForm").classList.add("animate-fade-in");
    setTimeout(() => {
        document
            .getElementById("loginForm")
            .classList.remove("animate-fade-in");
    }, 400);
}

function showRegister() {
    document.getElementById("registerForm").classList.remove("hidden");
    document.getElementById("loginForm").classList.add("hidden");

    document.getElementById("registerForm").classList.add("animate-fade-in");
    setTimeout(() => {
        document
            .getElementById("registerForm")
            .classList.remove("animate-fade-in");
    }, 400);

    showStep(1);
}

function showStep(step) {
    currentStep = step;

    ["step1", "step2", "step3"].forEach((id) => {
        const el = document.getElementById(id);
        if (el) el.classList.add("hidden");
    });

    const current = document.getElementById(`step${step}`);
    if (!current) return;

    current.classList.remove("hidden");
    current.classList.add("animate-slide-in");

    setTimeout(() => {
        current.classList.remove("animate-slide-in");
    }, 400);

    if (step === 2) {
        setupOtpInputs();
        const email = document.getElementById("emailInput")?.value || "";
        document.getElementById("emailDisplay").textContent = email;
        startResendTimer();
    }
}

function setupOtpInputs() {
    const otpInputs = document.querySelectorAll(".otp-input");

    otpInputs.forEach((input, index) => {
        input.inputMode = "numeric";
        input.type = "text";

        input.addEventListener("input", () => {
            input.value = input.value.replace(/[^0-9]/g, "");
            if (input.value && otpInputs[index + 1]) {
                otpInputs[index + 1].focus();
            }
            collectOtp();
        });

        input.addEventListener("keydown", (e) => {
            if (e.key === "Backspace" && !input.value && otpInputs[index - 1]) {
                otpInputs[index - 1].focus();
                otpInputs[index - 1].value = "";
                collectOtp();
            }
        });

        input.addEventListener("paste", (e) => {
            e.preventDefault();
            const paste = e.clipboardData.getData("text").replace(/\D/g, "");
            if (paste.length === 6) {
                paste.split("").forEach((n, i) => {
                    if (otpInputs[i]) otpInputs[i].value = n;
                });
                collectOtp();
                otpInputs[5].focus();
            }
        });
    });

    otpInputs[0]?.focus();
}

function collectOtp() {
    const otp = [...document.querySelectorAll(".otp-input")]
        .map((i) => i.value)
        .join("");

    document.getElementById("otpHidden").value = otp;
    document.getElementById("verifyOtpBtn").disabled = otp.length !== 6;
    return otp;
}

async function sendOtp() {
    const email = document.getElementById("emailInput").value;
    const btn = document.getElementById("sendOtpBtn");

    if (!email) return showToast("Email wajib diisi", "error");
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
        return showToast("Format email tidak valid", "error");

    const original = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<div class="spinner mx-auto"></div>';

    try {
        const res = await fetch(sendOtpUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
            body: JSON.stringify({ email }),
        });

        const data = await res.json();
        if (!res.ok || !data.status) throw new Error(data.message);

        showToast("Kode verifikasi dikirim", "success");
        showStep(2);
    } catch (e) {
        showToast(e.message || "Gagal kirim OTP", "error");
    } finally {
        btn.disabled = false;
        btn.innerHTML = original;
    }
}

async function verifyOtpManual() {
    const otp = collectOtp();
    const email = document.getElementById("emailInput").value;
    const btn = document.getElementById("verifyOtpBtn");

    if (otp.length !== 6) return showToast("OTP harus 6 digit", "error");

    const original = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<div class="spinner mx-auto"></div>';

    try {
        const res = await fetch(verifyOtpUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
            body: JSON.stringify({ email, otp }),
        });

        const data = await res.json();
        if (!res.ok || !data.status) throw new Error(data.message);

        emailVerified = true;
        showToast("Email terverifikasi", "success");
        setTimeout(() => showStep(3), 800);
    } catch (e) {
        showToast(e.message || "OTP tidak valid", "error");
    } finally {
        if (!emailVerified) {
            btn.disabled = false;
            btn.innerHTML = original;
        }
    }
}

async function resendOtp() {
    const email = document.getElementById("emailInput").value;
    if (!email) return;

    await sendOtp();
}

function startResendTimer() {
    const btn = document.getElementById("resendOtpBtn");
    let time = 30;

    btn.disabled = true;
    btn.textContent = `${time}s`;

    if (resendTimer) clearInterval(resendTimer);

    resendTimer = setInterval(() => {
        time--;
        btn.textContent = `${time}s`;
        if (time <= 0) {
            clearInterval(resendTimer);
            btn.disabled = false;
            btn.textContent = "Ulangi";
        }
    }, 1000);
}

function checkRegisterPassword() {
    checkPasswordMatch();
}

function checkPasswordMatch() {
    const pass = document.getElementById("registerPassword").value;
    const conf = document.getElementById("registerPasswordConfirm").value;
    const btn = document.getElementById("registerBtn");

    if (pass && conf && pass === conf && emailVerified) {
        btn.disabled = false;
    } else {
        btn.disabled = true;
    }
}

document.addEventListener("DOMContentLoaded", () => {
    setupOtpInputs();

    if (hasRegisterErrors) {
        showRegister();
        const email = document.getElementById("emailInput")?.value;
        if (email) showStep(2);
    }
});
