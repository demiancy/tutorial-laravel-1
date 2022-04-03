<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Arr;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'     => 'Usuario Administrador',
                'email'    => 'admin@noemail.com',
                'password' => 'desa',
                'phone'    => '00000000',
                'status'   => 'ACTIVE',
                'roles'    => ['admin']
                
            ],
            [
                'name'     => 'Usuario empleado',
                'email'    => 'employee@noemail.com',
                'password' => 'desa',
                'phone'    => '00000000',
                'status'   => 'ACTIVE',
                'roles'    => ['employe']
            ]
        ];

        foreach ($data as $user) {
            User::create(Arr::except($user, ['roles']))->assignRole($user['roles']);
        }
    }
}
