<x-app-layout>
    <div class="py-8 bg-white border-b border-sky-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-inter font-extrabold text-3xl text-slate-900 leading-tight">
                {{ __('Tableau de Bord') }}
            </h2>
            <p class="font-dm text-slate-500 text-sm mt-1">Ravi de vous revoir, {{ Auth::user()->name }} !</p>
        </div>
    </div>

    <div class="py-12 bg-[#f8fbff]"> <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-sky-50 border-b-4 border-b-sky-500">
                    <p class="font-sy-ne font-bold text-xs uppercase tracking-widest text-slate-400">Commandes</p>
                    <p class="text-3xl font-inter font-black text-slate-900 mt-2">{{ Auth::user()->orders->count() }}</p>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-sky-50">
                    <p class="font-inter font-bold text-xs uppercase tracking-widest text-slate-400">Statut Compte</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <p class="text-lg font-dm font-bold text-slate-700">Actif</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-sky-50">
                    <p class="font-inter font-bold text-xs uppercase tracking-widest text-slate-400">Support</p>
                    <a href="mailto:support@byfect.com" class="text-sky-600 font-dm font-bold mt-2 block hover:underline">Contacter l'aide</a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-sky-50">
                <div class="p-8">
                    <h3 class="font-inter font-bold text-xl text-slate-900 mb-4">Dernières activités</h3>
                    <div class="bg-sky-50 border border-sky-100 rounded-2xl p-4 text-sky-800 font-dm">
                        {{ __("Vous êtes connecté avec succès à votre espace Byfect.") }} 
                    </div>
                    
                    <div class="mt-8">
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-slate-900 text-white px-6 py-3 rounded-full font-inter font-bold text-sm hover:bg-sky-700 transition-all shadow-lg shadow-slate-200">
                            Continuer mes achats
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
