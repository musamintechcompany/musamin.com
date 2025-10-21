<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <!-- Back button and header -->
                    <div class="sticky top-0 flex items-center py-2 mb-6 bg-white dark:bg-gray-800">
                        <button onclick="window.history.back()" class="mr-4 back-button">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <h2 class="page-title">Support Center</h2>
                    </div>

                    <!-- Support options list -->
                    <div class="support-list">
                        <div class="support-item" onclick="openContactModal('whatsapp')">
                            <div class="left">
                                <div class="title">
                                    WhatsApp Support
                                    <span class="status-indicator status-online"></span>
                                </div>
                                <div class="subtitle">Available 24/7 • Instant response</div>
                            </div>
                            <div class="icon">→</div>
                        </div>

                        <div class="support-item" onclick="openContactModal('livechat')">
                            <div class="left">
                                <div class="title">
                                    Live Chat
                                    <span class="status-indicator status-online"></span>
                                </div>
                                <div class="subtitle">Mon-Fri, 9 AM - 5 PM EST • Avg wait: 2 min</div>
                            </div>
                            <div class="icon">→</div>
                        </div>

                        <div class="support-item" onclick="openContactModal('email')">
                            <div class="left">
                                <div class="title">Email Support</div>
                                <div class="subtitle">Response within 24 hours • Detailed help</div>
                            </div>
                            <div class="icon">→</div>
                        </div>



                        <div class="support-item" onclick="navigateTo('faqs')">
                            <div class="left">
                                <div class="title">FAQs</div>
                                <div class="subtitle">Answers to common questions</div>
                            </div>
                            <div class="icon">→</div>
                        </div>

                        <div class="support-item" onclick="openContactModal('callback')">
                            <div class="left">
                                <div class="title">Request Callback</div>
                                <div class="subtitle">We'll call you at your preferred time</div>
                            </div>
                            <div class="icon">→</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Modal -->
    <div class="contact-modal" id="contactModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="modalTitle">Contact Support</div>
                <div class="close-modal" onclick="closeModal()">×</div>
            </div>

            <div id="whatsappContent" class="modal-contact-content" style="display: none;">
                <div class="contact-option">
                    <div class="contact-icon">📱</div>
                    <div class="contact-info">
                        <div class="contact-type">WhatsApp Support</div>
                        <div class="contact-detail">+44 7397 824997</div>
                        <div class="action-buttons">
                            <button class="action-btn whatsapp" onclick="openWhatsApp()">
                                Open WhatsApp
                            </button>
                            <button class="copy-btn" onclick="copyToClipboard('+447397824997', 'WhatsApp number copied')">
                                Copy Number
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    Our WhatsApp support is available 24/7. Average response time: 5 minutes.
                </div>
            </div>

            <div id="livechatContent" class="modal-contact-content" style="display: none;">
                <div class="contact-option">
                    <div class="contact-icon">💬</div>
                    <div class="contact-info">
                        <div class="contact-type">Live Chat Support</div>
                        <div class="contact-detail">Available Mon-Fri, 9 AM - 5 PM EST</div>
                        <div class="action-buttons">
                            <button class="action-btn" onclick="startLiveChat()">
                                Start Chat
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    Current wait time: approximately 2 minutes. 3 agents available now.
                </div>
            </div>

            <div id="emailContent" class="modal-contact-content" style="display: none;">
                <div class="contact-option">
                    <div class="contact-icon">✉️</div>
                    <div class="contact-info">
                        <div class="contact-type">Email Support</div>
                        <div class="contact-detail">support@musamin.com</div>
                        <div class="action-buttons">
                            <button class="action-btn email" onclick="openEmailClient()">
                                Compose Email
                            </button>
                            <button class="copy-btn" onclick="copyToClipboard('support@musamin.com', 'Email address copied')">
                                Copy Email
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    We typically respond to emails within 24 hours. For urgent matters, please use live chat.
                </div>
            </div>

            <div id="callbackContent" class="modal-contact-content" style="display: none;">
                <div class="contact-option">
                    <div class="contact-icon">📞</div>
                    <div class="contact-info">
                        <div class="contact-type">Request Callback</div>
                        <div class="contact-detail">We'll call you at your preferred time</div>
                        <form id="callbackForm" onsubmit="submitCallbackRequest(event)">
                            <div class="form-group">
                                <input type="text" placeholder="Your Name" required>
                                <input type="tel" placeholder="Phone Number" required>
                                <select>
                                    <option>Preferred Callback Time</option>
                                    <option>9 AM - 12 PM</option>
                                    <option>12 PM - 3 PM</option>
                                    <option>3 PM - 6 PM</option>
                                </select>
                                <button type="submit" class="action-btn">
                                    Request Callback
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    Callbacks are available Mon-Fri, 9 AM - 5 PM EST. We'll call within 1 hour of your selected time.
                </div>
            </div>
        </div>
    </div>

    <div class="toast" id="toast"></div>

    @push('styles')
    <style>
        /* Theme Variables */
        :root {
            --primary-color: #0071e3;
            --primary-hover: #0077ed;
            --text-color: #1d1d1f;
            --text-secondary: #86868b;
            --bg-color: #f5f5f7;
            --card-bg: #ffffff;
            --border-color: #e0e0e0;
            --success-color: #34c759;
            --error-color: #ff3b30;
            --warning-color: #ff9500;
        }

        .dark {
            --primary-color: #0071e3;
            --primary-hover: #0077ed;
            --text-color: #e5e7eb;
            --text-secondary: #9ca3af;
            --bg-color: #111827;
            --card-bg: #1f2937;
            --border-color: #374151;
        }

        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        /* Header Styles */
        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: var(--text-color);
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            color: var(--text-secondary);
            transition: all 0.2s ease;
        }

        .back-button:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        /* Support List Styles */
        .support-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .support-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            border-radius: 10px;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .support-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: var(--primary-color);
        }

        .support-item .left {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .support-item .title {
            font-size: 17px;
            font-weight: 500;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            color: var(--text-color);
        }

        .support-item .subtitle {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .support-item .icon {
            color: var(--text-secondary);
            font-size: 20px;
            transition: transform 0.3s ease;
        }

        .support-item:hover .icon {
            transform: translateX(3px);
            color: var(--primary-color);
        }

        /* Status Indicators */
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-left: 8px;
        }

        .status-online {
            background-color: var(--success-color);
            box-shadow: 0 0 8px var(--success-color);
        }

        .status-offline {
            background-color: var(--error-color);
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 500;
            background-color: var(--primary-color);
            color: white;
            margin-left: 8px;
        }

        /* Updated Modal Styles */
        .contact-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999999;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: auto;
        }

        .contact-modal.active {
            opacity: 1;
        }

        .modal-content {
            background-color: var(--card-bg);
            width: 90%;
            max-width: 400px;
            border-radius: 16px;
            padding: 25px;
            animation: modalFadeIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 9999999;
            pointer-events: auto;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-title {
            font-size: 22px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .close-modal {
            font-size: 28px;
            cursor: pointer;
            color: var(--text-secondary);
            transition: all 0.2s ease;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            pointer-events: auto;
        }

        .close-modal:hover {
            color: var(--text-color);
            background-color: rgba(0, 0, 0, 0.05);
        }

        /* Contact Option Styles */
        .contact-option {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .contact-icon {
            margin-right: 15px;
            font-size: 24px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--bg-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .contact-info {
            flex: 1;
        }

        .contact-type {
            font-weight: 500;
            margin-bottom: 5px;
            font-size: 16px;
            color: var(--text-color);
        }

        .contact-detail {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 10px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .copy-btn, .action-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .action-btn.whatsapp {
            background-color: #25D366;
        }

        .action-btn.email {
            background-color: #EA4335;
        }

        .copy-btn:hover, .action-btn:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .copy-btn:active, .action-btn:active {
            transform: translateY(0);
        }

        /* Form Styles */
        .form-group {
            margin-top: 15px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: var(--card-bg);
            color: var(--text-color);
        }

        /* Footer Styles */
        .modal-footer {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
            font-size: 13px;
            color: var(--text-secondary);
            text-align: center;
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 1000001;
            display: flex;
            align-items: center;
            gap: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .toast.show {
            opacity: 1;
        }

        .toast.success {
            background-color: var(--success-color);
        }

        .toast.error {
            background-color: var(--error-color);
        }

        /* Responsive Styles */
        @media (max-width: 480px) {
            .modal-content {
                width: 95%;
                padding: 20px 15px;
            }

            .contact-option {
                flex-direction: column;
                align-items: flex-start;
            }

            .contact-icon {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .action-buttons {
                flex-direction: column;
                width: 100%;
            }

            .copy-btn, .action-btn {
                width: 100%;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Initialize theme from database
        document.addEventListener('DOMContentLoaded', function() {
            // Get theme from database (injected via Blade)
            const dbTheme = "{{ auth()->user()->theme ?? 'light' }}";

            // Apply the theme
            applyTheme(dbTheme);
            localStorage.setItem('theme', dbTheme);

            // Initialize live chat availability
            checkLiveChatAvailability();
        });

        function applyTheme(theme) {
            const html = document.documentElement;
            html.classList.remove('light', 'dark');
            html.classList.add(theme);
        }

        // Modal Functions
        function openContactModal(type) {
            const modal = document.getElementById('contactModal');
            const modalTitle = document.getElementById('modalTitle');
            const allContents = document.querySelectorAll('.modal-contact-content');

            // Hide all content first
            allContents.forEach(content => {
                content.style.display = 'none';
            });

            // Show the selected content and set title
            switch(type) {
                case 'whatsapp':
                    document.getElementById('whatsappContent').style.display = 'block';
                    modalTitle.textContent = 'WhatsApp Support';
                    break;
                case 'livechat':
                    document.getElementById('livechatContent').style.display = 'block';
                    modalTitle.textContent = 'Live Chat';
                    break;
                case 'email':
                    document.getElementById('emailContent').style.display = 'block';
                    modalTitle.textContent = 'Email Support';
                    break;
                case 'callback':
                    document.getElementById('callbackContent').style.display = 'block';
                    modalTitle.textContent = 'Request Callback';
                    break;
            }

            modal.style.display = 'flex';
            setTimeout(() => {
                modal.classList.add('active');
            }, 10);
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('contactModal');
            modal.classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
            document.body.style.overflow = 'auto';
        }

        // Clipboard Function
        function copyToClipboard(text, message) {
            navigator.clipboard.writeText(text).then(() => {
                showToast(message || 'Copied to clipboard', 'success');
            }).catch(err => {
                console.error('Failed to copy: ', err);
                showToast('Failed to copy', 'error');
            });
        }

        // Toast Notification
        function showToast(message, type = '') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = 'toast';
            toast.classList.add(type, 'show');

            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Navigation Function
        function navigateTo(page) {
            if (page === 'faqs') {
                window.location.href = '{{ route("contact") }}#faq-section';
            } else if (page === 'help-center') {
                window.location.href = '{{ route("contact") }}#help-center-section';
            } else {
                showToast(`Navigating to ${page.replace('-', ' ')}`, 'success');
            }
        }

        // Action Functions
        function openWhatsApp() {
            window.open('https://wa.me/447397824997', '_blank');
            showToast('Opening WhatsApp...', 'success');
        }

        function startLiveChat() {
            alert('This feature is currently not available. Please use WhatsApp or Email support.');
        }

        function openEmailClient() {
            window.location.href = 'mailto:support@musamin.com';
            showToast('Opening email client...', 'success');
        }

        function submitCallbackRequest(e) {
            e.preventDefault();
            alert('This feature is currently not available. Please use WhatsApp or Email support.');
            closeModal();
        }

        // Check live chat availability
        function checkLiveChatAvailability() {
            const liveChatStatus = document.querySelector('.support-item:nth-child(2) .status-indicator');

            if (liveChatStatus) {
                liveChatStatus.className = 'status-indicator status-online';
                liveChatStatus.title = 'Live chat is available now';
            }
        }

        // Prevent closing when clicking outside modal
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('contactModal');
            const modalContent = document.querySelector('.modal-content');

            if (modal.style.display === 'flex') {
                // Check if click was inside modal content
                let isClickInside = false;
                let targetElement = event.target;

                do {
                    if (targetElement === modalContent) {
                        isClickInside = true;
                        break;
                    }
                    targetElement = targetElement.parentNode;
                } while (targetElement);

                // If click was outside modal content, prevent default
                if (!isClickInside) {
                    event.stopPropagation();
                    event.preventDefault();
                }
            }
        }, true);

        // Simulate checking live agent availability every minute
        setInterval(checkLiveChatAvailability, 60000);
    </script>
    @endpush
</x-app-layout>
