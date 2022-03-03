<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Denomination;

class DenominationSeeder extends Seeder
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
                'type'  => 'BILLETE',
                'value' => 1000,
                'image' => 'http://localhost:3000/theme/img/90x90.jpg'
            ],
            [
                'type'  => 'BILLETE',
                'value' => 500,
                'image' => 'http://localhost:3000/theme/img/90x90.jpg'
            ],
            [
                'type'  => 'BILLETE',
                'value' => 200,
                'image' => 'http://localhost:3000/theme/img/90x90.jpg'
            ],
            [
                'type'  => 'BILLETE',
                'value' => 100,
                'image' => 'http://localhost:3000/theme/img/90x90.jpg'
            ],
            [
                'type'  => 'BILLETE',
                'value' => 50,
                'image' => 'http://localhost:3000/theme/img/90x90.jpg'
            ],
            [
                'type'  => 'BILLETE',
                'value' => 20,
                'image' => 'http://localhost:3000/theme/img/90x90.jpg'
            ],
            [
                'type'  => 'MONEDA',
                'value' => 10,
                'image' => 'http://localhost:3000/theme/img/90x90.jpg'
            ],
            [
                'type'  => 'MONEDA',
                'value' => 5,
                'image' => 'http://localhost:3000/theme/img/90x90.jpg'
            ],
            [
                'type'  => 'MONEDA',
                'value' => 2,
                'image' => 'http://localhost:3000/theme/img/90x90.jpg'
            ],
            [
                'type'  => 'MONEDA',
                'value' => 1,
                'image' => 'http://localhost:3000/theme/img/90x90.jpg'
            ],
            [
                'type'  => 'MONEDA',
                'value' => 0.5,
                'image' => 'http://localhost:3000/theme/img/90x90.jpg'
            ],
            [
                'type'  => 'OTRO',
                'value' => 0,
                'image' => 'http://localhost:3000/theme/img/90x90.jpg'
            ],
        ];

        foreach ($data as $denomination) {
            Denomination::create($denomination);
        }
    }
}
