<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ItemController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        // Obtenemos todos los artículos, cargando también quién lo vende y su categoría
        // Usamos paginate para que si hay muchos, se creen páginas automáticamente
        $search = $request->input('search');

        $items = Item::with(['user', 'category'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString(); // ¡IMPORTANTE! Esto mantiene la búsqueda al cambiar de página
        // Retornamos la vista 'welcome' pasándole los artículos
        return view('welcome', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048', // Max 2MB
            'category_id' => 'required|exists:categories,id',
        ]);

        // 2. Gestionar la imagen
        $path = $request->file('image')->store('items', 'public');

        // 3. Crear el registro
        Item::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . uniqid(),
            'description' => $request->description,
            'price' => $request->price,
            'image' => $path,
        ]);

        return redirect()->route('dashboard')->with('success', '¡Artículo publicado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {

        // Verificar que el usuario es el dueño
        $this->authorize('update', $item);

        $item->update($request->only('name', 'description', 'price', 'status'));
        return back()->with('success', 'Actualizado correctamente');
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);
        $item->delete();
        return redirect()->route('dashboard');
    }
}
