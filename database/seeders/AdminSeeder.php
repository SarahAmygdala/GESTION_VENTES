<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Administrateur',
            'email'    => 'admin@mivarotra.mg',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'active'   => true,
        ]);

        User::create([
            'name'     => 'Caissier Démo',
            'email'    => 'caissier@mivarotra.mg',
            'password' => Hash::make('password'),
            'role'     => 'caissier',
            'active'   => true,
        ]);
    }
}
