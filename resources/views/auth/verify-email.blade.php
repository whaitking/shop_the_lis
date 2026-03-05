<x-guest-layout>

    {{-- Título y Mensaje Explicativo --}}
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 text-[#002395] mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-black text-[#002395] uppercase tracking-widest">Verifica tu Correo</h2>
        <p class="text-sm text-gray-500 mt-2 font-medium px-2">
            ¡Gracias por unirte a SHOPTHELIS! Para garantizar la seguridad de tus transacciones, por favor verifica tu dirección de correo haciendo clic en el enlace que te acabamos de enviar.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
    <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 flex items-start gap-3">
        <svg class="w-5 h-5 text-green-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-sm font-bold text-green-800">
            Se ha enviado un nuevo enlace de verificación al correo que proporcionaste durante el registro.
        </p>
    </div>
    @endif

    <div class="mt-6 flex flex-col gap-4">

        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#002395] text-white font-black uppercase tracking-widest py-3 rounded-xl shadow-lg hover:bg-[#D4AF37] hover:text-[#002395] hover:-translate-y-1 transition-all duration-300 text-sm">
                {{ __('Reenviar correo de verificación') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full text-center border-t border-gray-100 pt-4">
            @csrf
            <button type="submit" class="text-xs font-bold text-gray-400 hover:text-red-500 uppercase tracking-wider transition-colors inline-block">
                {{ __('Cerrar Sesión') }}
            </button>
        </form>

    </div>
</x-guest-layout>