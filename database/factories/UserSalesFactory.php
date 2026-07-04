<?php

namespace Database\Factories;

use App\Models\UserSales;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserSalesFactory extends Factory
{
    protected $model = UserSales::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'sales_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'region' => $this->faker->randomElement(['Jakarta', 'Surabaya', 'Medan', 'Bandung', 'Semarang', 'Yogyakarta', 'Makassar', 'Palembang']),
            'quota' => $this->faker->numberBetween(10000000, 100000000),
            'achievement' => $this->faker->numberBetween(5000000, 90000000),
            'commission_rate' => $this->faker->randomElement([3.00, 5.00, 7.50, 10.00]),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'notes' => $this->faker->sentence(),
        ];
    }
}
