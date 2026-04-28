<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * $fillable est une protection très importante de Laravel appelée 
     * "Mass Assignment Protection" (Protection contre l'assignation de masse).
     * * Par défaut, Laravel interdit de remplir une ligne de base de données 
     * d'un seul coup avec un tableau de données (comme avec Category::create($request->all())).
     * En définissant ce tableau $fillable, vous dites explicitement à Laravel :
     * "C'est bon, j'autorise la création ou la modification directe des colonnes 'name' et 'slug'."
     * Toutes les autres colonnes (ex: un champ 'is_admin' qui existerait par erreur) seront ignorées par sécurité !
     */
    protected $fillable = ['name', 'slug'];

    /**
     * Définit la relation entre une Catégorie et des Produits.
     * C'est ce qu'on appelle une relation "One-To-Many" (Un à Plusieurs).
     */
    public function products() {
        // Cette ligne se lit littéralement : "Cette catégorie (this) possède plusieurs (hasMany) Produits".
        // Grâce à cette petite méthode, vous pouvez maintenant faire des choses magiques dans vos contrôleurs 
        // comme : $category->products (qui vous renverra automatiquement tous les produits de cette catégorie !)
        return $this->hasMany(Product::class);
    }
}