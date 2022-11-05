<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\NFT;
use App\Models\User;
use App\Models\UserBundle;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $this->call([
            BundleSeeder::class
        ]);
         User::factory(10)->create();
         NFT::factory(10)->create();
         UserBundle::factory(10)->create();

         $tenas = User::factory()->create([
             'name' => 'TENAS STEVE',
             'email' => 'tenas@gmail.com',
             'password' => Hash::make('password'),
             'wallet' => uuid_create(),
         ]);
         $tenas->bundle()->attach(1);
    }
}
