<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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
                'profile'  => 'ADMIN',
                'status'   => 'ACTIVE',
                
            ],
            [
                'name'     => 'Usuario empleado',
                'email'    => 'employee@noemail.com',
                'password' => 'desa',
                'phone'    => '00000000',
                'profile'  => 'EMPLOYEE',
                'status'   => 'ACTIVE',
                
            ]
        ];

        foreach ($data as $user) {
            User::create($user);
        }
    }
}
