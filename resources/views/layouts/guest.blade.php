<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><path fill='%23D4AF37' d='M50 10C50 10 40 40 10 45C30 50 45 55 45 90H55C55 55 70 50 90 45C60 40 50 10 50 10Z'/><rect x='42' y='55' width='16' height='4' fill='%23D4AF37'/></svg>">
    <title>{{ config('app.name', 'SHOPTHELIS') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,900" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-[#002395] relative overflow-hidden selection:bg-[#D4AF37] selection:text-[#002395]">

    {{-- Marca de agua de fondo gigante --}}
    <div class="absolute inset-0 z-0 flex items-center justify-center opacity-[0.03] pointer-events-none">
        <x-application-logo class="w-[800px] h-[800px] text-white" />
    </div>

    {{-- Efectos de iluminación de fondo --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-lg h-[500px] bg-[#D4AF37]/20 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-10 sm:pt-0 relative z-10 px-4">

        {{-- Encabezado (Logo y Título) --}}
        <div class="mb-8 text-center flex flex-col items-center">
            <a href="{{ route('welcome') }}" class="group block transform transition-transform duration-500 hover:scale-105">
                <div class="bg-white p-5 rounded-full shadow-2xl border-4 border-[#D4AF37] relative">
                    <x-application-logo class="w-16 h-16 text-[#002395] group-hover:text-[#D4AF37] transition-colors duration-300" />

                    {{-- Brillo sutil al hacer hover --}}
                    <div class="absolute inset-0 rounded-full shadow-[0_0_30px_rgba(212,175,55,0.5)] opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                </div>
            </a>

            <h1 class="mt-6 text-3xl md:text-4xl font-black text-white tracking-widest uppercase drop-shadow-md">
                Shop The Lis
            </h1>
            <p class="text-[#D4AF37] font-bold tracking-widest text-sm mt-2 uppercase flex items-center gap-2 justify-center">
                <span class="w-8 h-px bg-[#D4AF37]"></span>
                Acceso al Mercado
                <span class="w-8 h-px bg-[#D4AF37]"></span>
            </p>
        </div>

        {{-- Tarjeta Blanca del Formulario --}}
        <div class="w-full sm:max-w-md px-8 py-10 bg-white shadow-2xl overflow-hidden rounded-3xl border-t-8 border-[#D4AF37] relative">

            {{-- Decoración interna sutil --}}
            <div class="absolute top-0 right-0 -mt-4 -mr-4 text-gray-50 opacity-50 pointer-events-none">
                <x-application-logo class="w-32 h-32" />
            </div>

            <div class="relative z-10">
                {{ $slot }}
            </div>

        </div>

        {{-- Pie de página simple --}}
        <div class="mt-12 text-center pb-8">
            <a href="{{ route('welcome') }}" class="text-blue-200 hover:text-white text-sm font-semibold transition-colors flex items-center gap-2 justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al inicio
            </a>
        </div>

    </div>
</body>

</html>