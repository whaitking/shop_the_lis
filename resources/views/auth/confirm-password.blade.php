<x-guest-layout>

    {{-- Título y Mensaje de Seguridad --}}
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 text-[#002395] mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-black text-[#002395] uppercase tracking-widest">Área Segura</h2>
        <p class="text-sm text-gray-500 mt-2 font-medium">
            Por motivos de seguridad, confirma tu contraseña antes de continuar con esta acción.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <div>
            <label for="password" class="block text-xs font-bold text-[#002395] uppercase tracking-wider mb-1">
                {{ __('Contraseña') }}
            </label>
            <input id="password" type="password" name="password" required autocomplete="current-password" autofocus
                class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-xl shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300 px-4 py-2.5 text-gray-800 text-sm"
                placeholder="Introduce tu contraseña actual">
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 font-semibold text-xs" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#002395] text-white font-black uppercase tracking-widest py-3 rounded-xl shadow-lg hover:bg-[#D4AF37] hover:text-[#002395] hover:-translate-y-1 transition-all duration-300 text-sm">
                {{ __('Confirmar Identidad') }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </button>
        </div>

        <div class="text-center mt-4 border-t border-gray-100 pt-4">
            <a href="{{ url()->previous() }}" class="text-xs font-bold text-gray-400 hover:text-gray-700 uppercase tracking-wider transition-colors inline-block">
                Cancelar y volver
            </a>
        </div>
    </form>
</x-guest-layout>