<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KycVerification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\KycApproved;
use App\Mail\KycRejected;
use Illuminate\Support\Facades\Mail;

class KycController extends Controller
{
    /**
     * Display pending KYC submissions
     */
    public function index()
    {
        $kycs = KycVerification::with('user')
            ->where('status', 'pending')
            ->orderBy('submitted_at', 'desc')
            ->paginate(20);

        return view('management.portal.admin.kyc.index', compact('kycs'));
    }

    /**
     * Display KYC verification history
     */
    public function history()
    {
        $kycs = KycVerification::with('user')
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('reviewed_at', 'desc')
            ->paginate(20);

        return view('management.portal.admin.kyc.history', compact('kycs'));
    }

    /**
     * View KYC details (AJAX only)
     */
    public function view(KycVerification $kyc)
    {
        $kyc->load('user');
        return view('management.portal.admin.kyc.modal-content', compact('kyc'))->render();
    }

    /**
     * Approve KYC
     */
    public function approve(Request $request, KycVerification $kyc)
    {
        $validated = $request->validate([
            'reviewer_name' => 'required|string|max:100',
            'reviewer_notes' => 'nullable|string|max:500'
        ]);

        $kyc->approve($validated['reviewer_name'], $validated['reviewer_notes']);

        // Send approval email
        $kyc->refresh();
        Mail::to($kyc->user->email)->send(new KycApproved($kyc));

        return response()->json([
            'success' => true,
            'message' => 'KYC approved successfully'
        ]);
    }

    /**
     * Reject KYC
     */
    public function reject(Request $request, KycVerification $kyc)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
            'reviewer_name' => 'required|string|max:100',
            'reviewer_notes' => 'nullable|string|max:500'
        ]);

        $kyc->reject($validated['rejection_reason'], $validated['reviewer_name'], $validated['reviewer_notes']);

        // Send rejection email
        $kyc->refresh();
        Mail::to($kyc->user->email)->send(new KycRejected($kyc));

        return response()->json([
            'success' => true,
            'message' => 'KYC rejected successfully'
        ]);
    }

    /**
     * Get KYC statistics
     */
    public function stats()
    {
        $stats = [
            'pending' => KycVerification::where('status', 'pending')->count(),
            'approved' => KycVerification::where('status', 'approved')->count(),
            'rejected' => KycVerification::where('status', 'rejected')->count(),
            'total' => KycVerification::count(),
        ];

        return response()->json($stats);
    }
}
