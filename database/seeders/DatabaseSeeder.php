<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Creamos 10 usuarios
        \App\Models\User::factory(10)->create();

        // Creamos las categorías primero si no existen
        $categories = ['Electrónica', 'Moda', 'Hogar', 'Motor'];
        foreach ($categories as $cat) {
            \App\Models\Category::create([
                'name' => $cat,
                'slug' => \Illuminate\Support\Str::slug($cat)
            ]);
        }

        // CREAR 20 ARTÍCULOS, y que cada uno tenga 3 imágenes asociadas
        \App\Models\Item::factory(20)
            ->has(\App\Models\ItemImage::factory()->count(3), 'images')
            ->create();
    }
}
