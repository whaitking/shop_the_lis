<?php

use App\Models\Item;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ItemController;


// Solo usuarios autenticados pueden gestionar productos
Route::middleware(['auth'])->group(function () {
    Route::resource('items', ItemController::class);
});

// La página principal la puede ver cualquiera
// Ahora la página principal la gestiona el controlador
Route::get('/', [ItemController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    // Obtenemos solo los ítems que pertenecen al usuario logueado

    $myItems = Auth::user()->items()->latest()->get();

    // Pasamos la variable a la vista usando compact()
    return view('dashboard', compact('myItems'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
