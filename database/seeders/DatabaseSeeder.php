<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat 1 test user terlebih dahulu
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Buat 9 user tambahan untuk dropdown
        User::factory(9)->create();

        // Seed MarketingUserSeeder, TransactionSeeder and UserSalesSeeder
        $this->call([
            MarketingUserSeeder::class,
            TransactionSeeder::class,
            UserSalesSeeder::class,
        ]);
    }
}
