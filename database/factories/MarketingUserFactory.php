<?php

namespace Database\Factories;

use App\Models\MarketingUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarketingUserFactory extends Factory
{
    protected $model = MarketingUser::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'position' => $this->faker->jobTitle(),
            'department' => $this->faker->randomElement(['Marketing', 'Sales', 'Business Development', 'Brand']),
            'territory' => $this->faker->randomElement(['Jakarta', 'Surabaya', 'Medan', 'Bandung', 'Semarang']),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'notes' => $this->faker->sentence(),
        ];
    }
}
