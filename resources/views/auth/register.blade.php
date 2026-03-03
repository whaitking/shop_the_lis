<x-guest-layout>

    {{-- Título de Bienvenida Interno (Lenguaje E-commerce) --}}
    <div class="text-center mb-6">
        <h2 class="text-2xl font-black text-[#002395] uppercase tracking-widest">Crear Cuenta</h2>
        <p class="text-sm text-gray-500 mt-1 font-medium">Regístrate para comprar y vender artículos exclusivos</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-xs font-bold text-[#002395] uppercase tracking-wider mb-1">
                {{ __('Nombre de Usuario') }}
            </label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-xl shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300 px-4 py-2.5 text-gray-800 text-sm"
                placeholder="Ej: Coleccionista99">
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500 font-semibold text-xs" />
        </div>

        <div>
            <label for="email" class="block text-xs font-bold text-[#002395] uppercase tracking-wider mb-1">
                {{ __('Correo Electrónico') }}
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-xl shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300 px-4 py-2.5 text-gray-800 text-sm"
                placeholder="tu@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 font-semibold text-xs" />
        </div>

        <div>
            <label for="password" class="block text-xs font-bold text-[#002395] uppercase tracking-wider mb-1">
                {{ __('Contraseña') }}
            </label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-xl shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300 px-4 py-2.5 text-gray-800 text-sm"
                placeholder="Mínimo 8 caracteres">
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 font-semibold text-xs" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-[#002395] uppercase tracking-wider mb-1">
                {{ __('Confirmar Contraseña') }}
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-xl shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300 px-4 py-2.5 text-gray-800 text-sm"
                placeholder="Repite tu contraseña">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500 font-semibold text-xs" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#002395] text-white font-black uppercase tracking-widest py-3 rounded-xl shadow-lg hover:bg-[#D4AF37] hover:text-[#002395] hover:-translate-y-1 transition-all duration-300 text-sm">
                {{ __('Crear mi cuenta') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </button>
        </div>

        <div class="text-center mt-4 border-t border-gray-100 pt-4">
            <p class="text-xs text-gray-500 font-medium">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="font-black text-[#D4AF37] hover:text-[#002395] uppercase tracking-wider transition-colors ml-1 inline-block">
                    Inicia sesión
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>