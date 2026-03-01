<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $item->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-4">
                        <div class="rounded-lg overflow-hidden bg-gray-100 h-96 border border-gray-200">
                            @if($item->images->count() > 0)
                            <img id="mainImage" src="{{ asset('storage/' . $item->images->first()->image_path) }}" class="w-full h-full object-contain" alt="{{ $item->name }}">
                            @else
                            <img src="https://via.placeholder.com/600x400?text=Sin+Foto" class="w-full h-full object-cover">
                            @endif
                        </div>

                        @if($item->images->count() > 1)
                        <div class="grid grid-cols-5 gap-2">
                            @foreach($item->images as $image)
                            <button onclick="document.getElementById('mainImage').src='{{ asset('storage/' . $image->image_path) }}'"
                                class="h-20 rounded-md overflow-hidden border-2 border-transparent hover:border-blue-500 focus:border-blue-500 transition-all">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-full object-cover" alt="Miniatura">
                            </button>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-col">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $item->name }}</h1>
                        <p class="text-4xl font-bold text-green-600 mt-2">{{ $item->price }}€</p>

                        <div class="mt-4 pb-4 border-b border-gray-200">
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">
                                {{ $item->category->name }}
                            </span>
                            <span class="ml-2 text-sm text-gray-500">
                                Estado: <span class="font-semibold text-gray-800 uppercase">{{ $item->condition }}</span>
                            </span>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-800">Descripción</h3>
                            <p class="text-gray-600 mt-2 leading-relaxed">
                                {{ $item->description }}
                            </p>
                        </div>

                        <div class="mt-auto pt-8">
                            <div class="bg-gray-50 p-4 rounded-xl flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                        {{ substr($item->user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $item->user->name }}</p>
                                        <p class="text-xs text-gray-500">Vendedor particular</p>
                                    </div>
                                </div>

                                {{-- BOTÓN CONDICIONAL --}}
                                @auth
                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold transition">
                                    Chat con el vendedor
                                </button>
                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold transition">
                                    Comprar ahora
                                </button>
                                @else
                                <a href="{{ route('login') }}" class="bg-gray-800 hover:bg-black text-white px-6 py-2 rounded-lg font-bold transition">
                                    Identifícate para comprar
                                </a>
                                @endauth
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @if($relatedItems->count() > 0)
        <div class="mt-16 border-t pt-12">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">También te puede interesar</h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($relatedItems as $related)
                <a href="{{ route('items.show', $related) }}" class="group">
                    <div class="bg-gray-100 rounded-lg h-40 mb-2 overflow-hidden">
                        {{-- Lógica corregida para la primera imagen --}}
                        @php
                        $imagenUrl = $related->images->isNotEmpty()
                        ? asset('storage/' . $related->images->first()->image_path)
                        : 'https://via.placeholder.com/300';
                        @endphp

                        <img src="{{ $imagenUrl }}"
                            alt="{{ $related->name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <h4 class="font-semibold text-gray-800 truncate">{{ $related->name }}</h4>
                    <p class="text-green-600 font-bold">{{ $related->price }}€</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif
</x-app-layout>