<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;
use Stripe\Webhook;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handlePayment(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            // Verificamos matemáticamente que el mensaje viene de Stripe
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Código malicioso o payload inválido
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Firma inválida (alguien intentó hacerse pasar por Stripe)
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Si la verificación es correcta, miramos qué tipo de evento es
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $transactionId = $session->id; // Este es el ID que guardamos al iniciar la compra

            // Buscamos la orden en nuestra base de datos
            $order = Order::where('transaction_id', $transactionId)->first();

            if ($order && $order->status === Order::STATUS_PENDING) {
                // 1. Marcamos la orden como completada
                $order->update(['status' => Order::STATUS_COMPLETED]);

                // 2. Marcamos el artículo como vendido para que nadie más pueda comprarlo
                $item = Item::find($order->item_id);
                if ($item) {
                    $item->update(['status' => 'sold']);
                }

                // Aquí también podrías enviar un email de "Recibo de compra"
                Log::info("Pago completado con éxito para la orden: {$order->id}");
            }
        }

        // Le decimos a Stripe "Mensaje recibido, todo OK 200" para que no vuelva a enviarlo
        return response()->json(['status' => 'success'], 200);
    }
}
