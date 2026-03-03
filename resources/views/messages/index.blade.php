<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Tus Mensajes</h1>

            <div class="bg-white shadow-sm sm:rounded-lg divide-y">
                @forelse($chats as $chat)
                @php
                $otherUser = ($chat->sender_id == auth()->id()) ? $chat->receiver : $chat->sender;
                @endphp
                <a href="{{ route('messages.show', [$chat->item, $otherUser->id]) }}" class="block p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('storage/' . $chat->item->images->first()->image_path) }}" class="w-16 h-16 object-cover rounded shadow-sm">

                        <div class="flex-1">
                            <div class="flex justify-between">
                                <span class="font-bold text-gray-900">{{ $otherUser->name }}</span>
                                <span class="text-xs text-gray-500">{{ $chat->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm font-semibold text-blue-600 truncate">{{ $chat->item->name }}</p>
                            <p class="text-sm text-gray-600 truncate italic">"{{ $chat->content }}"</p>
                        </div>
                    </div>
                </a>
                @empty
                <div class="p-8 text-center text-gray-500">No tienes conversaciones todavía.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>