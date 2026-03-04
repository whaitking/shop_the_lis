<nav x-data="{ open: false, scrolled: false }"
    @scroll.window="scrolled = (window.pageYOffset > 20) ? true : false"
    :class="scrolled ? 'bg-[#002395] border-[#D4AF37]' : 'bg-white border-[#D4AF37]'"
    class="border-b-4 shadow-md sticky top-0 z-50 transition-colors duration-500">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">

            {{-- SECCIÓN IZQUIERDA: Logo y Menú Principal --}}
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}" class="group flex items-center gap-3">
                        <x-application-logo
                            :class="scrolled ? 'text-[#D4AF37]' : 'text-[#002395]'"
                            class="block h-12 w-auto group-hover:text-[#D4AF37] transition-colors duration-500 drop-shadow-md" />

                        <span
                            :class="scrolled ? 'text-white' : 'text-[#002395]'"
                            class="font-black text-2xl tracking-widest uppercase hidden sm:block group-hover:text-[#D4AF37] transition-colors duration-500">
                            Shop The Lis
                        </span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                    <a href="{{ route('welcome') }}"
                        :class="scrolled ? 'text-gray-200 hover:text-[#D4AF37]' : 'text-[#002395] hover:text-[#D4AF37]'"
                        class="font-black uppercase tracking-wider transition-colors duration-300 {{ request()->routeIs('welcome') ? 'border-b-2 border-[#D4AF37]' : '' }}">
                        {{ __('Mercado') }}
                    </a>

                    @auth
                    <a href="{{ route('dashboard') }}"
                        :class="scrolled ? 'text-gray-200 hover:text-[#D4AF37]' : 'text-[#002395] hover:text-[#D4AF37]'"
                        class="font-black uppercase tracking-wider transition-colors duration-300 {{ request()->routeIs('dashboard') ? 'border-b-2 border-[#D4AF37]' : '' }}">
                        {{ __('Mi Inventario') }}
                    </a>
                    <a href="{{ route('messages.index') }}"
                        :class="scrolled ? 'text-gray-200 hover:text-[#D4AF37]' : 'text-[#002395] hover:text-[#D4AF37]'"
                        class="relative font-black uppercase tracking-wider transition-colors duration-300 {{ request()->routeIs('messages.*') ? 'border-b-2 border-[#D4AF37]' : '' }}">
                        {{ __('Mensajes') }}
                        @if(auth()->user()->unreadMessagesCount() > 0)
                        <span class="absolute -top-2 -right-3 flex h-4 w-4 items-center justify-center rounded-full bg-red-600 text-[10px] font-bold text-white border border-white shadow-sm">
                            {{ auth()->user()->unreadMessagesCount() }}
                        </span>
                        @endif
                    </a>
                    @endauth
                </div>
            </div>

            {{-- SECCIÓN DERECHA: Notificaciones y Perfil --}}
            <div class="hidden sm:flex sm:items-center sm:ml-6 gap-2">
                @auth

                {{-- Campanita de Notificaciones --}}
                <div class="relative mr-4" x-data="{ notifyOpen: false, unreadCount: {{ auth()->user()->unreadNotifications->count() }} }">
                    <button @click="notifyOpen = !notifyOpen"
                        @mouseenter="if(unreadCount > 0) {
                            fetch('{{ route('notifications.markRead') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            });
                            unreadCount = 0;
                        }"
                        :class="scrolled ? 'text-[#D4AF37] hover:text-white hover:bg-white/10' : 'text-[#002395] hover:text-[#D4AF37] hover:bg-blue-50'"
                        class="relative p-2 transition-all duration-300 rounded-full focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>

                        <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-600 text-[10px] font-bold text-white border-2 border-white shadow-sm" style="display: none;">
                        </span>
                    </button>

                    {{-- Menú de Notificaciones (Siempre blanco para ser legible) --}}
                    <div x-show="notifyOpen" @click.away="notifyOpen = false" x-transition class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl overflow-hidden z-50 border border-gray-100" style="display: none;">
                        <div class="py-2">
                            <div class="px-4 py-3 text-xs text-[#002395] font-black uppercase tracking-widest border-b border-gray-100 bg-gray-50">Notificaciones</div>
                            @forelse(auth()->user()->notifications->take(5) as $notification)
                            <a href="{{ route('items.show', $notification->data['item_id']) }}" class="flex items-start px-4 py-3 hover:bg-blue-50 border-b border-gray-50 transition-colors {{ $notification->read_at ? 'opacity-70' : 'bg-blue-50/50' }}">
                                <div class="w-8 h-8 rounded-full bg-[#002395] text-[#D4AF37] flex items-center justify-center text-xs font-bold shrink-0 mt-0.5 border border-[#D4AF37]/30">
                                    {{ substr($notification->data['user_name'], 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-800 leading-tight">
                                        <span class="font-bold text-[#002395]">{{ $notification->data['user_name'] }}</span>
                                        {{ $notification->data['message'] }}
                                    </p>
                                    <span class="text-[10px] text-gray-400 font-semibold mt-1 block">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </a>
                            @empty
                            <div class="px-4 py-8 text-sm text-gray-500 text-center italic">No hay avisos en tu bandeja.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Dropdown del Usuario --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button :class="scrolled ? 'text-white hover:text-[#D4AF37] hover:bg-white/10 border-transparent' : 'text-[#002395] hover:text-[#D4AF37] hover:bg-gray-50 border-transparent'"
                            class="inline-flex items-center px-2 py-1.5 border text-sm leading-4 font-bold rounded-full transition-all duration-300 focus:outline-none">
                            <div class="flex items-center gap-2">
                                <div :class="scrolled ? 'bg-[#D4AF37] text-[#002395] border-white' : 'bg-[#002395] text-white border-[#D4AF37]'"
                                    class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-black border-2 transition-colors duration-500">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="uppercase tracking-wider hidden md:block">{{ Auth::user()->name }}</span>
                            </div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.public', Auth::user())" class="font-bold text-[#002395] hover:bg-blue-50 hover:text-[#D4AF37]">
                            {{ __('Mi Perfil Público') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')" class="font-bold text-[#002395] hover:bg-blue-50 hover:text-[#D4AF37]">
                            {{ __('Ajustes de Cuenta') }}
                        </x-dropdown-link>

                        <div class="border-t border-gray-100 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();" class="font-bold text-red-600 hover:bg-red-50">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>

                @else

                {{-- Botones Invitados --}}
                <a href="{{ route('login') }}"
                    :class="scrolled ? 'text-white hover:text-[#D4AF37]' : 'text-[#002395] hover:text-[#D4AF37]'"
                    class="font-bold uppercase tracking-widest text-sm px-4 py-2 transition-colors duration-300">
                    Entrar
                </a>

                <a href="{{ route('register') }}"
                    :class="scrolled ? 'bg-[#D4AF37] text-[#002395] hover:bg-yellow-500' : 'bg-[#002395] text-white hover:bg-[#D4AF37] hover:text-[#002395]'"
                    class="font-bold uppercase tracking-widest text-sm px-6 py-2.5 rounded-full transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                    Unirse
                </a>

                @endauth
            </div>

            {{-- Hamburger Móvil --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    :class="scrolled ? 'text-white hover:text-[#D4AF37] hover:bg-white/10' : 'text-[#002395] hover:text-[#D4AF37] hover:bg-gray-100'"
                    class="inline-flex items-center justify-center p-2 rounded-md focus:outline-none transition duration-300 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENÚ MÓVIL DESPLEGABLE (Siempre fondo claro para legibilidad) --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200 bg-gray-50 shadow-inner">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')" class="font-bold text-[#002395]">
                {{ __('Mercado') }}
            </x-responsive-nav-link>
            @auth
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-bold text-[#002395]">
                {{ __('Mi Inventario') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')" class="font-bold text-[#002395] flex items-center justify-between">
                <span>{{ __('Mensajes') }}</span>
                @if(auth()->user()->unreadMessagesCount() > 0)
                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-xs font-bold text-white">
                    {{ auth()->user()->unreadMessagesCount() }}
                </span>
                @endif
            </x-responsive-nav-link>
            @endauth
        </div>

        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-[#002395] text-white flex items-center justify-center font-black border-2 border-[#D4AF37]">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-black text-base text-[#002395] uppercase tracking-wider">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.public', Auth::user())" class="font-bold text-[#002395]">
                    {{ __('Mi Perfil Público') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')" class="font-bold text-[#002395]">
                    {{ __('Ajustes de Cuenta') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();" class="font-bold text-red-600">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-4 border-t border-gray-200 space-y-2 px-4">
            <a href="{{ route('login') }}" class="block text-center w-full text-[#002395] font-bold uppercase tracking-widest py-2">Entrar</a>
            <a href="{{ route('register') }}" class="block text-center w-full bg-[#002395] text-white font-bold uppercase tracking-widest py-3 rounded-full shadow-md">Unirse</a>
        </div>
        @endauth
    </div>
</nav>