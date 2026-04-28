<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
            <footer class="bg-slate-50 border-t border-sky-50/50 pt-20 pb-10">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            
            {{-- Branding --}}
            <div class="col-span-1 md:col-span-1">
                <a href="{{ url('/') }}" class="flex items-center gap-3 mb-6">
                    <img src="{{ asset('byfect.png') }}" alt="Logo" class="h-8 w-auto">
                    <span class="font-inter font-black text-xl tracking-tighter text-slate-800 uppercase">
                        BY<span class="text-sky-500">FECT</span>
                    </span>
                </a>
                <p class="text-slate-400 font-inter font-bold text-[11px] leading-relaxed uppercase tracking-widest">
                    La mode premium accessible. <br>Designé pour durer.
                </p>
            </div>

            {{-- Liens --}}
            <div>
                <h4 class="font-inter font-black text-[10px] uppercase tracking-[0.3em] text-slate-800 mb-6">Boutique</h4>
                <ul class="space-y-4 font-inter font-bold text-[10px] uppercase tracking-widest text-slate-500">
                    <li><a href="#" class="hover:text-sky-500 transition-colors">Nouveautés</a></li>
                    <li><a href="#" class="hover:text-sky-500 transition-colors">Homme</a></li>
                    <li><a href="#" class="hover:text-sky-500 transition-colors">Femme</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-inter font-black text-[10px] uppercase tracking-[0.3em] text-slate-800 mb-6">Support</h4>
                <ul class="space-y-4 font-inter font-bold text-[10px] uppercase tracking-widest text-slate-500">
                    <li><a href="#" class="hover:text-sky-500 transition-colors">Livraison</a></li>
                    <li><a href="#" class="hover:text-sky-500 transition-colors">Retours</a></li>
                    <li><a href="#" class="hover:text-sky-500 transition-colors">Contact</a></li>
                </ul>
            </div>

            {{-- Newsletter Style Pilule --}}
            <div>
                <h4 class="font-inter font-black text-[10px] uppercase tracking-[0.3em] text-slate-800 mb-6">Newsletter</h4>
                <div class="flex bg-white p-1.5 rounded-2xl border border-slate-100 shadow-sm">
                    <input type="email" placeholder="EMAIL" class="w-full bg-transparent border-none font-inter font-bold text-[9px] px-3 focus:ring-0">
                    <button class="bg-slate-900 text-white px-4 py-2 rounded-xl font-inter font-black text-[9px] uppercase tracking-widest hover:bg-sky-500 transition-all">OK</button>
                </div>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="border-t border-slate-200/50 pt-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <span class="font-inter font-bold text-[9px] uppercase tracking-[0.2em] text-slate-400">
                © 2026 BYFECT. TOUS DROITS RÉSERVÉS.
            </span>
            <div class="flex gap-8 font-inter font-bold text-[9px] uppercase tracking-[0.2em] text-slate-400">
                <a href="#" class="hover:text-slate-800">Mentions Légales</a>
                <a href="#" class="hover:text-slate-800">CGV</a>
            </div>
        </div>
    </div>
</footer>
        </div>

        <script type="text/javascript">
          window.$crisp=[];
          // Ton vrai ID que tu as fourni
          window.CRISP_WEBSITE_ID="73caeaec-0406-42a9-84d6-1292dea37c83";

          (function(){
            d=document;s=d.createElement("script");
            s.src="https://client.crisp.chat/l.js";
            s.async=1;
            d.getElementsByTagName("head")[0].appendChild(s);
          })();

          // Identification automatique si l'utilisateur est connecté
          @auth
            $crisp.push(["set", "user:email", ["{{ auth()->user()->email }}"]]);
            $crisp.push(["set", "user:nickname", ["{{ auth()->user()->name }}"]]);
          @endauth
        </script>
    </body>
</html>
