<?php

namespace Database\Seeders;

use App\Models\Bundle;
use Illuminate\Database\Seeder;

class BundleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Bundle::query()->create(['name'=> 'classic', 'limit' => 5]);
        Bundle::query()->create(['name'=> 'premium', 'limit' => 15]);
    }
}
