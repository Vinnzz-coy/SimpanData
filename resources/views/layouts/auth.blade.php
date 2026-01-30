<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Auth')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .otp-ready {
            width: 2.5rem;
            height: 2.5rem;
            text-align: center;
            font-size: 1.125rem;
            font-weight: 700;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }
        .focus-primary:focus {
            outline: none;
            border-color: #10367D;
            box-shadow: 0 0 0 3px rgba(16, 54, 125, 0.1);
        }
        .btn-transition {
            transition: all 0.2s ease-in-out;
        }
        .spinner {
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .shadow-soft {
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10367D',
                        secondary: '#FF6B35',
                        accent: '#A5CE00',
                        light: '#EBEBEB',
                        'primary-light': 'rgba(16, 54, 125, 0.1)',
                        'secondary-light': 'rgba(255, 107, 53, 0.1)',
                        'accent-light': 'rgba(165, 206, 0, 0.1)'
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif']
                    },
                    borderRadius: {
                        'xl': '1rem',
                        '2xl': '1.5rem'
                    }
                }
            }
        }
    </script>
</head>
<body class="relative flex items-center justify-center min-h-screen p-4 overflow-hidden font-sans">

    <div class="fixed inset-0 z-0">
        <div
            class="absolute inset-0 scale-105 bg-center bg-no-repeat bg-cover"
            style="background-image: url('{{ asset('storage/background/background.webp') }}');">
        </div>

        <div class="absolute inset-0 backdrop-blur-md bg-white/5"></div>
    </div>

    <div id="toastContainer" class="fixed z-50 max-w-full space-y-3 top-5 right-5 w-80"></div>

    @yield('content')

    <script>
        function showToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');

            const icons = {
                success: '✓',
                error: '✗',
                warning: '⚠',
                info: 'ℹ'
            };

            const colors = {
                success: 'bg-green-600',
                error: 'bg-red-600',
                warning: 'bg-yellow-600',
                info: 'bg-primary'
            };

            toast.className = `${colors[type]} text-white p-4 rounded-xl shadow-lg animate-fade-in-up flex items-center justify-between glass`;
            toast.innerHTML = `
                <div class="flex items-center">
                    <span class="mr-3 font-bold">${icons[type]}</span>
                    <span class="text-sm">${message}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                if (toast.parentElement) {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(20px)';
                    toast.style.transition = 'all 0.3s ease';

                    setTimeout(() => {
                        if (toast.parentElement) toast.remove();
                    }, 300);
                }
            }, 3500);
        }

        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        function setupOtpInputs() {
            const otpInputs = document.querySelectorAll('.otp-input');

            otpInputs.forEach((input, index) => {
                input.className = 'otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:border-secondary focus:ring-2 focus:ring-secondary-light transition-all duration-200';
                input.inputMode = 'numeric';
                input.type = 'text';

                input.addEventListener('input', (e) => {
                    input.value = input.value.replace(/[^0-9]/g, '');

                    if (input.value && otpInputs[index + 1]) {
                        otpInputs[index + 1].focus();
                    }

                    if (typeof window.collectOtp === 'function') {
                        window.collectOtp();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !input.value && otpInputs[index - 1]) {
                        e.preventDefault();
                        otpInputs[index - 1].focus();
                        otpInputs[index - 1].value = '';

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
                            if (otpInputs[idx]) {
                                otpInputs[idx].value = char;
                            }
                        });

                        if (typeof window.collectOtp === 'function') {
                            window.collectOtp();
                        }

                        otpInputs[5].focus();
                    }
                });
            });

            if (otpInputs[0]) {
                setTimeout(() => otpInputs[0].focus(), 100);
            }
        }

        function checkPasswordStrength(password) {
            let strength = 0;

            if (password.length >= 6) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            return strength;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const interactiveElements = document.querySelectorAll('button, input, a');
            interactiveElements.forEach(el => {
                el.classList.add('transition-colors', 'duration-200');
            });

            const firstInput = document.querySelector('input:not([type="hidden"])');
            if (firstInput && !firstInput.value) {
                setTimeout(() => firstInput.focus(), 500);
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
