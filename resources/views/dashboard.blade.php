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
                    <div class="border rounded-lg p-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/' . $item->image) }}" class="w-16 h-16 object-cover rounded mr-4">
                            <div>
                                <h4 class="font-bold">{{ $item->name }}</h4>
                                <p class="text-green-600 font-semibold">{{ $item->price }}€</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('items.edit', $item) }}" class="text-gray-500 hover:text-blue-600 text-sm">Editar</a>
                            <form action="{{ route('items.destroy', $item) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-sm">Borrar</button>
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