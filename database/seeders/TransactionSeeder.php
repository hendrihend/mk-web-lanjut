<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $users = User::factory()->count(5)->create();
        }

        foreach ($users as $user) {
            Transaction::factory()
                ->count(10)
                ->create([
                    'user_id' => $user->id,
                ]);
        }
    }
}
