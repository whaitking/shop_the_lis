<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Explorar Artículos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($items as $item)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 border border-gray-200">
                    <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-48 object-cover rounded-md mb-4">

                    <h3 class="text-lg font-bold text-gray-900">{{ $item->name }}</h3>
                    <p class="text-xl font-semibold text-green-600">{{ $item->price }}€</p>
                    <p class="text-sm text-gray-500 mb-4">{{ Str::limit($item->description, 50) }}</p>

                    <a href="{{ route('items.show', $item) }}" class="block text-center bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        Ver detalle
                    </a>
                </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</x-app-layout>