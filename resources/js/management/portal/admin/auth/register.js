// Admin Register JavaScript
window.togglePasswordVisibility = function(fieldId) {
    const field = document.getElementById(fieldId);
    if (!field) return;

    const iconPrefix = fieldId === 'password' ? 'passwordEye' : 'confirmPasswordEye';
    const isPassword = field.type === 'password';

    field.type = isPassword ? 'text' : 'password';

    // Toggle eye icons
    document.getElementById(`${iconPrefix}Open`)?.classList.toggle('hidden', !isPassword);
    document.getElementById(`${iconPrefix}Pupil`)?.classList.toggle('hidden', !isPassword);
    document.getElementById(`${iconPrefix}Closed`)?.classList.toggle('hidden', isPassword);
};

// Password strength checker
function checkPasswordStrength(password) {
    let strength = 0;
    const checks = {
        length: password.length >= 8,
        lowercase: /[a-z]/.test(password),
        uppercase: /[A-Z]/.test(password),
        numbers: /\d/.test(password),
        special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
    };

    strength = Object.values(checks).filter(Boolean).length;

    return {
        score: strength,
        level: strength < 3 ? 'weak' : strength < 5 ? 'medium' : 'strong',
        checks
    };
}

function updatePasswordStrength() {
    const password = document.getElementById('password')?.value || '';
    const strengthBar = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('strengthText');
    
    if (!strengthBar || !strengthText) return;

    const result = checkPasswordStrength(password);
    
    // Update strength bar
    strengthBar.className = `password-strength w-full strength-${result.level}`;
    
    // Update strength text
    const levels = { weak: 'Weak', medium: 'Medium', strong: 'Strong' };
    strengthText.textContent = password ? levels[result.level] : '';
    strengthText.className = `text-sm mt-1 ${
        result.level === 'weak' ? 'text-red-500' : 
        result.level === 'medium' ? 'text-yellow-500' : 'text-green-500'
    }`;
}

// Admin register form handling
async function handleAdminRegisterSubmit(form) {
    // Reset UI
    document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));
    document.getElementById('errorToast')?.classList.add('hidden');

    // Validate fields
    const errors = validateAdminRegisterFields();
    if (errors.length) {
        showFieldErrors(errors);
        return false;
    }

    // Show loading state
    toggleLoadingState(true);

    try {
        const response = await submitAdminForm(form);
        handleAdminRegisterResponse(response);
    } catch (error) {
        handleAdminRegisterError(error);
    } finally {
        toggleLoadingState(false);
    }
}

function validateAdminRegisterFields() {
    const errors = [];
    const fields = {
        name: {
            value: document.getElementById('name')?.value.trim(),
            required: true,
            validate: (name) => name.length >= 2
        },
        email: {
            value: document.getElementById('email')?.value.trim(),
            required: true,
            validate: (email) => /^\S+@\S+\.\S+$/.test(email)
        },
        password: {
            value: document.getElementById('password')?.value,
            required: true,
            validate: (password) => {
                const strength = checkPasswordStrength(password);
                return strength.score >= 3; // At least medium strength
            }
        },
        password_confirmation: {
            value: document.getElementById('password_confirmation')?.value,
            required: true,
            validate: (confirm) => confirm === document.getElementById('password')?.value
        }
    };

    Object.entries(fields).forEach(([field, config]) => {
        if (config.required && !config.value) {
            errors.push({ field, message: 'This field is required' });
        } else if (config.validate && !config.validate(config.value)) {
            errors.push({ field, message: getValidationMessage(field) });
        }
    });

    return errors;
}

function getValidationMessage(field) {
    const messages = {
        name: 'Name must be at least 2 characters',
        email: 'Please enter a valid email',
        password: 'Password must be at least medium strength',
        password_confirmation: 'Passwords do not match'
    };
    return messages[field] || 'Invalid value';
}

function showFieldErrors(errors) {
    errors.forEach(({ field, message }) => {
        const errorElement = document.getElementById(`${field}Error`);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
        }
    });
    showError('Please correct the highlighted errors');
}

async function submitAdminForm(form) {
    const response = await fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    });

    if (!response.ok) {
        const error = await response.json();
        throw error;
    }

    return response;
}

function handleAdminRegisterResponse(response) {
    if (response.redirected) {
        window.location.href = response.url;
    } else {
        response.json().then(data => {
            window.location.href = data.redirect || "/management/portal/admin/dashboard";
        });
    }
}

function handleAdminRegisterError(error) {
    console.error('Admin register error:', error);

    if (error.errors) {
        Object.entries(error.errors).forEach(([field, messages]) => {
            const errorElement = document.getElementById(`${field}Error`);
            if (errorElement) {
                errorElement.textContent = Array.isArray(messages) ? messages.join(' ') : messages;
                errorElement.classList.remove('hidden');
            }
        });
        showError('Please correct the highlighted errors');
    } else {
        showError(error.message || 'An unexpected error occurred. Please try again.');
    }
}

function toggleLoadingState(isLoading) {
    document.getElementById('spinner')?.classList.toggle('hidden', !isLoading);
    const buttonText = document.getElementById('buttonText');
    if (buttonText) buttonText.textContent = isLoading ? 'Creating Account...' : 'Create Admin Account';
    document.getElementById('registerBtn').disabled = isLoading;
}

function showError(message) {
    const toast = document.getElementById('errorToast');
    if (!toast) return;

    toast.textContent = message;
    toast.classList.remove('hidden');
    toast.classList.add('slide-down');

    setTimeout(() => {
        toast.classList.remove('slide-down');
        toast.classList.add('hidden');
    }, 5000);
}

// Initialize admin register
document.addEventListener('DOMContentLoaded', () => {
    const adminRegisterForm = document.getElementById('adminRegisterForm');
    if (adminRegisterForm) {
        adminRegisterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            handleAdminRegisterSubmit(adminRegisterForm);
        });
    }

    // Password strength monitoring
    const passwordField = document.getElementById('password');
    if (passwordField) {
        passwordField.addEventListener('input', updatePasswordStrength);
    }
});