<?php

namespace App\Http\Controllers;

// Importation des modèles nécessaires
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Affiche la liste des produits (Accueil du site) avec gestion des filtres.
     */
    public function index(Request $request)
    {
        // On récupère toutes les catégories pour pouvoir les afficher dans un menu (ex: barre latérale)
        $categories = Category::all();
        
        // On initialise une requête sur les produits. 
        // Product::query() prépare la recherche mais ne l'exécute pas encore.
        $query = Product::query();

        // FILTRE 1 : Par catégorie (si on clique sur un lien de catégorie)
        if ($request->filled('category')) {
            // whereHas() permet de filtrer les produits en fonction de leur relation 'category'.
            // Ici, on cherche les produits dont la catégorie a le 'slug' (l'URL) demandé.
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // FILTRE 2 : Par barre de recherche (si on tape un nom)
        if ($request->filled('search')) {
            // On cherche si le nom du produit contient (LIKE) le mot tapé par l'utilisateur.
            // Les '%' avant et après signifient que le mot peut être n'importe où dans le titre.
            $query->where('name', 'LIKE', "%{$request->search}%");
        }

        // Une fois les filtres appliqués (ou non), on exécute la requête avec get()
        // 'latest()' trie les produits du plus récent au plus ancien.
        $products = $query->latest()->get();

        // On renvoie la vue d'accueil ('welcome.blade.php') avec les produits et les catégories.
        return view('welcome', compact('products', 'categories'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau produit (Espace Admin).
     */
    public function create()
    {
        // On a besoin des catégories pour remplir la liste déroulante "<select>" du formulaire.
        $categories = Category::all();
        
        // On renvoie la vue du formulaire de création.
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Enregistre un NOUVEAU produit dans la base de données.
     * Cette méthode est appelée quand on valide le formulaire du create().
     */
public function store(Request $request) 
{
    // FORCE l'affichage des erreurs si la validation échoue
    // (À retirer une fois le problème trouvé)
    try {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,heic,heif|max:10240',        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Cela va afficher précisément quel champ pose problème
        dd($e->errors());
    }

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $validated['image'] = $path;
    }

    // On vérifie juste avant la création
    // dd($validated); 

    Product::create($validated);

    return redirect('/')->with('success', 'Produit ajouté avec succès !');
}

    /**
     * Affiche le formulaire de modification d'un produit existant (Espace Admin).
     */
    public function edit(Product $product) 
    {
        // Grâce au Route Model Binding (Product $product), Laravel trouve le produit tout seul via son ID.
        // On récupère aussi les catégories pour la liste déroulante.
        $categories = Category::all();
        
        // On renvoie le formulaire d'édition, pré-rempli avec les infos du produit actuel.
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Met à jour un produit existant en base de données.
     * Cette méthode est appelée quand on valide le formulaire du edit().
     */
    public function update(Request $request, Product $product) 
    {
        // Étape 1 : Validation (Presque identique à la création).
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:10000',
        ]);

        // Étape 2 : Gestion de la nouvelle image (S'il y en a une).
        if ($request->hasFile('image')) {
            // On stocke la nouvelle image
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
            
            // 💡 Note d'amélioration possible : Il serait bien de supprimer l'ANCIENNE image 
            // du dossier de stockage ici pour ne pas encombrer votre serveur ! 
            // (ex: Storage::disk('public')->delete($product->image); )
        }

        // Étape 3 : Mise à jour en base de données.
        $product->update($validated);
        
        return redirect('/')->with('success', 'Produit mis à jour avec succès !');
    }

    /**
     * Supprime définitivement un produit de la base de données.
     */
    public function destroy(Product $product) 
    {
        // On supprime le produit
        // 💡 Note d'amélioration : Comme pour l'update, pensez à supprimer l'image du serveur
        // avant d'exécuter la suppression du produit en base.
        $product->delete();
        
        return redirect('/')->with('success', 'Produit supprimé !');
    }

    /**
     * Affiche la page de détail d'un produit spécifique (Page Produit).
     */
    public function show(Product $product)
    {
        // En plus du produit demandé, on récupère des suggestions d'articles similaires.
        // On cherche des produits qui ont la même catégorie...
        $relatedProducts = Product::where('category_id', $product->category_id)
                                // ... mais on EXCLUT le produit qu'on est en train de regarder (!=)
                                ->where('id', '!=', $product->id)
                                // On en garde seulement 4 pour l'affichage
                                ->take(4)
                                // On exécute la requête
                                ->get();

        // On renvoie la vue avec le produit et ses suggestions.
        // ⚠️ Attention au chemin : vous pointez vers 'admin.products.show',
        // Est-ce une page réservée à l'admin ou est-ce la page produit publique pour les clients ?
        return view('admin.products.show', compact('product', 'relatedProducts'));
    }
}