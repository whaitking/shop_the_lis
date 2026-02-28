<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{

    public function run(): void
    {
        $categories = ['Electrónica', 'Moda y Accesorios', 'Hogar y Jardín', 'Deporte', 'Videojuegos'];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => str($cat)->slug(),
            ]);
        }
    }
}
