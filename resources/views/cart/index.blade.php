<x-app-layout>
    <div class="py-16 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            
            {{-- En-tête de page --}}
            <div class="mb-12">
                <h2 class="font-inter font-black text-4xl tracking-tighter text-slate-800 uppercase">
                    Mon <span class="text-sky-500">Panier</span>
                </h2>
                <p class="text-slate-400 font-inter font-bold text-[11px] uppercase tracking-[0.3em] mt-2">Récapitulatif de vos produits</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
                
                {{-- LISTE DES PRODUITS (Gauche) --}}
                <div class="lg:col-span-2 space-y-6">
                    @if(session('cart') && count(session('cart')) > 0)
                        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50/50 border-b border-slate-100">
                                        <th class="px-8 py-6 font-inter font-black text-[10px] uppercase tracking-widest text-slate-400">Produit</th>
                                        <th class="py-6 font-inter font-black text-[10px] uppercase tracking-widest text-slate-400 text-center">Quantité</th>
                                        <th class="px-8 py-6 font-inter font-black text-[10px] uppercase tracking-widest text-slate-400 text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @php $total = 0; @endphp
                                    @foreach(session('cart') as $id => $details)
                                        @php $total += $details['price'] * $details['quantity']; @endphp
                                        <tr class="group hover:bg-slate-50/30 transition-colors">
                                            <td class="px-8 py-6">
                                                <div class="flex items-center gap-6">
                                                    @if($details['image'])
                                                        <img src="{{ asset('storage/' . $details['image']) }}" class="w-20 h-20 object-cover rounded-2xl shadow-sm group-hover:scale-105 transition-transform duration-300">
                                                    @else
                                                        <div class="w-20 h-20 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-300">
                                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <p class="font-inter font-black text-sm uppercase tracking-tight text-slate-800">{{ $details['name'] }}</p>
                                                        <p class="text-sky-500 font-inter font-bold text-[10px] mt-1">{{ number_format($details['price'], 2) }} € / unité</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-6 text-center">
                                                <span class="inline-block px-4 py-2 bg-slate-50 rounded-xl font-inter font-black text-xs text-slate-600 border border-slate-100">
                                                    {{ $details['quantity'] }}
                                                </span>
                                            </td>
                                            <td class="px-8 py-6 text-right">
                                                <span class="font-inter font-black text-sm text-slate-900">
                                                    {{ number_format($details['price'] * $details['quantity'], 2) }} €
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Action Vider le panier --}}
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Vider tout votre panier ?')">
                            @csrf
                            <button type="submit" class="group flex items-center gap-2 text-slate-300 hover:text-red-500 transition-colors px-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                <span class="font-inter font-black text-[9px] uppercase tracking-widest">Vider mon panier</span>
                            </button>
                        </form>

                    @else
                        {{-- État Vide --}}
                        <div class="bg-white rounded-[2rem] border border-dashed border-slate-200 py-24 text-center">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-slate-50 rounded-full mb-6">
                                <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <p class="font-inter font-black text-lg text-slate-800 uppercase tracking-tight">Votre panier est vide</p>
                            <a href="{{ url('/') }}" class="mt-6 inline-flex items-center gap-3 bg-sky-500 text-white px-8 py-4 rounded-2xl font-inter font-black text-[10px] uppercase tracking-widest shadow-xl shadow-sky-100 hover:bg-slate-900 transition-all">
                                Commencer le shopping
                            </a>
                        </div>
                    @endif
                </div>

                {{-- RÉSUMÉ & PAIEMENT (Droite) --}}
                @if(session('cart') && count(session('cart')) > 0)
                <div class="sticky top-32">
                    <div class="bg-slate-900 rounded-[2rem] p-8 shadow-2xl shadow-slate-200 text-white">
                        <h3 class="font-inter font-black text-xs uppercase tracking-[0.2em] mb-8 text-sky-400">Résumé</h3>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center text-slate-400">
                                <span class="font-inter font-bold text-[10px] uppercase tracking-widest">Sous-total</span>
                                <span class="font-inter font-black text-sm">{{ number_format($total, 2) }} €</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-400">
                                <span class="font-inter font-bold text-[10px] uppercase tracking-widest">Livraison</span>
                                <span class="font-inter font-black text-[10px] uppercase">Offerte</span>
                            </div>
                            <div class="pt-4 border-t border-slate-800 flex justify-between items-center">
                                <span class="font-inter font-black text-xs uppercase tracking-widest text-white">Total TTC</span>
                                <span class="font-inter font-black text-2xl text-sky-400">{{ number_format($total, 2) }} €</span>
                            </div>
                        </div>

                        <form action="{{ route('checkout') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="space-y-3">
                                <input type="text" name="shipping_address" required placeholder="ADRESSE DE LIVRAISON" 
                                    class="w-full bg-slate-800 border-none rounded-xl p-4 text-[10px] font-inter font-bold uppercase tracking-widest text-white placeholder-slate-500 focus:ring-2 focus:ring-sky-500 transition-all">
                                
                                <div class="grid grid-cols-2 gap-3">
                                    <input type="text" name="shipping_postal_code" required placeholder="CODE POSTAL" 
                                        class="w-full bg-slate-800 border-none rounded-xl p-4 text-[10px] font-inter font-bold uppercase tracking-widest text-white placeholder-slate-500 focus:ring-2 focus:ring-sky-500 transition-all">
                                    <input type="text" name="shipping_city" required placeholder="VILLE" 
                                        class="w-full bg-slate-800 border-none rounded-xl p-4 text-[10px] font-inter font-bold uppercase tracking-widest text-white placeholder-slate-500 focus:ring-2 focus:ring-sky-500 transition-all">
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-sky-500 hover:bg-white hover:text-slate-900 text-white py-5 rounded-2xl font-inter font-black text-[11px] uppercase tracking-[0.2em] shadow-xl shadow-sky-900/20 transition-all mt-6 active:scale-95">
                                Valider la commande
                            </button>
                        </form>
                    </div>
                    
                    {{-- Badge de sécurité --}}
                    <div class="mt-6 flex items-center justify-center gap-3 text-slate-300">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        <span class="font-inter font-bold text-[9px] uppercase tracking-widest">Paiement 100% Sécurisé</span>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
