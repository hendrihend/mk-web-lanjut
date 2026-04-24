<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MarketingUser;

class MarketingUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat 20 marketing users menggunakan factory
        MarketingUser::factory(20)->create();

        // Atau buat data seed manual
        MarketingUser::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@example.com',
            'phone' => '08123456789',
            'position' => 'Senior Marketing Manager',
            'department' => 'Marketing',
            'territory' => 'Jakarta',
            'status' => 'active',
            'notes' => 'Manager senior untuk wilayah Jakarta',
        ]);

        MarketingUser::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti.nurhaliza@example.com',
            'phone' => '08987654321',
            'position' => 'Marketing Executive',
            'department' => 'Sales',
            'territory' => 'Surabaya',
            'status' => 'active',
            'notes' => 'Executive di wilayah Surabaya',
        ]);
    }
}
