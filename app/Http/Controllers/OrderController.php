<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Item $item)
    {
        // 1. SEGURIDAD: No puedes comprar tu propio producto
        if ($item->user_id === Auth::id()) {
            return back()->with('error', 'No puedes comprar tu propio artículo.');
        }

        // 2. SEGURIDAD: Verificar que siga disponible
        if ($item->status !== 'available') {
            return back()->with('error', 'Este artículo ya no está disponible.');
        }

        // 3. TRANSACCIÓN: Aseguramos que se haga todo o nada
        DB::transaction(function () use ($item) {
            // Creamos el registro de la compra
            Order::create([
                'user_id' => Auth::id(),
                'item_id' => $item->id,
                'amount' => $item->price,
            ]);

            // Marcamos el producto como vendido
            $item->update(['status' => 'sold']);
        });

        return redirect()->route('dashboard')->with('success', '¡Compra realizada con éxito! El vendedor se pondrá en contacto contigo.');
    }
}
