<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Revenue;
use App\Models\SystemWallet;
use App\Mail\CoinTransferSentMail;
use App\Mail\CoinTransferReceivedMail;
use App\Events\CoinTransferSent;
use App\Events\CoinTransferReceived;

class CoinTransferController extends Controller
{
    // Transfer fees (in percentage)
    const INTERNAL_TRANSFER_FEE = 2; // 2% for earned -> spending
    const EXTERNAL_TRANSFER_FEE = 5; // 5% for earned -> other user
    
    /**
     * Internal transfer: earned wallet -> spending wallet
     */
    public function internal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $user = auth()->user();
        $amount = $request->amount;
        $fee = 0; // No fee for internal transfers
        $totalDeduction = $amount;

        // Validate sufficient balance
        if ($user->earned_coins < $totalDeduction) {
            return response()->json(['success' => false, 'message' => 'Insufficient balance in earned wallet']);
        }

        DB::beginTransaction();
        try {
            // Deduct from earned wallet
            $user->decrement('earned_coins', $totalDeduction);
            
            // Add to spending wallet (no fee deduction)
            $user->increment('spendable_coins', $amount);

            // Create notification
            $user->notifications()->create([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\\Notifications\\CoinTransferNotification',
                'data' => [
                    'type' => 'internal_transfer',
                    'amount' => $amount,
                    'fee' => $fee,
                    'from_wallet' => 'earned',
                    'to_wallet' => 'spending',
                    'message' => "Transferred {$amount} coins to spending wallet (No fee)"
                ],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();
            
            // Send email notification
            Mail::to($user->email)->queue(new CoinTransferSentMail(
                $amount, 
                $fee, 
                'internal', 
                null, 
                null, 
                'earned', 
                $user->fresh()->earned_coins
            ));
            
            // Broadcast push notification
            broadcast(new CoinTransferSent(
                $user, 
                $amount, 
                $fee, 
                'internal', 
                null, 
                $user->fresh()->earned_coins
            ));
            
            return response()->json([
                'success' => true, 
                'message' => "Successfully transferred {$amount} coins to spending wallet (No fee)",
                'fee' => $fee,
                'new_earned_balance' => $user->fresh()->earned_coins,
                'new_spending_balance' => $user->fresh()->spendable_coins
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Transfer failed. Please try again.']);
        }
    }

    /**
     * External transfer: wallet -> other user's wallet
     */
    public function external(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wallet_id' => 'required|string',
            'amount' => 'required|integer|min:1',
            'from_wallet' => 'required|in:earned,spending'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $user = auth()->user();
        $amount = $request->amount;
        $fee = ceil($amount * self::EXTERNAL_TRANSFER_FEE / 100);
        $totalDeduction = $amount + $fee;
        $walletId = $request->wallet_id;
        $fromWallet = $request->from_wallet;

        // Find recipient by wallet ID (check both earned and spending wallets)
        $recipient = User::where('earned_wallet_id', $walletId)
                        ->orWhere('spending_wallet_id', $walletId)
                        ->first();
        
        if (!$recipient) {
            return response()->json(['success' => false, 'message' => 'Invalid wallet ID']);
        }

        if ($recipient->id === $user->id) {
            return response()->json(['success' => false, 'message' => 'Cannot transfer to yourself']);
        }

        // Determine recipient wallet type
        $toWallet = $recipient->earned_wallet_id === $walletId ? 'earned' : 'spending';
        
        // Block spending -> earned transfers
        if ($fromWallet === 'spending' && $toWallet === 'earned') {
            return response()->json(['success' => false, 'message' => 'Cannot transfer from spending wallet to earned wallet']);
        }

        // Validate sufficient balance
        $userBalance = $fromWallet === 'earned' ? $user->earned_coins : $user->spendable_coins;
        if ($userBalance < $totalDeduction) {
            return response()->json(['success' => false, 'message' => "Insufficient balance in {$fromWallet} wallet"]);
        }

        DB::beginTransaction();
        try {
            // Deduct from sender's wallet
            if ($fromWallet === 'earned') {
                $user->decrement('earned_coins', $totalDeduction);
            } else {
                $user->decrement('spendable_coins', $totalDeduction);
            }
            
            // Add to recipient's wallet
            if ($toWallet === 'earned') {
                $recipient->increment('earned_coins', $amount);
            } else {
                $recipient->increment('spendable_coins', $amount);
            }

            // Record transfer fee as revenue (if fee > 0)
            if ($fee > 0) {
                Revenue::create([
                    'type' => 'external_transfer_fee',
                    'revenueable_type' => User::class,
                    'revenueable_id' => $user->id,
                    'data' => [
                        'amount' => $fee,
                        'currency' => 'USD',
                        'status' => 'confirmed',
                        'transfer_amount' => $amount,
                        'fee_percentage' => self::EXTERNAL_TRANSFER_FEE,
                        'from_wallet' => $fromWallet,
                        'to_wallet' => $toWallet,
                        'recipient_id' => $recipient->id,
                        'recipient_name' => $recipient->name
                    ]
                ]);

                // Record in system wallet
                SystemWallet::create([
                    'type' => 'fee_inflow',
                    'amount' => $fee,
                    'transactionable_type' => User::class,
                    'transactionable_id' => $user->id,
                    'description' => "External transfer fee from {$user->name} to {$recipient->name}"
                ]);
            }

            // Create notification for sender
            $user->notifications()->create([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\\Notifications\\CoinTransferNotification',
                'data' => [
                    'type' => 'external_transfer_sent',
                    'amount' => $amount,
                    'fee' => $fee,
                    'from_wallet' => $fromWallet,
                    'to_wallet' => $toWallet,
                    'recipient_name' => $recipient->name,
                    'recipient_wallet' => $walletId,
                    'message' => "Sent {$amount} coins to {$recipient->name}'s {$toWallet} wallet (Fee: {$fee} coins)"
                ],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Create notification for recipient
            $recipient->notifications()->create([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\\Notifications\\CoinTransferNotification',
                'data' => [
                    'type' => 'external_transfer_received',
                    'amount' => $amount,
                    'from_wallet' => $fromWallet,
                    'to_wallet' => $toWallet,
                    'sender_name' => $user->name,
                    'sender_wallet' => $fromWallet === 'earned' ? $user->earned_wallet_id : $user->spending_wallet_id,
                    'message' => "Received {$amount} coins from {$user->name} to your {$toWallet} wallet"
                ],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();
            
            // Send email notifications
            $senderBalance = $fromWallet === 'earned' ? $user->fresh()->earned_coins : $user->fresh()->spendable_coins;
            $recipientBalance = $toWallet === 'earned' ? $recipient->fresh()->earned_coins : $recipient->fresh()->spendable_coins;
            
            Mail::to($user->email)->queue(new CoinTransferSentMail(
                $amount, 
                $fee, 
                'external', 
                $recipient->name, 
                $walletId, 
                $fromWallet, 
                $senderBalance
            ));
            
            Mail::to($recipient->email)->queue(new CoinTransferReceivedMail(
                $amount, 
                $user->name, 
                $fromWallet === 'earned' ? $user->earned_wallet_id : $user->spending_wallet_id, 
                $recipientBalance
            ));
            
            // Broadcast push notifications
            broadcast(new CoinTransferSent(
                $user, 
                $amount, 
                $fee, 
                'external', 
                $recipient->name, 
                $senderBalance
            ));
            
            broadcast(new CoinTransferReceived(
                $recipient, 
                $amount, 
                $user->name, 
                $recipientBalance
            ));
            
            return response()->json([
                'success' => true, 
                'message' => "Successfully sent {$amount} coins to {$recipient->name}'s {$toWallet} wallet",
                'fee' => $fee,
                'recipient_name' => $recipient->name,
                'from_wallet' => $fromWallet,
                'to_wallet' => $toWallet,
                'new_balance' => $senderBalance
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Transfer failed. Please try again.']);
        }
    }

    /**
     * Get transfer fees
     */
    public function getFees(Request $request)
    {
        $amount = $request->get('amount', 0);
        
        return response()->json([
            'internal_fee' => 0, // No fee for internal transfers
            'external_fee' => ceil($amount * self::EXTERNAL_TRANSFER_FEE / 100),
            'internal_fee_percentage' => 0,
            'external_fee_percentage' => self::EXTERNAL_TRANSFER_FEE
        ]);
    }

    /**
     * Validate wallet ID
     */
    public function validateWallet(Request $request)
    {
        $walletId = $request->get('wallet_id');
        
        if (!$walletId) {
            return response()->json(['valid' => false, 'message' => 'Wallet ID required']);
        }

        // Check both earned and spending wallets
        $user = User::where('earned_wallet_id', $walletId)
                   ->orWhere('spending_wallet_id', $walletId)
                   ->first();
        
        if (!$user) {
            return response()->json(['valid' => false, 'message' => 'Invalid wallet ID']);
        }

        if ($user->id === auth()->id()) {
            return response()->json(['valid' => false, 'message' => 'Cannot transfer to yourself']);
        }

        // Determine wallet type
        $walletType = $user->earned_wallet_id === $walletId ? 'earned' : 'spending';

        return response()->json([
            'valid' => true, 
            'user_name' => $user->name,
            'wallet_type' => $walletType,
            'message' => "{$user->name}'s {$walletType} wallet"
        ]);
    }
}