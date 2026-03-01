<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <h1 class="text-2xl font-bold mb-6">Editar artículo: {{ $item->name }}</h1>

                <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data" id="edit-item-form">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Nombre del artículo</label>
                        <input type="text" name="name" value="{{ old('name', $item->name) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Precio (€)</label>
                        <input type="number" name="price" value="{{ old('price', $item->price) }}" step="0.01" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Descripción</label>
                        <textarea name="description" class="w-full border-gray-300 rounded-md shadow-sm" rows="4">{{ old('description', $item->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Categoría</label>
                        <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (old('category_id', $item->category_id) == $category->id) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6 border-t pt-4">
                        <label class="block text-gray-700 font-bold mb-2">Fotos actuales</label>
                        <div class="flex gap-4 mb-4 overflow-x-auto pb-2">
                            @forelse($item->images as $image)
                            <div class="relative h-24 w-24 flex-shrink-0">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="h-full w-full object-cover rounded-md border border-gray-300">

                                <button type="button"
                                    onclick="if(confirm('¿Borrar foto?')) document.getElementById('delete-photo-{{ $image->id }}').submit();"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 shadow-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500 italic">Sin fotos actualmente.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="mb-6 border-t pt-4">
                        <label class="block text-gray-700 font-bold mb-4">Añadir nuevas fotos</label>
                        <div class="flex items-center gap-4">
                            <label for="images" class="cursor-pointer flex flex-col items-center justify-center w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100">
                                <div class="text-center">
                                    <svg class="w-8 h-8 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <p class="text-xs text-gray-500 font-semibold">Subir</p>
                                </div>
                                <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden">
                            </label>
                            <div id="image-preview" class="flex gap-4"></div>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-8">
                        <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-3 rounded-md hover:bg-blue-700 transition">
                            Guardar cambios
                        </button>
                        <a href="{{ route('dashboard') }}" class="flex-1 text-center bg-gray-200 text-gray-800 font-bold py-3 rounded-md hover:bg-gray-300 transition">
                            Cancelar
                        </a>
                    </div>
                </form>

                @foreach($item->images as $image)
                <form id="delete-photo-{{ $image->id }}" action="{{ route('items.images.destroy', $image) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>