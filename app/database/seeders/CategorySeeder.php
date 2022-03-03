<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'CURSOS',
            'TENIS',
            'CELULARES',
            'COMPUTADORAS'
        ];

        foreach ($data as $name) {
            Category::create([
                'name'  => $name,
                'image' => 'http://localhost:3000/theme/img/90x90.jpg'
            ]);
        }
    }
}
