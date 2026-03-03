<x-guest-layout>

    {{-- Título y Mensaje Explicativo --}}
    <div class="text-center mb-6">
        <h2 class="text-2xl font-black text-[#002395] uppercase tracking-widest">Nueva Contraseña</h2>
        <p class="text-sm text-gray-500 mt-1 font-medium px-2">
            Establece una nueva clave de acceso segura para tu cuenta.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-xs font-bold text-[#002395] uppercase tracking-wider mb-1">
                {{ __('Correo Electrónico') }}
            </label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-xl shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300 px-4 py-2.5 text-gray-800 text-sm opacity-80"
                readonly>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 font-semibold text-xs" />
        </div>

        <div>
            <label for="password" class="block text-xs font-bold text-[#002395] uppercase tracking-wider mb-1">
                {{ __('Nueva Contraseña') }}
            </label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-xl shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300 px-4 py-2.5 text-gray-800 text-sm"
                placeholder="Mínimo 8 caracteres">
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 font-semibold text-xs" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-[#002395] uppercase tracking-wider mb-1">
                {{ __('Confirmar Nueva Contraseña') }}
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-xl shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300 px-4 py-2.5 text-gray-800 text-sm"
                placeholder="Repite tu nueva contraseña">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500 font-semibold text-xs" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#002395] text-white font-black uppercase tracking-widest py-3 rounded-xl shadow-lg hover:bg-[#D4AF37] hover:text-[#002395] hover:-translate-y-1 transition-all duration-300 text-sm">
                {{ __('Restablecer Contraseña') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </button>
        </div>
    </form>
</x-guest-layout>