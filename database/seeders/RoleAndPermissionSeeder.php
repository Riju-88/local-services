<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $adminRole = Role::create(['name' => 'admin']);
        $providerRole = Role::create(['name' => 'provider']);
        $userRole = Role::create(['name' => 'user']);

        Permission::create(['name' => 'manage services']);
        Permission::create(['name' => 'manage service categories']);
        Permission::create(['name' => 'view services']);
        Permission::create(['name' => 'view service categories']);
        Permission::create(['name' => 'manage providers']);
        Permission::create(['name' => 'manage reviews']);

        $adminRole->givePermissionTo('manage services', 'manage service categories', 'manage providers', 'manage reviews');

        $providerRole->syncPermissions($userRole->permissions);
        $userRole->givePermissionTo('view services', 'view service categories', 'manage reviews', 'manage providers');




    }
}
