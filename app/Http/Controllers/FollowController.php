<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function toggle(User $user)
    {
        // El usuario que está logueado
        /** @var \App\Models\User $user */
        $follower = Auth::user();

        // No puedes seguirte a ti mismo (seguridad extra)
        if ($follower->id === $user->id) {
            return back()->with('error', 'No puedes seguirte a ti mismo.');
        }

        // toggle() añade si no existe, y quita si ya existe en la tabla pivot
        $follower->followings()->toggle($user->id);

        return back();
    }
}
