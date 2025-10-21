<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class LocationController extends Controller
{
    public function detect(Request $request)
    {
        try {
            $originalIp = $request->ip();
            $ip = $originalIp;
            
            // For local testing, use a real IP
            if ($ip === '127.0.0.1' || $ip === '::1' || str_starts_with($ip, '192.168.')) {
                $ip = '8.8.8.8'; // Google DNS IP for testing
            }
            
            $position = Location::get($ip);
            
            // Debug: Log what we got
            \Log::info('Location Detection', [
                'original_ip' => $originalIp,
                'used_ip' => $ip,
                'position' => $position ? $position->toArray() : null,
                'config_testing' => config('location.testing.enabled')
            ]);
            
            if ($position) {
                return response()->json([
                    'success' => true,
                    'city' => $position->cityName ?? $position->regionName ?? 'Unknown',
                    'country' => $position->countryCode ?? 'XX',
                    'debug' => [
                        'original_ip' => $originalIp,
                        'used_ip' => $ip,
                        'driver' => $position->driver ?? 'unknown',
                        'country_name' => $position->countryName ?? 'none',
                        'testing_enabled' => config('location.testing.enabled')
                    ]
                ]);
            }
            
            // Fallback to default location
            return response()->json([
                'success' => false,
                'city' => 'Global',
                'country' => 'WW',
                'debug' => [
                    'original_ip' => $originalIp,
                    'used_ip' => $ip,
                    'position' => 'null',
                    'testing_enabled' => config('location.testing.enabled')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'city' => 'Global',
                'country' => 'WW',
                'error' => $e->getMessage(),
                'debug' => [
                    'original_ip' => $originalIp ?? 'unknown',
                    'testing_enabled' => config('location.testing.enabled')
                ]
            ]);
        }
    }
}