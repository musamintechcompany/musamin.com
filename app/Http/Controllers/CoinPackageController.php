<?php

namespace App\Http\Controllers;

use App\Models\CoinPackage;
use App\Models\Setting;
use Illuminate\Http\Request;

class CoinPackageController extends Controller
{
    public function index()
    {
        // Get or create settings
        $settings = Setting::getSettings();

        // Calculate fee multiplier once on server side
        $feeMultiplier = ($settings->purchase_fee_type === 'fixed')
            ? $settings->purchase_fee
            : $settings->purchase_fee / 100;

        return view('coin-packages.index', [
            'coinPackages' => CoinPackage::where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('price')
                ->get(),

            'manualPaymentMethods' => app(PaymentMethodController::class)
                ->getManualMethods()
                ->getData(),

            // Simplified fee calculation variables
            'isFixedFee' => $settings->purchase_fee_type === 'fixed',
            'feeMultiplier' => $feeMultiplier,

            // Backward compatibility
            'feeSettings' => [
                'type' => $settings->purchase_fee_type,
                'value' => $settings->purchase_fee
            ]
        ]);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $packages = CoinPackage::where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('price')
                ->get();

            return response()->json([
                'success' => true,
                'packages' => $packages
            ]);
        }

        return response()->json(['success' => false], 400);
    }
}
