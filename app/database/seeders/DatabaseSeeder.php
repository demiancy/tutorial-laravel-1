<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            DenominationSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class
        ]);
    }
}
