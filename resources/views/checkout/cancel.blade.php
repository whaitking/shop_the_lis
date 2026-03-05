<x-app-layout>
    <div class="min-h-[80vh] flex flex-col justify-center items-center py-12 bg-gray-50 px-4 sm:px-6 lg:px-8">

        <div class="max-w-lg w-full bg-white shadow-xl rounded-3xl p-8 sm:p-12 border-t-8 border-gray-300 text-center relative">

            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-gray-50 border-4 border-gray-100 mb-6">
                <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>

            <h2 class="text-2xl font-black text-gray-800 uppercase tracking-widest mb-4">Operación Cancelada</h2>
            <p class="text-gray-500 font-medium mb-8 text-base">
                El proceso de pago ha sido interrumpido de forma segura. No se ha realizado ningún cargo en tu cuenta. El artículo sigue disponible en el mercado para cuando estés listo.
            </p>

            <a href="{{ route('welcome') }}" class="w-full flex items-center justify-center bg-[#002395] text-white px-6 py-4 rounded-xl font-black uppercase tracking-widest hover:bg-[#D4AF37] hover:text-[#002395] transition-all duration-300 shadow-lg hover:-translate-y-1">
                Explorar el Mercado
            </a>
        </div>

    </div>
</x-app-layout>