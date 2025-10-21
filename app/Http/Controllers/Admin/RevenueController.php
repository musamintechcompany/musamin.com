<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Revenue;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RevenueController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $totalRevenue = Revenue::confirmed()->get()->sum('amount');
        $todayRevenue = Revenue::confirmed()
            ->whereDate('created_at', today())
            ->get()->sum('amount');
        $monthRevenue = Revenue::confirmed()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->get()->sum('amount');
        $lastMonthRevenue = Revenue::confirmed()
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->get()->sum('amount');
        $lastYearRevenue = Revenue::confirmed()
            ->whereYear('created_at', now()->subYear()->year)
            ->get()->sum('amount');

        return view('management.portal.admin.revenue.index', compact(
            'totalRevenue', 
            'todayRevenue', 
            'monthRevenue',
            'lastMonthRevenue',
            'lastYearRevenue'
        ));
    }
}