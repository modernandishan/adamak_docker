<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::firstOrCreate(
            [
                'name' => 'محمدجواد',
                'family' => 'قانع دستجردی',
                'mobile' => '09332253169', // Please change to the actual mobile number
                'password' => Hash::make('password'), // Please choose a strong password
                'mobile_verified_at' => now(),
            ]
        );

        // Assign the 'super_admin' role to the user
        // This will not cause a conflict with the observer
        //$superAdmin->assignRole('super_admin');
    }
}
