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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');          // Nom du produit
        $table->text('description');     // Description détaillée
        $table->decimal('price', 10, 2); // Prix (ex: 99.99)
        $table->integer('stock');        // Quantité en stock
        $table->string('image')->nullable(); // Lien vers l'image du produit
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
