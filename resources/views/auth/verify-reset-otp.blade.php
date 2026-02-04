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

    <footer class="mt-8 text-center text-gray-400">
        <p class="text-xs">
            © {{ date('Y') }} SimpanData. All rights reserved.
        </p>
    </footer>
</div>
@endsection

@section('scripts')
    <script>
        window.routes = {
            resendOtp: "{{ route('send.reset.otp') }}"
        };
    </script>
    @vite(['resources/js/auth/verify-reset-otp.js'])
@endsection
