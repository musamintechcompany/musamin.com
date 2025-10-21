<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Your Referral Program
        </h2>
    </x-slot>

    <style>
        .referral-card {
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
        }
        .card-header {
            background-color: #3490dc;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }
        .stat-card {
            border: 1px solid;
            height: 100%;
            border-radius: 0.5rem;
        }
        .stat-card .card-body {
            padding: 1.25rem;
            text-align: center;
        }
        .stat-number {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        .copy-btn {
            transition: all 0.3s ease;
        }
        .copy-btn:hover {
            background-color: #f8f9fa;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }
        .table th {
            background-color: #f8f9fa;
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .badge {
            display: inline-block;
            padding: 0.25em 0.4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
        }
        .badge-success {
            color: #fff;
            background-color: #28a745;
        }
        .badge-info {
            color: #fff;
            background-color: #17a2b8;
        }
    </style>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="referral-card">
                <div class="card-header">
                    <h4>Your Referral Program</h4>
                </div>

                <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-b-lg">
                    <div style="display: flex; flex-wrap: wrap; margin-bottom: 1.5rem;">
                        <div style="flex: 1; min-width: 250px; margin-bottom: 1rem; padding-right: 1rem;">
                            <h5 style="font-weight: 600; margin-bottom: 0.5rem;">Your Referral Code</h5>
                            <div style="display: flex;">
                                <input type="text" style="flex: 1; padding: 0.375rem 0.75rem; border: 1px solid #ced4da; border-radius: 0.25rem 0 0 0.25rem;" value="{{ $referralCode }}" readonly id="referralCode">
                                <button class="copy-btn" style="padding: 0.375rem 0.75rem; background-color: #e9ecef; border: 1px solid #ced4da; border-left: 0; border-radius: 0 0.25rem 0.25rem 0;" onclick="copyToClipboard('referralCode')">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                            </div>
                        </div>

                        <div style="flex: 1; min-width: 250px; margin-bottom: 1rem;">
                            <h5 style="font-weight: 600; margin-bottom: 0.5rem;">Your Referral Link</h5>
                            <div style="display: flex;">
                                <input type="text" style="flex: 1; padding: 0.375rem 0.75rem; border: 1px solid #ced4da; border-radius: 0.25rem 0 0 0.25rem;" value="{{ $referralLink }}" readonly id="referralLink">
                                <button class="copy-btn" style="padding: 0.375rem 0.75rem; background-color: #e9ecef; border: 1px solid #ced4da; border-left: 0; border-radius: 0 0.25rem 0.25rem 0;" onclick="copyToClipboard('referralLink')">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; flex-wrap: wrap; margin-bottom: 1.5rem; text-align: center;">
                        <div style="flex: 1; min-width: 200px; margin-bottom: 1rem; padding: 0 0.5rem;">
                            <div class="stat-card" style="border-color: #17a2b8;">
                                <div class="card-body">
                                    <h2 style="color: #17a2b8; margin-bottom: 0.5rem;">{{ $pendingCount }}</h2>
                                    <p style="color: #6c757d; margin-bottom: 0;">Pending Referrals</p>
                                </div>
                            </div>
                        </div>
                        <div style="flex: 1; min-width: 200px; margin-bottom: 1rem; padding: 0 0.5rem;">
                            <div class="stat-card" style="border-color: #28a745;">
                                <div class="card-body">
                                    <h2 style="color: #28a745; margin-bottom: 0.5rem;">{{ $completedCount }}</h2>
                                    <p style="color: #6c757d; margin-bottom: 0;">Completed Referrals</p>
                                </div>
                            </div>
                        </div>
                        <div style="flex: 1; min-width: 200px; margin-bottom: 1rem; padding: 0 0.5rem;">
                            <div class="stat-card" style="border-color: #ffc107;">
                                <div class="card-body">
                                    <h2 style="color: #ffc107; margin-bottom: 0.5rem;">{{ $earnedAmount }}</h2>
                                    <p style="color: #6c757d; margin-bottom: 0;">Total Coins Earned</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 style="font-weight: 600; margin-bottom: 1rem;">Referral History</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($referrals as $referral)
                                <tr>
                                    <td>{{ $referral->referee->name }}</td>
                                    <td>{{ $referral->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span style="{{ $referral->status === 'completed' ? 'background-color: #28a745;' : 'background-color: #17a2b8;' }} color: white; padding: 0.25em 0.4em; border-radius: 0.25rem; font-size: 75%;">
                                            {{ ucfirst($referral->status) }}
                                        </span>
                                        @if($referral->status === 'completed')
                                        <small style="color: #6c757d; display: block;">{{ $referral->completed_at->format('M d, Y') }}</small>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function copyToClipboard(elementId) {
        const element = document.getElementById(elementId);
        element.select();
        document.execCommand('copy');

        // Show tooltip or change button text temporarily
        const button = element.nextElementSibling;
        const originalHtml = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i> Copied!';

        setTimeout(() => {
            button.innerHTML = originalHtml;
        }, 2000);
    }
    </script>
</x-app-layout>
