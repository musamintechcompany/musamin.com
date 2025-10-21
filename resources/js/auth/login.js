// Reuse password visibility toggle from register
window.togglePasswordVisibility = function(fieldId) {
    const field = document.getElementById(fieldId);
    if (!field) return;

    const iconPrefix = 'passwordEye'; // Simplified since only password field
    const isPassword = field.type === 'password';

    field.type = isPassword ? 'text' : 'password';

    // Toggle eye icons
    document.getElementById(`${iconPrefix}Open`)?.classList.toggle('hidden', !isPassword);
    document.getElementById(`${iconPrefix}Pupil`)?.classList.toggle('hidden', !isPassword);
    document.getElementById(`${iconPrefix}Closed`)?.classList.toggle('hidden', isPassword);
};

// Form handling
function handleLoginSubmit(form, event) {
    // Reset UI
    document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));
    document.getElementById('errorToast')?.classList.add('hidden');

    // Validate fields
    const errors = validateLoginFields();
    if (errors.length) {
        event.preventDefault();
        showFieldErrors(errors);
        return false;
    }

    // Show loading state
    toggleLoadingState(true);
    
    // Allow normal form submission for 2FA compatibility
    return true;
}

function validateLoginFields() {
    const errors = [];
    const fields = {
        email: {
            value: document.getElementById('email')?.value.trim(),
            required: true,
            validate: (email) => /^\S+@\S+\.\S+$/.test(email)
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



function toggleLoadingState(isLoading) {
    document.getElementById('spinner')?.classList.toggle('hidden', !isLoading);
    const buttonText = document.getElementById('buttonText');
    if (buttonText) buttonText.textContent = isLoading ? 'Logging in...' : 'Login';
    document.getElementById('loginBtn').disabled = isLoading;
}

function showError(message) {
    const toast = document.getElementById('errorToast');
    if (!toast) return;

    // Check for CSRF token mismatch or session expired errors
    if (message.toLowerCase().includes('csrf') || 
        message.toLowerCase().includes('token mismatch') ||
        message.toLowerCase().includes('419')) {
        message = 'Your session has expired. Please refresh the page and try again.';
    }

    toast.textContent = message;
    toast.classList.remove('hidden');
    toast.classList.add('slide-down');

    setTimeout(() => {
        toast.classList.remove('slide-down');
        toast.classList.add('hidden');
    }, 5000);
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            const isValid = handleLoginSubmit(loginForm, e);
            if (!isValid) {
                e.preventDefault();
            }
            // If valid, allow normal form submission
        });
    }
});
