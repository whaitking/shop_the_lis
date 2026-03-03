<x-app-layout>
    {{-- CABECERA DEL MERCADO --}}
    <x-slot name="header">
        <div class="flex items-center justify-between bg-white p-2 rounded-xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-[#002395] rounded-lg shadow-md">
                    <svg class="w-6 h-6 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h2 class="font-black text-2xl text-[#002395] uppercase tracking-wide">
                    {{ __('Mercado de Reliquias') }}
                </h2>
            </div>
            <div class="h-1 flex-1 bg-gradient-to-r from-[#D4AF37] to-transparent ml-6 rounded-full opacity-50 hidden md:block"></div>
        </div>
    </x-slot>

    {{-- CATÁLOGO DE ARTÍCULOS --}}
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse ($items as $item)
                {{-- Tarjeta de Tesoro (Toda la tarjeta es clicable) --}}
                <a href="{{ route('items.show', $item) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl border border-gray-100 hover:border-[#D4AF37] transition-all duration-500 transform hover:-translate-y-2 flex flex-col">

                    {{-- Contenedor de Imagen --}}
                    <div class="relative h-56 bg-gray-100 overflow-hidden">
                        {{-- Corrección de la imagen (usando la relación images) --}}
                        @if($item->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $item->images->first()->image_path) }}"
                            alt="{{ $item->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif

                        {{-- Categoría flotante --}}
                        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-[#002395] text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm">
                            {{ $item->category->name ?? 'Colección' }}
                        </div>
                    </div>

                    {{-- Información del Producto --}}
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-black text-gray-900 group-hover:text-[#002395] transition-colors leading-tight line-clamp-1 mb-1">{{ $item->name }}</h3>
                        <span class="text-2xl font-black text-[#D4AF37] block mb-3">{{ $item->price }}€</span>

                        <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $item->description }}</p>

                        {{-- Pie de la tarjeta (Vendedor y Acción) --}}
                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                            {{-- Vendedor info --}}
                            <div class="flex items-center gap-2 text-sm text-gray-600 group-hover:text-[#002395] transition-colors">
                                <div class="w-6 h-6 rounded-full bg-[#002395] text-[#D4AF37] flex items-center justify-center text-xs font-bold shadow-sm">
                                    {{ substr($item->user->name, 0, 1) }}
                                </div>
                                <span class="font-semibold truncate max-w-[100px]">{{ $item->user->name }}</span>
                            </div>

                            {{-- Indicador visual de acción --}}
                            <span class="text-[#D4AF37] bg-yellow-50 p-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
                @empty
                {{-- Estado Vacío Elegante --}}
                <div class="col-span-full py-16 px-4 text-center bg-white rounded-2xl border border-dashed border-[#D4AF37]/50 shadow-sm">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#002395] mb-2">El mercado está en silencio</h3>
                    <p class="text-gray-500 mb-6">Actualmente no hay reliquias en exposición. Vuelve pronto para descubrir nuevos tesoros.</p>
                    @auth
                    <a href="{{ route('items.create') }}" class="inline-block bg-[#002395] hover:bg-[#D4AF37] text-white font-bold py-3 px-8 rounded-full transition-colors shadow-lg">
                        Ser el primero en publicar
                    </a>
                    @endauth
                </div>
                @endforelse
            </div>

            {{-- Paginación --}}
            @if($items->hasPages())
            <div class="mt-10 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                {{ $items->links() }}
            </div>
            @endif

        </div>
    </div>
</x-app-layout>