<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(SuperAdminSeeder::class);
        $this->call(ReservedWordsSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CountriesAndStatesSeeder::class);
        $this->call(CurrenciesSeeder::class);
        $this->call(CoinPackageSeeder::class);
    }
}
