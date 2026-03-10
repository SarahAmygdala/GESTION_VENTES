@php
    $links = [
        [
            'name' => 'Tableau de bord',
            'route' => 'dashboard',
            'icon' =>
                'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
            'roles' => ['admin', 'caissier'],
        ],
        [
            'name' => 'Caisse (POS)',
            'route' => 'pos.index',
            'icon' =>
                'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z',
            'roles' => ['admin', 'caissier'],
        ],
        [
            'name' => 'Produits',
            'route' => 'products.index',
            'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
            'roles' => ['admin'],
        ],
        [
            'name' => 'Catégories',
            'route' => 'categories.index',
            'icon' =>
                'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
            'roles' => ['admin'],
        ],
        [
            'name' => 'Clients',
            'route' => 'clients.index',
            'icon' =>
                'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
            'roles' => ['admin', 'caissier'],
        ],
        [
            'name' => 'Ventes & Historique',
            'route' => 'sales.index',
            'icon' =>
                'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
            'roles' => ['admin', 'caissier'],
        ],
        [
            'name' => 'Stocks & Archive',
            'route' => 'stock.index',
            'icon' =>
                'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4a2 2 0 012-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4',
            'roles' => ['admin'],
        ],
        [
            'name' => 'Rapports',
            'route' => 'reports.index',
            'icon' =>
                'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002 2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
            'roles' => ['admin'],
        ],
        [
            'name' => 'Utilisateurs',
            'route' => 'users.index',
            'icon' =>
                'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
            'roles' => ['admin'],
        ],
        [
            'name' => 'Paramètres',
            'route' => 'settings.index',
            'icon' =>
                'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
            'roles' => ['admin'],
        ],
    ];
@endphp

@foreach ($links as $link)
    @if (in_array(Auth::user()->role, $link['roles']))
        <a href="{{ Route::has($link['route']) ? route($link['route']) : '#' }}"
            class="flex items-center px-4 py-3 text-[14px] font-medium rounded-xl transition-all duration-200 group {{ Request::routeIs($link['route'] . '*') ? 'bg-[#2563EB] text-white shadow-md shadow-blue-100' : 'text-[#6B7280] hover:bg-slate-50 hover:text-[#111827]' }}"
            title="{{ $link['name'] }}">
            <svg class="h-5 w-5 mr-3 flex-shrink-0 transition-transform group-hover:scale-105"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}" />
            </svg>
            <span class="truncate transition-opacity duration-300 whitespace-nowrap" x-show="!sidebarCollapsed"
                x-transition>{{ $link['name'] }}</span>

            @if ($link['route'] == 'products.index' && isset($stats['low_stock_count']) && $stats['low_stock_count'] > 0)
                <span
                    class="ml-auto bg-red-100 text-red-600 text-[10px] px-2 py-0.5 rounded-full font-black border border-red-200"
                    x-show="!sidebarCollapsed" x-transition>{{ $stats['low_stock_count'] }}</span>
            @endif
        </a>
    @endif
@endforeach
