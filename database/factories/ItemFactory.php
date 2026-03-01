<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        $name = $this->faker->words(3, true) . ' ' . rand(1, 1000);

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . uniqid(), // Uniqid asegura que nunca choque el slug
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 5, 1000), // Precios más realistas (ej: 15.50)
            'condition' => $this->faker->randomElement(['new', 'used']),
            'status' => 'available',
            // Buscamos uno existente o creamos uno nuevo si la DB está vacía
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
        ];
    }
}
