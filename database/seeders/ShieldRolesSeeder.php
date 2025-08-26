<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ShieldRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'user',
            'marketer',
            'consultant',
            'admin',
            'super_admin',
        ];

        foreach ($roles as $roleName) {
            if (! Role::where('name', $roleName)->where('guard_name', 'web')->exists()) {
                Role::create([
                    'name' => $roleName,
                    'guard_name' => 'web',
                ]);
            }
        }
    }
}
