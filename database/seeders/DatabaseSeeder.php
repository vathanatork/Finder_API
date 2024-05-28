<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            AdrProvinceSeeder::class,
            AdrDistrictSeeder::class,
            AdrCommuneSeeder::class,
            AdrVillageSeeder::class,
        ]);

    }
}
