<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['name' => 'Ravelo Jean',      'phone' => '034 12 345 67', 'email' => 'ravelo@gmail.com'],
            ['name' => 'Rasoa Marie',      'phone' => '033 98 765 43', 'email' => 'rasoa@gmail.com'],
            ['name' => 'Rakoto Pierre',    'phone' => '032 55 555 55', 'email' => null],
            ['name' => 'Andry Fano',       'phone' => '034 77 888 99', 'email' => 'andry@gmail.com'],
            ['name' => 'Lalaina Bodo',     'phone' => '033 22 333 44', 'email' => null],
        ];

        foreach ($clients as $c) {
            Client::create(array_merge($c, ['active' => true]));
        }
    }
}
