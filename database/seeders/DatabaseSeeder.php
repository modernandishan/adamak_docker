<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Set seeding context to avoid UserObserver interference
        app()->bind('seeder', function () {
            return true;
        });

        $this->call([
            ShieldRolesSeeder::class,
            SettingsSeeder::class,
            UserSeeder::class,
            // ConsultantBiographySeeder::class,
            // TestCategorySeeder::class,
            // TestSeeder::class,
            // PostCategorySeeder::class,
            // PostSeeder::class,
        ]);
    }
}
