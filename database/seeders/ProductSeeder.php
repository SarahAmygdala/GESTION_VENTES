<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Alimentation
            ['name' => 'Riz blanc 1kg',         'cat' => 'Alimentation', 'price' => 2500,  'cost' => 1800, 'stock' => 150, 'min' => 20],
            ['name' => 'Pain baguette',          'cat' => 'Alimentation', 'price' => 800,   'cost' => 500,  'stock' => 50,  'min' => 10],
            ['name' => 'Sucre 1kg',              'cat' => 'Alimentation', 'price' => 3000,  'cost' => 2200, 'stock' => 80,  'min' => 15],
            ['name' => 'Huile de palme 1L',      'cat' => 'Alimentation', 'price' => 4500,  'cost' => 3500, 'stock' => 60,  'min' => 10],
            // Boissons
            ['name' => 'Eau minérale 1.5L',     'cat' => 'Boissons',     'price' => 1500,  'cost' => 900,  'stock' => 200, 'min' => 30],
            ['name' => 'Coca-Cola 33cl',         'cat' => 'Boissons',     'price' => 1800,  'cost' => 1200, 'stock' => 120, 'min' => 20],
            ['name' => 'Jus de fruit 1L',        'cat' => 'Boissons',     'price' => 3500,  'cost' => 2500, 'stock' => 45,  'min' => 10],
            // Hygiène
            ['name' => 'Savon de bain',          'cat' => 'Hygiène',      'price' => 1200,  'cost' => 800,  'stock' => 80,  'min' => 15],
            ['name' => 'Shampooing 250ml',       'cat' => 'Hygiène',      'price' => 4000,  'cost' => 2800, 'stock' => 35,  'min' => 8],
            ['name' => 'Dentifrice 75ml',        'cat' => 'Hygiène',      'price' => 2500,  'cost' => 1700, 'stock' => 50,  'min' => 10],
            // Épicerie
            ['name' => 'Café soluble 200g',      'cat' => 'Épicerie',     'price' => 8500,  'cost' => 6000, 'stock' => 30,  'min' => 8],
            ['name' => 'Sel fin 500g',           'cat' => 'Épicerie',     'price' => 800,   'cost' => 500,  'stock' => 100, 'min' => 20],
            ['name' => 'Farine de blé 1kg',      'cat' => 'Épicerie',     'price' => 3200,  'cost' => 2400, 'stock' => 70,  'min' => 15],
            ['name' => 'Lait en poudre 400g',    'cat' => 'Épicerie',     'price' => 12000, 'cost' => 9000, 'stock' => 25,  'min' => 6],
            // Électronique
            ['name' => 'Câble USB-C',            'cat' => 'Électronique', 'price' => 5000,  'cost' => 2500, 'stock' => 40,  'min' => 10],
            ['name' => 'Batterie externe 5000mAh', 'cat' => 'Électronique', 'price' => 25000, 'cost' => 18000, 'stock' => 15,  'min' => 5],
            // Vêtements
            ['name' => 'T-shirt homme',          'cat' => 'Vêtements',    'price' => 15000, 'cost' => 8000, 'stock' => 30,  'min' => 5],
            ['name' => 'Chaussettes (lot 3)',    'cat' => 'Vêtements',    'price' => 8000,  'cost' => 4500, 'stock' => 45,  'min' => 8],
            ['name' => 'Ceinture cuir',          'cat' => 'Vêtements',    'price' => 12000, 'cost' => 7000, 'stock' => 20,  'min' => 5],
            ['name' => 'Casquette',              'cat' => 'Vêtements',    'price' => 9000,  'cost' => 5000, 'stock' => 3,   'min' => 5], // stock faible
        ];

        foreach ($products as $p) {
            $cat = Category::where('name', $p['cat'])->first();
            Product::create([
                'category_id' => $cat->id,
                'name'        => $p['name'],
                'slug'        => Str::slug($p['name']) . '-' . Str::random(5),
                'price'       => $p['price'],
                'cost'        => $p['cost'],
                'stock'       => $p['stock'],
                'min_stock'   => $p['min'],
                'barcode'     => 'MV' . str_pad(rand(1, 999999), 8, '0', STR_PAD_LEFT),
                'active'      => true,
            ]);
        }
    }
}
