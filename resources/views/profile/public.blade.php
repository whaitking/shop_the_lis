<x-app-layout>
    {{-- CABECERA DEL PERFIL --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-white p-4 rounded-xl shadow-sm border-t-4 border-[#D4AF37]">

            <div class="flex items-center gap-6">
                {{-- Avatar Imperial con Logo --}}
                <div class="relative flex-shrink-0">
                    <div class="h-24 w-24 rounded-full bg-[#002395] border-4 border-[#D4AF37] flex items-center justify-center shadow-lg">
                        {{-- Icono Flor de Lis genérico en SVG --}}
                        <svg class="w-12 h-12 text-[#D4AF37]" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M50 10C50 10 40 40 10 45C30 50 45 55 45 90H55C55 55 70 50 90 45C60 40 50 10 50 10Z" fill="currentColor" />
                            <rect x="42" y="55" width="16" height="4" fill="currentColor" />
                        </svg>
                    </div>
                </div>

                {{-- Información del Usuario --}}
                <div class="flex flex-col justify-center">
                    <h2 class="font-black text-3xl text-[#002395] tracking-tight uppercase">
                        {{ $user->name }}
                    </h2>

                    {{-- 1. SISTEMA DE ESTRELLAS --}}
                    <div class="flex items-center mt-1">
                        <div class="flex text-[#D4AF37]">
                            @php $rating = $user->averageRating(); @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $rating ? 'fas fa-star' : 'far fa-star' }}"></i>
                                @endfor
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500">({{ $user->reviewsReceived()->count() }} valoraciones)</span>
                    </div>

                    {{-- 2. SEGUIDORES Y SIGUIENDO --}}
                    <div class="flex items-center gap-4 mt-3">
                        <div class="text-center px-4 py-1 bg-gray-50 rounded-lg border border-gray-100">
                            <span class="block font-bold text-xl text-[#002395]">{{ $followersCount }}</span>
                            <span class="block text-gray-500 uppercase text-[10px] tracking-widest font-bold">Seguidores</span>
                        </div>
                        <div class="text-center px-4 py-1 bg-gray-50 rounded-lg border border-gray-100">
                            <span class="block font-bold text-xl text-[#002395]">{{ $followingCount }}</span>
                            <span class="block text-gray-500 uppercase text-[10px] tracking-widest font-bold">Siguiendo</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BOTÓN DE SEGUIR --}}
            @auth
            @if(auth()->id() !== $user->id)
            <form action="{{ route('user.follow', $user) }}" method="POST">
                @csrf
                <button type="submit" class="group flex items-center gap-2 px-8 py-3 rounded-full font-bold shadow-md transition-all duration-300 {{ auth()->user()->followings->contains($user) ? 'bg-gray-200 text-gray-700 hover:bg-red-100 hover:text-red-600' : 'bg-[#002395] text-white hover:bg-[#D4AF37] hover:text-[#002395]' }}">
                    <span>{{ auth()->user()->followings->contains($user) ? 'Dejar de seguir' : 'Seguir Usuario' }}</span>
                </button>
            </form>
            @endif
            @endauth
        </div>
    </x-slot>

    {{-- CUERPO DEL PERFIL: ARTÍCULOS EN VENTA --}}
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-black text-[#002395] uppercase tracking-wide">
                    Colección en venta
                </h3>
                <div class="h-1 flex-1 bg-gradient-to-r from-[#D4AF37] to-transparent ml-6 rounded-full opacity-50"></div>
            </div>

            @if($userItems->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="text-gray-500 text-lg">Este usuario aún no tiene artículos publicados en el mercado.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($userItems as $item)
                <a href="{{ route('items.show', $item) }}" class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 hover:border-[#D4AF37] transition-all duration-300 transform hover:-translate-y-1">

                    {{-- Imagen del producto --}}
                    <div class="relative h-56 bg-gray-100 overflow-hidden">
                        @if($item->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $item->images->first()->image_path) }}"
                            alt="{{ $item->name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <span class="text-sm">Sin imagen</span>
                        </div>
                        @endif

                        {{-- Etiqueta de precio superpuesta --}}
                        <div class="absolute bottom-3 right-3 bg-[#002395] text-white px-3 py-1 rounded-full font-bold shadow-md">
                            {{ $item->price }}€
                        </div>
                    </div>

                    {{-- Detalles del producto --}}
                    <div class="p-5">
                        <h4 class="text-lg font-bold text-gray-900 truncate group-hover:text-[#002395] transition-colors">{{ $item->name }}</h4>
                        <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $item->description }}</p>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</x-app-layout>