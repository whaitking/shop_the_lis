<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Shop the lis') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">

    </header>
    <x-app-layout>
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Explora Novedades') }}
                </h2>
                <!-- Buscador -->
                <form action="{{ route('welcome') }}" method="GET" class="w-full md:w-1/2 lg:w-1/3">
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Busca un iPhone, una bici..."
                            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-full shadow-sm pl-4 pr-10 py-2">
                        <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400 hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse ($items as $item)
                    {{-- Esto se ejecuta SI HAY productos --}}
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-300">
                        <div class="h-48 overflow-hidden bg-gray-100">
                            @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover" alt="{{ $item->name }}">
                            @else
                            <img src="https://via.placeholder.com/300x200?text=Sin+Foto" class="w-full h-full object-cover">
                            @endif
                        </div>

                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-bold text-gray-900 truncate">{{ $item->name }}</h3>
                                <span class="text-lg font-bold text-green-600">{{ $item->price }}€</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ $item->category->name }}</p>

                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xs text-gray-400">Vendido por: {{ $item->user->name }}</span>
                                <a href="{{ route('items.show', $item) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                    Ver más
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    {{-- Esto se ejecuta SI LA LISTA ESTÁ VACÍA --}}
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">No hemos encontrado nada que coincida con "{{ request('search') }}"</p>
                        <a href="{{ route('welcome') }}" class="text-blue-600 underline mt-2 inline-block">Ver todos los productos</a>
                    </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $items->links() }}
                </div>

            </div>
        </div>
    </x-app-layout>

    @if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>

</html>