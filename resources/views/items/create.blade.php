<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <h1 class="text-2xl font-bold mb-6">¿Qué quieres vender?</h1>

                <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">Nombre del artículo</label>
                        <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Precio (€)</label>
                        <input type="number" name="price" step="0.01" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Descripción</label>
                        <textarea name="description" class="w-full border-gray-300 rounded-md shadow-sm" rows="4"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Categoría</label>
                        <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Fotos del producto</label>
                        <label for="images" class="cursor-pointer flex flex-col items-center justify-center w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 hover:border-blue-400 transition-all group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <p class="text-xs text-gray-500 font-semibold group-hover:text-blue-500 text-center px-1">Añadir fotos</p>
                            </div>
                            <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden">
                        </label>

                        <p class="text-xs text-gray-500 mt-1">Puedes subir hasta 10 fotos. Elige fotos claras y luminosas.</p>

                        <div id="image-preview" class="grid grid-cols-3 sm:grid-cols-5 gap-4 mt-4"></div>
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-md hover:bg-green-700">
                        Publicar anuncio
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>