<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Byfect Shop | Premium Store</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>

<body>
<x-app-layout>

<main id="catalogue" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24 pt-14">

    <div class="mb-10 max-w-2xl mx-auto"> 
        <form action="{{ url('/') }}" method="GET" class="w-full">
            @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
            @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
            
            <div class="search-wrap">
                <svg style="margin-left:20px;color:#bae6fd;flex-shrink:0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Chercher un vêtement, une marque...">
                
                @if(request('search'))
                    <a href="{{ url('/#catalogue') }}" style="color:#94a3b8;padding:0 8px;display:flex;align-items:center" title="Effacer">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                @endif
                
                <button type="submit" class="search-btn">Rechercher</button>
            </div>
        </form>
    </div>

    <div class="flex overflow-x-auto no-scrollbar gap-3 pb-4 mb-14 sm:flex-wrap sm:justify-center sm:overflow-visible">
        <a href="{{ url('/#catalogue') }}" class="cat-pill {{ !request('category') ? 'active' : '' }}">
            <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Tous les articles
        </a>
        @foreach($categories as $category)
            <a href="{{ url('/?category=' . $category->slug . '#catalogue') }}" 
               class="cat-pill {{ request('category') == $category->slug ? 'active' : '' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

<div class="mb-12 text-center">
    <span class="section-eyebrow">
        @if(request('search')) Résultats @else Collection @endif
    </span>
    <h2 style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; color: var(--text-dark); letter-spacing: -0.03em; margin-top: 0.5rem">
        @if(request('search'))
            Résultats pour <span style="color: var(--sky-dark)">"{{ request('search') }}"</span>
        @else
            Notre <span style="color: var(--sky-dark)">Sélection</span> Premium
        @endif
    </h2>
</div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="product-card {{ $product->stock <= 0 ? 'out-of-stock' : '' }}">

                <div class="product-img-wrap">
                    <a href="{{ route('products.show', $product->id) }}" style="display:block;width:100%;height:100%">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div style="display:flex;align-items:center;justify-content:center;height:100%;color:#bae6fd">
                                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="quick-view-overlay">
                            <span class="quick-view-btn">Voir les détails →</span>
                        </div>
                    </a>

                    @if($product->stock <= 0)
                        <span class="badge badge-out">Épuisé</span>
                    @elseif($product->stock <= 3)
                        <span class="badge badge-low">⚡ {{ $product->stock }} restants</span>
                    @else
                        <span class="badge badge-stock">● En stock</span>
                    @endif
                </div>

                <div class="product-content">
                    <div>
                        <a href="{{ route('products.show', $product->id) }}" class="product-name">{{ $product->name }}</a>
                        <p class="product-desc">{{ $product->description }}</p>
                    </div>

                    <div class="price-row" style="margin-top:16px">
                        <div>
                            <span class="price-label">Prix</span>
                            <span class="price-amount">
                                {{ number_format($product->price, 2, ',', ' ') }}<span class="price-currency"> €</span>
                            </span>
                        </div>

                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="add-btn">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    <span class="hidden sm:inline">Ajouter</span>
                                </button>
                            </form>
                        @else
                            <span class="disabled-btn">Rupture</span>
                        @endif
                    </div>

                    @if(auth()->check() && auth()->user()->is_admin)
                        <div class="admin-row">
                            <a href="{{ route('products.edit', $product->id) }}" class="admin-link" style="color:#0284c7">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Éditer
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-link" style="color:#dc2626;background:none;border:none;cursor:pointer">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

        @empty
<div class="empty-state col-span-full">
    <div class="empty-icon">
        <svg width="36" height="36" fill="none" stroke="#0ea5e9" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
    </div>
    <h3 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 8px">Aucun article trouvé</h3>
    <p style="color: #94a3b8; font-size: .9rem; margin-bottom: 1.5rem">Essayez de modifier votre recherche ou votre filtre.</p>
    <a href="{{ url('/') }}" class="inline-block px-8 py-3 bg-sky-600 text-white rounded-full font-bold">
        Voir tout le catalogue
    </a>
</div>
        @endforelse
    </div>

    @if(isset($products) && method_exists($products, 'links'))
        <div class="mt-16 flex justify-center">
            {{ $products->links() }}
        </div>
    @endif

</main>


<!-- ═══════════════ FOOTER ═══════════════ -->
<footer>
    <div class="max-w-7xl mx-auto px-4">
        <div class="footer-logo">BYFECT</div>
        <p style="font-size:.8rem;color:#94a3b8;font-weight:500;letter-spacing:.12em;text-transform:uppercase">
            &copy; {{ date('Y') }} Byfect Shop Premium — Tous droits réservés
        </p>
        <div style="display:flex;justify-content:center;gap:1.5rem;margin-top:1rem;flex-wrap:wrap">
            <a href="#" style="font-size:.8rem;color:#94a3b8;text-decoration:none;transition:color .2s" onmouseover="this.style.color='#0ea5e9'" onmouseout="this.style.color='#94a3b8'">Mentions légales</a>
            <a href="#" style="font-size:.8rem;color:#94a3b8;text-decoration:none;transition:color .2s" onmouseover="this.style.color='#0ea5e9'" onmouseout="this.style.color='#94a3b8'">Politique de confidentialité</a>
            <a href="#" style="font-size:.8rem;color:#94a3b8;text-decoration:none;transition:color .2s" onmouseover="this.style.color='#0ea5e9'" onmouseout="this.style.color='#94a3b8'">Contact</a>
        </div>
    </div>
</footer>


<!-- ═══════════════ TOAST SUCCESS ═══════════════ -->
@if(session('success'))
    <div id="toast-success" class="toast">
        <div style="background:rgba(255,255,255,0.2);border-radius:12px;padding:8px;flex-shrink:0">
            <svg width="22" height="22" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <span style="font-weight:600;font-size:.9rem;flex:1">{{ session('success') }}</span>
        <button onclick="document.getElementById('toast-success').remove()" style="background:none;border:none;color:rgba(255,255,255,0.7);cursor:pointer;padding:4px;line-height:1">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    <script>
        setTimeout(() => {
            const t = document.getElementById('toast-success');
            if (t) { t.style.transition='all .4s ease'; t.style.opacity='0'; t.style.transform='translateY(40px)'; setTimeout(()=>t.remove(),400); }
        }, 4000);
    </script>
@endif


<!-- ═══════════════ SCROLL TO TOP ═══════════════ -->
<button id="scrollToTopBtn" title="Remonter">
    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path></svg>
</button>


<!-- ═══════════════ SCRIPTS ═══════════════ -->
<script>
    // Mobile menu
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const iconMenu = document.getElementById('menu-icon');
    const iconClose = document.getElementById('close-icon');
    btn && btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        iconMenu.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');
    });

    // Scroll to top
    const scrollBtn = document.getElementById('scrollToTopBtn');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) scrollBtn.classList.add('visible');
        else scrollBtn.classList.remove('visible');
    });
    scrollBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
</script>

<!-- Crisp Chat -->
<script type="text/javascript">
    window.$crisp=[];
    window.CRISP_WEBSITE_ID="73caeaec-0406-42a9-84d6-1292dea37c83";
    (function(){
        var d=document, s=d.createElement("script");
        s.src="https://client.crisp.chat/l.js";
        s.async=1;
        d.getElementsByTagName("head")[0].appendChild(s);
    })();
    @auth
        $crisp.push(["set", "user:email", [{{ Js::from(auth()->user()->email) }}]]);
        $crisp.push(["set", "user:nickname", [{{ Js::from(auth()->user()->name) }}]]);
    @endauth
</script>
</x-app-layout>
</body>
</html>
</html>
