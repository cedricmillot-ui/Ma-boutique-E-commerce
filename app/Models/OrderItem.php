<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
     * Toujours notre sécurité $fillable.
     * On autorise l'insertion rapide (mass assignment) pour relier 
     * la commande (order_id), le produit (product_id), et figer 
     * la quantité et le prix unitaire au moment de l'achat.
     */
    protected $fillable = [
        'order_id', 
        'product_id', 
        'quantity', 
        'price'
    ];

    /**
     * Relation N°1 : À quel produit correspond cette ligne ?
     */
    public function product()
    {
        // belongsTo : Cette ligne de commande appartient à un Produit.
        // 🚨 LE COUP DE GÉNIE ICI : withTrashed() !
        // Dans une boutique, si vous arrêtez de vendre un produit et le supprimez (Soft Delete), 
        // il ne faut SURTOUT PAS qu'il disparaisse des anciennes factures de vos clients ou 
        // de votre historique de ventes ! 
        // withTrashed() force Laravel à retrouver ce produit dans la base de données 
        // MÊME s'il a été mis à la corbeille. C'est brillant.
        return $this->belongsTo(Product::class)->withTrashed();
    }

    /**
     * Relation N°2 : À quelle commande globale appartient cette ligne ?
     */
    public function order()
    {
        // belongsTo : Cette ligne fait partie d'une Commande (Order) précise.
        // C'est exactement la relation INVERSE du "hasMany" que nous avons vu 
        // juste avant dans le modèle Order.php !
        return $this->belongsTo(Order::class);
    }
}