@extends('layouts.app')

@section('page-title', 'Nouveau Produit')

@section('content')
    <div class="max-w-4xl mx-auto pb-24 md:pb-6" x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)">

        <!-- Header -->
        <div class="flex items-center justify-between mb-4 md:mb-6" x-show="show"
            x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center space-x-3 md:space-x-4">
                <a href="{{ route('products.index') }}"
                    class="h-9 w-9 md:h-10 md:w-10 bg-white text-slate-600 rounded-lg flex items-center justify-center border border-slate-200 shadow-sm hover:bg-slate-50 hover:text-blue-600 transition-all active:scale-95">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-slate-900 tracking-tight">Nouveau Produit</h2>
                </div>
            </div>
        </div>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-4 md:space-y-6" x-show="show"
                x-transition:enter="transition ease-out duration-500 delay-100"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

                <!-- Section: Informations Générales -->
                <div class="bg-white p-5 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center">
                        <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mr-2">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        Informations Générales
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <!-- Nom -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nom du produit <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                placeholder="Ex: Riz blanc 1kg"
                                class="h-11 w-full px-4 bg-slate-50 md:bg-white border border-slate-200 rounded-xl text-sm font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catégorie -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Catégorie <span
                                    class="text-red-500">*</span></label>
                            <select name="category_id" required
                                class="h-11 w-full px-4 bg-slate-50 md:bg-white border border-slate-200 rounded-xl text-sm font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all appearance-none">
                                <option value="">Sélectionner une catégorie</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Code-barres -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Code-barres</label>
                            <input type="text" name="barcode" value="{{ old('barcode') }}"
                                placeholder="Scannez ou tapez..."
                                class="h-11 w-full px-4 bg-slate-50 md:bg-white border border-slate-200 rounded-xl text-sm font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                        </div>
                    </div>
                </div>

                <!-- Section: Prix & Stock -->
                <div class="bg-white p-5 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center">
                        <span
                            class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mr-2">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        Prix & Inventaire
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <!-- Prix d'achat -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Prix d'achat
                                ({{ setting('currency') }})</label>
                            <input type="number" step="0.01" inputmode="decimal" name="cost"
                                value="{{ old('cost', 0) }}"
                                class="h-11 w-full px-4 bg-slate-50 md:bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                        </div>

                        <!-- Prix de vente -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Prix de vente
                                ({{ setting('currency') }}) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" inputmode="decimal" name="price"
                                value="{{ old('price') }}" required
                                class="h-11 w-full px-4 bg-slate-50 md:bg-white border border-slate-200 rounded-xl text-sm font-bold text-blue-600 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all text-lg">
                        </div>

                        <!-- Stock actuel -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Stock initial <span
                                    class="text-red-500">*</span></label>
                            <input type="number" inputmode="numeric" name="stock" value="{{ old('stock', 0) }}" required
                                class="h-11 w-full px-4 bg-slate-50 md:bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                        </div>

                        <!-- Stock minimum -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alerte stock minimum <span
                                    class="text-red-500">*</span></label>
                            <input type="number" inputmode="numeric" name="min_stock" value="{{ old('min_stock', 5) }}"
                                required
                                class="h-11 w-full px-4 bg-slate-50 md:bg-white border border-slate-200 rounded-xl text-sm font-bold text-red-500 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                        </div>
                    </div>
                </div>

                <!-- Section: Media & Statut -->
                <div class="bg-white p-5 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center">
                        <span class="w-6 h-6 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center mr-2">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </span>
                        Options & Image
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Image du produit</label>
                            <input type="file" name="image"
                                class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer border border-slate-100 rounded-xl p-1.5">
                            @error('image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <input type="checkbox" name="active" id="active" value="1" checked
                                class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500 bg-white cursor-pointer transition-all">
                            <label for="active"
                                class="ml-3 text-sm font-bold text-slate-700 cursor-pointer select-none">Activer ce produit
                                pour la vente</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Bar (Desktop: Normal, Mobile: Sticky above Nav) -->
            <div class="mt-8 flex items-center justify-end space-x-3 md:relative fixed bottom-20 md:bottom-0 left-0 right-0 p-4 md:p-0 bg-white/90 backdrop-blur-sm md:bg-transparent border-t border-slate-100 md:border-none z-[110]"
                x-show="show" x-transition:enter="transition ease-out duration-500 delay-200"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <a href="{{ route('products.index') }}"
                    class="h-12 flex-1 md:flex-none md:h-10 px-6 flex items-center justify-center text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl md:rounded-lg font-bold md:font-medium text-sm transition-all active:scale-95">
                    Annuler
                </a>
                <button type="submit"
                    class="h-12 flex-[2] md:flex-none md:h-10 px-8 bg-blue-600 text-white rounded-xl md:rounded-lg font-black md:font-medium text-sm shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all active:scale-95 uppercase tracking-widest md:normal-case md:tracking-normal">
                    Créer le produit
                </button>
            </div>
        </form>
    </div>
@endsection
