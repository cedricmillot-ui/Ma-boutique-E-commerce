<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>BYFECT - Connexion</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .font-inter { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="font-sans text-slate-900 antialiased">
        {{-- Fond légèrement teinté pour faire ressortir le blanc du formulaire --}}
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f8fbff]">
            
            {{-- LOGO BYFECT (Remplace le logo Laravel) --}}
            <div class="mb-8 transform hover:scale-105 transition-transform duration-300">
                <a href="/" class="font-inter font-black text-4xl tracking-tighter text-slate-800">
                    BY<span class="text-sky-500">FECT</span>
                </a>
            </div>

            {{-- CONTENEUR FORMULAIRE : On harmonise les arrondis avec tes autres pages --}}
            <div class="w-full sm:max-w-md px-10 py-12 bg-white border border-sky-50 shadow-2xl shadow-sky-100/50 overflow-hidden rounded-[3rem]">
                {{ $slot }}
            </div>
            
            {{-- Petit rappel discret en bas --}}
            <p class="mt-8 text-[10px] font-black text-slate-300 uppercase tracking-[0.4em]">
                &copy; {{ date('Y') }} Byfect Studio
            </p>
        </div>
    </body>
</html>
