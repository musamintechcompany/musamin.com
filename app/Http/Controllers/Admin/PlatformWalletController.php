<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformWallet;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PlatformWalletController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        
        $totals = PlatformWallet::getCurrentTotals();
        
        $transactions = PlatformWallet::with('transactionable')
            ->latest()
            ->paginate(20);
        
        return view('management.portal.admin.platform-wallet.index', compact(
            'totals',
            'transactions'
        ));
    }
}