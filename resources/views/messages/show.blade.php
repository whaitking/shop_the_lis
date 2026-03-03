<x-app-layout>
    {{-- Usamos un alto ajustado para que no haya doble scroll en la página --}}
    <div class="py-6 h-[calc(100vh-80px)] flex flex-col">
        <div class="max-w-4xl mx-auto w-full flex-1 flex flex-col bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-100">

            {{-- CABECERA DEL CHAT --}}
            <div class="p-4 border-b flex items-center justify-between bg-white z-10 shadow-sm">
                <div class="flex items-center gap-2 sm:gap-4">
                    {{-- Botón de Volver (Flecha) --}}
                    <a href="{{ route('messages.index') }}" class="text-[#002395] hover:text-[#D4AF37] hover:bg-blue-50 p-2 rounded-full transition-colors" title="Volver a mis mensajes">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>

                    {{-- Info del Producto --}}
                    <a href="{{ route('items.show', $item) }}" class="flex items-center gap-3 group">
                        <div class="relative w-12 h-12 rounded-lg overflow-hidden border-2 border-transparent group-hover:border-[#D4AF37] transition-colors">
                            @if($item->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $item->images->first()->image_path) }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif
                        </div>
                        <div class="hidden sm:block">
                            <p class="font-bold text-sm text-gray-900 group-hover:text-[#002395] transition-colors line-clamp-1">{{ $item->name }}</p>
                            <p class="text-[#D4AF37] font-black text-sm">{{ $item->price }}€</p>
                        </div>
                    </a>
                </div>

                {{-- Info del Interlocutor --}}
                <div class="flex flex-col items-end text-right">
                    <span class="text-[10px] uppercase tracking-widest font-bold text-gray-400">Conversación con</span>
                    <a href="{{ route('profile.public', $otherUser ?? $receiver_id) }}" class="font-black text-[#002395] hover:text-[#D4AF37] transition-colors flex items-center gap-2">
                        {{ $otherUser->name ?? 'Usuario' }}
                    </a>
                </div>
            </div>

            {{-- CUERPO DE MENSAJES --}}
            <div class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-6 bg-gray-50/50" id="chat-container">
                @foreach($messages as $msg)
                <div class="flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[85%] sm:max-w-[70%] px-5 py-3 rounded-2xl shadow-sm relative group {{ $msg->sender_id == auth()->id() ? 'bg-[#002395] text-white rounded-br-sm' : 'bg-white text-gray-800 border border-gray-100 rounded-bl-sm' }}">
                        <p class="text-sm leading-relaxed">{{ $msg->content }}</p>
                        <span class="text-[10px] block text-right mt-2 {{ $msg->sender_id == auth()->id() ? 'text-blue-200' : 'text-gray-400' }}">
                            {{ $msg->created_at->format('H:i') }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- FORMULARIO DE ENVÍO --}}
            <div class="p-4 border-t bg-white">
                <form action="{{ route('messages.store', $item) }}" method="POST" class="flex gap-3 items-center">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $receiver_id }}">

                    <input type="text"
                        name="content"
                        placeholder="Escribe un mensaje..."
                        class="flex-1 border-gray-200 bg-gray-50 hover:bg-white focus:bg-white rounded-full px-6 py-3 focus:ring-2 focus:ring-[#002395] focus:border-transparent shadow-inner transition-all duration-300"
                        required
                        autocomplete="off"
                        autofocus>

                    <button type="submit" class="bg-[#D4AF37] text-[#002395] p-3 rounded-full hover:bg-yellow-500 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex-shrink-0 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#D4AF37]">
                        {{-- Icono de Avión de Papel Relleno --}}
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>