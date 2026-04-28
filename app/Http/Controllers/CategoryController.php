<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // 👈 INDISPENSABLE POUR GÉNÉRER LE SLUG

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // On crée la catégorie avec son nom ET son slug généré automatiquement
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // 👈 LE VOILÀ !
        ]);

        return back()->with('success', 'Catégorie ajoutée avec succès ! ✨');
    }
    public function destroy(Category $category)
{
    // Optionnel : vérifier si la catégorie possède des produits
    if ($category->products()->count() > 0) {
        return back()->with('error', 'Cette catégorie contient des produits et ne peut pas être supprimée.');
    }

    $category->delete();

    return back()->with('success', 'Catégorie supprimée avec succès.');
}
public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $category->update([
        'name' => $request->name,
    ]);

    return back()->with('success', 'Catégorie renommée avec succès !');
}
}
