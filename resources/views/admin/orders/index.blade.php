<x-app-layout>
    {{-- Décorations d'arrière-plan globales --}}
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[-10%] right-[-5%] w-[800px] h-[800px] bg-sky-100/40 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] bg-slate-100/60 rounded-full blur-[80px]"></div>
    </div>

    {{-- 1. HEADER & OUTILS --}}
    <div class="relative pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- En-tête --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-12">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-sky-50 border border-sky-100 mb-4">
                        <span class="w-2 h-2 rounded-full bg-sky-500 animate-pulse"></span>
                        <span class="text-sky-600 font-black text-[9px] uppercase tracking-[0.3em]">Administration Ventes</span>
                    </div>
                    <h2 class="font-inter font-black text-4xl lg:text-5xl text-slate-900 tracking-tight">
                        Tableau des <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-sky-600">Ventes</span>
                    </h2>
                    <p class="mt-3 font-dm text-slate-500 text-sm">Gérez vos commandes, expéditions et votre chiffre d'affaires.</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.logs') }}" 
                       class="inline-flex items-center gap-2.5 bg-white border border-slate-200 text-slate-600 px-6 py-3 rounded-full font-inter font-bold text-[10px] tracking-widest uppercase shadow-sm hover:shadow-md hover:border-sky-300 hover:text-sky-600 transition-all duration-300 group">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-sky-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Journal des logs
                    </a>
                </div>
            </div>

            {{-- Panneau d'Export Financier --}}
            <div class="mb-12 relative">
                <div class="bg-white/80 backdrop-blur-xl border border-sky-100/80 p-6 lg:p-8 rounded-[2rem] shadow-xl shadow-sky-900/5 flex flex-col lg:flex-row items-center justify-between gap-6 transition-all hover:shadow-sky-900/10 hover:bg-white relative overflow-hidden group">
                    
                    {{-- Effet de brillance au hover --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/50 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] pointer-events-none"></div>

                    <div class="flex items-center gap-5 w-full lg:w-auto relative z-10">
                        <div class="w-14 h-14 bg-gradient-to-br from-slate-800 to-slate-900 text-sky-400 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-inter font-black text-xl text-slate-900 mb-1">Bilan Comptable</h4>
                            <p class="text-slate-500 text-xs font-dm">Export CSV détaillé pour votre comptabilité</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.export.orders') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto relative z-10">
                        <div class="relative w-full sm:w-56 group/select">
                            <select name="period" class="w-full pl-5 pr-10 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl font-inter font-bold text-[10px] tracking-widest uppercase text-slate-700 appearance-none focus:ring-2 focus:ring-sky-400 focus:border-transparent focus:bg-white transition-all cursor-pointer hover:border-sky-300">
                                <option value="current_month">Mois en cours</option>
                                <option value="last_month">Mois dernier</option>
                                <option value="year">Année complète</option>
                                <option value="all">Historique complet</option>
                            </select>

                        </div>
                        
                        <button type="submit" class="w-full sm:w-auto bg-sky-500 hover:bg-slate-900 text-white px-8 py-3.5 rounded-2xl font-inter font-black text-[10px] tracking-[0.2em] uppercase transition-all duration-300 flex items-center justify-center gap-2 shadow-lg shadow-sky-500/25 hover:shadow-slate-900/20 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Générer
                        </button>
                    </form>
                </div>
            </div>

            {{-- Grille de Statistiques (Améliorée avec icônes) --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                {{-- Total --}}
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-center relative overflow-hidden group hover:border-sky-200 transition-all">
                    <div class="absolute top-4 right-4 w-10 h-10 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center group-hover:bg-sky-50 group-hover:text-sky-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Commandes</span>
                    <span class="font-inter font-black text-4xl text-slate-800">{{ $orders->count() }}</span>
                </div>
                
                {{-- En cours --}}
                <div class="bg-gradient-to-br from-sky-400 to-sky-500 p-6 rounded-[2rem] shadow-lg shadow-sky-500/25 flex flex-col justify-center relative overflow-hidden group transform hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute top-4 right-4 w-10 h-10 bg-white/20 text-white rounded-full flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <span class="text-[9px] font-black text-sky-100 uppercase tracking-widest mb-1 block">À Préparer</span>
                    <span class="font-inter font-black text-4xl text-white">{{ $orders->where('status', 'paid')->count() }}</span>
                </div>
                
                {{-- En transit --}}
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-center relative overflow-hidden group hover:border-orange-200 transition-all">
                    <div class="absolute top-4 right-4 w-10 h-10 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center group-hover:bg-orange-50 group-hover:text-orange-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    </div>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block">En Transit</span>
                    <span class="font-inter font-black text-4xl text-slate-800">{{ $orders->where('status', 'shipped')->count() }}</span>
                </div>
                
                {{-- Revenus --}}
                <div class="bg-slate-900 p-6 rounded-[2rem] shadow-xl shadow-slate-900/20 flex flex-col justify-center relative overflow-hidden group transform hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute -right-6 -top-6 w-32 h-32 bg-sky-500/20 rounded-full blur-2xl group-hover:bg-sky-400/30 transition-all"></div>
                    <div class="absolute top-4 right-4 w-10 h-10 bg-white/10 text-sky-300 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <span class="text-[9px] font-black text-sky-400 uppercase tracking-widest mb-1 block relative z-10">Revenus Nets</span>
                    <span class="font-inter font-black text-3xl text-white relative z-10 tracking-tight">{{ number_format($orders->where('status', '!=', 'cancelled')->sum('total_price'), 0, ',', ' ') }} <span class="text-sky-400 text-2xl">€</span></span>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. ZONE PRINCIPALE (Filtres & Liste) --}}
    <div class="pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Barre de recherche / Filtres --}}
            <div class="mb-8 flex flex-col xl:flex-row gap-4 justify-between items-center bg-white/60 backdrop-blur-md p-2 pl-4 rounded-full shadow-sm border border-slate-200/60">
                <form action="{{ route('admin.orders') }}" method="GET" class="relative w-full xl:w-[400px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Client, Email ou Numéro..." 
                           class="w-full pl-10 pr-4 py-3 bg-transparent border-none focus:ring-0 font-dm text-sm text-slate-700 placeholder-slate-400 outline-none">
                    <button type="submit" class="absolute left-2 top-1/2 -translate-y-1/2 text-slate-400 hover:text-sky-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
                
                <div class="flex gap-2 w-full xl:w-auto overflow-x-auto p-1 hide-scrollbar bg-slate-50 rounded-full border border-slate-100">
                    <a href="{{ route('admin.orders') }}" class="px-6 py-2.5 rounded-full font-inter font-bold text-[10px] tracking-widest transition-all whitespace-nowrap {{ !request('status') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">TOUTES</a>
                    <a href="{{ route('admin.orders', ['status' => 'paid']) }}" class="px-6 py-2.5 rounded-full font-inter font-bold text-[10px] tracking-widest transition-all whitespace-nowrap flex items-center gap-2 {{ request('status') == 'paid' ? 'bg-sky-500 text-white shadow-md shadow-sky-500/20' : 'text-slate-500 hover:text-slate-800' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request('status') == 'paid' ? 'bg-white' : 'bg-sky-400' }}"></span> À PRÉPARER
                    </a>
                    <a href="{{ route('admin.orders', ['status' => 'shipped']) }}" class="px-6 py-2.5 rounded-full font-inter font-bold text-[10px] tracking-widest transition-all whitespace-nowrap flex items-center gap-2 {{ request('status') == 'shipped' ? 'bg-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-500 hover:text-slate-800' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request('status') == 'shipped' ? 'bg-white' : 'bg-orange-400' }}"></span> EN TRANSIT
                    </a>
                    <a href="{{ route('admin.orders', ['status' => 'delivered']) }}" class="px-6 py-2.5 rounded-full font-inter font-bold text-[10px] tracking-widest transition-all whitespace-nowrap flex items-center gap-2 {{ request('status') == 'delivered' ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/20' : 'text-slate-500 hover:text-slate-800' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request('status') == 'delivered' ? 'bg-white' : 'bg-emerald-400' }}"></span> LIVRÉES
                    </a>
                </div>
            </div>

            {{-- Liste des commandes --}}
            <div class="flex flex-col gap-6">
                @forelse($orders as $order)
                    <div class="bg-white rounded-[2rem] shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 overflow-hidden hover:shadow-[0_8px_30px_rgb(14,165,233,0.08)] hover:border-sky-200 transition-all duration-300 group flex flex-col lg:flex-row">
                        
                        {{-- 2.1 Visuel et Statut --}}
                        <div class="lg:w-[260px] bg-slate-50 flex-shrink-0 relative overflow-hidden border-r border-slate-100">
                            @if($order->items->first() && $order->items->first()->product->image)
                                <img src="{{ asset('storage/' . $order->items->first()->product->image) }}" 
                                     class="w-full h-48 lg:h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-slate-900/10 to-transparent opacity-60"></div>
                            @else
                                <div class="w-full h-48 lg:h-full flex items-center justify-center bg-gradient-to-br from-slate-50 to-slate-100">
                                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            
                            {{-- Badge Statut --}}
                            <div class="absolute top-4 left-4">
                                <div class="px-3 py-1.5 rounded-full backdrop-blur-md bg-white/95 shadow-sm flex items-center gap-2">
                                    @php
                                        $statusColor = match($order->status) {
                                            'paid' => 'text-sky-500',
                                            'shipped' => 'text-orange-500',
                                            'delivered' => 'text-emerald-500',
                                            default => 'text-slate-500'
                                        };
                                        $dotColor = match($order->status) {
                                            'paid' => 'bg-sky-500 animate-pulse',
                                            'shipped' => 'bg-orange-500',
                                            'delivered' => 'bg-emerald-500',
                                            default => 'bg-slate-500'
                                        };
                                        $statusLabel = match($order->status) {
                                            'paid' => 'À PRÉPARER',
                                            'shipped' => 'EN TRANSIT',
                                            'delivered' => 'LIVRÉE',
                                            default => strtoupper($order->status)
                                        };
                                    @endphp
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                    <span class="text-[9px] font-black uppercase tracking-widest {{ $statusColor }}">
                                        {{ $statusLabel }}
                                    </span>
                                </div>
                            </div>
                            
                            {{-- Date flottante sur image --}}
                            <div class="absolute bottom-4 left-4 right-4">
                                <p class="text-white/90 font-dm text-xs drop-shadow-md flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $order->created_at->translatedFormat('d M. Y • H:i') }}
                                </p>
                            </div>
                        </div>

                        {{-- 2.2 Informations & Contenu --}}
                        <div class="flex-grow p-6 lg:p-8 flex flex-col justify-center">
                            <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-center">
                                
                                {{-- Client --}}
                                <div class="xl:col-span-5">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 block">Informations Client</span>
                                    <h4 class="font-inter font-black text-2xl text-slate-900 leading-tight mb-1 truncate">{{ $order->user->name }}</h4>
                                    <a href="mailto:{{ $order->user->email }}" class="font-dm text-sky-600 text-sm hover:underline flex items-center gap-1.5 mb-2">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        {{ $order->user->email }}
                                    </a>
                                    <span class="inline-block bg-slate-100 text-slate-500 font-mono text-[10px] px-2 py-1 rounded-md">
                                        REF-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>

                                {{-- Articles --}}
                                <div class="xl:col-span-7 bg-slate-50/50 rounded-2xl p-4 border border-slate-100/50">
                                    <div class="space-y-2 max-h-[140px] overflow-y-auto pr-2 custom-scrollbar">
                                        @foreach($order->items as $item)
                                            <div class="flex justify-between items-center bg-white p-2.5 px-4 rounded-xl shadow-sm border border-slate-100/50 hover:border-sky-200 transition-colors">
                                                <div class="flex items-center gap-3">
                                                    <span class="bg-slate-100 text-slate-600 font-black text-[10px] w-6 h-6 flex items-center justify-center rounded-lg">{{ $item->quantity }}</span> 
                                                    <span class="font-dm text-sm text-slate-700 truncate max-w-[180px] sm:max-w-[250px]">{{ $item->product->name ?? 'Produit Supprimé' }}</span>
                                                </div>
                                                <span class="font-inter font-bold text-sm text-slate-900">{{ number_format($item->price, 2) }}€</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2.3 Total & Actions --}}
                        <div class="lg:w-[240px] bg-slate-50/50 p-6 lg:p-8 border-t lg:border-t-0 lg:border-l border-slate-100 flex flex-col justify-between items-center lg:items-end text-center lg:text-right">
                            
                            <div class="w-full mb-6">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Montant Payé</span>
                                <div class="flex items-baseline justify-center lg:justify-end gap-1">
                                    <span class="font-inter font-black text-3xl text-slate-900">{{ number_format($order->total_price, 2) }}</span>
                                    <span class="font-inter font-bold text-lg text-sky-500">€</span>
                                </div>
                            </div>

                            <div class="w-full space-y-3">
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="w-full">
                                    @csrf @method('PATCH')
                                    @if($order->status == 'paid')
                                        <button type="submit" name="status" value="shipped" class="w-full py-3.5 bg-sky-500 text-white rounded-xl font-inter font-bold text-[10px] tracking-widest hover:bg-sky-600 transition-all uppercase shadow-md shadow-sky-500/20 active:scale-95 flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                            Expédier
                                        </button>
                                    @elseif($order->status == 'shipped')
                                        <button type="submit" name="status" value="delivered" class="w-full py-3.5 bg-emerald-500 text-white rounded-xl font-inter font-bold text-[10px] tracking-widest hover:bg-emerald-600 transition-all uppercase shadow-md shadow-emerald-500/20 active:scale-95 flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Livrée
                                        </button>
                                    @else
                                        <div class="w-full py-3.5 flex items-center justify-center gap-2 rounded-xl bg-slate-100 text-slate-400 font-inter font-bold text-[10px] uppercase tracking-widest cursor-not-allowed">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Terminée
                                        </div>
                                    @endif
                                </form>

                                <div class="flex gap-2 w-full">
                                    <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="flex-1 py-3 flex items-center justify-center gap-2 bg-white text-slate-600 rounded-xl border border-slate-200 hover:bg-slate-50 hover:text-slate-900 transition-all font-inter font-bold text-[9px] uppercase tracking-widest group">
                                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Facture
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- État Vide Amélioré --}}
                    <div class="text-center py-24 bg-white/50 backdrop-blur-sm rounded-[3rem] border border-dashed border-sky-200 shadow-sm flex flex-col items-center justify-center">
                        <div class="w-24 h-24 bg-sky-50 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h3 class="font-inter font-black text-2xl text-slate-800 mb-2">Aucune commande trouvée</h3>
                        <p class="font-dm text-slate-500 text-sm max-w-sm">Les commandes apparaitront ici dès que vos clients finaliseront leurs achats.</p>
                    </div>
                @endforelse
            </div>
            
        </div>
    </div>

    {{-- Style pour la scrollbar des articles --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Animation pour le bloc export */
        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }
    </style>
</x-app-layout>
