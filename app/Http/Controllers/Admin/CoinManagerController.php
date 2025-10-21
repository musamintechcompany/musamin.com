<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CoinManagerController extends Controller
{
    public function index()
    {
        return view('management.portal.admin.coin-manager.index');
    }

    public function searchUsers(Request $request)
    {
        $query = $request->get('q');
        $users = User::where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->orWhere('username', 'like', "%{$query}%")
                    ->limit(10)
                    ->get(['id', 'name', 'email', 'coins']);

        return response()->json($users);
    }

    public function updateCoins(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'action' => 'required|in:credit,debit',
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'required|string|max:255'
        ]);

        $user = User::findOrFail($request->user_id);
        $amount = $request->amount;

        if ($request->action === 'credit') {
            $user->increment('coins', $amount);
            $message = "Credited {$amount} coins to {$user->name}";
        } else {
            if ($user->coins < $amount) {
                return back()->withErrors(['amount' => 'Insufficient coins to debit']);
            }
            $user->decrement('coins', $amount);
            $message = "Debited {$amount} coins from {$user->name}";
        }

        // Log the transaction
        \DB::table('coin_transactions')->insert([
            'id' => \Str::uuid(),
            'user_id' => $user->id,
            'type' => $request->action === 'credit' ? 'admin_credit' : 'admin_debit',
            'amount' => $amount,
            'status' => 'approved',
            'notes' => $request->reason,
            'completed_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', $message);
    }
}