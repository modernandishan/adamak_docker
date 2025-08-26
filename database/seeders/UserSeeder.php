<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create Super Admin
        $superAdmin = User::firstOrCreate(
            ['mobile' => '09332253169'],
            [
                'name' => 'محمدجواد',
                'family' => 'قانع دستجردی',
                'password' => Hash::make('password'),
                'mobile_verified_at' => now(),
            ]
        );

        if (! $superAdmin->profile) {
            Profile::create([
                'user_id' => $superAdmin->id,
                'avatar' => null,
                'province' => 'اصفهان',
                'address' => 'شرکت مدرن اندیشان جی',
                'postal_code' => '1234567890',
                'national_code' => '1234567890',
                'birth' => now()->subYears(25),
            ]);
        }

        if (! $superAdmin->wallet) {
            Wallet::create([
                'user_id' => $superAdmin->id,
                'balance' => 0,
            ]);
        }

        $superAdmin->assignRole('super_admin');

        // Create Admin User
        /*$admin = User::firstOrCreate(
            ['mobile' => '09123456789'],
            [
                'name' => 'ادمین',
                'family' => 'سیستم',
                'password' => Hash::make('password'),
                'mobile_verified_at' => now(),
            ]
        );

        Profile::firstOrCreate([
            'user_id' => $admin->id,
        ], [
            'avatar' => null,
            'province' => 'تهران',
            'address' => 'آدرس ادمین',
            'postal_code' => '1234567891',
            'national_code' => '0012345679',
            'birth' => now()->subYears(25),
        ]);

        Wallet::firstOrCreate([
            'user_id' => $admin->id,
        ], [
            'balance' => 0,
        ]);

        $admin->assignRole('admin');

        // Create Consultant User
        $consultant = User::firstOrCreate(
            ['mobile' => '09444444444'],
            [
                'name' => 'دکتر محمد',
                'family' => 'رضایی',
                'password' => Hash::make('password'),
                'mobile_verified_at' => now(),
            ]
        );

        Profile::firstOrCreate([
            'user_id' => $consultant->id,
        ], [
            'avatar' => null,
            'province' => 'تهران',
            'address' => 'تهران، خیابان انقلاب',
            'postal_code' => '1234567893',
            'national_code' => '0012345677',
            'birth' => now()->subYears(35),
        ]);

        Wallet::firstOrCreate([
            'user_id' => $consultant->id,
        ], [
            'balance' => 50000,
        ]);

        $consultant->assignRole('consultant');

        // Create Marketer User
        $marketer = User::firstOrCreate(
            ['mobile' => '09555555555'],
            [
                'name' => 'احمد',
                'family' => 'بازاریاب',
                'password' => Hash::make('password'),
                'mobile_verified_at' => now(),
                'commission_percentage' => 15.00, // 15% commission
            ]
        );

        Profile::firstOrCreate([
            'user_id' => $marketer->id,
        ], [
            'avatar' => null,
            'province' => 'تهران',
            'address' => 'تهران، خیابان کریمخان',
            'postal_code' => '1234567894',
            'national_code' => '0012345676',
            'birth' => now()->subYears(28),
        ]);

        Wallet::firstOrCreate([
            'user_id' => $marketer->id,
        ], [
            'balance' => 0,
        ]);

        $marketer->assignRole('marketer');

        // Create Regular Users with different profiles
        $regularUsers = [
            [
                'mobile' => '09111111111',
                'name' => 'علی',
                'family' => 'احمدی',
                'profile' => [
                    'province' => 'تهران',
                    'address' => 'تهران، خیابان ولیعصر',
                    'postal_code' => '1234567892',
                    'national_code' => '0012345680',
                    'birth' => now()->subYears(28),
                ],
                'wallet_balance' => 10000,
            ],
            [
                'mobile' => '09222222222',
                'name' => 'فاطمه',
                'family' => 'محمدی',
                'profile' => [
                    'province' => 'اصفهان',
                    'address' => 'اصفهان، خیابان چهارباغ',
                    'postal_code' => '8134567892',
                    'national_code' => '0012345681',
                    'birth' => now()->subYears(24),
                ],
                'wallet_balance' => 25000,
            ],
            [
                'mobile' => '09333333333',
                'name' => 'محمد',
                'family' => 'رضایی',
                'profile' => [
                    'province' => 'شیراز',
                    'address' => 'شیراز، خیابان زند',
                    'postal_code' => '7134567892',
                    'national_code' => '0012345682',
                    'birth' => now()->subYears(32),
                ],
                'wallet_balance' => 0,
            ],
        ];

        foreach ($regularUsers as $userData) {
            $user = User::firstOrCreate(
                ['mobile' => $userData['mobile']],
                [
                    'name' => $userData['name'],
                    'family' => $userData['family'],
                    'password' => Hash::make('password'),
                    'mobile_verified_at' => now(),
                ]
            );

            Profile::firstOrCreate([
                'user_id' => $user->id,
            ], $userData['profile']);

            Wallet::firstOrCreate([
                'user_id' => $user->id,
            ], [
                'balance' => $userData['wallet_balance'],
            ]);

            $user->assignRole('user');
        }*/
    }
}
