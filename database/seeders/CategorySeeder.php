<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Alimentation',    'color' => '#10B981', 'description' => 'Produits alimentaires'],
            ['name' => 'Boissons',        'color' => '#3B82F6', 'description' => 'Boissons et rafraîchissements'],
            ['name' => 'Hygiène',         'color' => '#8B5CF6', 'description' => 'Produits hygiène et beauté'],
            ['name' => 'Épicerie',        'color' => '#F59E0B', 'description' => 'Épicerie générale'],
            ['name' => 'Électronique',    'color' => '#EF4444', 'description' => 'Accessoires électroniques'],
            ['name' => 'Vêtements',       'color' => '#EC4899', 'description' => 'Vêtements et mode'],
        ];

        foreach ($categories as $cat) {
            $cat['slug'] = Str::slug($cat['name']);
            Category::create($cat);
        }
    }
}
