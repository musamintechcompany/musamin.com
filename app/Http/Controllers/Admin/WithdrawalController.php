<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\WithdrawalApproved;
use App\Mail\WithdrawalRejected;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with(['user', 'withdrawalDetail', 'processedBy'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('management.portal.admin.withdrawals.index', compact('withdrawals'));
    }

    public function history()
    {
        $withdrawals = Withdrawal::with(['user', 'withdrawalDetail', 'processedBy'])
            ->whereIn('status', ['approved', 'rejected', 'completed'])
            ->orderBy('processed_at', 'desc')
            ->paginate(20);

        return view('management.portal.admin.withdrawals.history', compact('withdrawals'));
    }

    public function view(Withdrawal $withdrawal)
    {
        $withdrawal->load(['user', 'withdrawalDetail', 'processedBy']);
        return view('management.portal.admin.withdrawals.view', compact('withdrawal'));
    }

    public function approve(Request $request, Withdrawal $withdrawal)
    {
        if (!$withdrawal->isPending()) {
            return response()->json(['success' => false, 'message' => 'Withdrawal is not pending']);
        }

        DB::beginTransaction();
        try {
            $withdrawal->update([
                'status' => 'approved',
                'admin_notes' => $request->notes,
                'processed_by' => auth('admin')->id(),
                'processed_at' => now()
            ]);

            // Send approval email
            Mail::to($withdrawal->user->email)->queue(new WithdrawalApproved($withdrawal));
            
            // Notify user
            $withdrawal->user->notify(new \App\Notifications\WithdrawalApprovedNotification($withdrawal));

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Withdrawal approved successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Failed to approve withdrawal']);
        }
    }

    public function reject(Request $request, Withdrawal $withdrawal)
    {
        if (!$withdrawal->isPending()) {
            return response()->json(['success' => false, 'message' => 'Withdrawal is not pending']);
        }

        DB::beginTransaction();
        try {
            // Refund coins to user
            $withdrawal->user->increment('earned_coins', $withdrawal->amount + $withdrawal->fee);

            $withdrawal->update([
                'status' => 'rejected',
                'admin_notes' => $request->notes,
                'processed_by' => auth('admin')->id(),
                'processed_at' => now()
            ]);

            // Send rejection email
            Mail::to($withdrawal->user->email)->queue(new WithdrawalRejected($withdrawal));
            
            // Notify user
            $withdrawal->user->notify(new \App\Notifications\WithdrawalRejectedNotification($withdrawal));

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Withdrawal rejected and coins refunded']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Failed to reject withdrawal']);
        }
    }
}