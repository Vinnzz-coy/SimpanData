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
};

function checkPasswordStrength(password) {
    let score = 0;
    if (!password) return 0;

    if (password.length >= 8) score++;
    if (password.length >= 12) score++;

    if (/[a-z]/.test(password)) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;

    // Max score is 4, but we have 6 criteria. Let's normalize to 4.
    return Math.min(Math.floor(score * 4 / 6) + 1, 4);
}

// Improved version based on score count
function calculateStrengthScore(password) {
    let score = 0;
    if (!password) return 0;

    if (password.length >= 6) score++; // Minimum
    if (password.length >= 10) score++; // Length bonus
    if (/[a-z]/.test(password)) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;

    // 0-1: Sangat Lemah
    // 2: Lemah
    // 3-4: Cukup
    // 5: Kuat
    // 6: Sangat Kuat
    if (score <= 2) return 1;
    if (score === 3) return 2;
    if (score === 4) return 3;
    if (score >= 5) return 4;
    return 0;
}

window.updatePasswordStrengthView = function() {
    const password = document.getElementById('newPassword').value;
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');

    if (!password) {
        strengthBar.style.width = '0%';
        strengthBar.className = 'w-0 h-full transition-all duration-300 bg-gray-200';
        strengthText.textContent = '-';
        strengthText.className = 'text-xs font-medium text-gray-600';
        checkPasswordMatch();
        return;
    }

    const strength = calculateStrengthScore(password);

    const percentages = [0, 25, 50, 75, 100];
    const colors = ['bg-gray-200', 'bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500'];
    const texts = ['-', 'Sangat Lemah', 'Lemah', 'Cukup', 'Kuat & Aman'];

    strengthBar.style.width = `${percentages[strength]}%`;
    strengthBar.className = `h-full ${colors[strength]} transition-all duration-300`;
    strengthText.textContent = texts[strength];
    strengthText.className = `text-xs font-medium ${strength >= 3 ? 'text-green-600' : strength >= 2 ? 'text-yellow-600' : 'text-red-600'}`;

    checkPasswordMatch();
};

window.checkPasswordMatch = function() {
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
        matchDiv.innerHTML = '<span class="text-green-600 font-medium"><i class="mr-1 fas fa-check"></i>Password cocok</span>';
        submitBtn.disabled = false;
    } else if (password === confirm) {
        matchDiv.innerHTML = '<span class="text-red-600">Minimal 6 karakter</span>';
        submitBtn.disabled = true;
    } else {
        matchDiv.innerHTML = '<span class="text-red-600"><i class="mr-1 fas fa-times"></i>Password tidak cocok</span>';
        submitBtn.disabled = true;
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const resetForm = document.getElementById('resetForm');
    const newPassword = document.getElementById('newPassword');

    if (newPassword) {
        setTimeout(() => newPassword.focus(), 300);
        newPassword.addEventListener('input', updatePasswordStrengthView);
    }

    const confirmPassword = document.getElementById('confirmPassword');
    if (confirmPassword) {
        confirmPassword.addEventListener('input', checkPasswordMatch);
    }

    if (resetForm) {
        resetForm.addEventListener('submit', function(e) {
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
    }

    // Initial check
    updatePasswordStrengthView();
});
