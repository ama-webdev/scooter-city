<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone_no' => '09111111111',
            'address' => 'Maubin',
            'gender' => 'male',
            'password' => Hash::make('admin123')
        ]);
        $admin->assignRole('admin');

        $company = User::create([
            'name' => 'Vendor',
            'email' => 'vendor@gmail.com',
            'phone_no' => '09111111111',
            'address' => 'Maubin',
            'gender' => 'male',
            'password' => Hash::make('admin123')
        ]);
        $company->assignRole('vendor');

        $freelancer = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'phone_no' => '09111111111',
            'address' => 'Maubin',
            'gender' => 'male',
            'password' => Hash::make('admin123')
        ]);
        $freelancer->assignRole('user');
    }
}