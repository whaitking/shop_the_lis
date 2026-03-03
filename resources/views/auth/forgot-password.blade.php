<x-guest-layout>

    {{-- Título y Mensaje Explicativo --}}
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 text-[#002395] mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-black text-[#002395] uppercase tracking-widest">Recuperar Acceso</h2>
        <p class="text-sm text-gray-500 mt-2 font-medium px-2">
            ¿Has olvidado tu contraseña? No te preocupes. Indícanos tu correo electrónico y te enviaremos un enlace para crear una nueva.
        </p>
    </div>

    @if (session('status'))
    <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 flex items-start gap-3">
        <svg class="w-5 h-5 text-green-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-sm font-bold text-green-800">
            {{ session('status') }}
        </p>
    </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-xs font-bold text-[#002395] uppercase tracking-wider mb-1">
                {{ __('Correo Electrónico') }}
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-xl shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300 px-4 py-2.5 text-gray-800 text-sm"
                placeholder="tu@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 font-semibold text-xs" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#002395] text-white font-black uppercase tracking-widest py-3 rounded-xl shadow-lg hover:bg-[#D4AF37] hover:text-[#002395] hover:-translate-y-1 transition-all duration-300 text-sm">
                {{ __('Enviar Enlace') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </button>
        </div>

        <div class="text-center mt-4 border-t border-gray-100 pt-4">
            <a href="{{ route('login') }}" class="text-xs font-bold text-[#D4AF37] hover:text-[#002395] uppercase tracking-wider transition-colors inline-block">
                Volver a Iniciar Sesión
            </a>
        </div>
    </form>
</x-guest-layout>