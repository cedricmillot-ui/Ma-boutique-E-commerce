<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function download(Order $order)
    {
        // 1. Sécurité : Vérifier que l'utilisateur est le propriétaire OU un admin
        if (auth()->id() !== $order->user_id && !auth()->user()->is_admin) {
            abort(403, 'Accès non autorisé');
        }

        // 2. Charger les relations
        $order->load(['items.product', 'user']);

        // 3. Préparer les données
        $data = ['order' => $order];

        // 4. Générer le PDF 
        $pdf = Pdf::loadView('invoice', $data); 

        // 5. Retourner le PDF
        return $pdf->download('facture-byfect-'.$order->id.'.pdf');
    }
}