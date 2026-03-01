<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemImageFactory extends Factory
{
    protected $model = ItemImage::class;

    public function definition(): array
    {
        return [
            // Si creas una imagen suelta, creará un Item automáticamente
            'item_id' => Item::factory(),
            // Ruta relativa al disco 'public'
            'image_path' => 'items/placeholder.png',
        ];
    }
}
