<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class MessageController extends Controller
{
    // 1. BANDEJA DE ENTRADA (Historial de todos los chats)
    public function index()
    {
        // Obtenemos el último mensaje de cada conversación (Item + Persona)
        $chats = Message::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->with(['item.images', 'sender', 'receiver'])
            ->latest()
            ->get()
            ->unique(function ($message) {
                // Agrupamos por Item y por el par de usuarios
                $participants = [$message->sender_id, $message->receiver_id];
                sort($participants);
                return $message->item_id . '-' . implode('-', $participants);
            });

        return view('messages.index', compact('chats'));
    }

    // 2. VENTANA DE CHAT ESPECÍFICA
    public function show(Item $item, $participant_id = null)
    {
        // Si el usuario es el dueño del producto, necesita saber con quién chatea
        // Si es el comprador, el participante siempre es el dueño del item
        $receiver_id = $participant_id ?? $item->user_id;

        // Seguridad: No chatear con uno mismo
        if ($receiver_id == Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'No puedes chatear contigo mismo.');
        }

        // Buscamos los mensajes cifrados entre estos dos usuarios sobre este item
        $messages = Message::where('item_id', $item->id)
            ->where(function ($q) use ($receiver_id) {
                $q->where(function ($s) use ($receiver_id) {
                    $s->where('sender_id', Auth::id())->where('receiver_id', $receiver_id);
                })->orWhere(function ($s) use ($receiver_id) {
                    $s->where('sender_id', $receiver_id)->where('receiver_id', Auth::id());
                });
            })
            ->oldest()
            ->get();

        return view('messages.show', [
            'item' => $item,
            'messages' => $messages,
            'receiver_id' => $receiver_id,
            'otherUser' => \App\Models\User::findOrFail($receiver_id)
        ]);
    }

    public function store(Request $request, Item $item)
    {
        $request->validate(['content' => 'required', 'receiver_id' => 'required']);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'item_id' => $item->id,
            'content' => $request->content,
        ]);

        return back();
    }
}
