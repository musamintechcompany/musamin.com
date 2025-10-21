// Password visibility toggle with better icon handling
window.togglePasswordVisibility = function(fieldId) {
    const field = document.getElementById(fieldId);
    if (!field) return;

    const iconPrefix = fieldId === 'password' ? 'passwordEye' : 'confirmEye';
    const isShowing = field.type === 'password';

    field.type = isShowing ? 'text' : 'password';

    // Toggle eye icons
    document.getElementById(`${iconPrefix}Open`)?.classList.toggle('hidden', isShowing);
    document.getElementById(`${iconPrefix}Pupil`)?.classList.toggle('hidden', isShowing);
    document.getElementById(`${iconPrefix}Closed`)?.classList.toggle('hidden', !isShowing);
};

// Enhanced password strength meter
function initPasswordStrengthMeter() {
    const elements = {
        password: document.getElementById('password'),
        bar: document.getElementById('passwordStrengthBar'),
        text: document.getElementById('strengthText'),
        container: document.getElementById('strengthMeterContainer')
    };

    if (!Object.values(elements).every(el => el)) return;

    const strengthLevels = [
        { width: '20%', color: 'bg-red-500', label: 'Very Weak', minScore: 0 },
        { width: '40%', color: 'bg-orange-400', label: 'Weak', minScore: 1 },
        { width: '60%', color: 'bg-yellow-400', label: 'Medium', minScore: 2 },
        { width: '80%', color: 'bg-green-400', label: 'Strong', minScore: 3 },
        { width: '100%', color: 'bg-green-600', label: 'Very Strong', minScore: 4 }
    ];

    elements.password.addEventListener('input', () => {
        const password = elements.password.value;
        elements.container.classList.toggle('hidden', !password);

        if (!password) return;

        const score = calculatePasswordScore(password);
        const level = strengthLevels.findLast(level => score >= level.minScore) || strengthLevels[0];

        updateStrengthMeter(elements, level);
    });
}

function calculatePasswordScore(password) {
    let score = 0;
    if (password.length >= 8) score++;
    if (/[a-z]/.test(password)) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/\d/.test(password)) score++;
    if (/[^\w\s]/.test(password)) score++;
    return score;
}

function updateStrengthMeter(elements, level) {
    elements.bar.style.width = level.width;
    elements.bar.className = `h-full ${level.color} transition-all duration-300`;
    elements.text.textContent = level.label;
}

// Simple form validation like login
function handleFormSubmit(form, event) {
    // Reset UI
    document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));
    document.getElementById('errorToast')?.classList.add('hidden');

    // Validate fields
    const errors = validateFormFields();
    if (errors.length) {
        event.preventDefault();
        showFieldErrors(errors);
        return false;
    }

    // Show loading state
    toggleLoadingState(true);
    
    // Allow normal form submission
    return true;
}

function validateFormFields() {
    const errors = [];
    const fields = {
        name: { value: document.getElementById('name')?.value.trim(), required: true },
        email: {
            value: document.getElementById('email')?.value.trim(),
            required: true,
            validate: (email) => /^\S+@\S+\.\S+$/.test(email)
        },
        password: {
            value: document.getElementById('password')?.value,
            required: true,
            validate: (pw) => pw.length >= 8
        },
        confirm: {
            value: document.getElementById('password_confirmation')?.value,
            validate: (confirm) => confirm === document.getElementById('password')?.value
        },
        terms: {
            value: document.getElementById('terms')?.checked,
            required: !!document.getElementById('terms')
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
        password: 'Password must be at least 8 characters',
        confirm: 'Passwords do not match',
        terms: 'You must agree to the terms'
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
    if (buttonText) buttonText.textContent = isLoading ? 'Creating Account...' : 'Register';
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

// Initialize everything
document.addEventListener('DOMContentLoaded', () => {
    initPasswordStrengthMeter();

    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', (e) => {
            const isValid = handleFormSubmit(registerForm, e);
            if (!isValid) {
                e.preventDefault();
            }
            // If valid, allow normal form submission
        });
    }
});
