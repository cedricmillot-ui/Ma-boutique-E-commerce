<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // On lie l'article à la commande (si la commande est supprimée, l'article aussi)
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            // On lie l'article au produit
            $table->foreignId('product_id')->constrained();
            // On enregistre les infos au moment de l'achat
            $table->integer('quantity');
            $table->decimal('price', 10, 2); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};