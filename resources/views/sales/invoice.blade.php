<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Facture {{ $sale->sale_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 11pt;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3B82F6;
            padding-bottom: 20px;
        }

        .app-name {
            font-size: 24pt;
            font-weight: bold;
            color: #3B82F6;
            margin: 0;
        }

        .label {
            font-size: 9pt;
            color: #777;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .info-table td {
            vertical-align: top;
            width: 50%;
        }

        .sale-info {
            text-align: right;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table th {
            background: #F9FAFB;
            border-bottom: 1px solid #E5E7EB;
            padding: 12px 8px;
            text-align: left;
            font-size: 9pt;
        }

        .items-table td {
            padding: 12px 8px;
            border-bottom: 1px solid #F3F4F6;
        }

        .totals-table {
            width: 40%;
            margin-left: 60%;
        }

        .totals-table td {
            padding: 8px 0;
        }

        .total-row td {
            border-top: 1px solid #3B82F6;
            padding-top: 10px;
            font-weight: bold;
            font-size: 14pt;
            color: #3B82F6;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #999;
            border-top: 1px solid #EEE;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 class="app-name">{{ strtoupper(setting('store_name', 'MI VAROTRA')) }}</h1>
        <div style="font-size: 9pt; color: #666; margin-top: 5px;">Logiciel de Gestion de vente POS</div>
        <div style="font-size: 9pt; color: #555; margin-top: 8px;">
            {{ setting('store_address') }}<br>
            {{ setting('store_contact') }}
        </div>
    </div>

    <table class="info-table">
        <tr>
            <td>
                <div class="label">Facturé à :</div>
                <div style="font-size: 13pt; font-weight: bold;">{{ $sale->client->name ?? 'Client Occasionnel' }}</div>
                @if ($sale->client)
                    <div style="margin-top: 5px; color: #666;">
                        {{ $sale->client->phone }}<br>
                        {{ $sale->client->address }}
                    </div>
                @endif
            </td>
            <td class="sale-info">
                <div class="label">Date de vente :</div>
                <div style="font-weight: bold;">{{ $sale->created_at->format('d/m/Y H:i') }}</div>
                <div class="label" style="margin-top: 15px;">Numéro de facture :</div>
                <div style="font-weight: bold; font-size: 13pt; color: #3B82F6;">#{{ $sale->sale_number }}</div>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>Désignation</th>
                <th style="text-align: center;">Quantité</th>
                <th style="text-align: right;">Prix Unitaire</th>
                <th style="text-align: right;">Sous-total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->items as $item)
                <tr>
                    <td style="font-weight: bold;">{{ $item->product_name }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">{{ number_format($item->unit_price, 0, '.', ' ') }}
                        {{ setting('currency') }}</td>
                    <td style="text-align: right; font-weight: bold;">{{ number_format($item->subtotal, 0, '.', ' ') }}
                        {{ setting('currency') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td style="color: #666;">Sous-total :</td>
            <td style="text-align: right; font-weight: bold;">{{ number_format($sale->subtotal, 0, '.', ' ') }}
                {{ setting('currency') }}</td>
        </tr>
        @if ($sale->discount > 0)
            <tr>
                <td style="color: #EF4444;">Remise ({{ $sale->discount }}%) :</td>
                <td style="text-align: right; font-weight: bold; color: #EF4444;">-
                    {{ number_format($sale->discount_amount, 0, '.', ' ') }} {{ setting('currency') }}</td>
            </tr>
        @endif
        <tr class="total-row">
            <td>TOTAL :</td>
            <td style="text-align: right;">{{ number_format($sale->total, 0, '.', ' ') }} {{ setting('currency') }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 8pt; color: #666; padding-top: 20px; text-align: right;">
                Mode de paiement : <strong>{{ strtoupper($sale->payment_method) }}</strong><br>
                Montant reçu : {{ number_format($sale->amount_paid, 0, '.', ' ') }} {{ setting('currency') }}<br>
                Monnaie rendue : {{ number_format($sale->change_amount, 0, '.', ' ') }} {{ setting('currency') }}
            </td>
        </tr>
    </table>

    <div class="footer">
        Merci pour votre achat chez {{ setting('store_name', 'Mi Varotra') }} !<br>
        Généré le {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>

</html>
