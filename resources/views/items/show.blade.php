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

                    {{-- SECCIÓN DE IMÁGENES --}}
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

                    {{-- DETALLES DEL PRODUCTO --}}
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

                        {{-- SECCIÓN DEL VENDEDOR Y ACCIONES --}}
                        <div class="mt-auto pt-8">
                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center">
                                        <div class="h-12 w-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xl shadow-sm">
                                            {{ substr($item->user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <a href="{{ route('profile.public', $item->user) }}" class="hover:underline font-bold">
                                                {{ $item->user->name }}
                                            </a> {{-- Sistema de Valoración --}}
                                            <div class="flex items-center text-yellow-400 text-sm">
                                                @for($i=1; $i<=5; $i++)
                                                    <i class="{{ $i <= $item->user->averageRating() ? 'fas fa-star' : 'far fa-star' }}"></i>
                                                    @endfor
                                                    <span class="ml-2 text-gray-500">({{ $item->user->reviewsReceived()->count() }} valoraciones)</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Botón Seguir (Solo si no es mi producto) --}}
                                    @auth
                                    @if(auth()->id() !== $item->user_id)
                                    <form action="{{ route('user.follow', $item->user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm font-bold {{ auth()->user()->followings->contains($item->user) ? 'text-red-500' : 'text-blue-600' }} hover:underline">
                                            {{ auth()->user()->followings->contains($item->user) ? 'Dejar de seguir' : 'Seguir vendedor' }}
                                        </button>
                                    </form>
                                    @endif
                                    @endauth
                                </div>

                                {{-- BOTONES DE ACCIÓN --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @auth
                                    @can('update', $item)
                                    <a href="{{ route('items.edit', $item) }}" class="sm:col-span-2 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-bold text-center transition flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Editar mi publicación
                                    </a>
                                    @else
                                    {{-- Comprar --}}
                                    <form action="{{ route('orders.store', $item) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            {{ $item->status !== 'available' ? 'disabled' : '' }}
                                            onclick="return confirm('¿Confirmas la compra de {{ $item->name }}?')"
                                            class="w-full {{ $item->status === 'available' ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-400' }} text-white px-6 py-3 rounded-lg font-bold transition">
                                            {{ $item->status === 'available' ? 'Comprar ahora' : 'Vendido' }}
                                        </button>
                                    </form>

                                    {{-- Chat --}}
                                    <a href="{{ route('messages.show', ['item' => $item->id, 'participant_id' => $item->user_id]) }}"
                                        class="bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg font-bold transition flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        Chat
                                    </a>
                                    @endcan
                                    @else
                                    <a href="{{ route('login') }}" class="sm:col-span-2 bg-gray-800 hover:bg-black text-white px-6 py-3 rounded-lg font-bold text-center transition">
                                        Identifícate para comprar
                                    </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PRODUCTOS RELACIONADOS --}}
            @if($relatedItems->count() > 0)
            <div class="mt-16 border-t pt-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">También te puede interesar</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($relatedItems as $related)
                    <a href="{{ route('items.show', $related) }}" class="group">
                        <div class="bg-gray-100 rounded-lg h-48 mb-3 overflow-hidden border border-gray-200">
                            @php
                            $imagenUrl = $related->images->isNotEmpty()
                            ? asset('storage/' . $related->images->first()->image_path)
                            : 'https://via.placeholder.com/300';
                            @endphp
                            <img src="{{ $imagenUrl }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <h4 class="font-semibold text-gray-800 truncate">{{ $related->name }}</h4>
                        <p class="text-green-600 font-bold">{{ $related->price }}€</p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>