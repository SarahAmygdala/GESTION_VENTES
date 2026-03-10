<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Product::with('category')->get();
    }

    public function headings(): array
    {
        return [
            'Désignation',
            'Catégorie',
            'Code-barres',
            'Prix d\'achat',
            'Prix de vente',
            'Stock Actuel',
            'Stock Minimum',
            'Statut',
        ];
    }

    public function map($product): array
    {
        return [
            $product->name,
            $product->category->name,
            $product->barcode,
            $product->cost,
            $product->price,
            $product->stock,
            $product->min_stock,
            $product->active ? 'Actif' : 'Inactif',
        ];
    }
}
