<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function checkout(Item $item)
    {
        // 1. Autenticamos nuestra app con la llave secreta que pusiste en el .env
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // 2. Creamos la "Sesión de Pago" en los servidores de Stripe
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur', // Cambia a 'usd' o tu moneda local si lo necesitas
                    'product_data' => [
                        'name' => $item->name, // Nombre del artículo que verá el cliente en la pasarela
                    ],
                    // Stripe trabaja en céntimos para evitar errores de decimales. (Ej: 15.50€ = 1550)
                    'unit_amount' => $item->price * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment', // Pago único (no suscripción)
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
        ]);

        // 3. Registramos el pedido en nuestra base de datos con estado "Pendiente"
        Order::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'amount' => $item->price,
            'status' => Order::STATUS_PENDING,
            'transaction_id' => $session->id, // Guardamos el ID de esta sesión concreta
        ]);

        // 4. Redirigimos al usuario a la pasarela de pago segura de Stripe
        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        // En un futuro cercano aquí verificaremos el session_id con Stripe
        return view('checkout.success');
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }
}
