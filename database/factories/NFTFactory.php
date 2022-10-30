<?php

namespace Database\Factories;

use App\Models\NFT;
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
            'media_link' => fake()->localIpv4,
            'media_type' => fake()->mimeType(),
            'title' => fake()->title,
            'max_quantity' => fake()->randomDigitNotNull(),
            'price' => fake()->randomFloat(),
            'description' => fake()->words(5),
            'blockchain_type' => fake()->word,
            'created_by' => 1,
        ];
    }
}
