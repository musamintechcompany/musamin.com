<x-app-layout>
    @push('styles')
        <style>
            :root {
                --primary-blue: #3498db;
                --dark-blue: #2980b9;
                --black: #2c3e50;
                --light-black: #34495e;
                --purple: #9b59b6;
                --light-purple: #be90d4;
                --white: #ecf0f1;
                --gray: #bdc3c7;
                --success-green: #2ecc71;
                --card-bg: white;
                --border-color: #ddd;
                --text-color: #2c3e50;
                --hint-color: #666;
            }

            .dark {
                --primary-text: #f9fafb;
                --secondary-text: #d1d5db;
                --bg-color: #111827;
                --card-bg: #1f2937;
                --coin-bg: rgba(245, 158, 11, 0.1);
                --coin-border: rgba(245, 158, 11, 0.3);
                --white: #111827;
                --border-color: #374151;
                --text-color: #f9fafb;
                --hint-color: #9ca3af;
                --gray: #4b5563;
                --light-black: #f3f4f6;
                --black: #f9fafb;
            }

            @media (prefers-color-scheme: dark) {
                :root:not(.light) {
                    --primary-text: #f9fafb;
                    --secondary-text: #d1d5db;
                    --bg-color: #111827;
                    --card-bg: #1f2937;
                    --coin-bg: rgba(245, 158, 11, 0.1);
                    --coin-border: rgba(245, 158, 11, 0.3);
                    --white: #111827;
                    --border-color: #374151;
                    --text-color: #f9fafb;
                    --hint-color: #9ca3af;
                    --gray: #4b5563;
                    --light-black: #f3f4f6;
                    --black: #f9fafb;
                }
            }

            .idea-page {
                background-color: white;
                color: var(--text-color);
                line-height: 1.6;
                min-height: 100vh;
                transition: background-color 0.3s, color 0.3s;
            }
            
            .dark .idea-page {
                background-color: #111827;
            }

            .idea-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }

            .idea-header {
                background: linear-gradient(135deg, var(--black), var(--purple));
                color: white;
                padding: 3rem 0;
                text-align: center;
                border-radius: 0 0 20px 20px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                margin-bottom: 2rem;
                position: relative;
                overflow: hidden;
                min-height: 220px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .idea-header::before {
                content: "";
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
                transform: rotate(30deg);
                pointer-events: none;
            }

            .idea-title {
                font-size: 2.8rem;
                margin-bottom: 1rem;
                position: relative;
                text-shadow: 0 2px 4px rgba(0,0,0,0.2);
            }

            .idea-subtitle {
                font-size: 1.25rem;
                opacity: 0.9;
                max-width: 700px;
                margin: 0 auto;
                position: relative;
            }

            .rotating-message {
                position: absolute;
                width: 100%;
                text-align: center;
                padding: 0 20px;
                opacity: 0;
                transition: all 0.8s ease;
                transform: translateX(50px);
            }

            .rotating-message.active {
                opacity: 1;
                transform: translateX(0);
            }

            .rotating-message.fade-out {
                opacity: 0;
                transform: translateX(-50px);
            }

            .rotating-message h3 {
                font-size: 1.8rem;
                margin-bottom: 0.5rem;
                color: white;
            }

            .rotating-message p {
                font-size: 1.1rem;
                max-width: 700px;
                margin: 0 auto;
            }

            .idea-form {
                background: var(--card-bg);
                border-radius: 15px;
                padding: 2.5rem;
                box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
                margin-bottom: 3rem;
                position: relative;
                z-index: 1;
                border: 1px solid var(--border-color);
                transition: all 0.3s;
            }

            .form-group {
                margin-bottom: 1.75rem;
                position: relative;
            }

            .form-label {
                display: block;
                margin-bottom: 0.75rem;
                font-weight: 600;
                color: var(--light-black);
                font-size: 1.05rem;
            }

            .form-control {
                width: 100%;
                padding: 14px;
                border: 2px solid var(--gray);
                border-radius: 10px;
                font-size: 1rem;
                transition: all 0.3s ease;
                background-color: var(--card-bg);
                color: var(--text-color);
            }

            .form-control:focus {
                border-color: var(--primary-blue);
                outline: none;
                box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            }

            textarea.form-control {
                min-height: 180px;
                resize: vertical;
                line-height: 1.7;
            }

            .idea-btn {
                display: inline-block;
                background: linear-gradient(to right, var(--primary-blue), var(--purple));
                color: white;
                border: none;
                padding: 14px 28px;
                font-size: 1.05rem;
                font-weight: 600;
                border-radius: 10px;
                cursor: pointer;
                transition: all 0.3s ease;
                text-transform: uppercase;
                letter-spacing: 1px;
                position: relative;
                overflow: hidden;
            }

            .idea-btn::after {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transition: 0.5s;
            }

            .idea-btn:hover {
                background: linear-gradient(to right, var(--dark-blue), var(--light-purple));
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            }

            .idea-btn:hover::after {
                left: 100%;
            }

            .step-indicator {
                display: flex;
                justify-content: space-between;
                margin-bottom: 2rem;
                position: relative;
            }

            .step {
                display: flex;
                flex-direction: column;
                align-items: center;
                position: relative;
                z-index: 1;
            }

            .step-number {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background-color: var(--gray);
                color: var(--text-color);
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                margin-bottom: 0.5rem;
                transition: all 0.3s;
            }

            .step.active .step-number {
                background-color: var(--primary-blue);
                color: white;
            }

            .step.completed .step-number {
                background-color: var(--success-green);
                color: white;
            }

            .step-title {
                font-size: 0.9rem;
                color: var(--light-black);
                text-align: center;
            }

            .step-indicator::before {
                content: '';
                position: absolute;
                top: 20px;
                left: 0;
                right: 0;
                height: 2px;
                background-color: var(--gray);
                z-index: 0;
            }

            .step-progress {
                position: absolute;
                top: 20px;
                left: 0;
                height: 2px;
                background-color: var(--primary-blue);
                z-index: 1;
                transition: width 0.3s;
            }

            .form-step {
                display: none;
                animation: fadeIn 0.5s ease;
            }

            .form-step.active {
                display: block;
            }

            .phone-input-container {
                display: flex;
                gap: 10px;
            }

            .country-code {
                flex: 0 0 120px;
            }

            .phone-number {
                flex: 1;
            }

            .upload-hint {
                font-size: 14px;
                color: var(--hint-color);
                margin-top: 5px;
            }

            .popup-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.7);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999999;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s;
            }

            .popup-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            .contact-popup, .thank-you-popup {
                background: var(--card-bg);
                padding: 30px;
                border-radius: 15px;
                width: 90%;
                max-width: 500px;
                box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
                border: 1px solid var(--border-color);
            }

            .thank-you-popup {
                text-align: center;
            }

            .thank-you-popup h2 {
                color: var(--success-green);
                margin-bottom: 20px;
            }

            .success-message {
                display: none;
                background-color: var(--success-green);
                color: white;
                padding: 1.5rem;
                border-radius: 10px;
                margin-bottom: 2rem;
                text-align: center;
                animation: fadeIn 0.5s ease;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .char-counter {
                font-size: 0.85rem;
                color: var(--light-black);
                text-align: right;
                margin-top: 0.5rem;
                opacity: 0.7;
            }

            @media (max-width: 992px) {
                .idea-title {
                    font-size: 2.4rem;
                }

                .idea-subtitle {
                    font-size: 1.15rem;
                }
            }

            @media (max-width: 768px) {
                .idea-header {
                    padding: 2.5rem 0;
                    min-height: 180px;
                }

                .idea-title {
                    font-size: 2.2rem;
                }

                .rotating-message h3 {
                    font-size: 1.5rem;
                }

                .rotating-message p {
                    font-size: 1rem;
                }

                .idea-form {
                    padding: 2rem;
                }

                .step-title {
                    display: none;
                }
            }

            @media (max-width: 576px) {
                .idea-title {
                    font-size: 1.8rem;
                }

                .idea-subtitle {
                    font-size: 1rem;
                }

                .idea-header {
                    min-height: 160px;
                }

                .rotating-message h3 {
                    font-size: 1.3rem;
                }

                .rotating-message p {
                    font-size: 0.9rem;
                }

                .idea-form {
                    padding: 1.5rem;
                }

                .idea-btn {
                    width: 100%;
                }

                .phone-input-container {
                    flex-direction: column;
                }

                .country-code, .phone-number {
                    width: 100%;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dbTheme = "{{ auth()->user()->theme }}";
                if (dbTheme) {
                    applyTheme(dbTheme);
                    localStorage.setItem('theme', dbTheme);
                }

                function applyTheme(theme) {
                    const html = document.documentElement;
                    html.classList.remove('light', 'dark');
                    html.classList.add(theme);
                }

                // Simple form validation
                function validateForm() {
                    let isValid = true;
                    const requiredFields = document.querySelectorAll('[required]');
                    
                    requiredFields.forEach(field => {
                        const errorMsg = field.parentNode.querySelector('.error-message');
                        if (errorMsg) errorMsg.remove();
                        
                        if (!field.value.trim()) {
                            field.style.borderColor = '#e74c3c';
                            isValid = false;
                            showError(field, 'This field is required');
                        } else {
                            field.style.borderColor = '';
                        }
                    });
                    
                    // Check description length
                    const description = document.getElementById('description');
                    if (description.value.trim().length < 10) {
                        description.style.borderColor = '#e74c3c';
                        isValid = false;
                        showError(description, 'Please provide at least 10 characters');
                    }
                    
                    return isValid;
                }
                
                function showError(field, message) {
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'error-message';
                    errorMsg.style.color = '#e74c3c';
                    errorMsg.style.fontSize = '0.85rem';
                    errorMsg.style.marginTop = '0.25rem';
                    errorMsg.textContent = message;
                    field.parentNode.appendChild(errorMsg);
                }

                // Character counter for description
                const description = document.getElementById('description');
                const charCounter = document.createElement('div');
                charCounter.className = 'char-counter';
                description.parentNode.appendChild(charCounter);

                function updateCounter() {
                    const length = description.value.length;
                    charCounter.textContent = `${length}/1500 characters`;
                    charCounter.style.color = length > 1400 ? '#e74c3c' : '';
                }

                description.addEventListener('input', updateCounter);
                updateCounter();
                
                // Category dropdown functionality
                document.getElementById('category').addEventListener('change', function() {
                    const customInput = document.getElementById('custom-category');
                    const selectElement = this;
                    
                    if (this.value === 'other') {
                        customInput.style.display = 'block';
                        customInput.required = true;
                        selectElement.required = false;
                    } else {
                        customInput.style.display = 'none';
                        customInput.required = false;
                        customInput.value = '';
                        selectElement.required = true;
                    }
                });

                // File upload validation
                document.getElementById('media').addEventListener('change', function(e) {
                    const files = e.target.files;
                    const maxSize = 15 * 1024 * 1024; // 15MB

                    for (let i = 0; i < files.length; i++) {
                        if (files[i].size > maxSize) {
                            alert(`File "${files[i].name}" exceeds the 15MB size limit`);
                            e.target.value = '';
                            return;
                        }
                    }
                });

                // Form submission
                document.getElementById('ideaForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (validateForm()) {
                        submitIdea();
                    }
                });
                
                function submitIdea() {
                    const submitBtn = document.getElementById('submitBtn');
                    const btnText = submitBtn.querySelector('.btn-text');
                    const btnLoading = submitBtn.querySelector('.btn-loading');
                    
                    // Show loading state
                    submitBtn.disabled = true;
                    btnText.style.display = 'none';
                    btnLoading.style.display = 'inline';
                    
                    const formData = new FormData(document.getElementById('ideaForm'));
                    
                    fetch('{{ route("ideas.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('successPopup').classList.add('active');
                        } else {
                            alert('Error: ' + (data.message || 'Please try again'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Something went wrong. Please try again.');
                    })
                    .finally(() => {
                        // Reset button state
                        submitBtn.disabled = false;
                        btnText.style.display = 'inline';
                        btnLoading.style.display = 'none';
                    });
                }

                document.getElementById('okButton').addEventListener('click', function() {
                    document.getElementById('successPopup').classList.remove('active');
                    // Reset form
                    document.getElementById('ideaForm').reset();
                    updateCounter();
                });

                const messages = [
                    {
                        title: "Share Your Vision",
                        content: "Have a brilliant website or app idea? We want to hear it! Submit your concept and help shape the future of our platform."
                    },
                    {
                        title: "Fuel Innovation",
                        content: "Your creative ideas drive our platform forward. We're always looking for fresh perspectives to enhance our offerings."
                    },
                    {
                        title: "Potential Implementation",
                        content: "Exceptional ideas may be developed into actual products, with credit and rewards for the original thinkers."
                    },
                    {
                        title: "Confidential Process",
                        content: "All submissions are treated as confidential. We respect your intellectual property and creative input."
                    }
                ];

                const headerContent = document.querySelector('.idea-header');
                messages.forEach((message, index) => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `rotating-message message-${index}`;
                    messageDiv.innerHTML = `
                        <h3>${message.title}</h3>
                        <p>${message.content}</p>
                    `;
                    headerContent.appendChild(messageDiv);
                });

                const messageElements = document.querySelectorAll('.rotating-message');
                messageElements[0].classList.add('active');
                let currentIndex = 0;

                function rotateMessages() {
                    messageElements[currentIndex].classList.add('fade-out');
                    messageElements[currentIndex].classList.remove('active');
                    currentIndex = (currentIndex + 1) % messages.length;
                    setTimeout(() => {
                        messageElements[currentIndex].classList.remove('fade-out');
                        messageElements[currentIndex].classList.add('active');
                    }, 800);
                    setTimeout(() => {
                        messageElements.forEach(el => el.classList.remove('fade-out'));
                    }, 1600);
                }

                setInterval(rotateMessages, 5000);

                const countryCodeSelect = document.getElementById('countryCode');
                const userLang = navigator.language || navigator.userLanguage;
                const countryCode = userLang.split('-')[1];

                if (countryCode) {
                    const optionToSelect = countryCodeSelect.querySelector(`option[value="+${getCountryCode(countryCode)}"]`);
                    if (optionToSelect) {
                        optionToSelect.selected = true;
                    }
                }
            });

            function getCountryCode(country) {
                const codes = {
                    'US': '1', 'GB': '44', 'AU': '61', 'DE': '49',
                    'FR': '33', 'JP': '81', 'CN': '86', 'IN': '91',
                    'NG': '234', 'CA': '1', 'BR': '55', 'ZA': '27',
                    'KE': '254', 'GH': '233', 'EG': '20', 'MX': '52'
                };
                return codes[country] || '1';
            }
        </script>
    @endpush

    <div class="idea-page">
        <div class="idea-header">
            <div class="idea-container">
            </div>
        </div>

        <div class="idea-container">
            <form class="idea-form" id="ideaForm">
                @csrf

                <div class="form-group">
                    <label for="idea-title" class="form-label">Idea Title *</label>
                    <input type="text" id="idea-title" name="title" class="form-control" placeholder="Give your idea a clear, descriptive title" required>
                </div>

                <div class="form-group">
                    <label for="category" class="form-label">Category *</label>
                    <select id="category" name="category" class="form-control" required>
                        <option value="" disabled selected hidden>What type of idea is this?</option>
                        <option value="new-feature">New Feature</option>
                        <option value="improvement">Improvement</option>
                        <option value="bug-fix">Bug Fix</option>
                        <option value="ui-ux">UI/UX Enhancement</option>
                        <option value="performance">Performance</option>
                        <option value="security">Security</option>
                        <option value="other">Other</option>
                    </select>
                    <input type="text" id="custom-category" name="custom_category" class="form-control" placeholder="Please specify your category" style="display: none; margin-top: 10px;">
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Describe Your Idea *</label>
                    <textarea id="description" name="description" class="form-control" placeholder="Tell us about your idea. What problem does it solve? How would it work? Be as detailed as you'd like." maxlength="1500" required rows="6"></textarea>
                </div>

                <div class="form-group">
                    <label for="benefits" class="form-label">Expected Benefits</label>
                    <textarea id="benefits" name="benefits" class="form-control" placeholder="What value would this idea bring? How would it help users or improve the platform?" maxlength="800" rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label for="media" class="form-label">Supporting Files (Optional)</label>
                    <input type="file" id="media" name="media[]" class="form-control" accept="image/*,video/*,.pdf,.doc,.docx" multiple>
                    <p class="upload-hint">Upload images, videos, or documents to help explain your idea (Max 15MB per file)</p>
                </div>

                <div class="form-group" style="text-align: center; margin-top: 2rem;">
                    <button type="submit" class="idea-btn" id="submitBtn">
                        <span class="btn-text">Submit My Idea</span>
                        <span class="btn-loading" style="display: none;">Submitting...</span>
                    </button>
                </div>

                <div class="form-group" style="text-align: center; margin-top: 1rem;">
                    <p style="font-size: 0.9rem; color: var(--hint-color);">Your idea will be reviewed by our team and you'll receive feedback via your account notifications.</p>
                </div>
            </form>
        </div>
    </div>

    <div class="popup-overlay" id="successPopup">
        <div class="thank-you-popup">
            <div style="text-align: center; margin-bottom: 1rem;">
                <div style="width: 60px; height: 60px; background: var(--success-green); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                    <svg width="30" height="30" fill="white" viewBox="0 0 16 16">
                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                    </svg>
                </div>
            </div>
            <h2>Idea Submitted Successfully!</h2>
            <p>Thank you for sharing your idea with us. Our team will review it and get back to you through your account notifications.</p>
            <button id="okButton" class="idea-btn">Continue</button>
        </div>
    </div>
</x-app-layout>
