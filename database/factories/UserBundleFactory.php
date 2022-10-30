<?php

namespace Database\Factories;

use App\Models\Bundle;
use App\Models\User;
use App\Models\UserBundle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserBundle>
 */
class UserBundleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomElement(User::query()->pluck('id')),
            'bundle_id' => fake()->randomElement(Bundle::query()->pluck('id')),
        ];
    }
}
