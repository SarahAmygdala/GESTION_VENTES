@extends('layouts.app')

@section('page-title', 'Réapprovisionnement')

@section('content')
    <div class="max-w-3xl mx-auto pb-24 md:pb-6" x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)">

        <!-- Header -->
        <div class="flex items-center space-x-3 mb-6" x-show="show" x-transition>
            <a href="{{ route('products.index') }}"
                class="h-9 w-9 bg-white text-slate-600 rounded-lg flex items-center justify-center border border-slate-200 shadow-sm hover:bg-slate-50 transition-all active:scale-95">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Réapprovisionner</h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden" x-show="show"
            x-transition:enter="transition ease-out duration-500 delay-100">
            <div class="p-6 md:p-8 border-b border-slate-50 bg-slate-50/50">
                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-1">Mouvement de Stock</h3>
                <p class="text-xs text-slate-500 font-medium">Mettez à jour vos quantités en stock en quelques secondes.</p>
            </div>

            <form action="{{ route('stock.store') }}" method="POST" class="p-6 md:p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <!-- Produit -->
                    <div class="space-y-2">
                        <label for="product_id" class="block text-sm font-semibold text-slate-700">Produit <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="product_id" id="product_id" required
                                class="w-full h-12 px-4 bg-slate-50 md:bg-white border border-slate-200 rounded-xl text-sm font-medium focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all appearance-none cursor-pointer">
                                <option value="">Choisir un produit...</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old('product_id') == $product->id || $selected_product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (Actuel: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Quantité -->
                        <div class="space-y-2">
                            <label for="quantity" class="block text-sm font-semibold text-slate-700">Quantité <span
                                    class="text-red-500">*</span></label>
                            <input type="number" inputmode="numeric" name="quantity" id="quantity"
                                value="{{ old('quantity') }}" required min="1"
                                class="w-full h-12 px-4 bg-slate-50 md:bg-white border border-slate-200 rounded-xl text-lg font-black text-blue-600 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all"
                                placeholder="0">
                        </div>

                        <!-- Type -->
                        <div class="space-y-2">
                            <label for="type" class="block text-sm font-semibold text-slate-700">Type de
                                mouvement</label>
                            <select name="type" id="type" required
                                class="w-full h-12 px-4 bg-slate-50 md:bg-white border border-slate-200 rounded-xl text-sm font-medium focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all appearance-none cursor-pointer">
                                <option value="in" selected>Entrée (Achat)</option>
                                <option value="adjustment">Ajustement</option>
                                <option value="out">Sortie (Perte)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Motif -->
                    <div class="space-y-2">
                        <label for="reason" class="block text-sm font-semibold text-slate-700">Motif (Optionnel)</label>
                        <textarea name="reason" id="reason" rows="3"
                            class="w-full p-4 bg-slate-50 md:bg-white border border-slate-200 rounded-xl text-sm font-medium focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all resize-none"
                            placeholder="Ex: Arrivage fournisseur..."></textarea>
                    </div>
                </div>

                <!-- Action Bar (Desktop: Normal, Mobile: Sticky above Nav) -->
                <div
                    class="mt-8 flex items-center justify-end space-x-3 md:relative fixed bottom-20 md:bottom-0 left-0 right-0 p-4 md:p-0 bg-white/90 backdrop-blur-sm md:bg-transparent border-t border-slate-100 md:border-none z-[110]">
                    <a href="{{ route('products.index') }}"
                        class="h-12 flex-1 md:flex-none md:h-10 px-6 flex items-center justify-center text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl md:rounded-lg font-bold md:font-medium text-sm transition-all active:scale-95">
                        Annuler
                    </a>
                    <button type="submit"
                        class="h-12 flex-[2] md:flex-none md:h-10 px-8 bg-blue-600 text-white rounded-xl md:rounded-lg font-black md:font-medium text-sm shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all active:scale-95 uppercase tracking-widest md:normal-case md:tracking-normal">
                        Valider
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
