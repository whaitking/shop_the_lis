<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Constantes de estado (Te salvarán la vida para evitar errores de escritura)
    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_REFUNDED = 'refunded';

    protected $fillable = [
        'user_id',       // El comprador
        'item_id',       // El artículo comprado
        'amount',        // El precio (te recomiendo guardarlo en céntimos/enteros)
        'status',        // El estado del pago
        'transaction_id' // Aquí guardaremos el ID que nos devuelva Stripe (ej: pi_1Hh1...)
    ];

    // Relación con el usuario (Comprador)
    public function buyer()
    {
        // Le cambiamos el nombre a 'buyer' (comprador) para que el código sea más semántico,
        // pero le decimos a Laravel que siga usando 'user_id' en la base de datos.
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con el artículo
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
