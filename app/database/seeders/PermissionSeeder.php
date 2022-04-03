<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $data = [
            'view_categories',
            'update_categories',
            'create_categories',
            'delete_categories',
            'view_products',
            'update_products',
            'create_products',
            'delete_products',
            'view_roles',
            'update_roles',
            'create_roles',
            'delete_roles',
            'view_users',
            'update_users',
            'create_users',
            'delete_users',
            'view_denominations',
            'update_denominations',
            'create_denominations',
            'delete_denominations',
            'cashout',
            'reports',
            'sales',
        ];

        foreach ($data as $name) {
            Permission::create(['name' => $name]);
        }
    }
}
