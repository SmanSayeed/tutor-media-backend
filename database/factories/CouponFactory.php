<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => Str::upper(Str::random(10)),
            'type' => $this->faker->randomElement(['fixed', 'percent']),
            'value' => $this->faker->numberBetween(5, 50),
            'expires_at' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
            'is_active' => true,
        ];
    }
}
