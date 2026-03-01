<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mis Artículos en Venta') }}
            </h2>
            <a href="{{ route('items.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                + Subir nuevo artículo
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($myItems->isEmpty())
                <p class="text-gray-500 text-center">Aún no has subido ningún artículo. ¡Empieza ahora!</p>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($myItems as $item)
                    <div class="bg-gray-800 rounded-lg p-4 mb-4 flex items-center gap-6 border border-gray-700">

                        <div class="w-32 h-32 flex-shrink-0 rounded-md overflow-hidden bg-white">
                            @if($item->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $item->images->first()->image_path) }}"
                                alt="{{ $item->name }}"
                                class="w-full h-full object-cover">
                            @else
                            <img src="https://via.placeholder.com/150?text=Sin+Foto"
                                class="w-full h-full object-cover">
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <h3 class="text-xl font-bold text-white truncate">{{ $item->name }}</h3>
                            <p class="text-gray-400 text-sm mt-1">{{ $item->description }}</p>
                            <p class="text-green-500 font-bold text-2xl mt-2">{{ $item->price }}€</p>
                        </div>

                        <div class="flex flex-col gap-2 ml-4">
                            <a href="{{ route('items.edit', $item) }}" class="text-blue-400 hover:text-blue-300 font-semibold text-sm transition">
                                Editar
                            </a>

                            <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400 font-semibold text-sm transition" onclick="return confirm('¿Seguro que quieres borrar este anuncio?')">
                                    Borrar
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>