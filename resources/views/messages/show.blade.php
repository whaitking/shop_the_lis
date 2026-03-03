<x-app-layout>
    <div class="py-6 h-screen flex flex-col">
        <div class="max-w-3xl mx-auto w-full flex-1 flex flex-col bg-white shadow-lg rounded-t-xl overflow-hidden">

            <div class="p-4 border-b flex items-center justify-between bg-gray-50">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('storage/' . $item->images->first()->image_path) }}" class="w-12 h-12 object-cover rounded">
                    <div>
                        <p class="font-bold text-sm">{{ $item->name }}</p>
                        <p class="text-blue-600 font-bold">{{ $item->price }}€</p>
                    </div>
                </div>
                <a href="{{ route('items.show', $item) }}" class="text-xs text-gray-500 hover:underline">Ver artículo</a>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-100">
                @foreach($messages as $msg)
                <div class="flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[70%] px-4 py-2 rounded-2xl shadow-sm {{ $msg->sender_id == auth()->id() ? 'bg-blue-600 text-white rounded-tr-none' : 'bg-white text-gray-800 rounded-tl-none' }}">
                        <p class="text-sm">{{ $msg->content }}</p>
                        <span class="text-[10px] opacity-70 block text-right mt-1">{{ $msg->created_at->format('H:i') }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Sección del formulario en resources/views/messages/show.blade.php --}}

            <div class="p-4 border-t bg-white">
                <form action="{{ route('messages.store', $item) }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $receiver_id }}">

                    <input type="text"
                        name="content"
                        placeholder="Pregunta algo sobre {{ $item->name }}..."
                        class="flex-1 border-gray-300 rounded-full px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                        required
                        autocomplete="off"
                        autofocus>

                    <button type="submit" class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition transform active:scale-95">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>