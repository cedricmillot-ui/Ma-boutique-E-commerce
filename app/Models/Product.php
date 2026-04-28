<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use App\Models\ActivityLog;


class Product extends Model
{
    // 2. On indique au modèle d'utiliser ces fonctionnalités (Traits).
    // HasFactory : Permet de générer des faux produits facilement pour tester le site.
    // SoftDeletes : Modifie le comportement de la suppression (delete).
    use HasFactory, SoftDeletes; 

    /**
     * Les champs autorisés lors de l'enregistrement ou de la modification (Mass Assignment).
     * On retrouve toutes les infos du produit, y compris son image et surtout 
     * sa 'category_id' pour le relier à une catégorie.
     */
    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'stock', 
        'image', 
        'category_id' // Essentiel pour que le lien avec la catégorie s'enregistre !
    ];

    /**
     * Relation : À quelle catégorie appartient ce produit ?
     */
    public function category() 
    {
        // belongsTo : Relation inverse du "hasMany" vu dans le modèle Category.php.
        // On dit à Laravel : "Ce produit précis appartient à une seule Catégorie".
        // Cela vous permet de faire $product->category->name dans vos vues 
        // pour afficher "T-shirt en coton" (nom du produit) -> "Vêtements" (nom de la catégorie).
        return $this->belongsTo(Category::class);
    }
}