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
        ];

        foreach ($data as $name) {
            Permission::create(['name' => $name]);
        }
    }
}
