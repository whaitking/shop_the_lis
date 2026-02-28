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
                        <label class="block text-gray-700">Foto del producto</label>
                        <input type="file" name="image" class="w-full" accept="image/*" required>
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-md hover:bg-green-700">
                        Publicar anuncio
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>