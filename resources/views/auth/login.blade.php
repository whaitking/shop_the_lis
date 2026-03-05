<x-guest-layout>

    {{-- Título de Bienvenida Interno --}}
    <div class="text-center mb-8">
        <h2 class="text-2xl font-black text-[#002395] uppercase tracking-widest">Bienvenido de nuevo</h2>
        <p class="text-sm text-gray-500 mt-2 font-medium">Introduce tus credenciales para acceder a tus tesoros</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-sm font-bold text-[#002395] uppercase tracking-wider mb-2">
                {{ __('Correo Electrónico') }}
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-xl shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300 px-4 py-3 text-gray-800">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 font-semibold text-sm" />
        </div>

        <div>
            <label for="password" class="block text-sm font-bold text-[#002395] uppercase tracking-wider mb-2">
                {{ __('Contraseña') }}
            </label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-xl shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300 px-4 py-3 text-gray-800">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 font-semibold text-sm" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-gray-300 text-[#002395] shadow-sm focus:ring-[#D4AF37] group-hover:border-[#002395] transition-colors cursor-pointer w-5 h-5">
                <span class="ms-2 text-sm text-gray-600 font-bold group-hover:text-[#002395] transition-colors">
                    {{ __('Recordarme') }}
                </span>
            </label>

            @if (Route::has('password.request'))
            <a class="text-sm font-bold text-gray-400 hover:text-[#D4AF37] transition-colors" href="{{ route('password.request') }}">
                {{ __('¿Olvidaste tu contraseña?') }}
            </a>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#002395] text-white font-black uppercase tracking-widest py-4 rounded-xl shadow-lg hover:bg-[#D4AF37] hover:text-[#002395] hover:-translate-y-1 transition-all duration-300">
                {{ __('Entrar a SHOPTHELIS') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
            </button>
        </div>

        <div class="text-center mt-8 border-t border-gray-100 pt-6">
            <p class="text-sm text-gray-500 font-medium">
                ¿Aún no formas parte de SHOPTHELIS? <br class="sm:hidden">
                <a href="{{ route('register') }}" class="font-black text-[#002395] hover:text-[#D4AF37] uppercase tracking-wider transition-colors sm:ml-1 mt-2 sm:mt-0 inline-block">
                    Únete aquí
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>