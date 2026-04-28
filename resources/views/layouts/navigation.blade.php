<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white/70 backdrop-blur-md border-b border-sky-50/50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center h-24">
            
            {{-- BLOC LOGO (Gauche) --}}
            <div class="flex-shrink-0 w-1/4">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('byfect.png') }}" alt="Logo" class="h-10 w-auto object-contain transition-transform group-hover:scale-105">
                    <span class="font-inter font-black text-2xl tracking-tighter text-slate-800 uppercase">
                        BY<span class="text-sky-500">FECT</span>
                    </span>
                </a>
            </div>

            {{-- MENU CENTRAL (Navigation) --}}
            <div class="hidden md:flex flex-1 justify-center items-center gap-10">
                <a href="{{ url('/') }}" class="group relative py-2">
                    <span class="font-inter font-bold text-[11px] uppercase tracking-[0.2em] text-slate-500 group-hover:text-sky-500 transition-colors">Accueil</span>
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-sky-500 transition-all duration-300 group-hover:w-full"></span>
                </a>
                
                @auth
                    <a href="{{ route('orders.index') }}" class="group relative py-2">
                        <span class="font-inter font-bold text-[11px] uppercase tracking-[0.2em] text-slate-500 group-hover:text-sky-500 transition-colors">Commandes</span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-sky-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                @endauth
            </div>

            {{-- ACTIONS DROITE (Modifié : w-1/4 devient w-auto) --}}
            <div class="flex-shrink-0 w-auto flex items-center justify-end gap-3">
                @auth
                    {{-- Badges Admin --}}
                    @if(auth()->user()->is_admin)
                        {{-- Bouton Créer un produit (Ajout de whitespace-nowrap) --}}
                        <a href="{{ route('products.create') }}" class="hidden lg:block">
                            <span class="bg-sky-500 text-white text-[9px] font-black px-5 py-3 rounded-2xl uppercase tracking-widest whitespace-nowrap hover:bg-slate-900 transition-all shadow-sm shadow-sky-200">
                                + Produit
                            </span>
                        </a>

                        {{-- Badge Admin (Ajout de whitespace-nowrap) --}}
                        <a href="{{ route('admin.orders.index') }}" class="hidden lg:block">
                            <span class="bg-slate-900 text-white text-[9px] font-black px-5 py-3 rounded-2xl uppercase tracking-widest whitespace-nowrap hover:bg-sky-500 transition-all shadow-sm shadow-slate-200">
                                Admin
                            </span>
                        </a>
                    @endif

                    {{-- Lien Profil --}}
                    <a href="{{ route('profile.edit') }}" class="hidden lg:flex items-center gap-2 px-5 py-3 rounded-2xl bg-slate-50 border border-transparent hover:border-sky-100 hover:bg-white transition-all group">
                        <div class="w-1.5 h-1.5 rounded-full bg-sky-400 group-hover:animate-pulse"></div>
                        <span class="font-inter font-black text-[9px] uppercase tracking-widest text-slate-600 whitespace-nowrap">Profil</span>
                    </a>

                    {{-- Panier --}}
                    <a href="{{ route('cart.index') }}" class="relative group px-4 py-3 bg-slate-50 rounded-2xl hover:bg-sky-500 transition-all duration-300">
                        <svg class="w-4 h-4 text-slate-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-1 -right-1 flex h-4 w-4">
                                <span class="relative inline-flex rounded-full h-4 w-4 bg-slate-900 text-[8px] font-black text-white items-center justify-center border border-white">
                                    {{ count(session('cart')) }}
                                </span>
                            </span>
                        @endif
                    </a>

                    {{-- Logout --}}
                    <form action="{{ route('logout') }}" method="POST" class="hidden sm:block">
                        @csrf
                        <button type="submit" class="p-2 text-slate-300 hover:text-red-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                @else
                    {{-- Style Invité Uniformisé --}}
                    <a href="{{ route('login') }}" class="font-inter font-black text-[9px] uppercase tracking-[0.2em] text-slate-400 hover:text-sky-500 transition-colors px-4 whitespace-nowrap">
                        Login
                    </a>

                    {{-- S'inscrire --}}
                    <a href="{{ route('register') }}" class="flex items-center gap-2 px-6 py-3 rounded-2xl bg-slate-50 border border-transparent hover:border-sky-100 hover:bg-white transition-all group shadow-sm shadow-slate-100/50 active:scale-95 whitespace-nowrap">
                        <div class="w-1.5 h-1.5 rounded-full bg-sky-500 group-hover:animate-pulse"></div>
                        <span class="font-inter font-black text-[9px] uppercase tracking-[0.2em] text-slate-600">S'inscrire</span>
                    </a>
                @endauth

                {{-- Burger Mobile --}}
                <button @click="open = !open" class="md:hidden p-3 rounded-2xl bg-slate-50 text-slate-800 ml-2">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 8h16M4 16h16"></path></svg>
                    <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENU MOBILE --}}
    <div x-show="open" x-cloak
         x-transition:enter="transition duration-200 ease-out"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="md:hidden absolute top-full left-0 w-full bg-white border-b border-sky-50 p-8 shadow-2xl">
        <div class="flex flex-col gap-6 text-center">
            <a href="{{ url('/') }}" class="font-inter font-black text-xs uppercase tracking-widest text-slate-800">Accueil</a>
            @auth
                @if(auth()->user()->is_admin)
                    <div class="flex flex-col gap-4 py-4 border-y border-slate-100">
                        <a href="{{ route('products.create') }}" class="font-inter font-black text-xs uppercase tracking-widest text-sky-500">+ Créer un produit</a>
                        <a href="{{ route('admin.orders.index') }}" class="font-inter font-black text-xs uppercase tracking-widest text-slate-800">Espace Admin</a>
                    </div>
                @endif
                <a href="{{ route('orders.index') }}" class="font-inter font-black text-xs uppercase tracking-widest text-slate-800">Commandes</a>
                <a href="{{ route('profile.edit') }}" class="font-inter font-black text-xs uppercase tracking-widest text-sky-500">Mon Profil</a>
                <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="text-red-500 font-black text-[10px] uppercase tracking-widest">Déconnexion</button></form>
            @else
                <a href="{{ route('login') }}" class="font-inter font-black text-xs uppercase tracking-widest text-slate-400">Login</a>
                <a href="{{ route('register') }}" class="bg-sky-500 text-white py-5 rounded-3xl font-inter font-black text-xs uppercase tracking-[0.2em]">S'inscrire</a>
            @endauth
        </div>
    </div>
</nav>
