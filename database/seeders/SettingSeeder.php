<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'store_name', 'value' => 'Mi Varotra'],
            ['key' => 'store_contact', 'value' => '+261 34 00 000 00'],
            ['key' => 'store_address', 'value' => 'Antananarivo, Madagascar'],
            ['key' => 'currency', 'value' => 'Ar'],
            ['key' => 'language', 'value' => 'fr'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::firstOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
