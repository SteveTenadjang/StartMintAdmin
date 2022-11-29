<?php

namespace Database\Seeders;

use App\Models\NFT;
use App\Models\User;
use App\Models\UserBundle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            BundleSeeder::class
        ]);
        $tenas = User::query()->create([
            'name' => 'tenas',
            'email' => 'tenas@gmail.com',
            'password' => Hash::make('password'),
            'wallet' => uuid_create()
        ]);
        $tenas->bundle()->attach(2);

        User::factory(50)->create();
        NFT::factory(100)->create();
        UserBundle::factory(20)->create();
    }
}
