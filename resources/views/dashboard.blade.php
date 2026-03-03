<x-app-layout>
    {{-- CABECERA DEL DASHBOARD (Tu Perfil) --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-white p-4 rounded-xl shadow-sm border-t-4 border-[#D4AF37]">

            <div class="flex items-center gap-6">
                {{-- Tu Avatar Imperial --}}
                <div class="relative flex-shrink-0">
                    <div class="h-24 w-24 rounded-full bg-[#002395] border-4 border-[#D4AF37] flex items-center justify-center shadow-lg">
                        <svg class="w-12 h-12 text-[#D4AF37]" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M50 10C50 10 40 40 10 45C30 50 45 55 45 90H55C55 55 70 50 90 45C60 40 50 10 50 10Z" fill="currentColor" />
                            <rect x="42" y="55" width="16" height="4" fill="currentColor" />
                        </svg>
                    </div>
                </div>

                {{-- Tu Información --}}
                <div class="flex flex-col justify-center">
                    <h2 class="font-black text-3xl text-[#002395] tracking-tight uppercase">
                        {{ auth()->user()->name }}
                    </h2>

                    {{-- Tus Estrellas --}}
                    <div class="flex items-center mt-1">
                        <div class="flex text-[#D4AF37]">
                            @php $rating = auth()->user()->averageRating(); @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $rating ? 'fas fa-star' : 'far fa-star' }}"></i>
                                @endfor
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500">({{ auth()->user()->reviewsReceived()->count() }} valoraciones)</span>
                    </div>

                    {{-- Tus Seguidores y Siguiendo --}}
                    <div class="flex items-center gap-4 mt-3">
                        <div class="text-center px-4 py-1 bg-gray-50 rounded-lg border border-gray-100">
                            <span class="block font-bold text-xl text-[#002395]">{{ auth()->user()->followers()->count() }}</span>
                            <span class="block text-gray-500 uppercase text-[10px] tracking-widest font-bold">Seguidores</span>
                        </div>
                        <div class="text-center px-4 py-1 bg-gray-50 rounded-lg border border-gray-100">
                            <span class="block font-bold text-xl text-[#002395]">{{ auth()->user()->followings()->count() }}</span>
                            <span class="block text-gray-500 uppercase text-[10px] tracking-widest font-bold">Siguiendo</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botón de Acción Principal --}}
            <a href="{{ route('items.create') }}" class="group flex items-center gap-2 px-8 py-3 rounded-full font-bold shadow-md transition-all duration-300 bg-[#002395] text-white hover:bg-[#D4AF37] hover:text-[#002395]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Subir Tesoro</span>
            </a>
        </div>
    </x-slot>

    {{-- CUERPO: TUS ARTÍCULOS --}}
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-black text-[#002395] uppercase tracking-wide">
                    Tus Artículos en Venta
                </h3>
                <div class="h-1 flex-1 bg-gradient-to-r from-[#D4AF37] to-transparent ml-6 rounded-full opacity-50"></div>
            </div>

            @if($myItems->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-dashed border-[#D4AF37]/50">
                    <svg class="w-10 h-10 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-[#002395] mb-2">Tu inventario está vacío</h3>
                <p class="text-gray-500 mb-6">Aún no has publicado ningún objeto. ¡Comienza a vender hoy mismo!</p>
                <a href="{{ route('items.create') }}" class="inline-block bg-[#002395] hover:bg-[#D4AF37] text-white hover:text-[#002395] font-bold py-3 px-8 rounded-full transition-colors shadow-md">
                    Subir mi primer artículo
                </a>
            </div>
            @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($myItems as $item)
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg border border-gray-100 hover:border-[#D4AF37] transition-all duration-300 flex flex-col sm:flex-row group">

                    {{-- Imagen --}}
                    <div class="w-full sm:w-48 h-48 flex-shrink-0 bg-gray-100 relative overflow-hidden">
                        @if($item->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $item->images->first()->image_path) }}"
                            alt="{{ $item->name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-sm text-gray-400 font-bold uppercase tracking-widest">Sin Foto</span>
                        </div>
                        @endif

                        {{-- Etiqueta de Estado --}}
                        <div class="absolute top-2 left-2 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider {{ $item->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item->status === 'available' ? 'Disponible' : 'Vendido' }}
                        </div>
                    </div>

                    {{-- Información y Controles --}}
                    <div class="p-5 flex flex-col flex-1 justify-between">
                        <div>
                            <div class="flex justify-between items-start">
                                <h3 class="text-xl font-black text-[#002395] truncate pr-4">{{ $item->name }}</h3>
                                <span class="text-xl font-black text-[#D4AF37]">{{ $item->price }}€</span>
                            </div>
                            <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $item->description }}</p>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                            <a href="{{ route('items.show', $item) }}" class="text-sm font-bold text-gray-500 hover:text-[#002395] transition-colors">
                                Ver
                            </a>

                            <a href="{{ route('items.edit', $item) }}" class="text-sm font-bold bg-blue-50 text-blue-600 hover:bg-blue-100 px-4 py-2 rounded-lg transition-colors">
                                Editar
                            </a>

                            <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-bold bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg transition-colors" onclick="return confirm('¿Seguro que quieres borrar este anuncio de forma permanente?')">
                                    Borrar
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</x-app-layout>