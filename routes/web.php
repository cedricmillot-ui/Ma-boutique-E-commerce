<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController; 
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SendcloudWebhookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;

// --- ACCUEIL ---
Route::get('/', [ProductController::class, 'index']); 
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// --- WEBHOOKS (Publics) ---
Route::post('/stripe/webhook', [CartController::class, 'handleStripeWebhook']);
Route::post('/sendcloud/webhook', [SendcloudWebhookController::class, 'handle']);

/**
 * 🔐 ROUTES SÉCURISÉES (Middleware AUTH)
 */
Route::middleware('auth')->group(function () {
    
    // --- GESTION DU PROFIL ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // --- ADMINISTRATION DES PRODUITS ---
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // 👇 AJOUTE CETTE LIGNE POUR TA FENÊTRE MODAL DE CATÉGORIES :
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');

    // --- LE PANIER (CART) ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/panier/checkout', [CartController::class, 'checkout'])->name('checkout');
    
    // --- COMMANDES UTILISATEUR ---
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}/invoice', [InvoiceController::class, 'download'])->name('invoice.download');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // --- 🚨 ESPACE ADMIN (HARMONISATION DES NOMS) 🚨 ---
    
    // On définit les deux noms pour éviter les erreurs de navigation
    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders');
    Route::get('/admin/orders-list', [OrderController::class, 'adminIndex'])->name('admin.orders.index');

    // Changement de statut
    Route::patch('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    // Facturation (Utilisée dans ton tableau de vente)
    Route::get('/admin/orders/{order}/invoice', [InvoiceController::class, 'download'])->name('admin.orders.invoice');
    
   
    Route::get('/admin/logs', [LogController::class, 'index'])->name('admin.logs');
    // Export CSV
    Route::get('/admin/export-orders', [OrderController::class, 'exportCSV'])->name('admin.export.orders');

    // --- RETOUR STRIPE ---
    Route::get('/commande/succes/{order}', [CartController::class, 'success'])->name('checkout.success');
    Route::get('/commande/annulation', [CartController::class, 'cancel'])->name('checkout.cancel');
});

require __DIR__.'/auth.php';