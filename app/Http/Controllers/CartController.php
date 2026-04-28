<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; 

class CartController extends Controller
{
    /**
     * Affiche le contenu du panier
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Ajoute un produit au panier
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = (int) $request->input('quantity', 1);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        // --- ON GARDE TA VÉRIF DE STOCK ICI ---
        if ($cart[$id]['quantity'] > $product->stock) {
            $cart[$id]['quantity'] = $product->stock;
            session()->flash('warning', 'La quantité a été ajustée au stock maximum disponible.');
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produit ajouté !');
    }

    /**
     * Retire un produit spécifique du panier
     */
    public function remove($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Produit retiré du panier.');
    }

    /**
     * Vide tout le panier
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Votre panier a été entièrement vidé.');
    }

    /**
     * Initialise le paiement Stripe
     */
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        if (!$cart || count($cart) == 0) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $lineItems = [];
        foreach ($cart as $id => $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => ['name' => $item['name']],
                    'unit_amount' => intval($item['price'] * 100), 
                ],
                'quantity' => $item['quantity'],
            ];
        }

        // Sauvegarde des infos de livraison en session pour les récupérer après le paiement
        session()->put('shipping_info', $request->only(['shipping_address', 'shipping_postal_code', 'shipping_city']));

        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['order' => 'success']), 
            'cancel_url' => route('checkout.cancel'),
        ]);

        return redirect()->away($checkout_session->url);
    }

    /**
     * Traitement après succès du paiement
     */
public function success($status = null)
{
    $cart = session()->get('cart', []);
    $shipping = session()->get('shipping_info');

    if (empty($cart)) {
        return redirect('/')->with('success', 'Commande déjà traitée.');
    }

    $order = null;

    DB::transaction(function () use ($cart, $shipping, &$order) {
        $total = 0;
        foreach ($cart as $item) { 
            $total += $item['price'] * $item['quantity']; 
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $total,
            'status' => 'paid',
            'shipping_address' => $shipping['shipping_address'] ?? 'N/A',
            'shipping_postal_code' => $shipping['shipping_postal_code'] ?? 'N/A',
            'shipping_city' => $shipping['shipping_city'] ?? 'N/A',
            'shipping_country' => 'France',
        ]);

        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
            
            Product::find($id)->decrement('stock', $item['quantity']);
        }
    });

    if ($order) {
        try {
            // --- PRÉPARATION DES ARTICLES POUR SENDCLOUD ---
            $parcelItems = [];
            foreach ($cart as $item) {
                $parcelItems[] = [
                    'description' => $item['name'],
                    'quantity' => $item['quantity'],
                    'weight' => '0.100', // Poids par défaut par article
                    'value' => $item['price'],
                ];
            }

$response = \Illuminate\Support\Facades\Http::withBasicAuth(
    env('SENDCLOUD_KEY'), 
    env('SENDCLOUD_SECRET')
)->post('https://panel.sendcloud.sc/api/v2/parcels', [
    'parcel' => [
        'name'              => Auth::user()->name,
        'email'             => Auth::user()->email, // <--- AJOUTEZ CETTE LIGNE
        'address'           => $order->shipping_address,
        'city'              => $order->shipping_city,
        'postal_code'       => $order->shipping_postal_code,
        'country'           => 'FR',
        'order_number'      => 'CMD-' . $order->id,
        'total_order_value' => $order->total_price,
        'currency'          => 'EUR',
        'weight'            => '0.500',
        'parcel_items'      => $parcelItems,
        'request_label'     => false,
    ]
]);

            if ($response->successful()) {
                $order->update(['sendcloud_id' => $response->json()['parcel']['id']]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Sendcloud : ' . $e->getMessage());
        }
    }

    session()->forget(['cart', 'shipping_info']);
    return redirect('/')->with('success', 'Paiement réussi et synchronisé avec Sendcloud !');
}
}