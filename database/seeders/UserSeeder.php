<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super@example.com',
            'password' => Hash::make('super'),
        ]);

        $superAdmin->assignRole('Super Admin');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'head_id' => 3,
            'password' => Hash::make('admin123'),
        ]);

        $admin->assignRole('Admin');

        $head = User::create([
            'name' => 'Departemen Head',
            'email' => 'deptHead@example.com',
            'password' => Hash::make('head123'),
        ]);

        $head->assignRole('Division Head');
        
        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'),
        ]);

        $user->assignRole('User');

        
    }
}
