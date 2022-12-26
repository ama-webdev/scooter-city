<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'admin',
            'vendor',
            'user',
        ];

        $guard_name = 'web';
        foreach ($roles as $role) {
            $role = Role::create([
                'name' => $role,
                'guard_name' => $guard_name,
            ]);
        }
    }
}