<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reserved;

class ReservedWordsSeeder extends Seeder
{
    public function run(): void
    {
        $routeWords = [
            'admin', 'api', 'dashboard', 'login', 'register', 'password', 'email', 
            'stores', 'wallet', 'ideas', 'market-place', 'user-assets', 'support', 
            'profile', 'settings', 'coin-packages', 'payment-methods', 'coin-transactions',
            'home', 'marketplace', 'how-it-works', 'testimonials', 'contact', 'affiliate',
            'join-affiliate-program', 'affiliate-dashboard', 'asset-manager', 'my-code', 
            'earnings', 'forgot-password'
        ];

        $systemWords = [
            'www', 'mail', 'ftp', 'app', 'web', 'mobile', 'help', 'about', 
            'terms', 'privacy', 'blog', 'news', 'store', 'shop'
        ];

        Reserved::addReservedWords($routeWords, 'route', 'Application route');
        Reserved::addReservedWords($systemWords, 'system', 'System reserved');
    }
}