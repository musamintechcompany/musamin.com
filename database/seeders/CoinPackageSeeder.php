<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CoinPackage;

class CoinPackageSeeder extends Seeder
{
    public function run()
    {
        $packages = [
            [
                'pack_name' => 'M - I',
                'coins' => 200,
                'bonus_coins' => 0,
                'price' => 2.00,
                'features' => ['Instant Delivery'],
                'badge_color' => '#10B981',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'pack_name' => 'M - II',
                'coins' => 500,
                'bonus_coins' => 0,
                'price' => 5.00,
                'features' => ['Instant Delivery'],
                'badge_color' => '#3B82F6',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'pack_name' => 'M - III',
                'coins' => 1000,
                'bonus_coins' => 0,
                'price' => 10.00,
                'features' => ['Instant Delivery'],
                'badge_color' => '#8B5CF6',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'pack_name' => 'M - IV',
                'coins' => 2000,
                'bonus_coins' => 0,
                'price' => 20.00,
                'features' => ['Instant Delivery'],
                'badge_color' => '#F59E0B',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'pack_name' => 'M - V',
                'coins' => 3000,
                'bonus_coins' => 0,
                'price' => 30.00,
                'features' => ['Instant Delivery'],
                'badge_color' => '#EF4444',
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'pack_name' => 'M - VI',
                'coins' => 5000,
                'bonus_coins' => 0,
                'price' => 50.00,
                'features' => ['Instant Delivery'],
                'badge_color' => '#EC4899',
                'is_active' => true,
                'sort_order' => 6
            ],
            [
                'pack_name' => 'M - VII',
                'coins' => 7500,
                'bonus_coins' => 0,
                'price' => 75.00,
                'features' => ['Instant Delivery'],
                'badge_color' => '#06B6D4',
                'is_active' => true,
                'sort_order' => 7
            ],
            [
                'pack_name' => 'M - VIII',
                'coins' => 10000,
                'bonus_coins' => 0,
                'price' => 100.00,
                'features' => ['Instant Delivery'],
                'badge_color' => '#84CC16',
                'is_active' => true,
                'sort_order' => 8
            ],

        ];

        foreach ($packages as $package) {
            CoinPackage::create($package);
        }
    }
}