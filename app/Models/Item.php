<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Campos que permitimos llenar de golpe
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'condition',
        'status'
    ];

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function show(Item $item)
    {
        /** @var \App\Models\Item $item */ // Esto le dice al editor: "Oye, esto es un Item"
        $vendedor = $item->user->name;

        return view('items.show', compact('item'));
    }

    // Relación: Un artículo pertenece a un usuario (vendedor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un artículo pertenece a una categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ItemImage::class);
    }
}
