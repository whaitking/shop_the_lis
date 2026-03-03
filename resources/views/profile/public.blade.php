<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xl shadow-sm">
                    {{ substr($user->name, 0, 1) }}
                </div>

                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Perfil de {{ $user->name }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        {{ $followersCount }} Seguidores · {{ $followingCount }} Siguiendo
                    </p>
                </div>
                <div class="flex items-center text-yellow-400 text-xs mt-1">
                    @for($i=1; $i<=5; $i++)
                        <i class="{{ $i <= $user->averageRating() ? 'fas fa-star' : 'far fa-star' }}"></i>
                        @endfor
                        <span class="ml-2 text-gray-500">({{ $user->reviewsReceived()->count() }} reseñas)</span>
                </div>
            </div>

            {{-- Botones de acción si no es mi propio perfil --}}
            @auth
            @if(auth()->id() !== $user->id)
            <div class="flex gap-2">
                <form action="{{ route('user.follow', $user) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-md font-bold transition {{ auth()->user()->followings->contains($user) ? 'bg-gray-200 text-gray-700' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                        {{ auth()->user()->followings->contains($user) ? 'Dejar de seguir' : 'Seguir' }}
                    </button>
                </form>
            </div>
            @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-6 border-b pb-2 text-gray-700 underline decoration-blue-500">Artículos en venta</h3>

                @if($userItems->isEmpty())
                <p class="text-gray-500 text-center py-10">Este usuario aún no tiene artículos publicados.</p>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($userItems as $item)
                    {{-- Estilo basado en tu Dashboard --}}
                    <div class="bg-gray-800 rounded-lg p-4 flex items-center gap-4 border border-gray-700 hover:border-blue-500 transition shadow-lg group">

                        {{-- Imagen --}}
                        <div class="w-24 h-24 flex-shrink-0 rounded-md overflow-hidden bg-white">
                            @if($item->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $item->images->first()->image_path) }}"
                                alt="{{ $item->name }}"
                                class="w-full h-full object-cover">
                            @else
                            <img src="https://via.placeholder.com/150?text=Sin+Foto"
                                class="w-full h-full object-cover">
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-white truncate group-hover:text-blue-400 transition">{{ $item->name }}</h3>
                            <p class="text-green-500 font-bold text-xl mt-1">{{ $item->price }}€</p>

                            <a href="{{ route('items.show', $item) }}" class="text-xs text-blue-300 hover:underline mt-2 inline-block">
                                Ver detalles →
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>