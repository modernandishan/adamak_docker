<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::firstOrCreate(
            ['mobile' => '09332253169'],
            [
                'name' => 'محمدجواد',
                'family' => 'قانع دستجردی',
                'password' => Hash::make('password'),
                'mobile_verified_at' => now(),
            ]
        );

        if (!$superAdmin->profile) {
            Profile::create([
                'user_id' => $superAdmin->id,
                'avatar' => null,
                'province' => 'تهران',
                'address' => 'آدرس نمونه',
                'postal_code' => '1234567890',
                'national_code' => '0012345678',
                'birth' => now()->subYears(30),
            ]);
        }

        if (!$superAdmin->wallet) {
            Wallet::create([
                'user_id' => $superAdmin->id,
                'balance' => 0
            ]);
        }

        $superAdmin->assignRole('super_admin');
    }
}
