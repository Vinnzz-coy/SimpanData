@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="w-full max-w-md animate-fade-in-up">
    <div class="p-8 bg-white border-2 border-gray-300 shadow-lg rounded-xl glass shadow-gray-500">
        <div class="mb-6 text-center">
            <div class="inline-flex items-center justify-center mb-4 rounded-full w-14 h-14 bg-primary-light">
                <i class="text-xl fas fa-lock text-primary"></i>
            </div>
            <h1 class="mb-2 text-2xl font-bold text-gray-900">Reset Password</h1>
            <p class="text-gray-600">
                Buat password baru untuk akun
                <span class="font-semibold text-primary">{{ session('reset_email') }}</span>
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

        <form method="POST" action="{{ route('reset.password') }}" id="resetForm" class="space-y-5">
            @csrf

            <div class="space-y-2">
                <label for="newPassword" class="block text-sm font-medium text-gray-700">
                    Password Baru
                </label>
                <div class="relative">
                    <input type="password"
                            id="newPassword"
                            name="password"
                            placeholder="••••••••"
                            class="w-full px-4 py-3 pr-10 transition duration-200 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-light hover:border-gray-400"
                            required
                            minlength="6"
                            autocomplete="new-password"
                            oninput="checkPasswordStrength()">
                    <button type="button"
                            onclick="togglePassword('newPassword', this)"
                            class="absolute text-gray-400 transition-colors transform -translate-y-1/2 right-3 top-1/2 hover:text-gray-600">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <div id="passwordStrength" class="mt-3">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs text-gray-600">Kekuatan password:</span>
                        <span id="strengthText" class="text-xs font-medium">-</span>
                    </div>
                    <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                        <div id="strengthBar" class="w-0 h-full transition-all duration-300"></div>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label for="confirmPassword" class="block text-sm font-medium text-gray-700">
                    Konfirmasi Password
                </label>
                <div class="relative">
                    <input type="password"
                            id="confirmPassword"
                            name="password_confirmation"
                            placeholder="••••••••"
                            class="w-full px-4 py-3 pr-10 transition duration-200 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-light hover:border-gray-400"
                            required
                            minlength="6"
                            autocomplete="new-password"
                            oninput="checkPasswordMatch()">
                    <button type="button"
                            onclick="togglePassword('confirmPassword', this)"
                            class="absolute text-gray-400 transition-colors transform -translate-y-1/2 right-3 top-1/2 hover:text-gray-600">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div id="passwordMatch" class="mt-1 text-sm min-h-[20px]"></div>
            </div>

            <button type="submit"
                    id="submitBtn"
                    class="w-full py-3 font-medium text-white transition-shadow duration-200 rounded-lg shadow-sm bg-primary hover:bg-primary/90 active:bg-primary/80 btn-transition focus:outline-none focus:ring-2 focus:ring-primary-light hover:shadow disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                Reset Password
            </button>

            <div class="pt-4 text-center">
                <p class="text-sm text-gray-600">
                    Ingat password?
                    <a href="{{ route('auth') }}"
                        class="ml-1 font-medium transition-colors text-primary hover:text-primary/80">
                        Kembali ke Login
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function togglePassword(inputId, button) {
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

function updatePasswordStrength() {
    const password = document.getElementById('newPassword').value;
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');

    const strength = checkPasswordStrength(password);

    const percentages = [0, 25, 50, 75, 100];
    const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-400', 'bg-green-600'];
    const texts = ['Sangat Lemah', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];

    strengthBar.style.width = `${percentages[strength]}%`;
    strengthBar.className = `h-full ${colors[strength]} transition-all duration-300`;
    strengthText.textContent = texts[strength];
    strengthText.className = `text-xs font-medium ${strength >= 3 ? 'text-green-600' : strength >= 2 ? 'text-yellow-600' : 'text-red-600'}`;

    checkPasswordMatch();
}

function checkPasswordMatch() {
    const password = document.getElementById('newPassword').value;
    const confirm = document.getElementById('confirmPassword').value;
    const matchDiv = document.getElementById('passwordMatch');
    const submitBtn = document.getElementById('submitBtn');

    if (!password || !confirm) {
        matchDiv.innerHTML = '';
        submitBtn.disabled = true;
        return;
    }

    if (password === confirm && password.length >= 6) {
        matchDiv.innerHTML = '<span class="text-green-600"><i class="mr-1 fas fa-check"></i>Password cocok</span>';
        submitBtn.disabled = false;
    } else {
        matchDiv.innerHTML = '<span class="text-red-600"><i class="mr-1 fas fa-times"></i>Password tidak cocok</span>';
        submitBtn.disabled = true;
    }
}

document.getElementById('resetForm').addEventListener('submit', function(e) {
    const password = document.getElementById('newPassword').value;
    const confirm = document.getElementById('confirmPassword').value;

    if (password !== confirm) {
        e.preventDefault();
        showToast('Password dan konfirmasi password tidak cocok!', 'error');
        return;
    }

    if (password.length < 6) {
        e.preventDefault();
        showToast('Password minimal 6 karakter!', 'error');
        return;
    }

    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<div class="mx-auto spinner"></div>';
    submitBtn.classList.remove('bg-primary', 'hover:bg-primary/90', 'shadow-sm', 'hover:shadow');
    submitBtn.classList.add('bg-gray-400');
});

document.addEventListener('DOMContentLoaded', function() {
    updatePasswordStrength();
    checkPasswordMatch();

    const newPassword = document.getElementById('newPassword');
    if (newPassword) {
        setTimeout(() => newPassword.focus(), 300);
    }
});
</script>
@endsection
