<!-- Cuando alguien hace clic en un producto para comprarlo o preguntar. -->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 bg-white p-6 shadow-lg rounded-lg">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="md:w-1/2">
                    <img src="{{ asset('storage/' . $item->image) }}" class="w-full rounded-lg shadow-md">
                </div>

                <div class="md:w-1/2">
                    <h1 class="text-3xl font-bold mb-2">{{ $item->name }}</h1>
                    <p class="text-4xl font-bold text-green-600 mb-6">{{ $item->price }}€</p>

                    <div class="border-t border-b py-4 mb-6">
                        <p class="text-gray-700">{{ $item->description }}</p>
                    </div>

                    <p class="text-sm text-gray-500 mb-2">Vendedor: <span class="font-bold">{{ $item->user->name }}</span></p>
                    <p class="text-sm text-gray-500 mb-6">Categoría: {{ $item->category->name }}</p>

                    @if(auth()->id() !== $item->user_id)
                    <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700">
                        Enviar mensaje al vendedor
                    </button>
                    @else
                    <div class="flex gap-2">
                        <a href="{{ route('items.edit', $item) }}" class="bg-gray-500 text-white px-4 py-2 rounded">Editar</a>
                        <form action="{{ route('items.destroy', $item) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white px-4 py-2 rounded">Eliminar</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>