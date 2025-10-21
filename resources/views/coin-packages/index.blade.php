<x-app-layout>
    @push('styles')
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Main CSS styles -->
    <style>
        /* Root color variables for light/dark mode */
        :root {
            --primary-color: #4A90E2;
            --secondary-color: #EBF5FF;
            --accent-color: #357ABD;
            --text-color: #2D3748;
            --background-color: #ffffff;
            --card-bg: #ffffff;
            --card-border: #e0e7ff;
            --feature-divider: #e2e8f0;
            --feature-text: #4a5568;
            --modal-bg: white;
            --payment-option-bg: #f8fafc;
            --coin-icon-color: #FFD700;
            --danger-color: #e53e3e;
            --border-color: #e2e8f0;
            --success-color: #48BB78; /* Added for green highlights */
        }

        /* Dark mode color overrides */
        .dark {
            --primary-color: #5D9CEC;
            --secondary-color: #1E2B3A;
            --accent-color: #4A89DC;
            --text-color: #E2E8F0;
            --background-color: #1A202C;
            --card-bg: #2D3748;
            --card-border: #4A5568;
            --feature-divider: #4A5568;
            --feature-text: #CBD5E0;
            --modal-bg: #2D3748;
            --payment-option-bg: #1E2B3A;
            --coin-icon-color: #FFD700;
            --border-color: #4A5568;
            --success-color: #68D391; /* Added for dark mode green */
        }

        /* Base reset and body styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Container for main content */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header styles */
        .header {
            text-align: center;
            margin-bottom: 2rem;
            padding-top: 20px;
        }

        .header h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        /* Coin packages grid layout */
        .coin-packages {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 2rem;
        }

        /* Individual package card */
        .package {
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            padding: 25px;
            cursor: pointer;
            border: 1px solid var(--card-border);
        }

        .package:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        /* Package title badge */
        .package-title {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--primary-color);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 2;
        }

        /* Coin amount display */
        .coin-amount-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 15px 0 5px;
            position: relative;
        }

        .coin-icon {
            font-size: 2.5rem;
            color: var(--coin-icon-color);
            margin-bottom: 10px;
            position: relative;
        }

        .coin-icon::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
            border-radius: 3px;
        }

        .coin-amount {
            font-size: 2.1rem;
            font-weight: 800;
            color: var(--text-color);
            text-align: center;
        }

        /* Price display */
        .price {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 25px;
            text-align: center;
            position: relative;
        }

        .price::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 1px;
            background: var(--feature-divider);
        }

        /* Features list */
        .features {
            text-align: left;
            margin: 1.5rem 0;
            padding: 0;
            list-style-type: none;
        }

        .features li {
            padding: 8px 0;
            font-size: 1rem;
            line-height: 1.5;
            color: var(--feature-text);
            position: relative;
            margin-bottom: 8px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            word-break: break-word;
            white-space: normal;
        }

        .features li i {
            color: var(--primary-color);
            font-size: 0.9rem;
            margin-top: 3px;
        }

        /* Payment summary styling */
        .payment-summary {
            margin: 1.5rem 0;
            font-size: 0.9rem;
            color: var(--feature-text);
        }

        .payment-summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .payment-divider {
            border-top: 1px solid var(--feature-divider);
            margin: 1rem 0;
        }

        .total-amount {
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            margin: 1rem 0;
        }

        .total-amount-converted {
            color: var(--primary-color);
        }

        .send-exact-amount {
            font-weight: bold;
            color: var(--success-color); /* Changed to green */
            margin: 1.5rem 0 0.5rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .send-exact-amount i {
            font-size: 1.2rem;
            font-weight: 900;
        }

        /* Detail labels and wallet address */
        .detail-label {
            color: var(--primary-color);
            font-weight: bold;
            margin: 1rem 0 0.3rem;
            font-size: 0.95rem;
        }

        .wallet-address {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--secondary-color);
            padding: 0.8rem 1rem;
            border-radius: 0.8rem;
            font-family: monospace;
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .wallet-address-text {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .copy-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.2s;
            margin-left: 10px;
            flex-shrink: 0;
        }

        .copy-btn:hover {
            background: var(--accent-color);
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            justify-content: center;
            align-items: center;
            z-index: 9999;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: var(--modal-bg);
            padding: 2rem;
            border-radius: 1.5rem;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            -ms-overflow-style: none;
            scrollbar-width: none;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            position: relative;
            z-index: 10000;
        }

        .modal-content::-webkit-scrollbar {
            display: none;
        }

        .modal-content {
            transform: translateY(20px);
            animation: slideUp 0.3s ease forwards;
        }

        @keyframes slideUp {
            to { transform: translateY(0); }
        }

        .modal-header {
            margin-bottom: 1rem;
            text-align: center;
            position: relative;
        }

        .modal-header h2 {
            font-size: 1.8rem;
            color: var(--primary-color);
        }

        .step-indicator {
            font-size: 0.9rem;
            color: var(--accent-color);
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        /* Countdown timer styles */
        #countdownTimer, #step4Countdown {
            font-weight: bold;
            background: var(--secondary-color);
            padding: 0.3rem 0.6rem;
            border-radius: 0.5rem;
            color: var(--text-color);
        }

        #countdownTimer.urgent, #step4Countdown.urgent {
            color: var(--danger-color);
            animation: vibrate 0.3s linear infinite;
        }

        @keyframes vibrate {
            0% { transform: translate(0); }
            20% { transform: translate(-2px, 2px); }
            40% { transform: translate(-2px, -2px); }
            60% { transform: translate(2px, 2px); }
            80% { transform: translate(2px, -2px); }
            100% { transform: translate(0); }
        }

        /* Payment option selection */
        .payment-option {
            display: flex;
            align-items: center;
            padding: 1.2rem;
            margin: 1rem 0;
            border: 2px solid var(--feature-divider);
            border-radius: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            background: var(--payment-option-bg);
        }

        .payment-option:hover,
        .payment-option:focus {
            border-color: var(--primary-color);
            background: var(--secondary-color);
            outline: none;
        }

        .payment-option i {
            font-size: 1.8rem;
            margin-right: 1rem;
            width: 40px;
            text-align: center;
            color: var(--accent-color);
        }

        /* Payment type selection */
        .payment-type-option {
            display: flex;
            align-items: center;
            padding: 1.2rem;
            margin: 1rem 0;
            border: 2px solid var(--feature-divider);
            border-radius: 1.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
            background: var(--payment-option-bg);
        }

        .payment-type-option:hover,
        .payment-type-option:focus {
            border-color: var(--primary-color);
            background: var(--secondary-color);
            outline: none;
        }

        .payment-type-option i {
            font-size: 1.5rem;
            margin-right: 1rem;
            width: 30px;
        }

        /* QR code display */
        .qr-code {
            margin: 2rem 0;
            text-align: center;
        }

        #qrcodeCanvas {
            display: inline-block;
            padding: 10px;
            border: 1px solid var(--feature-divider);
            border-radius: 10px;
            background: white;
        }

        /* Proof submission section */
        .proof-section {
            margin: 2rem 0;
        }

        .file-input {
            position: relative;
            margin: 1rem 0;
        }

        .file-input input {
            opacity: 0;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input label {
            background: var(--secondary-color);
            padding: 1.2rem;
            border-radius: 0.8rem;
            display: block;
            text-align: center;
            border: 2px dashed var(--feature-divider);
            cursor: pointer;
            transition: all 0.2s;
        }

        .file-input label:hover {
            border-color: var(--primary-color);
            background: var(--payment-option-bg);
        }

        /* File preview styling */
        .file-preview {
            margin: 1rem 0;
            text-align: center;
        }

        .preview-item {
            position: relative;
            margin-bottom: 1rem;
            border: 1px solid var(--feature-divider);
            border-radius: 0.8rem;
            padding: 0.5rem;
        }

        .file-preview img {
            max-width: 100%;
            height: auto;
            border-radius: 0.8rem;
            margin-bottom: 0.5rem;
            display: block;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .pdf-preview {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
        }

        .delete-file {
            position: absolute;
            top: 5px;
            right: 5px;
            background: var(--danger-color);
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 10px;
            font-weight: bold;
            border: none;
        }

        .delete-file:hover {
            background: #c53030;
        }

        /* Additional notes textarea */
        textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid var(--feature-divider);
            border-radius: 0.8rem;
            margin: 1rem 0;
            resize: vertical;
            font-family: inherit;
            background: var(--secondary-color);
            color: var(--text-color);
        }

        textarea::placeholder {
            text-align: center;
            color: var(--feature-text);
            opacity: 0.7;
        }

        /* Button groups */
        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn {
            padding: 0.7rem 1.2rem;
            border-radius: 0.8rem;
            font-weight: bold;
            border: none;
            cursor: pointer;
            flex: 1;
            transition: transform 0.2s ease, background 0.2s;
            font-size: 0.9rem;
            height: auto;
            line-height: 1.2;
            text-align: center;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .cancel-btn {
            background: var(--payment-option-bg);
            color: var(--text-color);
            border: 2px solid var(--feature-divider);
            order: 1;
        }

        .cancel-btn:hover {
            background: var(--secondary-color);
        }

        .confirm-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, #6B46C1 100%);
            color: white;
            box-shadow: 0 3px 10px rgba(74, 144, 226, 0.3);
            order: 2;
        }

        .confirm-btn:hover {
            background: linear-gradient(135deg, #3d7bc8 0%, #5a3dab 100%);
        }

        /* Loading spinner */
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-left: 10px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Payment method type sections */
        .manual-methods {
            display: block;
        }

        .automatic-methods {
            display: none;
        }

        /* Address verification modal */
        #addressVerificationModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        #addressVerificationModal .modal-content {
            background: var(--modal-bg);
            padding: 1.5rem;
            border-radius: 1rem;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        #addressVerificationModal h2 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            text-align: center;
            font-size: 1.5rem;
        }

        #addressVerificationModal .form-group {
            margin-bottom: 1rem;
        }

        #addressVerificationModal label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-color);
            font-weight: 600;
            font-size: 0.9rem;
        }

        #addressVerificationModal input[type="text"] {
            width: 100%;
            padding: 0.6rem;
            border: 2px solid var(--feature-divider);
            border-radius: 0.5rem;
            background: var(--secondary-color);
            color: var(--text-color);
            font-size: 0.9rem;
        }

        #addressVerificationModal input[type="text"]:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        #addressVerificationModal .submit-btn {
            width: 100%;
            padding: 0.7rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 0.5rem;
            position: relative;
        }

        #addressVerificationModal .submit-btn:hover {
            background: var(--accent-color);
        }

        #addressVerificationModal .submit-btn.loading {
            pointer-events: none;
        }

        #addressVerificationModal .submit-btn.loading::after {
            content: "";
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        /* Change details button */
        .change-details-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            text-decoration: underline;
            cursor: pointer;
            font-size: 0.9rem;
            margin-top: 1rem;
            display: block;
            width: 100%;
            text-align: center;
            padding: 0.5rem;
        }

        .change-details-btn:hover {
            color: var(--accent-color);
        }

        /* Admin comments display */
        .payment-comment {
            background: var(--secondary-color);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: var(--danger-color);
            font-weight: bold;
        }

        /* Countdown display in step 4 */
        .countdown-display {
            margin: 1rem 0;
            font-size: 0.9rem;
            color: var(--feature-text);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Coin bonus display styles */
        .coin-bonus-display {
            display: flex;
            justify-content: space-between;
            margin: 0.5rem 0;
        }

        .coin-bonus-label {
            color: var(--feature-text);
        }

        .coin-bonus-value {
            color: var(--coin-icon-color);
            font-weight: bold;
        }

        .coin-total-display {
            font-weight: bold;
            color: var(--success-color);
            margin: 0.5rem 0;
            display: flex;
            justify-content: space-between;
        }

        /* Payment Proof Popup Styles */
        .payment-proof-popup {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 100000;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
        }

        .payment-proof-content {
            background: var(--modal-bg);
            color: var(--text-color);
            border-radius: 16px;
            padding: 28px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            text-align: center;
            border: 1px solid var(--border-color);
            animation: fadeIn 0.3s ease;
            margin: 20px;
        }

        .payment-proof-icon {
            margin-bottom: 20px;
        }

        .payment-proof-content h2 {
            margin: 0 0 16px 0;
            font-size: 24px;
            color: var(--primary-color);
        }

        .payment-proof-content p {
            margin: 0 0 16px 0;
            font-size: 15px;
            line-height: 1.5;
            color: var(--text-color);
            opacity: 0.9;
        }

        .payment-proof-details {
            background: var(--secondary-color);
            padding: 1.5rem;
            border-radius: 0.8rem;
            margin: 1.5rem 0;
            text-align: left;
        }

        .payment-proof-detail {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px dashed var(--feature-divider);
        }

        .payment-proof-detail:last-child {
            border-bottom: none;
        }

        .payment-proof-detail-label {
            font-weight: 600;
            color: var(--feature-text);
        }

        .payment-proof-detail-value {
            font-weight: 700;
        }

        .payment-proof-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .payment-proof-button {
            flex: 1;
            padding: 0.8rem;
            border-radius: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .payment-proof-button-exit {
            background: var(--payment-option-bg);
            color: var(--text-color);
            border: 1px solid var(--feature-divider);
        }

        .payment-proof-button-exit:hover {
            background: var(--secondary-color);
        }

        .payment-proof-button-dashboard {
            background: var(--primary-color);
            color: white;
        }

        .payment-proof-button-dashboard:hover {
            background: var(--accent-color);
        }

        /* Custom popup styles */
        .custom-popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 100000;
        }

        .custom-popup {
            background: var(--modal-bg);
            color: var(--text-color);
            border-radius: 16px;
            padding: 28px;
            width: 300px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            border: 1px solid var(--border-color);
            animation: fadeIn 0.3s ease;
        }

        .custom-popup-icon {
            font-size: 60px;
            margin-bottom: 20px;
            color: var(--danger-color);
        }

        .custom-popup h2 {
            margin: 0 0 16px 0;
            font-size: 24px;
            color: var(--danger-color);
        }

        .custom-popup p {
            margin: 0 0 16px 0;
            font-size: 15px;
            line-height: 1.5;
            color: var(--text-color);
            opacity: 0.9;
        }

        /* File upload popup */
        .file-upload-popup {
            background: var(--modal-bg);
            color: var(--text-color);
            border-radius: 8px;
            padding: 24px;
            width: 320px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            text-align: center;
            border: 1px solid var(--border-color);
            animation: fadeIn 0.3s ease;
            z-index: 100000;
        }

        .file-upload-icon {
            font-size: 48px;
            margin-bottom: 16px;
        }

        .file-upload-popup h2 {
            margin: 0 0 16px 0;
            font-size: 18px;
        }

        .file-upload-popup p {
            margin: 0 0 16px 0;
            font-size: 14px;
            color: var(--text-color);
            opacity: 0.8;
        }

        .file-formats {
            font-size: 12px;
            color: var(--text-color);
            opacity: 0.6;
        }

        /* Address saved popup */
        .address-saved-popup {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 100001;
        }

        .address-saved-content {
            background: var(--modal-bg);
            color: var(--text-color);
            border-radius: 16px;
            padding: 28px;
            width: 300px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            border: 1px solid var(--border-color);
            animation: fadeIn 0.3s ease;
        }

        .address-saved-icon {
            font-size: 60px;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .address-saved-content h2 {
            margin: 0 0 16px 0;
            font-size: 24px;
            color: var(--primary-color);
        }

        .address-saved-content p {
            margin: 0 0 16px 0;
            font-size: 15px;
            line-height: 1.5;
            color: var(--text-color);
            opacity: 0.9;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .coin-packages {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }

            .modal-content {
                max-height: 90vh;
            }

            .payment-proof-buttons {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 2rem;
            }

            .package {
                padding: 20px;
            }

            .coin-amount {
                font-size: 1.8rem;
            }

            .price {
                font-size: 1.6rem;
            }

            .features li {
                font-size: 0.95rem;
            }

            .button-group {
                flex-direction: column;
            }

            .payment-proof-content {
                padding: 20px;
                margin: 10px;
            }
        }
    </style>
    @endpush

    <!-- Main content container -->
    <div class="container">
        <div class="header">
            <h1><strong>Coin Packages</strong></h1>
        </div>

        <!-- Coin packages grid -->
        <div class="coin-packages">
            @foreach($coinPackages as $package)
                @if($package->is_active)
                    <div class="package"
                         data-price="{{ $package->price }}"
                         data-package="{{ $package->pack_name }}"
                         data-coins="{{ $package->coins }}"
                         data-bonus="{{ $package->bonus_coins }}"
                         data-uuid="{{ $package->id }}">
                        @if($package->badge_color)
                            <div class="package-title" style="background-color: {{ $package->badge_color }}">{{ $package->pack_name }}</div>
                        @else
                            <div class="package-title">{{ $package->pack_name }}</div>
                        @endif
                        <div class="coin-amount-container">
                            <i class="fas fa-coins coin-icon"></i>
                            <div class="coin-amount">{{ $package->coins }} Coins</div>
                        </div>
                        <div class="price">${{ number_format($package->price, 2) }}</div>
                        <ul class="features">
                            @if($package->bonus_coins > 0)
                                <li><i class="fas fa-gift"></i> Bonus: +{{ $package->bonus_coins }} coins</li>
                            @endif
                            @if($package->features)
                                @foreach($package->features as $feature)
                                    <li><i class="fas fa-check"></i> {{ $feature }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                @endif
            @endforeach
            
            <!-- Custom Package Card -->
            <div class="package custom-package" id="customPackageCard" style="cursor: pointer;">
                <div class="package-title" style="background: linear-gradient(135deg, #FF6B6B 0%, #4ECDC4 100%);">Custom</div>
                <div class="coin-amount-container">
                    <i class="fas fa-coins coin-icon" style="color: #FFD700;"></i>
                    <div class="coin-amount">Custom Amount</div>
                </div>
                <div class="price">$101+ USD</div>
                <ul class="features">
                    <li><i class="fas fa-bolt"></i> Instant Delivery</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Custom Package Modal -->
    <div id="customPackageModal" class="modal">
        <div class="modal-content" style="max-width: 400px;">
            <div class="modal-header">
                <h2>Create Custom Package</h2>
                <p style="color: var(--feature-text); font-size: 0.9rem; margin-top: 0.5rem;">Build your own coin package</p>
            </div>
            
            <div style="margin: 1.5rem 0;">
                <label for="customAmountInput" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-color);">Amount (USD)</label>
                <input type="number" id="customAmountInput" min="101" step="0.01" placeholder="Enter amount (minimum $101)" 
                       style="width: 100%; padding: 1rem; border: 2px solid var(--feature-divider); border-radius: 0.8rem; background: var(--secondary-color); color: var(--text-color); font-size: 1rem; text-align: center;">
            </div>
            
            <div id="customPackagePreview" style="background: var(--secondary-color); padding: 1.5rem; border-radius: 0.8rem; margin: 1.5rem 0; display: none; text-align: center;">
                <div style="font-size: 1.5rem; font-weight: 700; color: var(--coin-icon-color); margin-bottom: 0.5rem;">
                    <i class="fas fa-coins"></i> <span id="previewCoins">0</span> Coins
                </div>
                <div style="font-size: 1.2rem; color: var(--accent-color); font-weight: 600;">
                    Rate: 1 USD = 100 Coins
                </div>
            </div>
            
            <div class="button-group">
                <button class="btn cancel-btn" id="customCancelBtn">Cancel</button>
                <button class="btn confirm-btn" id="customContinueBtn" style="opacity: 0.5; pointer-events: none;">
                    Continue
                </button>
            </div>
        </div>
    </div>

    <!-- Address Verification Modal -->
    <div id="addressVerificationModal" class="modal">
        <div class="modal-content">
            <h2>Complete Your Address Details</h2>
            <p style="margin-bottom: 1rem; color: var(--feature-text); font-size: 0.9rem;">Please provide your full address details to continue with your purchase.</p>

            <form id="addressForm">
                @csrf
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" id="country" name="country" required placeholder="Enter your country" value="{{ auth()->user()->country ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="state">State/Province</label>
                    <input type="text" id="state" name="state" required placeholder="Enter your state or province" value="{{ auth()->user()->state ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" required placeholder="Enter your city" value="{{ auth()->user()->city ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="postal_code">Postal Code</label>
                    <input type="text" id="postal_code" name="postal_code" required placeholder="Enter your postal code" value="{{ auth()->user()->postal_code ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="address">Full Street Address</label>
                    <input type="text" id="address" name="address" required placeholder="Enter your full street address" value="{{ auth()->user()->address ?? '' }}">
                </div>

                <button type="submit" class="submit-btn" id="saveAddressBtn">
                    <span id="saveAddressText">Save Address</span>
                    <span id="saveAddressSpinner" class="spinner" style="display: none;"></span>
                </button>
            </form>
        </div>
    </div>

    <!-- Payment Type Selection Modal (Step 1) -->
    <div id="paymentTypeModal" class="modal" role="dialog" aria-modal="true">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Select Payment Type</h2>
                <div class="step-indicator">Step 1 of 4</div>
            </div>
            <div class="payment-type-selection">
                <div class="payment-type-option" id="manualPaymentOption" tabindex="0" role="button">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span>Manual Payment</span>
                </div>
                <div class="payment-type-option" id="autoPaymentOption" tabindex="0" role="button">
                    <i class="fas fa-robot"></i>
                    <span>Automatic Payment</span>
                </div>
            </div>
            <div class="button-group">
                <button class="btn cancel-btn" id="typeCancelBtn">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Payment Method Modal (Step 2) -->
    <div id="paymentMethodModal" class="modal" role="dialog" aria-modal="true">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Select Payment Method</h2>
                <div class="step-indicator">Step 2 of 4</div>
            </div>
            <div class="manual-methods">
                @if(count($manualPaymentMethods) > 0)
                    @foreach($manualPaymentMethods as $method)
                    <div class="payment-option"
                        data-code="{{ $method->code ?? '' }}"
                        data-category="{{ $method->category ?? '' }}"
                        data-method="{{ json_encode($method) }}"
                        tabindex="0"
                        role="button">
                        <i class="{{ $method->icon ?? 'fas fa-wallet' }}"></i>
                        <span>{{ $method->name ?? 'Unknown Method' }}</span>
                    </div>
                    @endforeach
                @else
                    <div class="no-methods" style="text-align: center; padding: 2rem; color: var(--feature-text);">
                        <i class="fas fa-exclamation-circle" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                        <p>No manual payment methods available at this time.</p>
                    </div>
                @endif
            </div>
            <div class="automatic-methods">
                <div class="payment-option" tabindex="0" role="button" id="creditCardOption">
                    <i class="fab fa-cc-stripe"></i>
                    <span>Credit/Debit Card</span>
                </div>
                <div class="payment-option" tabindex="0" role="button" id="paypalOption">
                    <i class="fab fa-paypal"></i>
                    <span>PayPal</span>
                </div>
                <div class="payment-option" tabindex="0" role="button" id="mobilePaymentOption">
                    <i class="fas fa-mobile-alt"></i>
                    <span>Mobile Payment</span>
                </div>
                <div class="payment-option" tabindex="0" role="button" id="bankTransferOption">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Bank Transfer</span>
                </div>
            </div>
            <div class="button-group">
                <button class="btn cancel-btn" id="methodCancelBtn">Back</button>
            </div>
        </div>
    </div>

    <!-- Payment Details Modal (Step 3) -->
    <div id="paymentDetailsModal" class="modal" role="dialog" aria-modal="true">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Payment Instructions</h2>
                <div class="step-indicator">Step 3 of 4 <span id="countdownTimer"></span></div>
            </div>
            <div id="paymentDetailsContent">
                <!-- Content dynamically populated by JavaScript -->
            </div>
            <div class="button-group">
                <button class="btn cancel-btn" id="detailsCancelBtn">Back</button>
                <button class="btn confirm-btn" id="confirmPaymentBtn">
                    <span id="confirmText">I've Paid</span>
                    <span id="loadingSpinner" class="spinner" style="display: none;"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Proof Submission Modal (Step 4) -->
    <div id="proofModal" class="modal" role="dialog" aria-modal="true">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Submit Proof of Payment</h2>
                <div class="step-indicator">Step 4 of 4 <span id="step4Countdown"></span></div>
            </div>
            <div class="proof-section">
                <div class="file-input">
                    <input type="file" id="proofFile" accept="image/*,.pdf" required multiple>
                    <label for="proofFile">
                        <i class="fas fa-upload"></i> Upload Payment Proof (Images or PDF)
                    </label>
                </div>
                <div class="file-preview" id="filePreview"></div>
                <textarea id="paymentNotes" placeholder="Additional notes (optional)" rows="4"></textarea>
                <div class="button-group">
                    <button class="btn confirm-btn" id="submitProofBtn" style="width: 100%;">
                        <span id="submitText">Submit Proof</span>
                        <span id="submitSpinner" class="spinner" style="display: none;"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- QR Code generation library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <!-- SweetAlert for notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Global state variables
            let selectedPaymentMethod = null;
            let selectedPackagePrice = 0;
            let selectedPackageName = '';
            let selectedPackageCoins = 0;
            let selectedPackageBonus = 0;
            let selectedPackageUuid = '';
            let selectedPaymentType = '';
            let countdownInterval;
            let addressVerified = {{ auth()->user()->country && auth()->user()->state && auth()->user()->address ? 'true' : 'false' }};
            let currentCredentialIndex = 0;
            let credentialGroups = [];
            let hasMultipleCredentials = false;
            let countdownSecondsRemaining = 0;
            let timerStartTime = 0;
            let totalTimeUsed = 0;
            let currentTransactionId = null;

            // Modal references
            const modals = {
                type: document.getElementById('paymentTypeModal'),
                method: document.getElementById('paymentMethodModal'),
                details: document.getElementById('paymentDetailsModal'),
                proof: document.getElementById('proofModal'),
                address: document.getElementById('addressVerificationModal')
            };

            function calculateFees() {
                let serviceFeeAmount = 0;
                let totalAmount = selectedPackagePrice;

                if (selectedPaymentMethod?.has_fee !== false) {
                    const isFixedFee = {{ $isFixedFee ? 'true' : 'false' }};
                    const feeMultiplier = {{ $feeMultiplier }};

                    if (isFixedFee) {
                        serviceFeeAmount = feeMultiplier;
                    } else {
                        serviceFeeAmount = selectedPackagePrice * feeMultiplier;
                    }
                    totalAmount = selectedPackagePrice + serviceFeeAmount;
                }

                return {
                    serviceFee: serviceFeeAmount,
                    total: totalAmount
                };
            }

            function showPaymentProofPopup(data = {}) {
                const defaultData = {
                    status: 'Processing',
                    timeTaken: formatTime(totalTimeUsed),
                    amount: selectedPackageCoins + ' coins',
                    transactionId: currentTransactionId || 'TX' + Date.now().toString().slice(-8),
                    coinBagImage: 'https://musamin.com/company/gifs/coinbag1.gif',
                    dashboardUrl: '{{ route('dashboard') }}',
                    packagesUrl: '{{ route('coin-packages.index') }}'
                };

                const popupData = {...defaultData, ...data};

                const overlay = document.createElement('div');
                overlay.className = 'payment-proof-popup';
                document.body.appendChild(overlay);

                const popupContent = document.createElement('div');
                popupContent.className = 'payment-proof-content';
                popupContent.innerHTML = `
                    <div class="payment-proof-icon">
                        <img src="${popupData.coinBagImage}" alt="Coin Bag" class="mx-auto w-24 h-auto rounded-xl" style="pointer-events: none" oncontextmenu="return false;">
                    </div>
                    <h2>Payment Proof Submitted</h2>
                    <p>Your transaction has been received and is being processed.</p>

                    <div class="payment-proof-details">
                        <div class="payment-proof-detail">
                            <span class="payment-proof-detail-label">Status:</span>
                            <span class="payment-proof-detail-value" style="color: var(--primary-color)">${popupData.status}</span>
                        </div>
                        <div class="payment-proof-detail">
                            <span class="payment-proof-detail-label">Time Taken:</span>
                            <span class="payment-proof-detail-value">${popupData.timeTaken}</span>
                        </div>
                        <div class="payment-proof-detail">
                            <span class="payment-proof-detail-label">Amount:</span>
                            <span class="payment-proof-detail-value" style="color: var(--coin-icon-color)">
                                <i class="fas fa-coins"></i> ${popupData.amount}
                            </span>
                        </div>
                        <div class="payment-proof-detail">
                            <span class="payment-proof-detail-label">Transaction ID:</span>
                            <span class="payment-proof-detail-value" style="color: var(--accent-color); font-family: monospace">${popupData.transactionId}</span>
                        </div>
                    </div>

                    <div class="payment-proof-buttons">
                        <button class="payment-proof-button payment-proof-button-exit" id="proofExitBtn">
                            Exit
                        </button>
                        <button class="payment-proof-button payment-proof-button-dashboard" id="proofDashboardBtn">
                            Dashboard
                        </button>
                    </div>
                `;

                overlay.appendChild(popupContent);
                document.body.style.overflow = 'hidden';

                // Add event listeners to buttons
                document.getElementById('proofExitBtn').addEventListener('click', () => {
                    overlay.remove();
                    document.body.style.overflow = '';
                    window.location.reload();
                });

                document.getElementById('proofDashboardBtn').addEventListener('click', () => {
                    overlay.remove();
                    document.body.style.overflow = '';
                    window.location.href = popupData.dashboardUrl;
                });

                // Handle escape key
                document.addEventListener('keydown', function handleEscape(e) {
                    if (e.key === 'Escape') {
                        overlay.remove();
                        document.body.style.overflow = '';
                        document.removeEventListener('keydown', handleEscape);
                    }
                });

                // Auto-focus on exit button
                setTimeout(() => document.getElementById('proofExitBtn').focus(), 100);
            }

            function showAddressSavedPopup() {
                const overlay = document.createElement('div');
                overlay.className = 'address-saved-popup';
                document.body.appendChild(overlay);

                const popup = document.createElement('div');
                popup.className = 'address-saved-content';
                popup.innerHTML = `
                    <div class="address-saved-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h2>Address Saved Successfully</h2>
                    <p>You can now proceed to buy a coin pack</p>
                `;

                overlay.appendChild(popup);
                document.body.style.overflow = 'hidden';

                setTimeout(() => {
                    overlay.style.opacity = '0';
                    overlay.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => {
                        overlay.remove();
                        document.body.style.overflow = '';
                    }, 300);
                }, 2000);
            }

            function checkAddressDetails() {
                if (!addressVerified) {
                    showModal(modals.address);
                    return false;
                }
                return true;
            }

            function showModal(modal) {
                if (modal.id !== 'customPackageModal') {
                    document.body.style.overflow = 'hidden';
                }
                modal.style.display = 'flex';
                modal.setAttribute('aria-hidden', 'false');
                if (modal.id === "paymentDetailsModal") startCountdown();
            }

            function hideModal(modal) {
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
                if (modal.id === "paymentDetailsModal" && countdownInterval) clearInterval(countdownInterval);
                if (modal.id === 'customPackageModal') {
                    document.body.style.overflow = 'auto';
                }
            }

            function hideAllModals() {
                document.body.style.overflow = 'auto';
                Object.values(modals).forEach(modal => {
                    if (modal) {
                        modal.style.display = 'none';
                        modal.setAttribute('aria-hidden', 'true');
                    }
                });
                if (countdownInterval) clearInterval(countdownInterval);
                isPurchasing = false; // Resume auto-refresh when purchase ends
            }

            function formatTime(seconds) {
                const isNegative = seconds < 0;
                seconds = Math.abs(seconds);
                const hrs = Math.floor(seconds / 3600);
                const mins = Math.floor((seconds % 3600) / 60);
                const secs = seconds % 60;
                return (isNegative ? "-" : "") + String(hrs).padStart(2, '0') + ":" + String(mins).padStart(2, '0') + ":" + String(secs).padStart(2, '0');
            }

            function startCountdown(seconds = null) {
                if (countdownInterval) clearInterval(countdownInterval);
                countdownSecondsRemaining = seconds !== null ? seconds : (selectedPaymentMethod?.countdown_time || 180);
                timerStartTime = Date.now();
                updateCountdownDisplay();
                countdownInterval = setInterval(updateCountdownDisplay, 1000);
            }

            function updateCountdownDisplay() {
                countdownSecondsRemaining--;
                totalTimeUsed++;
                const timeStr = formatTime(countdownSecondsRemaining);
                document.getElementById('countdownTimer').textContent = timeStr;
                document.getElementById('step4Countdown').textContent = timeStr;

                if (countdownSecondsRemaining <= 0) {
                    document.getElementById('countdownTimer').style.color = "var(--danger-color)";
                    document.getElementById('step4Countdown').style.color = "var(--danger-color)";
                    document.getElementById('countdownTimer').classList.add('urgent');
                    document.getElementById('step4Countdown').classList.add('urgent');
                } else if (countdownSecondsRemaining < 60) {
                    document.getElementById('countdownTimer').style.color = "var(--danger-color)";
                    document.getElementById('step4Countdown').style.color = "var(--danger-color)";
                }
            }

            function convertAmount(amount, method) {
                if (!method) return amount.toFixed(2) + ' USD';
                if (method.category === 'crypto') {
                    const convertedAmount = amount * method.usd_rate;
                    // Format very small numbers properly instead of scientific notation
                    const formattedAmount = convertedAmount < 0.001 
                        ? convertedAmount.toFixed(8).replace(/\.?0+$/, '') 
                        : convertedAmount.toFixed(8);
                    return formattedAmount + ' ' + method.code;
                } else if (method.category === 'bank') {
                    return method.currency_symbol + (amount * method.usd_rate).toFixed(2);
                }
                return amount.toFixed(2) + ' USD';
            }

            function buildCryptoDetails(credentials) {
                let html = `
                    <div class="qr-code">
                        <div id="qrcodeCanvas"></div>
                    </div>
                    <p class="detail-label">Wallet Address</p>
                    <div class="wallet-address">
                        <span class="wallet-address-text">${credentials.address}</span>
                        <button class="copy-btn" data-text="${credentials.address}" title="Copy Wallet Address">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                `;

                setTimeout(() => {
                    new QRCode(document.getElementById("qrcodeCanvas"), {
                        text: credentials.address,
                        width: 200,
                        height: 200,
                        colorDark: "#000000",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H
                    });
                }, 50);

                if (credentials.comment) {
                    html += `
                        <div class="payment-comment">
                            <p><strong>Note:</strong> ${credentials.comment}</p>
                        </div>
                    `;
                }

                return html;
            }

            function buildBankDetails(credentials) {
                let html = '';
                
                // Handle different detail structures
                let detailsArray = [];
                if (Array.isArray(credentials.details)) {
                    detailsArray = credentials.details;
                } else if (typeof credentials.details === 'object' && credentials.details !== null) {
                    detailsArray = Object.entries(credentials.details).map(([title, value]) => ({ title, value }));
                } else {
                    console.warn('Invalid bank details structure:', credentials);
                    return '<p style="color: var(--danger-color);">Invalid payment details format</p>';
                }

                if (detailsArray.length === 0) {
                    return '<p style="color: var(--danger-color);">No payment details available</p>';
                }

                detailsArray.forEach(detail => {
                    if (detail.title && detail.value) {
                        html += `
                            <p class="detail-label">${detail.title}</p>
                            <div class="wallet-address">
                                <span class="wallet-address-text">${detail.value}</span>
                                <button class="copy-btn" data-text="${detail.value}" title="Copy ${detail.title}">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        `;
                    }
                });

                if (credentials.comment) {
                    html += `
                        <div class="payment-comment">
                            <p><strong>Note:</strong> ${credentials.comment}</p>
                        </div>
                    `;
                }

                return html;
            }

            function updatePaymentDetailsUI() {
                if (!selectedPaymentMethod || !credentialGroups || !credentialGroups[currentCredentialIndex]) {
                    console.error('Missing payment details data:', {
                        selectedPaymentMethod,
                        credentialGroups,
                        currentCredentialIndex
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Error',
                        text: 'Failed to load payment details. Please try another method.',
                        confirmButtonText: 'OK'
                    });
                    hideModal(modals.details);
                    showModal(modals.method);
                    return;
                }

                const credentials = credentialGroups[currentCredentialIndex];
                const paymentDetailsContent = document.getElementById('paymentDetailsContent');
                const { serviceFee, total } = calculateFees();
                const convertedAmount = convertAmount(total, selectedPaymentMethod);
                const rateInfo = selectedPaymentMethod.category === 'bank'
                    ? `1 USD = ${selectedPaymentMethod.currency_symbol}${selectedPaymentMethod.usd_rate.toFixed(2)}`
                    : `1 USD = ${selectedPaymentMethod.usd_rate < 0.001 
                        ? selectedPaymentMethod.usd_rate.toFixed(8).replace(/\.?0+$/, '') 
                        : selectedPaymentMethod.usd_rate.toFixed(8)} ${selectedPaymentMethod.code}`;

                let detailsHTML = `
                    <p>Package: ${selectedPackageName}</p>
                    <div class="coin-bonus-display">
                        <span class="coin-bonus-label">Coins:</span>
                        <span class="coin-bonus-value">${selectedPackageCoins.toLocaleString()} ${selectedPackageBonus > 0 ? '+ ' + selectedPackageBonus.toLocaleString() + ' bonus' : ''}</span>
                    </div>
                    ${selectedPackageBonus > 0 ? `
                    <div class="coin-total-display">
                        <span>Total:</span>
                        <span>${(selectedPackageCoins + selectedPackageBonus).toLocaleString()} coins</span>
                    </div>
                    ` : ''}
                    <p>Rate: ${rateInfo}</p>
                    <div class="payment-summary">
                        <div class="payment-summary-item">
                            <span>Package Amount:</span>
                            <span>$${selectedPackagePrice.toFixed(2)}</span>
                        </div>
                        <div class="payment-summary-item">
                            <span>Service Fee:</span>
                            <span>$${serviceFee.toFixed(2)}</span>
                        </div>
                        <div class="payment-divider"></div>
                        <div class="total-amount">
                            <span>Total Amount:</span>
                            <span>$${total.toFixed(2)} =
                            <span class="total-amount-converted">${convertedAmount}</span></span>
                        </div>
                    </div>
                    <p class="send-exact-amount">Send EXACTLY ${convertedAmount} to: <i class="fas fa-angle-down"></i></p>
                `;

                if (selectedPaymentMethod.category === 'crypto') {
                    detailsHTML += buildCryptoDetails(credentials);
                } else if (selectedPaymentMethod.category === 'bank') {
                    detailsHTML += buildBankDetails(credentials);
                } else {
                    detailsHTML += '<p style="color: var(--danger-color);">Unsupported payment method category</p>';
                }

                if (hasMultipleCredentials) {
                    detailsHTML += `<button class="change-details-btn" id="changeDetailsBtn">Change Details</button>`;
                }

                paymentDetailsContent.innerHTML = detailsHTML;
                startCountdown(selectedPaymentMethod.countdown_time);
                setupCopyButtons();

                if (hasMultipleCredentials) {
                    document.getElementById('changeDetailsBtn').addEventListener('click', () => {
                        currentCredentialIndex = (currentCredentialIndex + 1) % credentialGroups.length;
                        updatePaymentDetailsUI();
                    });
                }
            }

            function setupCopyButtons() {
                document.querySelectorAll('.copy-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const text = btn.getAttribute('data-text');
                        const originalText = btn.innerHTML;
                        navigator.clipboard.writeText(text).then(() => {
                            btn.innerHTML = '<i class="fas fa-check"></i> Copied';
                            setTimeout(() => {
                                btn.innerHTML = originalText;
                            }, 1000);
                        });
                    });
                });
            }

            function showPaymentUnavailablePopup() {
                const overlay = document.createElement('div');
                overlay.className = 'custom-popup-overlay';
                overlay.style.zIndex = '100000';

                const popup = document.createElement('div');
                popup.className = 'custom-popup';
                popup.innerHTML = `
                    <div class="custom-popup-icon">⚠️</div>
                    <h2>Oops!</h2>
                    <p>This payment method is currently unavailable. Please use the manual payment method. Thank you!</p>
                `;

                overlay.appendChild(popup);
                document.body.appendChild(overlay);

                setTimeout(() => {
                    overlay.style.opacity = '0';
                    overlay.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => {
                        overlay.remove();
                    }, 300);
                }, 1500);
            }

            function showNoFilePopup() {
                const overlay = document.createElement('div');
                overlay.className = 'custom-popup-overlay';
                overlay.style.zIndex = '100000';

                const popup = document.createElement('div');
                popup.className = 'file-upload-popup';
                popup.innerHTML = `
                    <div class="file-upload-icon">📁</div>
                    <h2>No File Selected</h2>
                    <p>Please upload at least one proof of payment.</p>
                    <div class="file-formats">Supported formats: JPG, PNG, GIF, PDF</div>
                `;

                overlay.appendChild(popup);
                document.body.appendChild(overlay);

                setTimeout(() => {
                    overlay.style.opacity = '0';
                    overlay.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => {
                        overlay.remove();
                    }, 300);
                }, 1500);
            }

            // Package click handlers (exclude custom package)
            document.querySelectorAll('.package:not(.custom-package)').forEach(pkg => {
                pkg.addEventListener('click', () => {
                    if (!checkAddressDetails()) return;
                    isPurchasing = true; // Pause auto-refresh during purchase
                    selectedPackagePrice = parseFloat(pkg.getAttribute('data-price'));
                    selectedPackageName = pkg.getAttribute('data-package');
                    selectedPackageCoins = parseInt(pkg.getAttribute('data-coins'));
                    selectedPackageBonus = parseInt(pkg.getAttribute('data-bonus'));
                    selectedPackageUuid = pkg.getAttribute('data-uuid');
                    showModal(modals.type);
                });
            });

            // Payment type selection
            document.getElementById('manualPaymentOption').addEventListener('click', () => {
                selectedPaymentType = 'manual';
                document.querySelector('.manual-methods').style.display = 'block';
                document.querySelector('.automatic-methods').style.display = 'none';
                hideModal(modals.type);
                showModal(modals.method);
            });

            document.getElementById('autoPaymentOption').addEventListener('click', () => {
                selectedPaymentType = 'auto';
                document.querySelector('.manual-methods').style.display = 'none';
                document.querySelector('.automatic-methods').style.display = 'block';
                hideModal(modals.type);
                showModal(modals.method);
            });

            // Automatic payment method placeholders
            ['creditCardOption', 'paypalOption', 'mobilePaymentOption', 'bankTransferOption'].forEach(id => {
                document.getElementById(id).addEventListener('click', showPaymentUnavailablePopup);
            });

            // Manual payment method selection
            document.querySelectorAll('.manual-methods .payment-option').forEach(option => {
                option.addEventListener('click', function() {
                    try {
                        const methodData = JSON.parse(this.getAttribute('data-method'));
                        console.log('Raw method data:', methodData);
                        
                        // Validate that method has credentials
                        if (!methodData.credentials || methodData.credentials.length === 0) {
                            console.error('Method has no credentials:', methodData);
                            throw new Error('No payment credentials available for this method');
                        }

                        // Transform credentials for consistent structure
                        const transformedCredentials = methodData.credentials.map(cred => {
                            if (methodData.category === 'bank') {
                                // Ensure details is an array for bank methods
                                const details = Array.isArray(cred.details) ? cred.details : 
                                    Object.entries(cred.details || {}).map(([title, value]) => ({ title, value }));
                                
                                return {
                                    type: 'bank',
                                    details: details,
                                    comment: cred.comment,
                                    active: cred.active !== false
                                };
                            }
                            return {
                                ...cred,
                                active: cred.active !== false
                            };
                        });

                        selectedPaymentMethod = {
                            ...methodData,
                            credentials: transformedCredentials,
                            has_multiple: transformedCredentials.length > 1
                        };

                        currentCredentialIndex = 0;
                        credentialGroups = transformedCredentials;
                        hasMultipleCredentials = transformedCredentials.length > 1;
                        
                        console.log('Selected payment method:', selectedPaymentMethod);
                        console.log('Credential groups:', credentialGroups);
                        
                        updatePaymentDetailsUI();
                        hideModal(modals.method);
                        showModal(modals.details);
                    } catch (e) {
                        console.error('Payment Processing Error:', e);
                        Swal.fire({
                            icon: 'error',
                            title: 'Payment Error',
                            text: e.message || 'Failed to load payment details. Please try another method.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Navigation between steps
            document.getElementById('detailsCancelBtn').addEventListener('click', () => {
                hideModal(modals.details);
                showModal(modals.method);
            });

            // Confirm payment button
            document.getElementById('confirmPaymentBtn').addEventListener('click', async function() {
                const confirmText = document.getElementById('confirmText');
                const loadingSpinner = document.getElementById('loadingSpinner');
                confirmText.textContent = 'Processing...';
                loadingSpinner.style.display = 'inline-block';

                try {
                    // Prepare transaction data
                    const transactionData = {
                        package_id: selectedPackageUuid,
                        payment_type: selectedPaymentType,
                        payment_method: selectedPaymentMethod.name,
                        payment_credentials: credentialGroups[currentCredentialIndex],
                        amount: selectedPackagePrice,
                        base_coins: selectedPackageCoins,
                        bonus_coins: selectedPackageBonus,
                        countdown_time: selectedPaymentMethod.countdown_time || 180,
                        time_taken: totalTimeUsed,
                        ip_address: await fetch('https://api.ipify.org?format=json').then(res => res.json()).then(data => data.ip),
                        user_agent: navigator.userAgent,
                        _token: document.querySelector('meta[name="csrf-token"]').content
                    };

                    // Submit transaction to backend (queued)
                    const response = await fetch('{{ route("coin-transaction.submit") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Queue-Job': 'true'
                        },
                        body: JSON.stringify(transactionData)
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Failed to submit transaction');
                    }

                    // Store transaction ID for proof submission
                    currentTransactionId = data.transaction_id;

                    // Hide current modal and show proof submission
                    hideModal(modals.details);
                    showModal(modals.proof);

                } catch (error) {
                    console.error('Transaction submission error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Submission Failed',
                        text: error.message || 'Failed to submit transaction. Please try again.',
                        confirmButtonText: 'OK'
                    });
                } finally {
                    confirmText.textContent = 'I\'ve Paid';
                    loadingSpinner.style.display = 'none';
                }
            });

            // File upload handling
            const proofFileInput = document.getElementById('proofFile');
            const filePreview = document.getElementById('filePreview');
            proofFileInput.addEventListener('change', function() {
                filePreview.innerHTML = '';
                Array.from(this.files).forEach((file, index) => {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'preview-item';
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewItem.innerHTML = `
                                <img src="${e.target.result}">
                                <button class="delete-file" data-index="${index}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            `;
                            filePreview.appendChild(previewItem);
                        };
                        reader.readAsDataURL(file);
                    } else if (file.type === 'application/pdf') {
                        previewItem.innerHTML = `
                            <div class="pdf-preview">
                                <i class="fas fa-file-pdf"></i>
                                <span>${file.name}</span>
                                <button class="delete-file" data-index="${index}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        `;
                        filePreview.appendChild(previewItem);
                    } else {
                        const errorMsg = document.createElement('p');
                        errorMsg.textContent = 'Unsupported file type: ' + file.type;
                        filePreview.appendChild(errorMsg);
                    }
                });

                const label = this.nextElementSibling;
                label.innerHTML = this.files.length ? `<i class="fas fa-check"></i> ${this.files.length} file(s) selected` : `<i class="fas fa-upload"></i> Upload Payment Proof`;

                document.querySelectorAll('.delete-file').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        const dt = new DataTransfer();
                        const files = Array.from(proofFileInput.files);
                        files.splice(index, 1);
                        files.forEach(file => dt.items.add(file));
                        proofFileInput.files = dt.files;
                        this.parentElement.remove();
                        label.innerHTML = files.length ? `<i class="fas fa-check"></i> ${files.length} file(s) selected` : `<i class="fas fa-upload"></i> Upload Payment Proof`;
                        proofFileInput.dispatchEvent(new Event('change'));
                    });
                });
            });

            // Submit proof button
            document.getElementById('submitProofBtn').addEventListener('click', async () => {
                if (document.getElementById('proofFile').files.length === 0) {
                    showNoFilePopup();
                    return;
                }

                const submitText = document.getElementById('submitText');
                const submitSpinner = document.getElementById('submitSpinner');
                submitText.textContent = 'Submitting...';
                submitSpinner.style.display = 'inline-block';

                try {
                    const formData = new FormData();
                    formData.append('transaction_id', currentTransactionId);
                    formData.append('notes', document.getElementById('paymentNotes').value);
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                    Array.from(document.getElementById('proofFile').files).forEach((file, index) => {
                        formData.append(`proofs[${index}]`, file);
                    });

                    const response = await fetch('{{ route("coin-transaction.complete") }}', {
                        method: 'POST',
                        headers: {
                            'X-Queue-Job': 'true'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Failed to submit proof');
                    }

                    showPaymentProofPopup({
                        transactionId: data.hashid,
                        status: 'Pending Review'
                    });
                    hideAllModals();

                } catch (error) {
                    console.error('Proof submission error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Submission Failed',
                        text: error.message || 'Failed to submit proof. Please try again.',
                        confirmButtonText: 'OK'
                    });
                } finally {
                    submitText.textContent = 'Submit Proof';
                    submitSpinner.style.display = 'none';
                }
            });

            // Address form submission
            document.getElementById('addressForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const country = document.getElementById('country').value.trim();
                const state = document.getElementById('state').value.trim();
                const city = document.getElementById('city').value.trim();
                const postal_code = document.getElementById('postal_code').value.trim();
                const address = document.getElementById('address').value.trim();

                if (!country || !state || !city || !postal_code || !address) {
                    Swal.fire({
                        icon: 'error',
                        title: 'All fields are required',
                        text: 'Please fill in all address fields to continue.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                const submitBtn = document.getElementById('saveAddressBtn');
                const saveAddressText = document.getElementById('saveAddressText');
                const saveAddressSpinner = document.getElementById('saveAddressSpinner');

                saveAddressText.textContent = 'Saving...';
                saveAddressSpinner.style.display = 'inline-block';

                fetch('{{ route("user.update-address") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ country, state, city, postal_code, address })
                })
                .then(response => response.ok ? response.json() : Promise.reject('Network response was not ok'))
                .then(data => {
                    if (data.success) {
                        addressVerified = true;
                        hideModal(modals.address);
                        showAddressSavedPopup();
                    } else {
                        throw new Error(data.message || 'Failed to save address');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Failed to save address. Please try again.',
                        confirmButtonText: 'OK'
                    });
                })
                .finally(() => {
                    saveAddressText.textContent = 'Save Address';
                    saveAddressSpinner.style.display = 'none';
                });
            });

            // Cancel buttons
            document.getElementById('typeCancelBtn').addEventListener('click', hideAllModals);
            document.getElementById('methodCancelBtn').addEventListener('click', () => {
                hideModal(modals.method);
                showModal(modals.type);
            });

            // Prevent modal closing when clicking inside
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal && !modal.classList.contains('allow-close')) {
                        e.stopPropagation();
                    }
                });
            });

            // Initialize UI state
            document.querySelector('.manual-methods').style.display = 'block';
            document.querySelector('.automatic-methods').style.display = 'none';

            // Custom package functionality
            const customPackageCard = document.getElementById('customPackageCard');
            const customPackageModal = document.getElementById('customPackageModal');
            const customAmountInput = document.getElementById('customAmountInput');
            const customPackagePreview = document.getElementById('customPackagePreview');
            const previewCoins = document.getElementById('previewCoins');
            const customContinueBtn = document.getElementById('customContinueBtn');
            const customCancelBtn = document.getElementById('customCancelBtn');

            // Add custom modal to modals object
            modals.custom = customPackageModal;

            // Custom package card click
            customPackageCard.addEventListener('click', function() {
                if (!checkAddressDetails()) return;
                showModal(modals.custom);
            });

            // Custom amount input
            customAmountInput.addEventListener('input', function() {
                const amount = parseFloat(this.value) || 0;
                if (amount >= 101) {
                    const coins = Math.floor(amount * 100);
                    previewCoins.textContent = coins.toLocaleString();
                    customPackagePreview.style.display = 'block';
                    customContinueBtn.style.opacity = '1';
                    customContinueBtn.style.pointerEvents = 'auto';
                    customContinueBtn.textContent = 'Continue';
                } else {
                    customPackagePreview.style.display = 'none';
                    customContinueBtn.style.opacity = '0.5';
                    customContinueBtn.style.pointerEvents = 'none';
                    customContinueBtn.textContent = amount > 0 && amount < 101 ? 'Minimum $101' : 'Continue';
                }
            });

            // Custom continue button
            customContinueBtn.addEventListener('click', function() {
                const amount = parseFloat(customAmountInput.value);
                if (amount >= 101) {
                    isPurchasing = true;
                    selectedPackagePrice = amount;
                    selectedPackageName = 'Custom';
                    selectedPackageCoins = Math.floor(amount * 100);
                    selectedPackageBonus = 0;
                    selectedPackageUuid = 'custom-' + Date.now();
                    hideModal(modals.custom);
                    showModal(modals.type);
                }
            });

            // Custom cancel button
            customCancelBtn.addEventListener('click', function() {
                hideModal(modals.custom);
                customAmountInput.value = '';
                customPackagePreview.style.display = 'none';
                customContinueBtn.style.opacity = '0.5';
                customContinueBtn.style.pointerEvents = 'none';
            });
        });


    </script>
    @endpush
</x-app-layout>
