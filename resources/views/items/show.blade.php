<x-app-layout>
    {{-- Navegación superior (Breadcrumb) --}}
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500 font-semibold">
            <a href="{{ route('welcome') }}" class="hover:text-[#002395] transition">Mercado</a>
            <span>/</span>
            <span class="text-[#D4AF37]">{{ $item->category->name ?? 'Colección' }}</span>
            <span>/</span>
            <span class="text-[#002395] truncate max-w-xs">{{ $item->name }}</span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- CONTENEDOR PRINCIPAL DEL PRODUCTO --}}
            <div class="bg-white shadow-xl sm:rounded-3xl p-6 sm:p-10 border border-gray-100">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                    {{-- 1. SECCIÓN DE IMÁGENES --}}
                    <div class="flex flex-col gap-4">
                        {{-- Imagen Principal --}}
                        <div class="rounded-2xl overflow-hidden bg-gray-100 h-[500px] border border-gray-200 relative group">
                            @if($item->images->isNotEmpty())
                            <img id="mainImage" src="{{ asset('storage/' . $item->images->first()->image_path) }}" class="w-full h-full object-contain transition-transform duration-700 group-hover:scale-105" alt="{{ $item->name }}">
                            @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-bold uppercase tracking-widest text-sm">Sin imagen</span>
                            </div>
                            @endif

                            {{-- Badge de Estado --}}
                            @if($item->status !== 'available')
                            <div class="absolute top-4 left-4 bg-red-600 text-white font-black uppercase tracking-widest px-4 py-2 rounded-lg shadow-lg">
                                Vendido
                            </div>
                            @endif
                        </div>

                        {{-- Miniaturas --}}
                        @if($item->images->count() > 1)
                        <div class="grid grid-cols-5 gap-3">
                            @foreach($item->images as $image)
                            <button onclick="document.getElementById('mainImage').src='{{ asset('storage/' . $image->image_path) }}'"
                                class="h-24 rounded-xl overflow-hidden border-2 border-transparent hover:border-[#D4AF37] focus:border-[#D4AF37] transition-all duration-300 bg-gray-50 shadow-sm opacity-80 hover:opacity-100 focus:opacity-100">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-full object-cover" alt="Miniatura">
                            </button>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    {{-- 2. DETALLES DEL PRODUCTO Y ACCIONES --}}
                    <div class="flex flex-col">

                        {{-- Título y Precio --}}
                        <div>
                            <h1 class="text-4xl font-black text-[#002395] leading-tight mb-2">{{ $item->name }}</h1>
                            <p class="text-5xl font-black text-[#D4AF37] drop-shadow-sm">{{ $item->price }}€</p>
                        </div>

                        {{-- Etiquetas --}}
                        <div class="mt-6 flex flex-wrap gap-3 pb-6 border-b border-gray-100">
                            <span class="px-4 py-2 bg-[#002395]/10 text-[#002395] rounded-lg text-sm font-bold uppercase tracking-widest">
                                {{ $item->category->name }}
                            </span>
                            <span class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-bold uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Estado: {{ $item->condition }}
                            </span>
                        </div>

                        {{-- Descripción --}}
                        <div class="mt-8 flex-1">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3 border-l-4 border-[#D4AF37] pl-3">Crónica de la Reliquia</h3>
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line text-lg">
                                {{ $item->description }}
                            </p>
                        </div>

                        {{-- SECCIÓN DEL VENDEDOR Y BOTONES --}}
                        <div class="mt-12 pt-8 border-t border-gray-100">

                            {{-- Info del Vendedor --}}
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 mb-6 flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="h-14 w-14 rounded-full bg-[#002395] flex items-center justify-center text-[#D4AF37] font-black text-2xl shadow-md border-2 border-[#D4AF37]">
                                        {{ substr($item->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-0.5">Custodiado por</p>
                                        <a href="{{ route('profile.public', $item->user) }}" class="text-lg font-black text-[#002395] hover:text-[#D4AF37] transition-colors">
                                            {{ $item->user->name }}
                                        </a>

                                        {{-- Valoración --}}
                                        <div class="flex items-center text-[#D4AF37] text-sm mt-1">
                                            @for($i=1; $i<=5; $i++)
                                                <i class="{{ $i <= $item->user->averageRating() ? 'fas fa-star' : 'far fa-star' }}"></i>
                                                @endfor
                                                <span class="ml-2 text-xs font-bold text-gray-500">({{ $item->user->reviewsReceived()->count() }})</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Botón Seguir (Solo si no es mi producto) --}}
                                @auth
                                @if(auth()->id() !== $item->user_id)
                                <form action="{{ route('user.follow', $item->user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-sm font-bold uppercase tracking-widest px-4 py-2 rounded-lg transition-colors border-2 {{ auth()->user()->followings->contains($item->user) ? 'border-gray-300 text-gray-500 hover:border-red-500 hover:text-red-500' : 'border-[#002395] text-[#002395] hover:bg-[#002395] hover:text-white' }}">
                                        {{ auth()->user()->followings->contains($item->user) ? 'Siguiendo' : 'Seguir' }}
                                    </button>
                                </form>
                                @endif
                                @endauth
                            </div>

                            {{-- BOTONERA DE ACCIÓN FINAL --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @auth
                                @can('update', $item)
                                <a href="{{ route('items.edit', $item) }}" class="sm:col-span-2 bg-[#002395] hover:bg-[#001866] text-white px-8 py-4 rounded-xl font-black uppercase tracking-widest text-center transition-all shadow-lg flex items-center justify-center gap-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Editar Reliquia
                                </a>
                                @else
                                {{-- NUEVO Botón Comprar (Apunta a Stripe) --}}
                                <form action="{{ route('checkout.process', $item) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit"
                                        {{ $item->status !== 'available' ? 'disabled' : '' }}
                                        class="w-full {{ $item->status === 'available' ? 'bg-[#D4AF37] hover:bg-yellow-500 text-[#002395] shadow-lg hover:-translate-y-1' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }} px-6 py-4 rounded-xl font-black uppercase tracking-widest transition-all flex items-center justify-center gap-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        {{ $item->status === 'available' ? 'Pagar de forma segura' : 'Agotado' }}
                                    </button>
                                </form>

                                {{-- Chat (Azul Francia) --}}
                                <a href="{{ route('messages.show', ['item' => $item->id, 'participant_id' => $item->user_id]) }}"
                                    class="w-full bg-[#002395] hover:bg-[#001866] text-white px-6 py-4 rounded-xl font-black uppercase tracking-widest shadow-lg hover:-translate-y-1 transition-all flex items-center justify-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    Mensaje
                                </a>
                                @endcan
                                @else
                                <a href="{{ route('login') }}" class="sm:col-span-2 bg-gray-900 hover:bg-black text-white px-8 py-4 rounded-xl font-black uppercase tracking-widest text-center shadow-xl transition-all">
                                    Identifícate para Adquirir
                                </a>
                                @endauth
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- PRODUCTOS RELACIONADOS --}}
            @if($relatedItems->count() > 0)
            <div class="mt-20">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-black text-[#002395] uppercase tracking-wide">Tesoros Relacionados</h3>
                    <div class="h-1 flex-1 bg-gradient-to-r from-[#D4AF37] to-transparent ml-6 rounded-full opacity-30"></div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($relatedItems as $related)
                    <a href="{{ route('items.show', $related) }}" class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 hover:border-[#D4AF37] transition-all duration-300 transform hover:-translate-y-1">
                        <div class="bg-gray-100 h-48 relative overflow-hidden">
                            @php
                            $imagenUrl = $related->images->isNotEmpty()
                            ? asset('storage/' . $related->images->first()->image_path)
                            : 'https://via.placeholder.com/300';
                            @endphp
                            <img src="{{ $imagenUrl }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-gray-900 truncate group-hover:text-[#002395] transition-colors">{{ $related->name }}</h4>
                            <p class="text-[#D4AF37] font-black text-lg mt-1">{{ $related->price }}€</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>