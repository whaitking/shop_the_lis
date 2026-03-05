<x-app-layout>
    <div class="min-h-[80vh] flex flex-col justify-center items-center py-12 bg-gray-50 px-4 sm:px-6 lg:px-8">

        {{-- Tarjeta de Éxito Premium --}}
        <div class="max-w-lg w-full bg-white shadow-2xl rounded-3xl p-8 sm:p-12 border-t-8 border-[#D4AF37] text-center relative overflow-hidden">

            {{-- Marca de agua de fondo --}}
            <div class="absolute -right-16 -top-16 text-gray-50 opacity-60 pointer-events-none">
                <x-application-logo class="w-64 h-64" />
            </div>

            <div class="relative z-10">
                {{-- Icono de Check Animado --}}
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-50 border-4 border-green-100 mb-8 shadow-inner">
                    <svg class="h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <h2 class="text-3xl font-black text-[#002395] uppercase tracking-widest mb-4">Adquisición Exitosa</h2>
                <p class="text-gray-600 font-medium mb-10 text-lg leading-relaxed">
                    El pago se ha procesado con absoluta seguridad. La reliquia ha sido reservada y ahora forma parte de tu colección privada.
                </p>

                {{-- Botonera de Acción --}}
                <div class="space-y-4">
                    <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-center bg-[#002395] text-white px-6 py-4 rounded-xl font-black uppercase tracking-widest hover:bg-[#D4AF37] hover:text-[#002395] transition-all duration-300 shadow-lg hover:-translate-y-1 gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Ver mi Inventario
                    </a>
                    <a href="{{ route('welcome') }}" class="w-full flex items-center justify-center bg-transparent text-[#002395] px-6 py-4 rounded-xl font-black uppercase tracking-widest hover:bg-blue-50 transition-all duration-300 border-2 border-[#002395] gap-2">
                        Volver al Mercado
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>