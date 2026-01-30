@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
<div class="w-full max-w-md animate-fade-in-up">
    <div class="p-8 bg-white border-2 border-gray-300 shadow-lg rounded-xl glass shadow-gray-500">
        <div class="mb-6 text-center">
            <div class="inline-flex items-center justify-center mb-4 rounded-full w-14 h-14 bg-primary-light">
                <i class="text-xl fas fa-key text-primary"></i>
            </div>
            <h1 class="mb-2 text-2xl font-bold text-gray-900">Lupa Password</h1>
            <p class="text-gray-600">
                Masukkan email akunmu. Kami akan mengirimkan kode OTP
                untuk verifikasi reset password.
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

        @if (session('success'))
            <div class="p-4 mb-6 text-green-700 border border-green-200 rounded-lg bg-green-50 animate-fade-in">
                <div class="flex items-center">
                    <i class="mr-2 fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-6 text-red-700 border border-red-200 rounded-lg bg-red-50 animate-fade-in">
                <div class="flex items-center mb-2">
                    <i class="mr-2 fas fa-exclamation-circle"></i>
                    <span class="font-medium">Perhatian</span>
                </div>
                <ul class="space-y-1 text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="forgotForm" class="space-y-5">
            @csrf

            <div class="space-y-2">
                <label for="emailInput" class="block text-sm font-medium text-gray-700">
                    Email Terdaftar
                </label>
                <input type="email"
                        id="emailInput"
                        name="email"
                        placeholder="contoh@gmail.com"
                        class="w-full px-4 py-3 transition duration-200 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-light hover:border-gray-400"
                        required
                        autocomplete="email"
                        value="{{ old('email') }}">
                <div id="emailStatus" class="mt-1 text-sm min-h-[20px]"></div>
            </div>

            <button type="submit"
                    id="submitBtn"
                    disabled
                    class="w-full py-3 font-medium text-white transition-shadow duration-200 rounded-lg shadow-sm bg-primary hover:bg-primary/90 active:bg-primary/80 btn-transition focus:outline-none focus:ring-2 focus:ring-primary-light hover:shadow disabled:opacity-50 disabled:cursor-not-allowed">
                Kirim Kode Verifikasi
            </button>
        </form>

        <div class="pt-6 mt-8 text-center border-t border-gray-100">
            <p class="text-sm text-gray-600">
                Ingat password?
                <a href="{{ route('auth') }}" class="ml-1 font-medium transition-colors text-primary hover:text-primary/80">
                    Kembali ke Login
                </a>
            </p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
    const emailInput = document.getElementById('emailInput');
    const submitBtn = document.getElementById('submitBtn');
    const forgotForm = document.getElementById('forgotForm');
    const emailStatus = document.getElementById('emailStatus');
    const csrfToken = "{{ csrf_token() }}";

    let emailValid = false;

    emailInput.addEventListener('blur', validateEmail);

    async function validateEmail() {
        const email = emailInput.value.trim();

        if (!email) {
            updateEmailStatus('invalid', '');
            emailValid = false;
            updateSubmitButton();
            return;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            updateEmailStatus('invalid', 'Format email tidak valid');
            emailValid = false;
            updateSubmitButton();
            return;
        }

        updateEmailStatus('checking', 'Memeriksa email...');

        try {
            const response = await fetch("{{ route('check.email') }}", {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ email })
            });

            const data = await response.json();

            if (data.status) {
                updateEmailStatus('valid', '✓ Email terdaftar');
                emailValid = true;
                updateSubmitButton();
                showToast('Email terdaftar, OTP siap dikirim', 'success');
            } else {
                updateEmailStatus('invalid', '✗ ' + data.message);
                emailValid = false;
                updateSubmitButton();
                showToast(data.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            updateEmailStatus('invalid', 'Gagal memeriksa email');
            emailValid = false;
            updateSubmitButton();
            showToast('Gagal memeriksa email. Coba lagi.', 'error');
        }
    }

    function updateEmailStatus(status, message) {
        emailStatus.innerHTML = message;

        switch(status) {
            case 'valid':
                emailStatus.className = 'text-sm text-green-600 font-medium';
                break;
            case 'invalid':
                emailStatus.className = 'text-sm text-red-600';
                break;
            case 'checking':
                emailStatus.className = 'text-sm text-blue-600';
                break;
            default:
                emailStatus.className = 'text-sm text-gray-500';
        }
    }

    function updateSubmitButton() {
        if (emailValid) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    forgotForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = emailInput.value.trim();

        if (!email) {
            showToast('Email wajib diisi', 'error');
            return;
        }

        if (!emailValid) {
            showToast('Email belum tervalidasi', 'error');
            return;
        }

        const originalText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<div class="mx-auto spinner"></div>';
        submitBtn.classList.remove('bg-primary', 'hover:bg-primary/90');
        submitBtn.classList.add('bg-gray-400');

        try {
            const formData = new FormData();
            formData.append('email', email);
            formData.append('_token', csrfToken);

            const response = await fetch("{{ route('forgot.password.post') }}", {
                method: "POST",
                body: formData
            });

            const data = await response.json();

            if (response.ok && data.status) {
                showToast(data.message, 'success');

                setTimeout(() => {
                    window.location.href = "{{ route('verify.reset.otp') }}";
                }, 1500);
            } else {
                throw new Error(data.message || 'Gagal mengirim OTP');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast(error.message || 'Gagal mengirim OTP', 'error');

            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            submitBtn.classList.add('bg-primary', 'hover:bg-primary/90');
            submitBtn.classList.remove('bg-gray-400');
        }
    });

    emailInput.addEventListener('input', () => {
        if (emailValid) {
            emailValid = false;
            updateSubmitButton();
            updateEmailStatus('invalid', '');
        }
    });


    emailInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault()
            validateEmail()
        }
    })

    document.addEventListener('DOMContentLoaded', function() {
        if (emailInput && !emailInput.value) {
            setTimeout(() => emailInput.focus(), 300);
        }

        if (emailInput.value) {
            validateEmail();
        }
    });
    </script>
@endsection
