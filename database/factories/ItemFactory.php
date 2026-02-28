<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ItemFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true) . ' ' . rand(1, 1000); // Nombre aleatorio + número
        return [
            'name' => $name,
            'slug' => Str::slug($name), // Esto generará slugs únicos como 'bicicleta-de-montaña-452'
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(10, 500),
            'condition' => $this->faker->randomElement(['new', 'used']),
            'status' => 'available',
            'image' => 'items/placeholder.png',
            'user_id' => \App\Models\User::inRandomOrder()->first()->id ?? \App\Models\User::factory(),
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id ?? \App\Models\Category::factory(),
        ];
    }
}
