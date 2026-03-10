@extends('layouts.app')

@section('page-title', 'Gestion des Produits')

@section('content')
    <div class="space-y-6" x-data="{ show: false, filtersOpen: false }" x-init="setTimeout(() => show = true, 50)">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4" x-show="show"
            x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center space-x-4">
                <div
                    class="h-12 w-12 md:h-14 md:w-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shadow-sm">
                    <svg class="h-6 w-6 md:h-8 md:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg md:text-2xl font-black text-slate-900 tracking-tight">Gestion des Produits</h2>
                    <p class="text-[11px] md:text-sm text-slate-500 font-medium">
                        {{ $products->total() }} articles enregistrés
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('products.export') }}"
                    class="hidden md:flex h-11 md:h-12 px-4 md:px-5 bg-white text-slate-700 border border-slate-200 rounded-xl font-bold shadow-sm hover:bg-slate-50 transition-all flex items-center text-sm active:scale-95">
                    <svg class="w-5 h-5 md:mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="hidden md:inline">Exporter</span>
                </a>
                <a href="{{ route('products.create') }}"
                    class="hidden md:flex h-12 px-6 bg-blue-600 text-white rounded-xl font-black shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all items-center text-sm uppercase tracking-wider active:scale-95">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouveau
                </a>
            </div>
        </div>

        <!-- Desktop Filters (Large Screen) -->
        <div class="hidden md:block mb-4">
            <form action="{{ route('products.index') }}" method="GET"
                class="space-y-4 md:space-y-0 md:grid md:grid-cols-12 md:gap-4 items-end">
                <div class="md:col-span-6">
                    <label
                        class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Rechercher</label>
                    <div class="relative group">
                        <span
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            x-on:input.debounce.500ms="$el.form.submit()" placeholder="Nom du produit, code-barres..."
                            class="h-12 w-full pl-11 pr-4 bg-slate-50 border-none rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500/10 focus:bg-white transition-all placeholder:text-slate-400">
                    </div>
                </div>
                <div class="md:col-span-3">
                    <label
                        class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Catégorie</label>
                    <div class="relative">
                        <select name="category_id" x-on:change="$el.form.submit()"
                            class="h-12 w-full pl-4 pr-10 bg-slate-50 bg-none border-none rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500/10 focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">Toutes les catégories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="md:col-span-3 flex items-center space-x-2">
                    <a href="{{ route('products.index') }}"
                        class="h-12 w-12 bg-slate-100 text-slate-500 rounded-2xl font-bold text-sm hover:bg-slate-200 transition-all flex items-center justify-center active:scale-95 flex-shrink-0"
                        title="Réinitialiser">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </a>
                </div>
            </form>
        </div>

        <!-- Mobile Filter Bar -->
        <div class="md:hidden flex items-center space-x-2 mb-4">
            <div class="flex-1 relative">
                <form action="{{ route('products.index') }}" method="GET">
                    <input type="text" name="search" value="{{ request('search') }}"
                        x-on:input.debounce.500ms="$el.form.submit()" placeholder="Rechercher un produit..."
                        class="h-11 w-full pl-10 pr-4 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-2 focus:ring-blue-500/10 transition-all">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    @if (request('category_id'))
                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                    @endif
                </form>
            </div>
            <button @click="filtersOpen = true"
                class="h-11 w-11 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-slate-600 shadow-sm relative">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                @if (request('category_id'))
                    <span class="absolute -top-1 -right-1 h-3 w-3 bg-blue-600 rounded-full border-2 border-white"></span>
                @endif
            </button>
        </div>

        <!-- Mobile Filter Drawer -->
        <div x-show="filtersOpen" class="fixed inset-0 z-[150] md:hidden" x-cloak>
            <div @click="filtersOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
                class="absolute bottom-0 inset-x-0 bg-white rounded-t-[32px] shadow-2xl flex flex-col p-6 space-y-6">
                <div class="h-1.5 w-12 bg-slate-200 rounded-full mx-auto -mt-2 mb-2 flex-shrink-0"></div>

                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-black text-slate-900">Filtrer par catégorie</h3>
                    <button @click="filtersOpen = false" class="text-slate-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('products.index') }}" method="GET" id="mobileProductFilter">
                    @if (request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <div class="grid grid-cols-2 gap-3">
                        <button type="submit" name="category_id" value=""
                            class="p-3 rounded-2xl border text-sm font-bold transition-all {{ !request('category_id') ? 'bg-blue-600 border-blue-600 text-white' : 'bg-slate-50 border-slate-100 text-slate-600' }}">
                            Toutes
                        </button>
                        @foreach ($categories as $category)
                            <button type="submit" name="category_id" value="{{ $category->id }}"
                                class="p-3 rounded-2xl border text-sm font-bold transition-all {{ request('category_id') == $category->id ? 'bg-blue-600 border-blue-600 text-white' : 'bg-slate-50 border-slate-100 text-slate-600' }}"
                                style="{{ request('category_id') == $category->id ? '' : 'border-left: 4px solid ' . $category->color }}">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </form>

                <div class="pt-4 border-t border-slate-50">
                    <a href="{{ route('products.index') }}"
                        class="w-full h-12 bg-slate-100 text-slate-600 rounded-2xl font-bold flex items-center justify-center">
                        Réinitialiser tout
                    </a>
                </div>
            </div>
        </div>
        <!-- Desktop Table -->
        <div class="hidden md:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Produit
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Catégorie
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Prix</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Statut
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="h-10 w-10 flex-shrink-0 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                class="h-full w-full object-cover">
                                        @else
                                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-800">{{ $product->name }}</div>
                                        <div class="text-xs text-gray-500 uppercase tracking-wider font-medium">
                                            {{ $product->barcode }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold"
                                    style="background-color: {{ $product->category->color }}20; color: {{ $product->category->color }}">
                                    {{ $product->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                {{ number_format($product->price, 0, '.', ' ') }} {{ setting('currency') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span
                                        class="text-sm font-medium mr-2 {{ $product->stock <= $product->min_stock ? 'text-red-600' : 'text-gray-700' }}">{{ $product->stock }}</span>
                                    <div class="w-16 bg-gray-100 rounded-full h-1.5">
                                        <div class="h-1.5 rounded-full {{ $product->stock <= $product->min_stock ? 'bg-red-500' : 'bg-green-500' }}"
                                            style="width: {{ min(100, ($product->stock / ($product->min_stock * 3)) * 100) }}%">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($product->active)
                                    <span
                                        class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Actif</span>
                                @else
                                    <span
                                        class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Inactif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('stock.create', ['product_id' => $product->id]) }}"
                                        title="Réapprovisionner"
                                        class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all hover:scale-110 active:scale-95 transition-transform">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}"
                                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all hover:scale-110 active:scale-95 transition-transform">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                        @submit.prevent="$dispatch('confirm', { title: 'Suppression', message: 'Voulez-vous vraiment supprimer ce produit ?', callback: () => $el.submit() })">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">Aucun produit trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        </div>

        <!-- Mobile Cards Stack -->
        <div class="md:hidden space-y-4 pb-24">
            @forelse($products as $product)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden"
                    x-data="{ open: false }">
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div
                                class="h-12 w-12 bg-slate-50 rounded-xl flex items-center justify-center overflow-hidden border border-slate-100">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <svg class="h-6 w-6 text-slate-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">{{ $product->name }}</h4>
                                <span class="text-[10px] uppercase font-black tracking-widest"
                                    style="color: {{ $product->category->color }}">
                                    {{ $product->category->name }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-black text-blue-600">
                                {{ number_format($product->price, 0, '.', ' ') }} Ar</div>
                            <div
                                class="text-[10px] font-bold {{ $product->stock <= $product->min_stock ? 'text-red-500' : 'text-slate-400' }}">
                                Stock: {{ $product->stock }}
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-50 flex items-center justify-between">
                        <div class="flex space-x-1">
                            <a href="{{ route('products.edit', $product) }}"
                                class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <a href="{{ route('stock.create', ['product_id' => $product->id]) }}"
                                class="p-2 text-slate-400 hover:text-green-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </a>
                        </div>

                        <div class="flex items-center space-x-3">
                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                @submit.prevent="$dispatch('confirm', { title: 'Suppression', message: 'Supprimer ce produit ?', callback: () => $el.submit() })">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-300 hover:text-red-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                            <button @click="open = !open" class="p-2 text-slate-400 transition-transform"
                                :class="open ? 'rotate-180' : ''">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Expandable Details -->
                    <div x-show="open" x-collapse class="px-4 py-4 bg-white border-t border-slate-50 space-y-3">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Code-barres</span>
                                <span class="text-xs font-bold text-slate-700">{{ $product->barcode ?: 'N/A' }}</span>
                            </div>
                            <div>
                                <span
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Statut</span>
                                <span
                                    class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $product->active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $product->active ? 'Actif' : 'Inactif' }}
                                </span>
                            </div>
                            <div>
                                <span
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Stock
                                    Alerte</span>
                                <span class="text-xs font-bold text-slate-700">{{ $product->min_stock }} unités</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-slate-400 italic bg-white rounded-2xl border border-slate-100">
                    Aucun produit trouvé
                </div>
            @endforelse

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>

        <!-- Floating Action Button (Mobile) -->
        <div class="md:hidden fixed bottom-24 right-6 z-[100]">
            <a href="{{ route('products.create') }}"
                class="flex items-center justify-center h-14 w-14 bg-blue-600 text-white rounded-2xl shadow-2xl shadow-blue-500/50 active:scale-90 transition-transform">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>
    </div>
@endsection
