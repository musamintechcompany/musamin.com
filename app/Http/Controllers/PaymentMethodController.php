<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentMethodController extends Controller
{
    public function getManualMethods()
    {
        try {
            $methods = PaymentMethod::where('type', 'manual')
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(function ($method) {
                    $formatted = $this->formatMethodResponse($method);
                    Log::info("Method {$method->name} has " . count($formatted['credentials']) . " credentials");
                    return $formatted;
                });

            return response()->json($methods);
        } catch (\Exception $e) {
            Log::error("Failed to fetch manual payment methods: " . $e->getMessage());
            return response()->json([], 500);
        }
    }

    public function show($code)
    {
        try {
            $method = PaymentMethod::where('code', $code)
                ->where('is_active', true)
                ->firstOrFail();

            return response()->json($this->formatMethodResponse($method));
        } catch (\Exception $e) {
            Log::error("Failed to fetch payment method {$code}: " . $e->getMessage());
            return response()->json(['error' => 'Payment method not found'], 404);
        }
    }

    protected function formatMethodResponse(PaymentMethod $method): array
    {
        $credentials = [];
        try {
            if ($method->category === 'crypto') {
                $credentials = $this->formatCryptoCredentials($method->crypto_credentials);
            } elseif ($method->category === 'bank') {
                $credentials = $this->formatBankCredentials($method->bank_credentials);
            }
            
            Log::info("Formatted {$method->name}", [
                'category' => $method->category,
                'raw_data' => $method->category === 'bank' ? $method->bank_credentials : $method->crypto_credentials,
                'credential_count' => count($credentials)
            ]);
            
        } catch (\Exception $e) {
            Log::error("Error formatting credentials for method {$method->id}: " . $e->getMessage());
            $credentials = [];
        }

        return [
            'id' => $method->id,
            'hashid' => $method->hashid,
            'name' => $method->name,
            'code' => $method->code,
            'type' => $method->type,
            'category' => $method->category,
            'icon' => $method->icon ?? $this->getMethodIcon($method->code),
            'countdown_time' => $method->countdown_time,
            'usd_rate' => (float)$method->usd_rate,
            'currency_symbol' => $method->currency_symbol,
            'has_fee' => (bool)$method->has_fee,
            'credentials' => $credentials,
            'has_multiple' => count($credentials) > 1,
        ];
    }

    protected function formatCryptoCredentials($credentials): array
    {
        if (empty($credentials)) return [];

        $wallets = $credentials['wallets'] ?? [];
        $formatted = [];

        foreach ($wallets as $wallet) {
            if (($wallet['active'] ?? true)) {
                $formatted[] = [
                    'type' => 'crypto',
                    'address' => $wallet['address'] ?? '',
                    'qr_code' => $wallet['qr_code'] ?? null,
                    'network' => $wallet['network'] ?? null,
                    'comment' => $wallet['comment'] ?? null,
                    'active' => true
                ];
            }
        }

        return $formatted;
    }

    protected function formatBankCredentials($credentials): array
    {
        Log::info('Processing bank credentials:', ['data' => $credentials]);
        
        if (empty($credentials)) {
            Log::warning('Empty bank credentials');
            return [];
        }

        // Handle different structures
        $groups = [];
        if (isset($credentials['groups'])) {
            $groups = $credentials['groups'];
        } elseif (is_array($credentials) && !empty($credentials)) {
            $groups = $credentials;
        }

        if (empty($groups)) {
            Log::warning('No groups found');
            return [];
        }

        $formatted = [];
        foreach ($groups as $index => $group) {
            if (!($group['active'] ?? true)) continue;

            $details = [];
            if (isset($group['details']) && is_array($group['details'])) {
                foreach ($group['details'] as $detail) {
                    if (!empty($detail['title']) && !empty($detail['value'])) {
                        $details[] = [
                            'title' => $detail['title'],
                            'value' => $detail['value']
                        ];
                    }
                }
            }

            if (!empty($details)) {
                $formatted[] = [
                    'type' => 'bank',
                    'details' => $details,
                    'comment' => $group['comment'] ?? null,
                    'active' => true
                ];
            }
        }

        Log::info('Bank credentials formatted:', ['count' => count($formatted)]);
        return $formatted;
    }

    protected function getMethodIcon($code): string
    {
        return match(strtoupper($code)) {
            'BTC' => 'fab fa-bitcoin',
            'ETH' => 'fab fa-ethereum',
            'USDT' => 'fas fa-coins',
            'NGN' => 'fas fa-flag',
            default => 'fas fa-wallet',
        };
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $methods = PaymentMethod::where('type', 'manual')
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(function ($method) {
                    return $this->formatMethodResponse($method);
                });

            return response()->json([
                'success' => true,
                'methods' => $methods
            ]);
        }

        return response()->json(['success' => false], 400);
    }
}