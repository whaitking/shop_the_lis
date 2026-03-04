<?php

use App\Models\Item;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FollowController;

// Solo usuarios autenticados pueden gestionar productos
Route::middleware(['auth'])->group(function () {
    Route::resource('items', ItemController::class);
});

// Rutas públicas (cualquiera puede entrar)
Route::post('/buy/{item}', [OrderController::class, 'store'])->name('orders.store')->middleware('auth');
Route::get('/', [ItemController::class, 'index'])->name('welcome');
Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
Route::get('/chat/{item}', [MessageController::class, 'index'])->name('chat.index');
Route::post('/chat/{item}', [MessageController::class, 'store'])->name('chat.store');
Route::get('/profile/{user}', [ProfileController::class, 'showPublic'])->name('profile.public');
// Ruta para borrar una imagen individual
Route::delete('/items/images/{image}', [App\Http\Controllers\ItemController::class, 'destroyImage'])->name('items.images.destroy');

Route::get('/dashboard', function () {
    // Obtenemos solo los ítems que pertenecen al usuario logueado
    $myItems = Auth::user()->items()->with('images')->latest()->get();
    // Pasamos la variable a la vista usando compact()
    return view('dashboard', compact('myItems'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Listado de todos mis chats
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    // Chat sobre un producto específico (el participant_id es para que el vendedor sepa con qué comprador habla)
    Route::get('/messages/{item}/{participant_id?}', [MessageController::class, 'show'])->name('messages.show');

    Route::post('/messages/{item}', [MessageController::class, 'store'])->name('messages.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/user/{user}/follow', [FollowController::class, 'toggle'])->name('user.follow');
});

require __DIR__ . '/auth.php';
