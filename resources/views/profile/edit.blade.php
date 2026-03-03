<x-app-layout>
    {{-- CABECERA IDENTITARIA --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-white p-4 rounded-xl shadow-sm border-t-4 border-[#D4AF37]">

            <div class="flex items-center gap-6">
                {{-- Avatar --}}
                <div class="relative flex-shrink-0">
                    <div class="h-20 w-20 rounded-full bg-[#002395] border-4 border-[#D4AF37] flex items-center justify-center shadow-md">
                        <svg class="w-10 h-10 text-[#D4AF37]" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M50 10C50 10 40 40 10 45C30 50 45 55 45 90H55C55 55 70 50 90 45C60 40 50 10 50 10Z" fill="currentColor" />
                            <rect x="42" y="55" width="16" height="4" fill="currentColor" />
                        </svg>
                    </div>
                </div>

                {{-- Tu Información y Estadísticas --}}
                <div class="flex flex-col justify-center">
                    <h2 class="font-black text-2xl text-[#002395] tracking-tight uppercase">
                        Ajustes de Cuenta
                    </h2>

                    <div class="flex items-center mt-1">
                        <div class="flex text-[#D4AF37] text-sm">
                            @php $rating = auth()->user()->averageRating(); @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $rating ? 'fas fa-star' : 'far fa-star' }}"></i>
                                @endfor
                        </div>
                        <span class="ml-2 text-xs font-medium text-gray-500">({{ auth()->user()->reviewsReceived()->count() }} reseñas)</span>
                    </div>

                    <div class="flex items-center gap-3 mt-2">
                        <div class="text-sm">
                            <span class="font-bold text-[#002395]">{{ auth()->user()->followers()->count() }}</span>
                            <span class="text-gray-500 uppercase text-[9px] tracking-widest font-bold">Seguidores</span>
                        </div>
                        <div class="text-sm border-l pl-3 border-gray-200">
                            <span class="font-bold text-[#002395]">{{ auth()->user()->followings()->count() }}</span>
                            <span class="text-gray-500 uppercase text-[9px] tracking-widest font-bold">Siguiendo</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botón de Volver --}}
            <a href="{{ route('dashboard') }}" class="group flex items-center gap-2 px-6 py-2.5 rounded-full font-bold shadow-sm border border-gray-200 transition-all duration-300 bg-gray-50 text-gray-700 hover:bg-[#002395] hover:text-white hover:border-[#002395]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Volver al Mercado</span>
            </a>
        </div>
    </x-slot>

    {{-- FORMULARIOS DE AJUSTES --}}
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Sección: Información del Perfil --}}
            <div class="p-6 sm:p-10 bg-white shadow-lg sm:rounded-2xl border border-gray-100 relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-2 h-full bg-[#002395] transition-all duration-300 group-hover:bg-[#D4AF37]"></div>
                <div class="max-w-xl pl-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Sección: Contraseña --}}
            <div class="p-6 sm:p-10 bg-white shadow-lg sm:rounded-2xl border border-gray-100 relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-2 h-full bg-[#002395] transition-all duration-300 group-hover:bg-[#D4AF37]"></div>
                <div class="max-w-xl pl-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Sección: Zona de Peligro (Eliminar Cuenta) --}}
            <div class="p-6 sm:p-10 bg-white shadow-lg sm:rounded-2xl border border-red-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-red-500"></div>
                <div class="max-w-xl pl-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>