<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::orderBy('sort_order')->paginate(10);
        return view('management.portal.admin.payment-methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('management.portal.admin.payment-methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:manual,automatic',
            'category' => 'required|in:crypto,bank',
            'code' => 'required|string|max:10',
            'icon' => 'required|string|max:255',
            'usd_rate' => 'required|numeric|min:0',
            'currency_symbol' => 'nullable|string|max:5',
            'countdown_time' => 'nullable|integer|min:30',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $data = [
            'name' => $request->name,
            'type' => $request->type,
            'category' => $request->category,
            'code' => $request->code,
            'icon' => $request->icon,
            'usd_rate' => $request->usd_rate,
            'currency_symbol' => $request->currency_symbol,
            'countdown_time' => $request->countdown_time,
            'has_fee' => $request->has('has_fee'),
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0
        ];

        // Handle crypto wallets
        if ($request->category === 'crypto' && $request->crypto_wallets) {
            $data['crypto_credentials'] = ['wallets' => $request->crypto_wallets];
        }

        // Handle bank groups
        if ($request->category === 'bank' && $request->bank_groups) {
            $data['bank_credentials'] = ['groups' => $request->bank_groups];
        }

        PaymentMethod::create($data);

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method created successfully.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('management.portal.admin.payment-methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:manual,automatic',
            'category' => 'required|in:crypto,bank',
            'code' => 'required|string|max:10',
            'icon' => 'required|string|max:255',
            'usd_rate' => 'required|numeric|min:0',
            'currency_symbol' => 'nullable|string|max:5',
            'countdown_time' => 'nullable|integer|min:30',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $data = [
            'name' => $request->name,
            'type' => $request->type,
            'category' => $request->category,
            'code' => $request->code,
            'icon' => $request->icon,
            'usd_rate' => $request->usd_rate,
            'currency_symbol' => $request->currency_symbol,
            'countdown_time' => $request->countdown_time,
            'has_fee' => $request->has('has_fee'),
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0
        ];

        // Handle crypto wallets
        if ($request->category === 'crypto' && $request->crypto_wallets) {
            $data['crypto_credentials'] = ['wallets' => $request->crypto_wallets];
        }

        // Handle bank groups
        if ($request->category === 'bank' && $request->bank_groups) {
            $data['bank_credentials'] = ['groups' => $request->bank_groups];
        }

        $paymentMethod->update($data);

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method updated successfully.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }
}