<?php

namespace App\Http\Controllers;

use App\Models\CoinTransaction;
use App\Models\CoinPackage;
use App\Models\User;
use App\Mail\CoinTransactionSubmitted;
use App\Mail\CoinTransactionApproved;
use App\Mail\CoinTransactionDeclined;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Hashids\Hashids;

class CoinTransactionController extends Controller
{
    protected $hashids;

    public function __construct()
    {
        $this->hashids = new Hashids(config('app.key'), 10);
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|string',
            'payment_type' => 'required|in:manual,auto',
            'payment_method' => 'required|string',
            'payment_credentials' => 'required|array',
            'amount' => 'required|numeric',
            'base_coins' => 'required|integer',
            'bonus_coins' => 'required|integer',
            'countdown_time' => 'required|integer',
            'time_taken' => 'required|integer',
            'ip_address' => 'required|ip',
            'user_agent' => 'required|string'
        ]);

        $user = Auth::user();
        
        // Handle custom packages
        $isCustom = str_starts_with($validated['package_id'], 'custom-');
        if ($isCustom) {
            $packageId = null;
            $packageName = 'Custom';
        } else {
            // Validate existing package
            $package = CoinPackage::find($validated['package_id']);
            if (!$package) {
                return response()->json(['success' => false, 'message' => 'Package not found'], 404);
            }
            $packageId = $package->id;
            $packageName = $package->pack_name;
        }

        // Synchronous processing
        $transaction = CoinTransaction::create([
            'user_id' => $user->id,
            'package_id' => $packageId,
            'package_name' => $packageName,
            'base_coins' => $validated['base_coins'],
            'bonus_coins' => $validated['bonus_coins'],
            'amount' => $validated['amount'],
            'payment_type' => $validated['payment_type'],
            'payment_method' => $validated['payment_method'],
            'payment_credentials' => $validated['payment_credentials'],
            'countdown_time' => $validated['countdown_time'],
            'time_taken' => $validated['time_taken'],
            'ip_address' => $validated['ip_address'],
            'user_agent' => $validated['user_agent'],
            'status' => 'processing'
        ]);

        return response()->json([
            'success' => true,
            'transaction_id' => $transaction->id
        ]);
    }

    public function complete(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|string',
            'proofs' => 'required|array|min:1',
            'proofs.*' => 'file|mimes:jpg,jpeg,png,gif,pdf|max:5120',
            'notes' => 'nullable|string|max:500'
        ]);

        $transaction = CoinTransaction::find($validated['transaction_id']);
        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaction not found'], 404);
        }

        // Synchronous processing
        $transaction->update([
            'proofs' => $this->storeProofs($request->file('proofs')),
            'user_notes' => $validated['notes'] ?? null,
            'status' => 'pending'
        ]);

        Mail::to($transaction->user->email)
            ->queue(new CoinTransactionSubmitted($transaction));

        return response()->json([
            'success' => true,
            'hashid' => $transaction->hashid
        ]);
    }

    public function approve(CoinTransaction $transaction, Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate(['comments' => 'nullable|string|max:500']);

        $this->ensureWalletExists($transaction->user);

        $transaction->update([
            'status' => 'approved',
            'processed_by' => $user->id,
            'staff_comments' => $validated['comments'],
            'completed_at' => now()
        ]);

        $transaction->user()->increment('spendable_coins', $transaction->totalCoins());

        // Send email via queue
        Mail::to($transaction->user->email)
            ->queue((new CoinTransactionApproved($transaction))->onQueue('emails'));

        return response()->json(['success' => true]);
    }

    public function decline(CoinTransaction $transaction, Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'reason' => 'required|string|max:255',
            'comments' => 'nullable|string|max:500'
        ]);

        $transaction->update([
            'status' => 'declined',
            'processed_by' => $user->id,
            'decline_reason' => $validated['reason'],
            'staff_comments' => $validated['comments'],
            'completed_at' => now()
        ]);

        // Send email via queue
        Mail::to($transaction->user->email)
            ->queue((new CoinTransactionDeclined($transaction))->onQueue('emails'));

        return response()->json(['success' => true]);
    }

    protected function ensureWalletExists(User $user)
    {
        if (empty($user->spending_wallet_id)) {
            $user->update([
                'spending_wallet_id' => 'SP-' . $user->generateWalletId(9),
                'earned_wallet_id' => 'EN-' . $user->generateWalletId(9)
            ]);
        }
    }

    private function storeProofs($files)
    {
        return collect($files)->map(function ($file) {
            return $file->store('transaction-proofs', 'public');
        })->all();
    }
}
