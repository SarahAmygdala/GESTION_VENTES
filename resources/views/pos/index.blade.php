@extends('layouts.app')

@section('page-title', 'Caisse (POS)')
@section('main-classes', 'py-4 px-4 sm:px-6 lg:px-8')

@section('content')
    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)">
        <div class="h-full md:h-[calc(100vh-120px)] overflow-hidden" x-data="posSystem()" x-show="show"
            x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            {{-- Main 3-Column POS Layout --}}
            <div class="flex flex-col md:flex-row h-full md:space-x-6 space-y-6 md:space-y-0 relative">

                <div class="flex-1 flex flex-col min-w-0 h-full">
                    <!-- POS Header -->
                    <div class="mb-4 md:mb-6 flex items-center space-x-3">
                        <div
                            class="h-10 w-10 md:h-12 md:w-12 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-lg shadow-blue-200 flex-shrink-0">
                            <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-sm md:text-xl font-black text-slate-900 leading-tight uppercase tracking-wider">
                                Caisse de Vente</h2>
                            <p
                                class="text-[10px] md:text-xs text-slate-500 font-bold uppercase tracking-widest leading-none">
                                Interface Rapide</p>
                        </div>
                    </div>

                    <!-- Search & Filters -->
                    <div class="mb-4 md:mb-6 flex space-x-2 md:space-x-4 flex-shrink-0">
                        <div class="relative flex-1 group">
                            <span
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <svg class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" x-model="search" placeholder="Rechercher produit..."
                                class="h-[44px] md:h-[52px] w-full px-4 pl-10 md:pl-12 bg-white border border-slate-200 rounded-xl md:rounded-2xl text-[13px] md:text-[14px] font-medium focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all placeholder:text-slate-400 shadow-sm">
                        </div>

                        <!-- Mobile Category Toggle -->
                        <button @click="categoryDrawerOpen = true"
                            class="md:hidden h-[44px] w-12 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-500 shadow-sm relative">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            <span x-show="selectedCategory"
                                class="absolute -top-1 -right-1 h-3 w-3 bg-blue-600 rounded-full border-2 border-white"></span>
                        </button>

                        <div class="hidden md:block relative w-64"
                            x-data="{ open: false, label: 'Toutes les catégories' }">
                            <button @click="open = !open" type="button"
                                class="h-[52px] w-full pl-4 pr-10 bg-white border border-slate-200 rounded-2xl text-[14px] font-bold text-slate-700 shadow-sm hover:border-blue-400 transition-all cursor-pointer outline-none flex items-center justify-between relative">
                                <span class="truncate" x-text="label"></span>
                                <svg class="h-4 w-4 text-slate-400 flex-shrink-0 transition-transform duration-200"
                                    :class="open ? 'rotate-180' : ''"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.outside="open = false" x-cloak
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                class="absolute z-50 top-[56px] left-0 w-full bg-white border border-slate-100 rounded-2xl shadow-xl shadow-slate-200/60 overflow-hidden">
                                <button type="button"
                                    @click="selectedCategory = ''; label = 'Toutes les catégories'; open = false"
                                    class="w-full text-left px-4 py-3 text-[14px] font-bold text-blue-600 bg-blue-50/50 hover:bg-blue-50 transition-colors flex items-center space-x-2">
                                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                                    </svg>
                                    <span>Toutes les catégories</span>
                                </button>
                                <div class="divide-y divide-slate-50">
                                @foreach ($categories as $category)
                                    <button type="button"
                                        @click="selectedCategory = '{{ $category->id }}'; label = '{{ $category->name }}'; open = false"
                                        class="w-full text-left px-4 py-3 text-[14px] font-medium text-slate-700 hover:bg-slate-50 transition-colors flex items-center space-x-2">
                                        <span class="h-3 w-3 rounded-full flex-shrink-0" style="background:{{ $category->color }}"></span>
                                        <span>{{ $category->name }}</span>
                                    </button>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Category Drawer -->
                    <div x-show="categoryDrawerOpen" class="fixed inset-0 z-[150] md:hidden" x-cloak>
                        <div @click="categoryDrawerOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm">
                        </div>
                        <div x-transition:enter="transition ease-out duration-300 transform"
                            x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
                            class="absolute bottom-0 inset-x-0 bg-white rounded-t-[32px] shadow-2xl p-6 pb-24 flex flex-col space-y-4">
                            <div class="h-1.5 w-12 bg-slate-200 rounded-full mx-auto -mt-2 mb-2"></div>
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-black text-slate-900">Catégories</h3>
                                <button @click="categoryDrawerOpen = false" class="text-slate-400">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="grid grid-cols-2 gap-3 max-h-[50vh] overflow-y-auto pb-4">
                                <button @click="selectedCategory = ''; categoryDrawerOpen = false"
                                    class="p-3 rounded-2xl border text-sm font-bold transition-all"
                                    :class="!selectedCategory ? 'bg-blue-600 border-blue-600 text-white' :
                                        'bg-slate-50 border-slate-100 text-slate-600'">
                                    Toutes
                                </button>
                                @foreach ($categories as $category)
                                    <button @click="selectedCategory = '{{ $category->id }}'; categoryDrawerOpen = false"
                                        class="p-3 rounded-2xl border text-sm font-bold transition-all"
                                        :style="selectedCategory == '{{ $category->id }}' ? '' :
                                            'border-left: 4px solid {{ $category->color }}'"
                                        :class="selectedCategory == '{{ $category->id }}' ?
                                            'bg-blue-600 border-blue-600 text-white' :
                                            'bg-slate-50 border-slate-100 text-slate-600'">
                                        {{ $category->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Scrollable Grid -->
                    <div class="flex-1 overflow-y-auto pr-1 md:pr-2 custom-scrollbar">
                        <div
                            class="grid grid-cols-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 md:gap-4 pb-20 md:pb-0">
                            <template x-for="product in filteredProducts()" :key="product.id">
                                <div @click="addToCart(product)"
                                    :style="'background-color: ' + (product.category?.color || '#FFFFFF') +
                                    '08; border-color: ' + (
                                        product.category?.color || '#E5E7EB') +
                                    '30; border-top-width: 4px; border-top-color: ' + (product.category?.color ||
                                        '#E5E7EB')"
                                    class="bg-white border rounded-[14px] shadow-sm transition-all duration-300 hover:shadow-md translate-y-0 hover:-translate-y-1 p-2 md:p-4 group flex flex-col cursor-pointer relative">
                                    <!-- Product Image Area -->
                                    <div
                                        class="w-full aspect-square bg-[#F8FAFC] rounded-[10px] mb-4 flex items-center justify-center overflow-hidden border border-[#F3F4F6] group-hover:border-[#2563EB]/20 transition-colors">
                                        <template x-if="product.image">
                                            <img :src="'/storage/' + product.image"
                                                class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        </template>
                                        <template x-if="!product.image">
                                            <svg class="h-10 w-10 text-[#E5E7EB]" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                                                    stroke-width="2" />
                                            </svg>
                                        </template>
                                    </div>
                                    <!-- Info -->
                                    <div class="flex-1 flex flex-col mt-auto">
                                        <h4 class="text-[11px] md:text-[13px] text-[#111827] font-bold leading-tight md:leading-snug line-clamp-2 mb-1 md:mb-3 min-h-[22px] md:min-h-[34px]"
                                            x-text="product.name"></h4>

                                        <div class="space-y-3">
                                            <!-- Price & Label -->
                                            <div class="flex flex-col border-l-2 border-[#2563EB] pl-1.5 md:pl-2 py-0.5">
                                                <span
                                                    class="text-[10px] md:text-xs font-bold text-gray-900 bg-white/90 backdrop-blur-sm px-1.5 md:px-2 py-0.5 md:py-1 rounded-md shadow-sm border border-gray-100"
                                                    x-text="formatCurrency(product.price)"></span>
                                                <span
                                                    class="hidden md:block text-[9px] uppercase tracking-wider font-bold text-[#6B7280] mt-1">Prix
                                                    Unitaire</span>
                                            </div>

                                            <!-- Stock Indicator -->
                                            <div class="pt-1 border-t border-slate-50 flex items-center justify-between">
                                                <div
                                                    class="flex items-center space-x-1 px-1.5 md:px-2 py-0.5 md:py-1 rounded-md bg-slate-50 border border-slate-100">
                                                    <div class="h-1 w-1 md:h-1.5 md:w-1.5 rounded-full"
                                                        :class="product.stock <= product.min_stock ? 'bg-[#EF4444]' :
                                                            'bg-[#22C55E]'">
                                                    </div>
                                                    <span class="text-[8px] md:text-[10px] font-bold text-[#6B7280]">
                                                        Stk: <span x-text="product.stock" class="text-[#111827]"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Add Button Overlay (Feedback) -->
                                    <div
                                        class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <div class="bg-[#2563EB] text-white p-2 rounded-lg shadow-lg">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- 2 & 3. Cart & Payment (Desktop: Sidebars, Mobile: Bottom Drawer) -->

                <!-- Mobile Backdrops -->
                <div x-show="cartOpen || paymentOpen" x-cloak
                    class="md:hidden fixed inset-0 z-[130] bg-black/40 backdrop-blur-sm"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    @click="cartOpen = false; paymentOpen = false">
                </div>

                <!-- Mobile Cart Drawer -->
                <div class="fixed md:hidden inset-x-0 bottom-0 z-[140] transform h-[80vh] bg-white rounded-t-[32px] shadow-2xl transition-transform duration-300 ease-in-out flex flex-col"
                    :class="cartOpen ? 'translate-y-0' : 'translate-y-full'" x-cloak>
                    <div class="flex justify-center py-4" @click="cartOpen = false">
                        <div class="w-12 h-1.5 bg-slate-200 rounded-full"></div>
                    </div>
                    <div class="flex-1 flex flex-col overflow-hidden p-4">
                        <div
                            class="flex flex-col bg-white border border-[#E5E7EB] rounded-[24px] shadow-sm overflow-hidden h-full">
                            <div class="p-5 border-b border-[#F3F4F6] flex items-center justify-between bg-[#F8FAFC]">
                                <h3 class="text-[16px] font-bold text-[#111827]">Votre Panier</h3>
                                <span
                                    class="text-[11px] text-[#2563EB] bg-white border border-[#E5E7EB] px-3 py-1 rounded-full font-black"
                                    x-text="cart.length + ' ARTICLES'"></span>
                            </div>
                            <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar">
                                <template x-for="(item, index) in cart" :key="index">
                                    <div :style="'border-left-width: 4px; border-left-color: ' + (item.categoryColor || '#E5E7EB')"
                                        class="p-4 bg-slate-50 border border-[#F3F4F6] rounded-xl flex flex-col space-y-3 relative">
                                        <div class="flex justify-between items-start pr-8">
                                            <p class="text-[14px] text-[#111827] font-bold leading-tight"
                                                x-text="item.name"></p>
                                            <button @click="removeItem(index)"
                                                class="absolute top-4 right-4 text-slate-300 hover:text-red-500">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center bg-white rounded-lg border border-[#E5E7EB] p-1">
                                                <button @click="updateQty(index, -1)"
                                                    class="w-8 h-8 flex items-center justify-center font-black">-</button>
                                                <span class="w-10 text-center font-black text-[14px]"
                                                    x-text="item.quantity"></span>
                                                <button @click="updateQty(index, 1)"
                                                    class="w-8 h-8 flex items-center justify-center font-black">+</button>
                                            </div>
                                            <span class="text-[16px] font-black text-[#111827]"
                                                x-text="formatCurrency(item.price * item.quantity)"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <div class="p-5 bg-slate-50 border-t border-slate-100">
                                <button @click="cartOpen = false; paymentOpen = true"
                                    class="w-full h-14 bg-blue-600 text-white rounded-2xl font-black shadow-lg shadow-blue-100 flex items-center justify-center space-x-3 active:scale-95 transition-all">
                                    <span>Passer au Paiement</span>
                                    <svg class="w-5 h-5 font-black" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Desktop Sidebar (Unchanged container logic but cleaned for mobile) -->
                <div class="hidden md:flex md:space-x-4 h-full">
                    <!-- 2. Cart (Desktop) -->
                    <div
                        class="md:w-[320px] flex flex-col bg-white border border-[#E5E7EB] rounded-[14px] shadow-sm overflow-hidden h-full">
                        <div class="p-5 border-b border-[#F3F4F6] flex items-center justify-between bg-[#F8FAFC]">
                            <h3 class="text-[16px] font-semibold text-[#111827] flex items-center">
                                <svg class="h-5 w-5 mr-2 text-[#2563EB]" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="2.5" />
                                </svg>
                                Panier
                            </h3>
                            <span
                                class="text-[12px] text-[#2563EB] bg-white border border-[#E5E7EB] px-2.5 py-1 rounded-full font-black"
                                x-text="cart.length + ' ARTICLES'"></span>
                        </div>
                        <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar">
                            <template x-for="(item, index) in cart" :key="index">
                                <div :style="'border-left-width: 4px; border-left-color: ' + (item.categoryColor || '#E5E7EB')"
                                    class="p-3 bg-white border border-[#F3F4F6] rounded-xl flex flex-col space-y-3 hover:border-[#E5E7EB] transition-colors relative group">
                                    <div class="flex justify-between items-start">
                                        <p class="text-[13px] text-[#111827] font-bold line-clamp-2 pr-6"
                                            x-text="item.name"></p>
                                        <button @click="removeItem(index)"
                                            class="absolute top-3 right-3 text-[#D1D5DB] hover:text-[#EF4444] transition-colors">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div
                                            class="flex items-center bg-[#F8FAFC] rounded-lg border border-[#E5E7EB] p-0.5">
                                            <button @click="updateQty(index, -1)"
                                                class="w-7 h-7 flex items-center justify-center font-bold">-</button>
                                            <span class="w-8 text-center text-[13px] font-black"
                                                x-text="item.quantity"></span>
                                            <button @click="updateQty(index, 1)"
                                                class="w-7 h-7 flex items-center justify-center font-bold">+</button>
                                        </div>
                                        <span class="text-[14px] font-black text-[#111827]"
                                            x-text="formatCurrency(item.price * item.quantity)"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    @include('pos.partials.payment_sidebar')
                </div>

                <!-- Mobile Payment Drawer -->
                <div class="fixed md:hidden inset-x-0 bottom-0 z-[150] transform h-[85vh] bg-white rounded-t-[32px] shadow-2xl transition-transform duration-300 ease-in-out flex flex-col pb-20"
                    :class="paymentOpen ? 'translate-y-0' : 'translate-y-full'" x-cloak>
                    <div class="flex justify-center py-4" @click="paymentOpen = false">
                        <div class="w-12 h-1.5 bg-slate-200 rounded-full"></div>
                    </div>
                    <div class="flex-1 overflow-y-auto px-6 pb-6 space-y-6">
                        <div class="text-center">
                            <h3 class="text-[18px] font-black text-slate-900 uppercase tracking-widest">Règlement de la
                                vente</h3>
                            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Finalisez la
                                transaction</p>
                        </div>

                        <!-- Totals Card -->
                        <div
                            class="bg-blue-600 rounded-[28px] p-6 text-white shadow-xl shadow-blue-100 flex flex-col items-center">
                            <span class="text-[10px] font-black uppercase tracking-[0.3em] opacity-80 mb-2">Net à
                                payer</span>
                            <span class="text-[32px] font-black" x-text="formatCurrency(total())"></span>
                            <div class="mt-4 w-full h-px bg-white/20"></div>
                            <div class="flex justify-between w-full mt-4 px-2">
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-bold uppercase opacity-70">Sous-total</span>
                                    <span class="text-[14px] font-black" x-text="formatCurrency(subtotal())"></span>
                                </div>
                                <div class="flex flex-col text-right">
                                    <span class="text-[9px] font-bold uppercase opacity-70 text-right">Remise</span>
                                    <span class="text-[14px] font-black" x-text="'-' + discount + '%'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Fields -->
                        <div class="space-y-5">
                            @include('pos.partials.payment_fields_mobile')
                        </div>
                    </div>
                </div>

                <!-- 4. Mobile Sticky Bottom Bar (View Cart & Payment) -->
                <div
                    class="md:hidden fixed bottom-20 left-0 right-0 p-4 bg-white/95 backdrop-blur-xl border-t border-slate-100 flex items-center justify-between z-[120] shadow-[0_-10px_30px_rgba(0,0,0,0.08)]">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Total</span>
                        <span class="text-[16px] font-black text-slate-900" x-text="formatCurrency(total())"></span>
                    </div>
                    <div class="flex space-x-2">
                        <!-- Cart Button -->
                        <button @click="cartOpen = true; paymentOpen = false"
                            class="flex items-center justify-center bg-slate-100 text-slate-700 w-[52px] h-[48px] rounded-2xl relative active:scale-90 transition-all border border-slate-200">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span x-show="cart.length > 0"
                                class="absolute -top-1 -right-1 bg-blue-600 text-white text-[9px] font-bold h-5 w-5 rounded-full flex items-center justify-center border-2 border-white"
                                x-text="cart.length"></span>
                        </button>
                        <!-- Payment Button -->
                        <button @click="paymentOpen = true; cartOpen = false" :disabled="cart.length === 0"
                            class="flex items-center bg-blue-600 text-white px-5 h-[48px] rounded-2xl font-black space-x-2 shadow-lg shadow-blue-100 active:scale-95 transition-all disabled:grayscale disabled:opacity-50">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                            </svg>
                            <span class="text-[14px] uppercase tracking-wider">Payer</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function posSystem() {
            return {
                products: @json($products),
                clients: @json($clients),
                search: '',
                selectedCategory: '',
                cart: [],
                cartOpen: false,
                paymentOpen: false,
                categoryDrawerOpen: false,
                discount: 0,
                paymentMethod: 'espèces',
                amountReceived: '',
                selectedClientId: '',
                showToast(message, type = 'success') {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            message,
                            type
                        }
                    }));
                },
                showModal(title, message, type = 'success') {
                    window.dispatchEvent(new CustomEvent('modal', {
                        detail: {
                            title,
                            message,
                            type
                        }
                    }));
                },

                filteredProducts() {
                    return this.products.filter(p => {
                        const matchSearch = p.name.toLowerCase().includes(this.search.toLowerCase()) ||
                            (p.barcode && p.barcode.includes(this.search));
                        const matchCat = this.selectedCategory === '' || p.category_id == this.selectedCategory;
                        return matchSearch && matchCat;
                    });
                },

                addToCart(product) {
                    const existing = this.cart.find(i => i.id === product.id);
                    if (existing) {
                        if (existing.quantity < product.stock) {
                            existing.quantity++;
                            this.showToast(`${product.name} ajouté au panier`);
                        } else {
                            this.showToast('Stock maximum atteint !', 'error');
                        }
                    } else {
                        if (product.stock > 0) {
                            this.cart.push({
                                id: product.id,
                                name: product.name,
                                price: product.price,
                                categoryColor: product.category?.color,
                                quantity: 1
                            });
                            this.showToast(`${product.name} ajouté au panier`);
                        } else {
                            this.showToast('Produit épuisé !', 'error');
                        }
                    }
                },

                updateQty(index, delta) {
                    const item = this.cart[index];
                    const product = this.products.find(p => p.id === item.id);
                    const newQty = item.quantity + delta;

                    if (newQty > 0) {
                        if (newQty <= product.stock) {
                            item.quantity = newQty;
                        } else {
                            this.showToast('Stock maximum atteint !', 'error');
                        }
                    } else {
                        this.removeItem(index);
                    }
                },

                removeItem(index) {
                    this.cart.splice(index, 1);
                },

                subtotal() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                },

                total() {
                    const sub = this.subtotal();
                    return sub - (sub * this.discount / 100);
                },

                change() {
                    if (!this.amountReceived) return 0;
                    return parseFloat(this.amountReceived) - this.total();
                },

                formatCurrency(amount) {
                    return new Intl.NumberFormat('fr-FR').format(amount) + ' {{ setting('currency') }}';
                },

                processPayment() {
                    const data = {
                        client_id: this.selectedClientId || null,
                        items: this.cart,
                        discount: this.discount,
                        amount_paid: this.amountReceived,
                        payment_method: this.paymentMethod,
                        _token: '{{ csrf_token() }}'
                    };

                    fetch('{{ route('pos.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                this.showModal('Vente Terminée', data.message, 'success');

                                // Ouverture automatique de la facture PDF dans un nouvel onglet
                                if (data.sale_id) {
                                    window.open(`/sales/${data.sale_id}/pdf`, '_blank');
                                }

                                this.cart = [];
                                this.amountReceived = '';
                                this.discount = 0;
                                this.selectedClientId = '';
                                this.paymentOpen = false; // Ferme le tiroir mobile
                            } else {
                                this.showToast(data.message, 'error');
                            }
                        })
                        .catch(err => this.showToast('Une erreur est survenue !', 'error'));
                }
            }
        }
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
