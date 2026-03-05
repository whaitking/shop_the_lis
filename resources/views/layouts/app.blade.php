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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900 selection:bg-[#D4AF37] selection:text-[#002395]">
    <div class="min-h-screen flex flex-col">

        {{-- Barra de Navegación --}}
        @include('layouts.navigation')

        {{-- Page Heading (Cabeceras de las páginas) --}}
        @isset($header)
        <header class="bg-white border-b border-gray-100 shadow-sm relative z-40">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        {{-- Page Content (Contenido principal que se expande) --}}
        <main class="flex-grow">
            {{ $slot }}
        </main>

        {{-- Footer Elegante de Shop The Lis --}}
        <footer class="bg-[#002395] text-white py-12 border-t-4 border-[#D4AF37] mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center">
                <x-application-logo class="w-16 h-16 text-[#D4AF37] mb-6 drop-shadow-lg" />
                <p class="text-blue-100 text-sm tracking-widest uppercase font-black mb-2">Shop The Lis</p>
                <p class="text-blue-300 text-xs font-medium">© {{ date('Y') }} El mercado de los elegidos. Todos los derechos reservados.</p>
            </div>
        </footer>

    </div>
</body>

</html>