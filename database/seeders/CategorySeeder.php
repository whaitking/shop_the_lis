<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

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
