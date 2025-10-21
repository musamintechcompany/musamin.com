<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Setting;
use App\Models\Withdrawal;
use App\Models\Admin;

class WithdrawalController extends Controller
{
    
    /**
     * Submit withdrawal request
     */
    public function submit(Request $request)
    {
        $settings = Setting::getSettings();
        $minWithdrawal = $settings->minimum_withdrawal_amount ?? 1000;
        
        $validator = Validator::make($request->all(), [
            'amount' => 'required|integer|min:' . $minWithdrawal,
            'bank_account_id' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $user = auth()->user();
        $amount = $request->amount;
        
        // Calculate fee based on settings
        if ($settings->withdrawal_fee_type === 'fixed') {
            $fee = $settings->withdrawal_fee ?? 0;
        } else {
            $fee = ceil($amount * ($settings->withdrawal_fee ?? 0) / 100);
        }
        
        $totalDeduction = $amount + $fee;
        $netAmount = $amount - $fee;

        // Validate sufficient balance in earned wallet only
        if ($user->earned_coins < $totalDeduction) {
            return response()->json([
                'success' => false, 
                'message' => 'Insufficient balance in earned wallet. You need at least ' . number_format($totalDeduction) . ' coins.'
            ]);
        }

        // Get selected bank account from user's withdrawal details
        $selectedBank = $user->withdrawalDetails()->find($request->bank_account_id);
        
        if (!$selectedBank) {
            return response()->json(['success' => false, 'message' => 'Invalid bank account selected']);
        }

        DB::beginTransaction();
        try {
            // Deduct from earned wallet
            $user->decrement('earned_coins', $totalDeduction);

            // Create withdrawal record
            $withdrawal = Withdrawal::create([
                'user_id' => $user->id,
                'withdrawal_detail_id' => $selectedBank->id,
                'amount' => $amount,
                'fee' => $fee,
                'net_amount' => $netAmount,
                'status' => 'pending'
            ]);
            
            // Create notification for user
            $user->notifications()->create([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\\Notifications\\WithdrawalNotification',
                'data' => [
                    'type' => 'withdrawal_submitted',
                    'withdrawal_id' => $withdrawal->id,
                    'amount' => $amount,
                    'fee' => $fee,
                    'net_amount' => $netAmount,
                    'bank_account' => $selectedBank->method_name,
                    'status' => 'pending',
                    'message' => "Withdrawal request submitted for {$amount} coins (Net: {$netAmount} coins after {$fee} coins fee)"
                ],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Notify admins about new withdrawal request
            $admins = Admin::where('is_active', true)->get();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\Admin\WithdrawalSubmittedNotification($withdrawal));
            }

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Your withdrawal request has been submitted successfully! 🎉',
                'details' => [
                    'withdrawal_id' => $withdrawal->id,
                    'amount' => $amount,
                    'fee' => $fee,
                    'net_amount' => $netAmount,
                    'processing_message' => 'Your request is being reviewed by our team. You will receive your funds within 1-3 business days once approved. Thank you for your patience! 💰'
                ],
                'new_earned_balance' => $user->fresh()->earned_coins
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Withdrawal request failed. Please try again.']);
        }
    }

    /**
     * Get withdrawal fees and limits
     */
    public function getFees(Request $request)
    {
        $amount = $request->get('amount', 0);
        $settings = Setting::getSettings();
        
        // Calculate fee based on settings
        if ($settings->withdrawal_fee_type === 'fixed') {
            $fee = $settings->withdrawal_fee ?? 0;
        } else {
            $fee = ceil($amount * ($settings->withdrawal_fee ?? 0) / 100);
        }
        
        $minWithdrawal = $settings->minimum_withdrawal_amount ?? 1000;
        $coinsToUsdRate = $settings->usd_to_coins_rate ?? 100;
        
        return response()->json([
            'fee' => $fee,
            'fee_type' => $settings->withdrawal_fee_type ?? 'percent',
            'fee_value' => $settings->withdrawal_fee ?? 0,
            'net_amount' => $amount - $fee,
            'min_withdrawal' => $minWithdrawal,
            'min_withdrawal_usd' => $minWithdrawal / $coinsToUsdRate,
            'coins_to_usd_rate' => $coinsToUsdRate
        ]);
    }

    /**
     * Get user's bank accounts
     */
    public function getBankAccounts()
    {
        $user = auth()->user();
        
        // Get user's withdrawal details (bank accounts)
        $accounts = $user->withdrawalDetails->map(function($detail) {
            return [
                'id' => $detail->id,
                'method_name' => $detail->method_name,
                'credentials' => $detail->credentials
            ];
        });
        
        return response()->json([
            'accounts' => $accounts
        ]);
    }
}