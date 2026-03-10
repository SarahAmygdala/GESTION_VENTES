<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Sale::with(['user', 'client'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'N° Vente',
            'Date',
            'Client',
            'Caissier',
            'Sous-total',
            'Remise (%)',
            'Remise (Ar)',
            'Total (Ar)',
            'Paiement',
        ];
    }

    public function map($sale): array
    {
        return [
            $sale->sale_number,
            $sale->created_at->format('d/m/Y H:i'),
            $sale->client->name ?? 'Client Occasionnel',
            $sale->user->name,
            $sale->subtotal,
            $sale->discount,
            $sale->discount_amount,
            $sale->total,
            $sale->payment_method,
        ];
    }
}
