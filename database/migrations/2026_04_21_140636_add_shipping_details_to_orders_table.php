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
    Schema::table('orders', function (Blueprint $table) {
        $table->string('shipping_address')->nullable();
        $table->string('shipping_city')->nullable();
        $table->string('shipping_postal_code')->nullable();
        $table->string('shipping_country')->default('FR');
        $table->string('sendcloud_id')->nullable(); // Pour stocker l'ID de suivi plus tard
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
