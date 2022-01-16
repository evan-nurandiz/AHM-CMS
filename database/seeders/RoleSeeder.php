<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $divisionHead = Role::create(['name' => 'Division Head']);
        $admin = Role::create(['name' => 'Admin']);
        $user = Role::create(['name' => 'User']);
        
    }
}
