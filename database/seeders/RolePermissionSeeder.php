<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view dashboard',

            'view products',
            'create products',
            'edit products',
            'delete products',

            'view categories',
            'manage categories',

            'view suppliers',
            'manage suppliers',

            'view units',
            'manage units',

            'view warehouses',
            'manage warehouses',

            'view inventory',
            'manage inventory',

            'view transactions',
            'create transactions',

            'view requests',
            'create requests',
            'approve requests',
            'reject requests',

            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $warehouse = Role::firstOrCreate(['name' => 'Warehouse']);
        $purchasing = Role::firstOrCreate(['name' => 'Purchasing']);
        $manager = Role::firstOrCreate(['name' => 'Manager']);

        $admin->syncPermissions(Permission::all());

        $warehouse->syncPermissions([
            'view dashboard',
            'view products',
            'view categories',
            'view units',
            'view warehouses',
            'view inventory',
            'manage inventory',
            'view transactions',
            'create transactions',
        ]);

        $purchasing->syncPermissions([
            'view dashboard',
            'view products',
            'view categories',
            'view suppliers',
            'view units',
            'view requests',
            'create requests',
        ]);

        $manager->syncPermissions([
            'view dashboard',
            'view requests',
            'approve requests',
            'reject requests',
            'view reports',
        ]);
    }
}