// Admin Login JavaScript
window.togglePasswordVisibility = function(fieldId) {
    const field = document.getElementById(fieldId);
    if (!field) return;

    const iconPrefix = 'passwordEye';
    const isPassword = field.type === 'password';

    field.type = isPassword ? 'text' : 'password';

    // Toggle eye icons
    document.getElementById(`${iconPrefix}Open`)?.classList.toggle('hidden', !isPassword);
    document.getElementById(`${iconPrefix}Pupil`)?.classList.toggle('hidden', !isPassword);
    document.getElementById(`${iconPrefix}Closed`)?.classList.toggle('hidden', isPassword);
};

// Admin login form handling
async function handleAdminLoginSubmit(form) {
    // Reset UI
    document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));
    document.getElementById('errorToast')?.classList.add('hidden');

    // Validate fields
    const errors = validateAdminLoginFields();
    if (errors.length) {
        showFieldErrors(errors);
        return false;
    }

    // Show loading state
    toggleLoadingState(true);

    try {
        const response = await submitAdminForm(form);
        handleAdminLoginResponse(response);
    } catch (error) {
        handleAdminLoginError(error);
    } finally {
        toggleLoadingState(false);
    }
}

function validateAdminLoginFields() {
    const errors = [];
    const fields = {
        email: {
            value: document.getElementById('email')?.value.trim(),
            required: true,
            validate: (email) => /^\\S+@\\S+\\.\\S+$/.test(email)
        },
        password: {
            value: document.getElementById('password')?.value,
            required: true
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
        email: 'Please enter a valid email',
        password: 'Password is required'
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

function handleAdminLoginResponse(response) {
    if (response.redirected) {
        window.location.href = response.url;
    } else {
        response.json().then(data => {
            window.location.href = data.redirect || "/management/portal/admin/dashboard";
        });
    }
}

function handleAdminLoginError(error) {
    console.error('Admin login error:', error);

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
    if (buttonText) buttonText.textContent = isLoading ? 'Accessing...' : 'Access Admin Portal';
    document.getElementById('loginBtn').disabled = isLoading;
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

// Initialize admin login
document.addEventListener('DOMContentLoaded', () => {
    const adminLoginForm = document.getElementById('adminLoginForm');
    if (adminLoginForm) {
        adminLoginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            handleAdminLoginSubmit(adminLoginForm);
        });
    }
});