<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Wallet;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory()
            ->count(10)
            ->create();
        $users->each(function ($user) {
            Product::factory()
                ->count(rand(1, 20))
                ->for($user)
                ->create();
            Wallet::factory()
                ->for($user)
                ->create();
        });
    }
}
