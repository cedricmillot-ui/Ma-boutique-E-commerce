<x-app-layout>
    <style>
        body { font-family: 'DM Sans', sans-serif; background-color: #f8fafc; }
        .font-inter { font-family: 'Inter', sans-serif; }
        .form-input-premium {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.2s;
            background: #ffffff;
        }
        .form-input-premium:focus {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
            outline: none;
        }
        .card-premium {
            background: white;
            border-radius: 24px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }
    </style>

    <div class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 text-center">
                <span class="text-sky-600 font-bold tracking-widest text-xs uppercase mb-2 block">Administration</span>
                <h2 class="font-inter text-4xl font-extrabold text-slate-900 tracking-tight">
                    Modifier le <span class="text-sky-500">Produit</span>
                </h2>
                <p class="text-slate-500 mt-2 italic">"{{ $product->name }}"</p>
            </div>

            <div class="card-premium p-8 sm:p-10">
                
                @if ($errors->any())
                    <div class="mb-8 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            <span class="font-bold">Veuillez corriger les points suivants :</span>
                        </div>
                        <ul class="list-disc list-inside text-sm opacity-90">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT') 
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 ml-1">Nom du produit</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                                   class="w-full form-input-premium" placeholder="Ex: Tee-shirt Oversize" required>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 ml-1">Catégorie</label>
                            <select name="category_id" class="w-full form-input-premium" required>
                                <option value="" disabled>Sélectionner une catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 ml-1">Description détaillée</label>
                        <textarea name="description" rows="4" class="w-full form-input-premium" 
                                  placeholder="Décrivez les spécificités du produit..." required>{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 ml-1">Prix (€)</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" 
                                       class="w-full form-input-premium" required>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 ml-1">Unités en stock</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" 
                                   class="w-full form-input-premium" required>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 ml-1">Nouvelle image</label>
                            <input type="file" name="image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100" accept="image/*">
                        </div>
                    </div>

                    @if($product->image)
                        <div class="p-4 bg-slate-50 rounded-2xl flex items-center space-x-4 border border-dashed border-slate-200">
                            <img src="{{ asset('storage/' . $product->image) }}" class="h-20 w-20 object-cover rounded-xl shadow-sm border-2 border-white">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Image actuelle</p>
                                <p class="text-sm text-slate-500 italic">Sera conservée si aucun fichier n'est choisi</p>
                            </div>
                        </div>
                    @endif

                    <div class="pt-8 flex flex-col sm:flex-row gap-4">
                        <button type="submit" class="flex-1 bg-slate-900 text-white font-inter font-bold px-8 py-4 rounded-2xl hover:bg-sky-600 shadow-lg shadow-slate-200 transition-all transform hover:-translate-y-1">
                            Enregistrer les modifications
                        </button>
                        
                        <a href="{{ url('/') }}" class="sm:w-1/3 flex items-center justify-center font-inter font-bold text-slate-500 border-2 border-slate-100 px-8 py-4 rounded-2xl hover:bg-slate-50 transition-all">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
