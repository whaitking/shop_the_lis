<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Aquí autorizamos los campos para el Order::create
    protected $fillable = [
        'user_id',
        'item_id',
        'amount',
        'status', // Aunque tenga un default, es bueno tenerlo aquí por si lo cambias luego
    ];

    // Relación con el usuario (comprador)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el artículo
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
