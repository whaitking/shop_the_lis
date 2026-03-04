<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Cabecera Elegante --}}
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-black text-[#002395] uppercase tracking-wide">Mensajes de la Orden</h1>
                <div class="h-1 flex-1 bg-gradient-to-r from-[#D4AF37] to-transparent ml-6 rounded-full opacity-30"></div>
            </div>

            {{-- Contenedor Principal --}}
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100 divide-y divide-gray-100">
                @forelse($chats as $chat)
                @php
                $otherUser = ($chat->sender_id == auth()->id()) ? $chat->receiver : $chat->sender;

                // Determinamos si el último mensaje es de la otra persona y no lo hemos leído
                $hasUnread = $chat->receiver_id == auth()->id() && is_null($chat->read_at);
                @endphp

                {{-- Fila de Chat (Ahora es un div relative) --}}
                <div class="relative group p-5 transition-colors duration-300 {{ $hasUnread ? 'bg-blue-50/70 border-l-4 border-l-[#002395]' : 'hover:bg-blue-50/50' }}">

                    {{-- ENLACE PRINCIPAL INVISIBLE (Cubre toda la fila y lleva al chat) --}}
                    <a href="{{ route('messages.show', [$chat->item, $otherUser->id]) }}" class="absolute inset-0 z-0" aria-hidden="true"></a>

                    <div class="relative z-10 flex items-center gap-5 pointer-events-none">

                        {{-- Miniatura del Producto --}}
                        <div class="relative w-16 h-16 flex-shrink-0 rounded-xl overflow-hidden bg-gray-100 border-2 border-transparent group-hover:border-[#D4AF37] transition-all duration-300 shadow-sm">
                            @if($chat->item->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $chat->item->images->first()->image_path) }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif
                        </div>

                        {{-- Información del Mensaje --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-1">
                                {{-- ENLACE AL PERFIL DEL USUARIO (Elevamos el z-index) --}}
                                <a href="{{ route('profile.public', $otherUser) }}" class="font-bold text-lg text-[#002395] hover:text-[#D4AF37] truncate pr-4 relative z-20 pointer-events-auto transition-colors" title="Ver perfil de {{ $otherUser->name }}">
                                    {{ $otherUser->name }}
                                </a>

                                {{-- Fecha --}}
                                <span class="text-xs font-semibold text-gray-400 whitespace-nowrap">{{ $chat->created_at->diffForHumans() }}</span>
                            </div>

                            {{-- Producto y Último Mensaje --}}
                            <div class="flex items-center gap-2 mb-0.5">
                                <p class="text-sm font-black text-[#D4AF37] truncate">{{ $chat->item->name }}</p>
                                @if($hasUnread)
                                <span class="flex h-2.5 w-2.5 rounded-full bg-red-600"></span>
                                @endif
                            </div>
                            <p class="text-sm {{ $hasUnread ? 'text-gray-900 font-bold' : 'text-gray-500 italic' }} truncate">"{{ $chat->content }}"</p>
                        </div>

                        {{-- Flecha indicadora --}}
                        <div class="text-gray-300 group-hover:text-[#D4AF37] group-hover:translate-x-1 transition-all duration-300 px-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                @empty
                {{-- Estado Vacío Elegante --}}
                <div class="p-16 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-dashed border-[#D4AF37]/50">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#002395] mb-2">Tu buzón está en silencio</h3>
                    <p class="text-gray-500 mb-6">Aún no has iniciado ninguna correspondencia con otros miembros de la Orden.</p>
                    <a href="{{ route('welcome') }}" class="inline-block bg-[#002395] hover:bg-[#D4AF37] text-white font-bold py-3 px-8 rounded-full transition-colors shadow-md">
                        Explorar Tesoros
                    </a>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>