<?php

namespace Database\Factories;

use App\Models\NFT;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NFT>
 */
class NFTFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_name' => fake()->userName,
            'contract_address' => fake()->address,
            'wallet' => fake()->unique()->uuid,
            'token' => fake()->unique()->uuid,
            'media_link' => fake()->localIpv4,
            'media_type' => fake()->word(),
            'media_title' => fake()->word,
            'nft_quantity' => fake()->randomDigitNotZero(),
            'price' => fake()->randomFloat(),
            'description' => fake()->sentence(4),
            'blockchain_type' => fake()->word,
            'created_by' => fake()->randomElement(User::query()->pluck('id')),
        ];
    }
}
