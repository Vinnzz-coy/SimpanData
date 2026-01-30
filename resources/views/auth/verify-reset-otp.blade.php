@extends('layouts.auth')

@section('title', 'Verifikasi OTP')

@section('content')
<div class="w-full max-w-md animate-fade-in-up">
    <div class="p-8 bg-white border-2 border-gray-300 shadow-lg rounded-xl glass shadow-gray-500">
        <div class="mb-6 text-center">
            <div class="inline-flex items-center justify-center mb-4 rounded-full w-14 h-14 bg-primary-light">
                <i class="text-xl fas fa-shield-alt text-primary"></i>
            </div>
            <h1 class="mb-2 text-2xl font-bold text-gray-900">Verifikasi OTP</h1>
            <p class="text-gray-600">
                Masukkan 6 digit kode OTP yang dikirim ke email
                <span class="font-semibold text-primary">
                    {{ session('reset_email') ? session('reset_email') : 'Anda' }}
                </span>
            </p>
        </div>

        @if (session('error'))
            <div class="p-4 mb-6 text-red-700 border border-red-200 rounded-lg bg-red-50 animate-fade-in">
                <div class="flex items-center">
                    <i class="mr-2 fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-6 text-red-700 border border-red-200 rounded-lg bg-red-50 animate-fade-in">
                <ul class="space-y-1 text-sm list-disc list-inside">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="otpForm" method="POST" action="{{ route('verify.reset.otp.post') }}" class="space-y-5">
            @csrf

            <div class="mb-5">
                <div class="flex justify-center gap-2 mb-6">
                    <input class="otp-input" maxlength="1">
                    <input class="otp-input" maxlength="1">
                    <input class="otp-input" maxlength="1">
                    <input class="otp-input" maxlength="1">
                    <input class="otp-input" maxlength="1">
                    <input class="otp-input" maxlength="1">
                </div>

                <input type="hidden" name="otp" id="otpHidden">
            </div>

            <button type="submit"
                    id="verifyBtn"
                    disabled
                    class="w-full py-3 font-medium text-white transition-shadow duration-200 rounded-lg shadow-sm bg-primary hover:bg-primary/90 active:bg-primary/80 btn-transition focus:outline-none focus:ring-2 focus:ring-primary-light hover:shadow disabled:opacity-50 disabled:cursor-not-allowed">
                Verifikasi OTP
            </button>

            <div class="pt-4 text-center">
                <div class="mb-2">
                    <span id="countdownText" class="text-sm text-gray-600">Kirim ulang OTP dalam 60 detik</span>
                </div>
                <button id="resendBtn"
                        onclick="resendOtp()"
                        disabled
                        class="px-4 py-2 text-sm border rounded-lg text-primary border-primary hover:bg-primary/5 btn-transition disabled:opacity-50 disabled:cursor-not-allowed">
                    Kirim ulang OTP
                </button>
            </div>

            <div class="pt-4 text-center border-t border-gray-100">
                <p class="text-sm text-gray-600">
                    Salah email?
                    <a href="{{ route('forgot.password.form') }}"
                        class="ml-1 font-medium transition-colors text-primary hover:text-primary/80">
                        Kembali
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

    <footer>
        <p style="color:#999; font-size:12px; margin:0;">
            © {{ date('Y') }} SimpanData. All rights reserved.
        </p>
    </footer>
@endsection

@section('scripts')
<script>
function showToast(message, type = 'info') {
    const existingToast = document.querySelector('.custom-toast');
    if (existingToast) existingToast.remove();

    const toast = document.createElement('div');
    toast.className = `custom-toast fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-white animate-fade-in ${type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'}`;
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

function setupOtpInputs() {
    const inputs = document.querySelectorAll('.otp-input');

    inputs.forEach((input, index) => {
        input.className = 'otp-input w-10 h-10 text-center text-lg font-bold border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary-light transition-all duration-200';
        input.type = 'text';
        input.inputMode = 'numeric';

        input.addEventListener('input', (e) => {
            input.value = input.value.replace(/[^0-9]/g, '');

            if (input.value && inputs[index + 1]) {
                inputs[index + 1].focus();
            }

            if (typeof window.collectOtp === 'function') {
                window.collectOtp();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && inputs[index - 1]) {
                e.preventDefault();
                inputs[index - 1].focus();
                inputs[index - 1].value = '';

                if (typeof window.collectOtp === 'function') {
                    window.collectOtp();
                }
            }
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasteData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');

            if (pasteData.length === 6) {
                pasteData.split('').forEach((char, idx) => {
                    if (inputs[idx]) {
                        inputs[idx].value = char;
                    }
                });

                if (typeof window.collectOtp === 'function') {
                    window.collectOtp();
                }

                inputs[5].focus();
            }
        });
    });

    if (inputs[0]) {
        setTimeout(() => inputs[0].focus(), 100);
    }
}

const inputs = document.querySelectorAll('.otp-input');
const hiddenInput = document.getElementById('otpHidden');
const verifyBtn = document.getElementById('verifyBtn');
const resendBtn = document.getElementById('resendBtn');
const countdownText = document.getElementById('countdownText');
let countdown = 60;
let timer = null;

setupOtpInputs();

window.collectOtp = function() {
    let otp = '';
    inputs.forEach(i => otp += i.value);
    hiddenInput.value = otp;

    verifyBtn.disabled = otp.length !== 6;
    return otp.length === 6 ? otp : null;
}

function startCountdown() {
    resendBtn.disabled = true;
    countdown = 60;

    updateCountdownText();

    timer = setInterval(() => {
        countdown--;
        updateCountdownText();

        if (countdown <= 0) {
            clearInterval(timer);
            countdownText.innerText = 'Tidak menerima OTP?';
            resendBtn.disabled = false;
        }
    }, 1000);
}

function updateCountdownText() {
    countdownText.innerText = `Kirim ulang OTP dalam ${countdown} detik`;
}

async function resendOtp() {
    resendBtn.disabled = true;
    resendBtn.innerHTML = '<div class="mx-auto spinner"></div>';
    showToast('Mengirim ulang OTP...', 'info');

    try {
        const response = await fetch("{{ route('send.reset.otp') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                _token: "{{ csrf_token() }}"
            })
        });

        const data = await response.json();

        if (response.ok && data.status) {
            showToast(data.message, 'success');

            inputs.forEach(input => input.value = '');
            hiddenInput.value = '';
            verifyBtn.disabled = true;

            clearInterval(timer);
            startCountdown();
        } else {
            throw new Error(data.message || 'Gagal mengirim OTP');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast(error.message || 'Gagal mengirim OTP ulang', 'error');
        resendBtn.disabled = false;
        resendBtn.innerHTML = 'Kirim ulang OTP';
    }
}

document.getElementById('otpForm').addEventListener('submit', function(e) {
    const otp = collectOtp();
    if (!otp) {
        e.preventDefault();
        showToast('Harap isi semua digit OTP', 'error');
        return;
    }

    verifyBtn.disabled = true;
    verifyBtn.innerHTML = '<div class="mx-auto spinner"></div>';
});

document.addEventListener('DOMContentLoaded', function() {
    startCountdown();
});
</script>
@endsection
