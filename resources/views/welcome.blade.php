<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Shop the Lis') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,900" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <x-app-layout>

        {{-- HERO SECTION / HEADER (Sustituye al header antiguo) --}}
        <x-slot name="header">
            <div class="bg-[#002395] rounded-2xl p-8 md:p-12 shadow-2xl relative overflow-hidden border border-[#D4AF37]/30">

                {{-- Decoración de fondo (Flor de Lis gigante) --}}
                <div class="absolute -right-20 -top-20 opacity-10 pointer-events-none">
                    <svg class="w-96 h-96 text-[#D4AF37]" viewBox="0 0 100 100" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M50 10C50 10 40 40 10 45C30 50 45 55 45 90H55C55 55 70 50 90 45C60 40 50 10 50 10Z" />
                        <rect x="42" y="55" width="16" height="4" />
                    </svg>
                </div>

                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="text-center md:text-left">
                        <h2 class="font-black text-4xl md:text-5xl text-white tracking-tight uppercase mb-2">
                            Descubre <span class="text-[#D4AF37]">Tesoros</span>
                        </h2>
                        <p class="text-blue-100 text-lg max-w-xl">
                            El mercado exclusivo de SHOPTHELIS. Encuentra reliquias, arte y tecnología de otros miembros de confianza.
                        </p>
                    </div>

                    <form action="{{ route('welcome') }}" method="GET" class="w-full md:w-96">
                        <div class="relative group">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Busca una reliquia..."
                                class="w-full bg-white/10 border-2 border-[#D4AF37]/50 text-white placeholder-blue-200 focus:border-[#D4AF37] focus:bg-white focus:text-[#002395] focus:placeholder-gray-400 rounded-full shadow-lg pl-6 pr-12 py-4 transition-all duration-300 outline-none">
                            <button type="submit" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                <svg class="h-6 w-6 text-[#D4AF37] group-focus-within:text-[#002395] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </x-slot>

        {{-- CUERPO PRINCIPAL: LISTA DE PRODUCTOS --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Título de sección si hay búsqueda --}}
                @if(request('search'))
                <div class="mb-8 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-[#002395]">Resultados para: "<span class="text-[#D4AF37]">{{ request('search') }}</span>"</h3>
                    <a href="{{ route('welcome') }}" class="text-sm font-semibold text-gray-500 hover:text-[#002395] transition">Limpiar búsqueda ✕</a>
                </div>
                @else
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-black text-[#002395] uppercase tracking-wide">Novedades Recientes</h3>
                    <div class="h-1 flex-1 bg-gradient-to-r from-[#D4AF37] to-transparent ml-6 rounded-full opacity-30"></div>
                </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @forelse ($items as $item)
                    {{-- Tarjeta de Producto Premium --}}
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl border border-gray-100 hover:border-[#D4AF37] transition-all duration-500 transform hover:-translate-y-2 flex flex-col">

                        {{-- Contenedor de Imagen --}}
                        <div class="relative h-60 bg-gray-50 overflow-hidden">
                            @if($item->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $item->images->first()->image_path) }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif

                            {{-- Categoría (Badge superior) --}}
                            <div class="absolute top-3 left-3 flex flex-col gap-2">
                                <div class="bg-white/90 backdrop-blur-sm text-[#002395] text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                    {{ $item->category->name }}
                                </div>
                                @if($item->status === 'sold')
                                <div class="bg-red-600/90 backdrop-blur-sm text-white text-xs font-black px-3 py-1 rounded-full shadow-sm uppercase tracking-widest self-start">
                                    Vendido
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Información del Producto --}}
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex justify-between items-start gap-2 mb-2">
                                <h3 class="text-lg font-black text-gray-900 group-hover:text-[#002395] transition-colors leading-tight line-clamp-2">
                                    {{ $item->name }}
                                </h3>
                            </div>

                            <span class="text-2xl font-black text-[#D4AF37] mb-4 block">{{ $item->price }}€</span>

                            <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                {{-- Vendedor info simplificada --}}
                                <a href="{{ route('profile.public', $item->user) }}" class="flex items-center gap-2 text-sm text-gray-600 hover:text-[#002395] transition group/vendor">
                                    <div class="w-6 h-6 rounded-full bg-[#002395] text-white flex items-center justify-center text-xs font-bold group-hover/vendor:bg-[#D4AF37]">
                                        {{ substr($item->user->name, 0, 1) }}
                                    </div>
                                    <span class="font-semibold truncate max-w-[100px]">{{ $item->user->name }}</span>
                                </a>

                                <div class="flex gap-2 items-center">
                                    @can('update', $item)
                                    <a href="{{ route('items.edit', $item) }}" class="text-gray-400 hover:text-[#D4AF37] transition" title="Editar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    @endcan

                                    <a href="{{ route('items.show', $item) }}" class="bg-gray-100 hover:bg-[#002395] text-gray-600 hover:text-white px-3 py-1.5 rounded-lg text-sm font-bold transition-colors">
                                        Ver →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    {{-- Estado Vacío (Sin resultados) --}}
                    <div class="col-span-full py-16 px-4 text-center bg-white rounded-2xl border border-dashed border-[#D4AF37]/50">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#002395] mb-2">No hemos encontrado reliquias</h3>
                        <p class="text-gray-500 mb-6">No hay ningún objeto que coincida con "<span class="font-bold text-gray-800">{{ request('search') }}</span>"</p>
                        <a href="{{ route('welcome') }}" class="inline-block bg-[#002395] hover:bg-[#D4AF37] text-white font-bold py-3 px-8 rounded-full transition-colors shadow-lg">
                            Volver al Mercado General
                        </a>
                    </div>
                    @endforelse
                </div>

                {{-- Paginación personalizada --}}
                @if($items->hasPages())
                <div class="mt-12 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    {{ $items->links() }}
                </div>
                @endif

            </div>
        </div>
    </x-app-layout>
</body>

</html>