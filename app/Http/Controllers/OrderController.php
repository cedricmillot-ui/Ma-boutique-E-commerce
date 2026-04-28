<?php

namespace App\Http\Controllers;

use App\Models\Order; 
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http; 

class OrderController extends Controller
{
    /**
     * Affiche TOUTES les commandes (Vue Admin).
     */
    public function adminIndex(Request $request)
    {
        $query = Order::with(['user', 'items.product'])->latest();

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('id', 'like', "%{$search}%");
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Affiche uniquement les commandes du client (Vue Client).
     */
    public function index()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Met à jour le statut d'une commande.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:paid,shipped,delivered,cancelled'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        DB::transaction(function () use ($order, $oldStatus, $newStatus) {
            if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
            if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }
            $order->update(['status' => $newStatus]);
        });

        return back()->with('success', 'Statut mis à jour avec succès !');
    }

    /**
     * Exporte le bilan comptable CSV en Français.
     */
    public function exportCSV(Request $request)
    {
        $query = Order::with(['user', 'items'])->orderBy('created_at', 'desc');

        if ($request->period === 'current_month') {
            $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($request->period === 'last_month') {
            $query->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
        } elseif ($request->period === 'year') {
            $query->whereYear('created_at', now()->year);
        }

        $orders = $query->get();
        $fileName = "bilan_comptable_" . date('d-m-Y') . ".csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8 pour Excel
            
            $separator = ';';

            // En-têtes
            fputcsv($file, ['RÉFÉRENCE', 'DATE', 'CLIENT', 'EMAIL', 'STATUT', 'TOTAL TTC'], $separator);

            foreach ($orders as $order) {
                // Traduction des statuts
                $statutFr = match($order->status) {
                    'paid'      => 'Payée',
                    'shipped'   => 'Expédiée',
                    'delivered' => 'Livrée',
                    'cancelled' => 'Annulée',
                    default     => $order->status,
                };

                // LA MÉTHODE QUI FONCTIONNE :
                $dateAffichage = $order->created_at ? $order->created_at->format('d/m/Y H:i') : 'N/A';

                fputcsv($file, [
                    'CMD-' . $order->id,
                    $dateAffichage,
                    $order->user ? $order->user->name : 'Inconnu',
                    $order->user ? $order->user->email : 'N/A',
                    $statutFr,
                    number_format($order->total_price, 2, ',', ' ') . ' €'
                ], $separator);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
public function cancel(Order $order)
{
    // 1. Vérifier si la commande n'est pas déjà annulée pour éviter de doubler le stock
    if ($order->status === 'cancelled') {
        return redirect()->back()->with('error', 'Cette commande est déjà annulée.');
    }

    // 2. Remonter le stock pour chaque produit de la commande
    foreach ($order->items as $item) {
        $product = $item->product;
        if ($product) {
            $product->increment('stock', $item->quantity);
        }
    }

    // 3. Mettre à jour le statut dans la base de données
    $order->update(['status' => 'cancelled']);

    // 4. Annulation sur Sendcloud (votre code existant)
    if ($order->sendcloud_id) {
        try {
            \Illuminate\Support\Facades\Http::withBasicAuth(
                env('SENDCLOUD_KEY'), 
                env('SENDCLOUD_SECRET')
            )->post("https://panel.sendcloud.sc/api/v2/parcels/{$order->sendcloud_id}/cancel");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erreur Sendcloud Cancel: " . $e->getMessage());
        }
    }

    return redirect()->back()->with('success', 'Commande annulée et stock mis à jour.');
}
}
