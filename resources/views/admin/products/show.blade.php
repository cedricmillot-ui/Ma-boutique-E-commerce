<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <nav class="flex mb-8 text-sm font-medium text-slate-500">
                <a href="{{ url('/') }}" class="hover:text-sky-500 transition flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Boutique
                </a>
                <span class="mx-2">/</span>
                <span class="text-slate-400">{{ $product->name }}</span>
            </nav>

            <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-slate-200 flex flex-col md:flex-row">
                
                <div class="md:w-1/2 bg-slate-100 relative group overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover min-h-[500px] transition duration-700 group-hover:scale-110">
                    @else
                        <div class="flex items-center justify-center h-full min-h-[500px] text-slate-300">
                             <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>

                <div class="md:w-1/2 p-8 md:p-14 flex flex-col">
                    <div class="mb-6">
                        <span class="bg-sky-50 text-sky-600 text-[10px] font-black uppercase tracking-[0.2em] px-4 py-2 rounded-full border border-sky-100">
                            {{ $product->category->name ?? 'Collection Byfect' }}
                        </span>
                    </div>

                    <h1 class="text-4xl font-black text-slate-900 mb-2 tracking-tight">{{ $product->name }}</h1>
                    
                    <div class="mb-8">
                        <p class="text-4xl font-black text-sky-500">{{ number_format($product->price, 2) }} € <span class="text-sm font-bold uppercase ml-1 text-sky-400">TTC</span></p>
                        
                        {{-- Calcul de la TVA (basé sur 20% par défaut) --}}
                        @php
                            $tvaRate = 20; 
                            $priceHt = $product->price / (1 + ($tvaRate / 100));
                            $tvaAmount = $product->price - $priceHt;
                        @endphp
                        
                        <div class="mt-2 flex gap-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                            <span>Prix HT : {{ number_format($priceHt, 2) }} €</span>
                            <span>TVA ({{ $tvaRate }}%) : {{ number_format($tvaAmount, 2) }} €</span>
                        </div>
                    </div>
                    
                    <div class="mb-10">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-4">Description</h4>
                        <p class="text-slate-600 leading-relaxed text-lg">
                            {{ $product->description }}
                        </p>
                    </div>

                    <div class="mt-auto pt-8 border-t border-slate-100">
                        @if($product->stock > 0)
                            <div class="flex items-center mb-6">
                                <span class="flex h-3 w-3 relative mr-3">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                </span>
                                <span class="text-sm font-bold text-emerald-600">Stock disponible : {{ $product->stock }} articles</span>
                            </div>

                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex flex-col gap-4">
                                @csrf
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <div class="flex items-center border-2 border-slate-100 rounded-2xl p-1 bg-slate-50 h-16">
                                        <label class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Qté</label>
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                            class="w-16 border-none bg-transparent focus:ring-0 font-black text-sky-500 text-lg text-center">
                                    </div>
                                    <button type="submit" class="flex-grow bg-slate-900 text-white px-8 py-4 rounded-2xl font-black shadow-xl hover:bg-sky-500 transition-all transform active:scale-95 flex justify-center items-center gap-3">
                                        <svg class="w-6 h-6 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        Ajouter au panier
                                    </button>
                                </div>
                            </form>

                            @auth
                                @if(auth()->user()->address)
                                    <div class="mt-6 flex items-start gap-3 p-4 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                        <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <div>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Adresse de livraison</p>
                                            <p class="text-xs font-black text-slate-700">{{ auth()->user()->address }}, {{ auth()->user()->zip_code }} {{ auth()->user()->city }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endauth
                        @else
                            <div class="bg-red-50 p-6 rounded-3xl border border-red-100 text-red-700 shadow-inner">
                                <p class="font-black text-lg uppercase tracking-widest italic">Victime de son succès</p>
                                <p class="text-sm opacity-80 font-bold">Revenez très bientôt pour le prochain réassort.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
