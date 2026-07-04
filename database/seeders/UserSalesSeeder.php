<?php

namespace Database\Seeders;

use App\Models\UserSales;
use Illuminate\Database\Seeder;

class UserSalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserSales::factory(15)->create();
    }
}
