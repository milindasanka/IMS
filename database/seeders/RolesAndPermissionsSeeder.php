<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
                app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

                // Create permissions
                Permission::create(['name' => 'manage users']);
                Permission::create(['name' => 'edit articles']);
                Permission::create(['name' => 'delete articles']);
                Permission::create(['name' => 'view articles']);

                // Create roles and assign permissions
                $adminRole = Role::create(['name' => 'admin']);
                $adminRole->givePermissionTo(['manage users', 'edit articles', 'delete articles', 'view articles']);

                $userRole = Role::create(['name' => 'user']);
                $userRole->givePermissionTo(['view articles']);
    }
}
