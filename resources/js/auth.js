// Authentication Page Logic

let currentStep = 1;
let emailVerified = false;
let resendTimer = null;

// Get CSRF Token from meta tag
const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Helper to show login form
window.showLogin = function() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    
    loginForm.classList.remove('hidden');
    registerForm.classList.add('hidden');

    loginForm.classList.add('animate-fade-in');
    setTimeout(() => {
        loginForm.classList.remove('animate-fade-in');
    }, 400);
}

// Helper to show register form
window.showRegister = function() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    
    registerForm.classList.remove('hidden');
    loginForm.classList.add('hidden');

    registerForm.classList.add('animate-fade-in');
    setTimeout(() => {
        registerForm.classList.remove('animate-fade-in');
    }, 400);

    showStep(1);
}

// Step navigation
window.showStep = function(step) {
    currentStep = step;

    ['step1', 'step2', 'step3'].forEach(id => {
        document.getElementById(id).classList.add('hidden');
    });

    const targetStep = document.getElementById(`step${step}`);
    targetStep.classList.remove('hidden');
    targetStep.classList.add('animate-slide-in');

    setTimeout(() => {
        targetStep.classList.remove('animate-slide-in');
    }, 400);

    if (step === 2) {
        setupOtpInputs();
        const email = document.getElementById('emailInput').value;
        document.getElementById('emailDisplay').textContent = email;
        startResendTimer();
    }
}

// OTP Inputs Setup
function setupOtpInputs() {
    const otpInputs = document.querySelectorAll('.otp-input');

    otpInputs.forEach((input, index) => {
        input.className =
            'otp-input w-10 h-10 text-center text-lg font-bold border-2 border-gray-300 rounded-lg focus:border-secondary focus:ring-2 focus:ring-secondary-light transition-all duration-200';
        input.inputMode = 'numeric';
        input.type = 'text';

        input.addEventListener('input', (e) => {
            input.value = input.value.replace(/[^0-9]/g, '');

            if (input.value && otpInputs[index + 1]) {
                otpInputs[index + 1].focus();
            }

            collectOtp();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && otpInputs[index - 1]) {
                e.preventDefault();
                otpInputs[index - 1].focus();
                otpInputs[index - 1].value = '';
                collectOtp();
            }
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasteData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');

            if (pasteData.length === 6) {
                pasteData.split('').forEach((char, idx) => {
                    if (otpInputs[idx]) {
                        otpInputs[idx].value = char;
                    }
                });
                collectOtp();
                otpInputs[5].focus();
            }
        });
    });

    if (otpInputs[0]) {
        setTimeout(() => otpInputs[0].focus(), 100);
    }
}

// Collect OTP
window.collectOtp = function() {
    const otpInputs = document.querySelectorAll('.otp-input');
    let otp = '';

    otpInputs.forEach(input => {
        otp += input.value;
    });

    const hiddenInput = document.getElementById('otpHidden');
    if(hiddenInput) hiddenInput.value = otp;

    const verifyBtn = document.getElementById('verifyOtpBtn');
    if(verifyBtn) verifyBtn.disabled = otp.length !== 6;

    return otp;
}

// Send OTP
window.sendOtp = async function() {
    const email = document.getElementById('emailInput').value;
    const sendOtpBtn = document.getElementById('sendOtpBtn');

    if (!email) {
        showToast('Email wajib diisi', 'error');
        return;
    }

    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailRegex.test(email)) {
        showToast('Format email tidak valid', 'error');
        return;
    }

    const originalText = sendOtpBtn.innerHTML;

    sendOtpBtn.disabled = true;
    sendOtpBtn.innerHTML = '<div class="mx-auto spinner"></div>';
    sendOtpBtn.classList.remove('bg-primary', 'hover:bg-primary/90');
    sendOtpBtn.classList.add('bg-gray-400');

    try {
        const response = await fetch(window.routes.sendOtp, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": getCsrfToken(),
                "Accept": "application/json"
            },
            body: JSON.stringify({ email: email })
        });

        const data = await response.json();

        if (response.ok && data.status) {
            showToast('Kode verifikasi telah dikirim ke email Anda', 'success');
            showStep(2);
        } else {
            throw new Error(data.message || 'Gagal mengirim kode verifikasi');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast(error.message || 'Gagal mengirim kode verifikasi', 'error');
    } finally {
        sendOtpBtn.disabled = false;
        sendOtpBtn.innerHTML = originalText;
        sendOtpBtn.classList.add('bg-primary', 'hover:bg-primary/90');
        sendOtpBtn.classList.remove('bg-gray-400');
    }
}

// Verify OTP Manual
window.verifyOtpManual = async function() {
    const otp = collectOtp();
    const email = document.getElementById('emailInput').value;
    const verifyBtn = document.getElementById('verifyOtpBtn');
    const otpStatus = document.getElementById('otpStatus');

    if (!otp || otp.length !== 6) {
        showToast('Kode verifikasi harus 6 digit', 'error');
        return;
    }

    if (!email) {
        showToast('Email wajib diisi', 'error');
        return;
    }

    const originalText = verifyBtn.innerHTML;

    verifyBtn.disabled = true;
    verifyBtn.innerHTML = '<div class="mx-auto spinner"></div>';
    verifyBtn.classList.remove('bg-secondary', 'hover:bg-secondary/90');
    verifyBtn.classList.add('bg-gray-400');

    try {
        const response = await fetch(window.routes.verifyOtp, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": getCsrfToken(),
                "Accept": "application/json"
            },
            body: JSON.stringify({
                email: email,
                otp: otp
            })
        });

        const data = await response.json();

        if (response.ok && data.status) {
            showToast('Email berhasil diverifikasi!', 'success');

            emailVerified = true;

            otpStatus.innerHTML =
                '<span class="font-medium text-green-600"><i class="mr-1 fas fa-check"></i>Email terverifikasi</span>';

            document.querySelectorAll('.otp-input').forEach(input => {
                input.disabled = true;
                input.classList.add('opacity-50', 'bg-gray-100');
            });

            verifyBtn.disabled = true;
            verifyBtn.innerHTML = '<i class="mr-1 fas fa-check"></i>Terverifikasi';
            verifyBtn.classList.remove('bg-gray-400');
            verifyBtn.classList.add('bg-green-500', 'hover:bg-green-500', 'cursor-default');

            if (resendTimer) clearInterval(resendTimer);

            setTimeout(() => {
                showStep(3);
            }, 1000);
        } else {
            throw new Error(data.message || 'Kode verifikasi tidak valid');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast(error.message || 'Kode verifikasi tidak valid', 'error');

        otpStatus.innerHTML =
            '<span class="text-red-600"><i class="mr-1 fas fa-times"></i>Kode tidak valid</span>';
    } finally {
        if (!emailVerified) {
            verifyBtn.innerHTML = originalText;
            verifyBtn.disabled = false;
            verifyBtn.classList.add('bg-secondary', 'hover:bg-secondary/90');
            verifyBtn.classList.remove('bg-gray-400');
        }
    }
}

// Resend OTP
window.resendOtp = async function() {
    const email = document.getElementById('emailInput').value;
    const resendBtn = document.getElementById('resendOtpBtn');

    if (!email) {
        showToast('Email wajib diisi', 'error');
        return;
    }

    const originalText = resendBtn.innerHTML;

    resendBtn.disabled = true;
    resendBtn.innerHTML = '<div class="mx-auto spinner"></div>';
    resendBtn.classList.add('opacity-50');

    showToast('Mengirim ulang kode verifikasi...', 'info');

    try {
        const response = await fetch(window.routes.sendOtp, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": getCsrfToken(),
                "Accept": "application/json"
            },
            body: JSON.stringify({ email: email })
        });

        const data = await response.json();

        if (response.ok && data.status) {
            showToast('Kode verifikasi baru telah dikirim', 'success');

            document.querySelectorAll('.otp-input').forEach(input => {
                input.value = '';
                input.disabled = false;
                input.classList.remove('opacity-50', 'bg-gray-100');
            });

            document.getElementById('otpHidden').value = '';

            const verifyBtn = document.getElementById('verifyOtpBtn');
            verifyBtn.disabled = true;
            verifyBtn.innerHTML = 'Verifikasi';
            verifyBtn.classList.remove('bg-green-500', 'cursor-default');
            verifyBtn.classList.add('bg-secondary', 'hover:bg-secondary/90');

            document.getElementById('otpStatus').innerHTML = '';

            setupOtpInputs();
            startResendTimer();
        } else {
            throw new Error(data.message || 'Gagal mengirim kode verifikasi');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast(error.message || 'Gagal mengirim kode verifikasi ulang', 'error');
    } finally {
        resendBtn.disabled = false;
        resendBtn.innerHTML = originalText;
        resendBtn.classList.remove('opacity-50');
    }
}

// Resend Timer
function startResendTimer() {
    const resendBtn = document.getElementById('resendOtpBtn');
    let countdown = 30;

    resendBtn.disabled = true;
    resendBtn.innerHTML = `<i class="mr-1 fas fa-clock"></i>${countdown}s`;
    resendBtn.classList.add('opacity-50', 'cursor-not-allowed');

    if (resendTimer) clearInterval(resendTimer);

    resendTimer = setInterval(() => {
        countdown--;
        resendBtn.innerHTML = `<i class="mr-1 fas fa-clock"></i>${countdown}s`;

        if (countdown <= 0) {
            clearInterval(resendTimer);
            resendBtn.disabled = false;
            resendBtn.innerHTML = '<i class="mr-1 fas fa-redo"></i>Ulangi';
            resendBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }, 1000);
}

// Password Strength
window.checkRegisterPassword = function() {
    const password = document.getElementById('registerPassword').value;
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');

    const strength = checkPasswordStrength(password);

    const percentages = [0, 25, 50, 75, 100];
    const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-400', 'bg-green-600'];
    const texts = ['Sangat Lemah', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];

    strengthBar.style.width = `${percentages[strength]}%`;
    strengthBar.className = `h-full ${colors[strength]} transition-all duration-300`;
    strengthText.textContent = texts[strength];
    strengthText.className =
        `text-xs font-medium ${strength >= 3 ? 'text-green-600' : strength >= 2 ? 'text-yellow-600' : 'text-red-600'}`;

    checkPasswordMatch();
}

// Password Match
window.checkPasswordMatch = function() {
    const password = document.getElementById('registerPassword').value;
    const confirm = document.getElementById('registerPasswordConfirm').value;
    const matchDiv = document.getElementById('passwordMatch');
    const registerBtn = document.getElementById('registerBtn');

    if (!password || !confirm) {
        matchDiv.innerHTML = '';
        registerBtn.disabled = true;
        return;
    }

    if (password === confirm && password.length >= 6) {
        matchDiv.innerHTML = '<span class="text-green-600"><i class="mr-1 fas fa-check"></i>Password cocok</span>';

        registerBtn.disabled = !emailVerified;
        if (!registerBtn.disabled) {
            registerBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    } else {
        matchDiv.innerHTML =
            '<span class="text-red-600"><i class="mr-1 fas fa-times"></i>Password tidak cocok</span>';

        registerBtn.disabled = true;
        registerBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
}

// Toggle Password
window.togglePassword = function(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function checkPasswordStrength(password) {
    let score = 0;
    if (!password) return 0;

    if (password.length >= 8) score++;
    if (password.length >= 12) score++;

    if (/[a-z]/.test(password)) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;

    return Math.min(score, 4);
}

// Toast Notification
window.showToast = function(message, type = 'info') {
    const existingToast = document.querySelector('.custom-toast');
    if (existingToast) existingToast.remove();

    const toast = document.createElement('div');
    toast.className =
        `custom-toast fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-white animate-fade-in ${type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'}`;
    toast.innerHTML = `
    <div class="flex items-center">
        <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'} mr-2"></i>
        <span>${message}</span>
    </div>
`;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('animate-fade-out');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    setupOtpInputs();

    if (window.authConfig && window.authConfig.hasRegisterErrors) {
        showRegister();
        const email = document.getElementById('emailInput').value;
        if (email) {
            showStep(2);
        }
    }

    const firstInput = document.querySelector('input:not([type="hidden"])');
    if (firstInput && !firstInput.value) {
        setTimeout(() => firstInput.focus(), 300);
    }
});
