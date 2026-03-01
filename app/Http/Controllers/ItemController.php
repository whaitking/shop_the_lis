<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Category;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

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
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'images' => 'required|array|min:1|max:10', // Máximo 10 archivos
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 2. Crear el registro
        $item = Item::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . uniqid(),
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // 3. Guardar las imágenes una por una
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Guardamos el archivo en 'storage/app/public/items'
                $path = $file->store('items', 'public');

                // Creamos la relación en la tabla item_images
                $item->images()->create([
                    'image_path' => $path,
                ]);
            }
        }
        return redirect()->route('dashboard')->with('success', '¡Producto publicado con éxito!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        $item->load(['user', 'category']);

        // Buscamos productos de la misma categoría, excluyendo el actual
        $relatedItems = Item::where('category_id', $item->category_id)
            ->where('id', '!=', $item->id) // No queremos que se vea a sí mismo
            ->where('status', 'available') // Solo los que están a la venta
            ->latest()
            ->take(4) // Solo queremos 4 para la fila de abajo
            ->get();

        return view('items.show', compact('item', 'relatedItems'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        // 1. Laravel comprueba automáticamente la política. Si falla, lanza un error 403.
        Gate::authorize('update', $item);

        // 2. Cargar las categorías para el desplegable
        $categories = \App\Models\Category::all();

        // 3. Devolver la vista pasándole el artículo y las categorías
        return view('items.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        // 1. SEGURIDAD: Verificar que el usuario tiene permiso para actualizar este artículo
        Gate::authorize('update', $item);

        // 2. Validar los datos (Nota: las imágenes ahora son 'nullable' porque no es obligatorio subir nuevas al editar)
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 3. Actualizar los datos de texto
        $item->update($request->only('name', 'price', 'description', 'category_id'));

        // 4. Guardar NUEVAS imágenes si el usuario ha subido más
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('items', 'public');
                $item->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', '¡Artículo actualizado correctamente!');
    }

    public function destroy(Item $item)
    {
        Gate::authorize('delete', $item);
        $item->delete();
        return redirect()->route('dashboard');
    }

    public function destroyImage(ItemImage $image)
    {
        // 1. SEGURIDAD: Comprobamos que el usuario es el dueño del artículo al que pertenece la foto
        Gate::authorize('update', $image->item);

        //Limpiamos la ruta por si acaso tiene el prefijo '/storage/' o 'storage/'
        // Storage::disk('public')->delete() espera algo como 'items/nombre.jpg'
        $path = str_replace(['/storage/', 'storage/'], '', $image->image_path);
        // 2. Borrar el archivo físico del disco duro (Storage)
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        // 3. Borrar el registro de la base de datos
        $image->delete();

        // 4. Recargar la página con un mensaje de éxito
        return back()->with('success', 'Imagen eliminada correctamente.');
    }
}
