<x-app-layout>
    {{-- En-tête de la page --}}
    <div class="bg-white border-b border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="font-inter font-extrabold text-3xl text-slate-950 tracking-tight flex items-center gap-3">
                    Mes Commandes
                    <span class="inline-flex h-4 w-1 bg-sky-300 rounded-full"></span>
                </h2>
                <p class="font-dm text-slate-600 text-sm mt-2">Retrouvez ici l'historique complet de vos achats.</p>
            </div>
            <div class="text-sm font-bold text-sky-600 font-inter uppercase tracking-widest bg-sky-50 px-4 py-2 rounded-full border border-sky-100 shadow-inner">
                {{ $orders->count() }} commande(s)
            </div>
        </div>
    </div>

    {{-- Corps de la page --}}
    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @forelse($orders as $order)
                {{-- Carte de commande (avec effet de survol bleuté) --}}
                <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden hover:border-sky-100 transition-colors duration-200 shadow-sm hover:shadow-lg hover:shadow-sky-500/5 group">
                    
                    {{-- Informations de la commande --}}
                    <div class="bg-white px-8 py-6 border-b border-gray-100 flex flex-wrap md:flex-nowrap justify-between items-center gap-6">
                        <div class="flex flex-wrap items-center gap-x-12 gap-y-3">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Date</p>
                                <p class="text-sm font-semibold text-slate-900 font-inter">{{ $order->created_at->translatedFormat('d F Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Total</p>
                                <p class="text-sm font-extrabold text-sky-600 font-inter">{{ number_format($order->total_price, 2, ',', ' ') }} €</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">N° Commande</p>
                                <p class="text-sm font-semibold text-slate-900 font-inter">#{{ $order->id }}</p>
                            </div>
                        </div>

                        {{-- Statuts (Pastilles de couleur) --}}
                        <div>
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black tracking-wider uppercase
                                {{ $order->status === 'delivered' || $order->status === 'shipped' ? 'bg-sky-50 text-sky-700 ring-1 ring-sky-200' : 
                                   ($order->status === 'paid' ? 'bg-sky-50 text-sky-700 ring-1 ring-sky-200' : 'bg-orange-50 text-orange-700 ring-1 ring-orange-200') }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-2.5 
                                    {{ $order->status === 'delivered' || $order->status === 'shipped' ? 'bg-sky-500' : 
                                       ($order->status === 'paid' ? 'bg-sky-500' : 'bg-orange-500') }}"></span>
                                @switch($order->status)
                                    @case('paid') Payée @break
                                    @case('shipped') Expédiée @break
                                    @case('delivered') Livrée @break
                                    @case('pending') En attente @break
                                    @case('cancelled') Annulée @break
                                    @default {{ $order->status }}
                                @endswitch
                            </span>
                        </div>
                    </div>

                    {{-- Liste des articles --}}
                    <div class="px-8 py-6">
                        <div class="flow-root">
                            <ul role="list" class="-my-6 divide-y divide-gray-100">
                                @foreach($order->items as $item)
                                    <li class="py-6 flex items-center group/item">
                                        {{-- Image du produit --}}
                                        <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-xl border border-gray-100 bg-gray-50 transition group-hover/item:border-sky-200 group-hover/item:shadow-lg group-hover/item:shadow-sky-100">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover object-center transition-transform duration-300 group-hover/item:scale-105">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-slate-300 text-xs font-bold uppercase p-4 text-center">Sans image</div>
                                            @endif
                                        </div>

                                        {{-- Détails du produit --}}
                                        <div class="ml-8 flex flex-1 flex-col">
                                            <div class="flex justify-between text-base font-semibold text-slate-950 font-inter">
                                                <h3>{{ $item->product->name }}</h3>
                                                <p class="ml-4 whitespace-nowrap">{{ number_format($item->price * $item->quantity, 2, ',', ' ') }} €</p>
                                            </div>
                                            <div class="mt-1 flex flex-1 items-end justify-between text-sm">
                                                <p class="font-dm text-slate-500">
                                                    Quantité : <span class="text-sky-500 font-bold">{{ $item->quantity }}</span>
                                                    <span class="mx-1 text-gray-300">|</span> 
                                                    {{ number_format($item->price, 2, ',', ' ') }} € / unité
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

{{-- Actions (Boutons en bas de carte) --}}
<div class="bg-white px-8 py-5 flex flex-col sm:flex-row sm:items-center justify-end gap-3 border-t border-gray-100">
    
    {{-- Bouton d'annulation : visible uniquement si la commande est payée ou en attente --}}
    @if($order->status === 'paid' || $order->status === 'pending')
        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?');" class="inline">
            @csrf
            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 bg-red-50 border border-red-100 text-red-600 text-xs font-black uppercase tracking-widest rounded-full hover:bg-red-100 transition shadow-sm active:scale-95">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Annuler la commande
            </button>
        </form>
    @endif

    @if($order->tracking_number)
        <a href="https://www.sendcloud.fr/track/{{ $order->tracking_number }}" target="_blank" 
           class="inline-flex justify-center items-center px-6 py-3 bg-sky-600 text-white text-xs font-black uppercase tracking-widest rounded-full hover:bg-sky-700 transition shadow-md shadow-sky-100 active:scale-95">
            Suivre le colis 🚀
        </a>
    @elseif($order->sendcloud_id)
        <span class="inline-flex justify-center items-center px-6 py-3 bg-gray-100 text-gray-500 text-xs font-dm font-bold rounded-full border border-dashed border-gray-200">
            ⏳ En préparation...
        </span>
    @endif

    <a href="{{ route('invoice.download', $order->id) }}" target="_blank" 
       class="inline-flex justify-center items-center px-6 py-3 bg-white border border-gray-200 text-slate-950 text-xs font-black uppercase tracking-widest rounded-full hover:bg-gray-50 hover:border-gray-300 transition shadow-sm active:scale-95">
        <svg class="w-4 h-4 mr-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
        </svg>
        Télécharger Facture
    </a>
</div>
            @empty
                {{-- État vide (Si le client n'a aucune commande) --}}
                <div class="text-center py-24 px-8 bg-white border border-gray-100 rounded-3xl shadow-lg shadow-slate-100">
                    <div class="mx-auto h-24 w-24 bg-sky-50 rounded-full border border-sky-100 flex items-center justify-center mb-6 shadow-inner">
                        <svg class="h-10 w-10 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-2 text-3xl font-inter font-extrabold text-slate-950">Aucune commande</h3>
                    <p class="mt-3 text-lg font-dm text-slate-600 max-w-md mx-auto mb-10">Vous n'avez pas encore passé de commande. Découvrez nos collections et trouvez votre bonheur.</p>
                    <a href="{{ url('/') }}" class="inline-flex items-center px-8 py-4 border border-transparent shadow-2xl shadow-sky-100 text-sm font-black font-inter uppercase tracking-widest rounded-full text-white bg-sky-600 hover:bg-sky-700 transition active:scale-95">
                        Faire un tour en boutique
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>