<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoinTransaction;
use App\Mail\CoinTransactionApproved;
use App\Mail\CoinTransactionDeclined;
use App\Notifications\CoinPurchaseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CoinTransactionController extends Controller
{
    public function pending()
    {
        $transactions = CoinTransaction::with(['user', 'package'])
            ->pending()
            ->latest()
            ->paginate(20);
            
        return view('management.portal.admin.coin-transactions.pending', compact('transactions'));
    }

    public function history()
    {
        $transactions = CoinTransaction::with(['user', 'package'])
            ->completed()
            ->latest()
            ->paginate(20);
            
        return view('management.portal.admin.coin-transactions.history', compact('transactions'));
    }

    public function show(CoinTransaction $coinTransaction)
    {
        $coinTransaction->load(['user', 'package']);
        return view('management.portal.admin.coin-transactions.view', compact('coinTransaction'));
    }

    public function approve(Request $request, CoinTransaction $coinTransaction)
    {
        $request->validate([
            'staff_comments' => 'nullable|string|max:500'
        ]);

        $coinTransaction->update([
            'status' => 'approved',
            'staff_comments' => $request->staff_comments,
            'completed_at' => now()
        ]);

        // Credit coins to user's spending wallet
        $coinTransaction->user->increment('spendable_coins', $coinTransaction->totalCoins());

        // Send approval email
        Mail::to($coinTransaction->user->email)->queue(new CoinTransactionApproved($coinTransaction));

        // Send coin purchase notification for wallet activities
        $coinTransaction->user->notify(new CoinPurchaseNotification($coinTransaction));

        return redirect()->back()->with('success', 'Transaction approved and coins credited successfully.');
    }

    public function decline(Request $request, CoinTransaction $coinTransaction)
    {
        $request->validate([
            'decline_reason' => 'required|string|max:500',
            'staff_comments' => 'nullable|string|max:500'
        ]);

        $coinTransaction->update([
            'status' => 'declined',
            'decline_reason' => $request->decline_reason,
            'staff_comments' => $request->staff_comments,
            'completed_at' => now()
        ]);

        // Send decline email
        Mail::to($coinTransaction->user->email)->queue(new CoinTransactionDeclined($coinTransaction));

        return redirect()->back()->with('success', 'Transaction declined successfully.');
    }

    public function pendingData(Request $request)
    {
        if ($request->ajax()) {
            $transactions = CoinTransaction::with(['user', 'package'])
                ->pending()
                ->latest()
                ->paginate(20);

            return response()->json([
                'success' => true,
                'transactions' => $transactions
            ]);
        }

        return response()->json(['success' => false], 400);
    }
}