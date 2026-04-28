<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Facture Byfect #{{ $order->id }}</title>
    <style>
        @page { margin: 40px 50px; }
        
        body { 
            font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif; 
            font-size: 11px; 
            color: #334155;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        /* Thème Byfect */
        .text-sky { color: #0ea5e9; }
        .text-dark { color: #0f172a; }
        .text-muted { color: #64748b; }
        .font-bold { font-weight: bold; }

        /* Structure générale */
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; }

        /* Header */
        .header-table { border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; margin-bottom: 30px; }
        .brand-logo { font-size: 32px; font-weight: 900; letter-spacing: -1px; color: #0ea5e9; }
        .brand-logo span { color: #0f172a; }
        .invoice-title { font-size: 28px; font-weight: 300; letter-spacing: 2px; color: #0f172a; text-transform: uppercase; margin: 0 0 5px 0; }

        /* Infos Adresses */
        .address-table { margin-bottom: 40px; }
        .address-col { width: 33.33%; }
        .section-title { 
            font-size: 9px; 
            font-weight: bold; 
            text-transform: uppercase; 
            color: #94a3b8; 
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: block;
        }
        .info-box { background: #f8fafc; padding: 15px; border-radius: 4px; }

        /* Table des articles */
        .items-table { margin-bottom: 30px; }
        .items-table th { 
            background-color: #f1f5f9; 
            color: #475569; 
            padding: 10px 12px; 
            text-align: left;
            text-transform: uppercase;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #cbd5e1;
        }
        .items-table td { 
            padding: 12px; 
            border-bottom: 1px solid #e2e8f0; 
        }
        .items-table th.text-right, .items-table td.text-right { text-align: right; }
        .items-table th.text-center, .items-table td.text-center { text-align: center; }

        /* Bloc Totaux */
        .totals-wrapper { width: 100%; margin-bottom: 40px; }
        .totals-table { width: 280px; float: right; }
        .totals-table td { padding: 8px 12px; border-bottom: 1px solid #e2e8f0; }
        .total-row-highlight { background-color: #f8fafc; }
        .total-final { 
            background-color: #0ea5e9; 
            color: #ffffff; 
            font-size: 14px; 
            font-weight: bold; 
        }
        .total-final td { border: none; padding: 12px; }

        /* Clearfix pour le float */
        .clearfix::after { content: ""; clear: both; display: table; }

        /* Footer */
        .footer { 
            position: fixed; 
            bottom: 0; 
            left: 0;
            width: 100%; 
            text-align: center; 
            font-size: 8px; 
            color: #94a3b8; 
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
            line-height: 1.6;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="brand-logo" style="width: 50%;">
                BY<span>FECT</span>
            </td>
            <td style="width: 50%; text-align: right;">
                <h1 class="invoice-title">Facture</h1>
                <p class="text-muted" style="margin: 0; font-size: 12px;">
                    <strong>Référence :</strong> #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}<br>
                    <strong>Date de facturation :</strong> {{ $order->created_at->format('d/m/Y') }}<br>
                    <strong>Date d'échéance :</strong> {{ $order->created_at->addDays(30)->format('d/m/Y') }}
                </p>
            </td>
        </tr>
    </table>

    <table class="address-table">
        <tr>
            <td class="address-col" style="padding-right: 20px;">
                <span class="section-title">Émetteur</span>
                <div class="font-bold text-dark" style="font-size: 12px; margin-bottom: 4px;">BYFECT SAS</div>
                123 Rue de l'E-commerce<br>
                75000 Paris, France<br>
                TVA : FR01234567890<br>
                contact@byfect.com
            </td>
            
            <td class="address-col" style="padding-right: 20px;">
                <span class="section-title">Facturé à</span>
                <div class="info-box">
                    <div class="font-bold text-dark" style="font-size: 12px; margin-bottom: 4px;">{{ $order->user->name }}</div>
                    {{ $order->user->address ?? 'Adresse non renseignée' }}<br>
                    {{ $order->user->zip_code ?? '' }} {{ $order->user->city ?? '' }}<br>
                    <span class="text-sky">{{ $order->user->email }}</span>
                </div>
            </td>

            <td class="address-col">
                <span class="section-title">Adresse de livraison</span>
                <div class="info-box">
                    <div class="font-bold text-dark" style="font-size: 12px; margin-bottom: 4px;">{{ $order->user->name }}</div>
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_postal_code }} {{ $order->shipping_city }}<br>
                    {{ strtoupper($order->shipping_country) }}
                </div>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 35%;">Description</th>
                <th class="text-center" style="width: 15%;">P.U HT</th>
                <th class="text-center" style="width: 10%;">Qté</th>
                <th class="text-center" style="width: 10%;">TVA</th>
                <th class="text-right" style="width: 15%;">Total HT</th>
                <th class="text-right" style="width: 15%;">Total TTC</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    <strong class="text-dark">{{ $item->product->name ?? 'Produit #' . $item->product_id }}</strong><br>
                    <span style="font-size: 9px; color: #94a3b8;">Réf. article : {{ $item->product->id ?? 'N/A' }}</span>
                </td>
                <td class="text-center">{{ number_format($item->price / 1.2, 2, ',', ' ') }} €</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-center">20%</td>
                <td class="text-right">{{ number_format(($item->price / 1.2) * $item->quantity, 2, ',', ' ') }} €</td>
                <td class="text-right font-bold text-dark">{{ number_format($item->price * $item->quantity, 2, ',', ' ') }} €</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="clearfix totals-wrapper">
        <table class="totals-table">
            <tr>
                <td class="text-muted">Total HT</td>
                <td class="text-right">{{ number_format($order->total_price / 1.2, 2, ',', ' ') }} €</td>
            </tr>
            <tr>
                <td class="text-muted">Total TVA (20%)</td>
                <td class="text-right">{{ number_format($order->total_price - ($order->total_price / 1.2), 2, ',', ' ') }} €</td>
            </tr>
            <tr class="total-final">
                <td>TOTAL NET À PAYER</td>
                <td class="text-right">{{ number_format($order->total_price, 2, ',', ' ') }} €</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <strong>BYFECT SAS</strong> au capital de 10 000 € — RCS Paris B 123 456 789 — N° TVA Intracommunautaire : FR 01 234 567 890<br>
        Siège social : 123 Rue de l'E-commerce, 75000 Paris — Téléphone : 01 23 45 67 89 — Site web : www.byfect.com<br>
        En cas de retard de paiement, une pénalité égale à 3 fois le taux d'intérêt légal sera appliquée, ainsi qu'une indemnité forfaitaire pour frais de recouvrement de 40 €.<br>
        <strong class="text-dark" style="font-size: 10px; display: block; margin-top: 8px;">Merci de votre confiance !</strong>
    </div>

</body>
</html>
