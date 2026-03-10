<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {
    /**
     * Obtenir la valeur d'un paramètre
     * 
     * @param string $key La clé du paramètre
     * @param mixed $default Valeur par défaut si non trouvé
     * @return mixed
     */
    function setting($key, $default = null)
    {
        // On récupère tous les paramètres et on les met en cache pour éviter les requêtes répétées
        $settings = Cache::rememberForever('app_settings', function () {
            return Setting::pluck('value', 'key')->toArray();
        });

        return array_key_exists($key, $settings) ? $settings[$key] : $default;
    }
}
