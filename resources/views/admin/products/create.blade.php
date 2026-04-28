<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-sky-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-sky-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <div>
                    <h2 class="font-inter font-black text-3xl text-slate-800 leading-tight tracking-tighter">Nouveau Produit</h2>
                    <p class="text-sky-400 text-[10px] font-black uppercase tracking-[0.3em]">Gestion de l'inventaire</p>
                </div>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="group flex items-center gap-2 text-slate-400 hover:text-sky-500 transition-all font-inter font-bold text-xs uppercase tracking-widest">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#f8fbff]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
                    
                    {{-- COLONNE GAUCHE --}}
                    <div class="space-y-8 bg-white p-10 rounded-[3rem] border border-sky-100 shadow-sm shadow-sky-50">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-2 h-8 bg-sky-400 rounded-full"></div>
                            <h3 class="font-inter font-black text-xl text-slate-800 uppercase tracking-tighter">Informations</h3>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block font-inter font-black text-[10px] text-slate-400 uppercase tracking-widest mb-2 ml-1">Nom du produit</label>
                                <input type="text" name="name" class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-slate-800 font-bold focus:bg-white focus:border-sky-200 focus:ring-0 transition-all" required>
                            </div>

                            <div>
                                <div class="flex justify-between mb-2 ml-1">
                                    <label class="block font-inter font-black text-[10px] text-slate-400 uppercase tracking-widest">Collection</label>
                                    <button type="button" onclick="openCategoryModal()" class="text-[9px] font-black text-sky-500 hover:underline tracking-widest uppercase">Gérer les catégories</button>
                                </div>
                                <select name="category_id" class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-slate-800 font-bold focus:bg-white focus:border-sky-200 focus:ring-0 transition-all cursor-pointer" required>
                                    <option value="" disabled selected>Sélectionner une catégorie</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-inter font-black text-[10px] text-slate-400 uppercase tracking-widest mb-2 ml-1">Description</label>
                                <textarea name="description" rows="8" class="w-full bg-slate-50 border-transparent rounded-[2rem] p-5 text-slate-700 font-medium focus:bg-white focus:border-sky-200 focus:ring-0 transition-all" placeholder="Détails techniques..." required></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- COLONNE DROITE --}}
                    <div class="space-y-8">
                        <div class="bg-white rounded-[3rem] p-10 border border-sky-100 shadow-sm shadow-sky-50">
                            <div class="flex items-center gap-3 mb-8">
                                <div class="w-2 h-8 bg-sky-200 rounded-full"></div>
                                <h3 class="font-inter font-black text-xl text-slate-800 uppercase tracking-tighter">Prix & Taxes</h3>
                            </div>

                            <div class="grid grid-cols-2 gap-6 mb-8">
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Prix HT (€)</label>
                                    <input type="number" step="0.01" id="price_ht" class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-slate-800 font-black focus:ring-sky-200 focus:bg-white transition-all border border-slate-100" placeholder="0.00">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Taux TVA</label>
                                    <select id="tva_rate" class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-slate-800 font-black focus:ring-sky-200 focus:bg-white transition-all border border-slate-100">
                                        <option value="20">20%</option>
                                        <option value="5.5">5.5%</option>
                                        <option value="10">10%</option>
                                        <option value="0">0%</option>
                                    </select>
                                </div>
                            </div>

                            <div class="bg-sky-50 rounded-3xl p-6 border border-sky-100 flex justify-between items-center shadow-inner">
                                <label class="font-inter font-black text-sky-500 text-xs uppercase tracking-widest">Montant TTC</label>
                                <div class="flex items-center gap-2">
                                    <input type="number" step="0.01" name="price" id="price_ttc" class="bg-transparent border-none p-0 text-sky-600 font-inter font-black text-3xl text-right focus:ring-0 w-32" required placeholder="0.00">
                                    <span class="text-sky-300 font-black text-xl">€</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-10 rounded-[3rem] border border-sky-100 shadow-sm shadow-sky-50 space-y-8">
                            <div class="grid grid-cols-2 gap-8 items-end">
                                <div class="space-y-2">
                                    <label class="block font-inter font-black text-[10px] text-slate-400 uppercase tracking-widest ml-1">Stock Initial</label>
                                    <input type="number" name="stock" class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-slate-800 font-black focus:bg-white focus:border-sky-200 transition-all border border-slate-100" placeholder="0" required>
                                </div>
                                <div class="relative h-[60px]">
                                    <label class="absolute inset-0 cursor-pointer bg-sky-100/30 border-2 border-dashed border-sky-200 rounded-2xl flex items-center justify-center gap-3 hover:bg-sky-100 transition-all group">
                                        <svg class="w-5 h-5 text-sky-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-[10px] font-black text-sky-500 uppercase tracking-widest">Image</span>
                                        <input type="file" name="image" id="image-input" class="hidden" accept="image/*" onchange="previewImage(this)">
                                    </label>
                                </div>
                            </div>
                            <div id="preview-box" class="hidden relative h-40 rounded-[2rem] overflow-hidden border-2 border-sky-50 ring-8 ring-slate-50">
                                <img id="image-preview" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-sky-500 text-white py-6 rounded-[2rem] font-inter font-black uppercase tracking-[0.3em] text-sm hover:bg-slate-800 shadow-xl shadow-sky-200 transition-all active:scale-[0.98]">
                            Mettre en ligne l'article
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL GESTION CATÉGORIES --}}
    <div id="categoryModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-sky-900/20 backdrop-blur-sm transition-opacity" onclick="closeCategoryModal()"></div>
        <div id="categoryModalContent" class="relative bg-white rounded-[3.5rem] shadow-2xl w-full max-w-md p-10 transform scale-95 opacity-0 transition-all duration-500 border border-white">
            <h3 class="text-xl font-inter font-black text-slate-800 mb-6 tracking-tighter text-center uppercase">Collections</h3>

            <div class="max-h-64 overflow-y-auto mb-8 space-y-3 pr-2 custom-scrollbar">
                @foreach($categories as $category)
                    <div class="bg-slate-50 p-3 px-5 rounded-2xl border border-transparent hover:border-sky-100 transition-all group">
                        <div id="display-{{ $category->id }}" class="flex items-center justify-between">
                            <span class="font-bold text-slate-700 text-sm">{{ $category->name }}</span>
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="toggleEdit({{ $category->id }})" class="text-slate-300 hover:text-sky-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <form id="edit-{{ $category->id }}" action="{{ route('categories.update', $category->id) }}" method="POST" class="hidden">
                            @csrf @method('PUT')
                            <div class="flex gap-2">
                                <input type="text" name="name" value="{{ $category->name }}" class="flex-1 bg-white border-sky-200 rounded-xl p-1 px-3 text-sm font-bold text-slate-800 focus:ring-sky-500">
                                <button type="submit" class="bg-sky-500 text-white p-1 px-3 rounded-xl text-[10px] font-black uppercase">OK</button>
                                <button type="button" onclick="toggleEdit({{ $category->id }})" class="text-slate-400 text-[10px] font-black uppercase">X</button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="w-full h-px bg-slate-100 mb-8"></div>

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-[10px] font-black text-slate-400 mb-3 uppercase tracking-widest text-center">Nouvelle catégorie</label>
                    <input type="text" name="name" class="w-full bg-slate-50 border-transparent rounded-2xl p-4 font-bold text-slate-800 text-center focus:bg-white focus:border-sky-200 transition-all" placeholder="Nom de la collection">
                </div>
                <button type="submit" class="w-full bg-sky-500 text-white py-4 rounded-[1.5rem] font-inter font-black uppercase tracking-widest text-xs shadow-lg shadow-sky-100 hover:bg-slate-800 transition-all">Ajouter</button>
            </form>
        </div>
    </div>

    {{-- ALERTES --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-100 text-red-600 text-xs font-black uppercase tracking-widest rounded-2xl text-center">{{ session('error') }} [cite: 47]</div>
        @endif
        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs font-black uppercase tracking-widest rounded-2xl text-center">{{ session('success') }} [cite: 48]</div>
        @endif
    </div>

    {{-- STYLE CSS POUR LES MENUS DÉROULANTS --}}
    <style>
        select {
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2338bdf8' stroke-width='3'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 1.5rem center !important;
            background-size: 1.2rem !important;
            padding-right: 3.5rem !important;
            cursor: pointer !important;
        } 

        select option {
            background-color: white !important;
            color: #1e293b !important;
            padding: 15px !important;
            font-weight: 600 !important;
        } [cite: 52]

        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #bae6fd; border-radius: 10px; } [cite: 53, 54, 55]
    </style>

    <script>
        const inputHt = document.getElementById('price_ht');
        const inputTtc = document.getElementById('price_ttc');
        const selectTva = document.getElementById('tva_rate'); [cite: 56]

        const updateFromHt = () => {
            const ht = parseFloat(inputHt.value) || 0;
            const tva = parseFloat(selectTva.value) / 100;
            inputTtc.value = (ht * (1 + tva)).toFixed(2);
        }; [cite: 57]

        const updateFromTtc = () => {
            const ttc = parseFloat(inputTtc.value) || 0;
            const tva = parseFloat(selectTva.value) / 100;
            inputHt.value = (ttc / (1 + tva)).toFixed(2);
        }; [cite: 58, 59]

        inputHt.addEventListener('input', updateFromHt);
        inputTtc.addEventListener('input', updateFromTtc);
        selectTva.addEventListener('change', updateFromHt); [cite: 60]

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('preview-box').classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        } [cite: 61, 62, 63]

        function openCategoryModal() {
            const m = document.getElementById('categoryModal');
            const c = document.getElementById('categoryModalContent');
            m.classList.remove('hidden'); m.classList.add('flex');
            setTimeout(() => { 
                c.classList.remove('scale-95', 'opacity-0'); 
                c.classList.add('scale-100', 'opacity-100'); 
            }, 50);
        } [cite: 64, 65]

        function closeCategoryModal() {
            const m = document.getElementById('categoryModal');
            const c = document.getElementById('categoryModalContent');
            c.classList.remove('scale-100', 'opacity-100'); 
            c.classList.add('scale-95', 'opacity-0');
            setTimeout(() => { m.classList.remove('flex'); m.classList.add('hidden'); }, 400);
        } [cite: 66, 67]

        function toggleEdit(id) {
            const displayDiv = document.getElementById(`display-${id}`);
            const editForm = document.getElementById(`edit-${id}`);
            if (editForm.classList.contains('hidden')) {
                displayDiv.classList.add('hidden');
                editForm.classList.remove('hidden');
                const input = editForm.querySelector('input');
                input.focus();
                input.select();
            } else {
                displayDiv.classList.remove('hidden');
                editForm.classList.add('hidden');
            }
        } [cite: 68, 69, 70]
    </script>
</x-app-layout>