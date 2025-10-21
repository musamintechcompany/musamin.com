<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemWallet;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SystemWalletController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        
        $currentBalance = SystemWallet::getCurrentBalance();
        $totalInflows = SystemWallet::inflows()->sum('amount');
        $totalOutflows = abs(SystemWallet::outflows()->sum('amount'));
        
        $transactions = SystemWallet::with('transactionable')
            ->latest()
            ->paginate(20);
        
        return view('management.portal.admin.system-wallet.index', compact(
            'currentBalance',
            'totalInflows', 
            'totalOutflows',
            'transactions'
        ));
    }
}