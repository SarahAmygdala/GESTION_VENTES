@extends('layouts.app')

@section('page-title', 'Archive des Stocks')

@section('content')
    <div class="space-y-6" x-data="{ show: false, filtersOpen: false }" x-init="setTimeout(() => show = true, 50)">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4" x-show="show"
            x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center space-x-4">
                <div
                    class="h-12 w-12 md:h-14 md:w-14 bg-slate-100 text-slate-600 rounded-2xl flex items-center justify-center shadow-sm">
                    <svg class="h-6 w-6 md:h-8 md:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg md:text-2xl font-black text-slate-900 tracking-tight">Archive des Stocks</h2>
                    <p class="text-[11px] md:text-sm text-slate-500 font-medium">
                        {{ $movements->total() }} mouvements tracés
                    </p>
                </div>
            </div>
            <a href="{{ route('stock.create') }}"
                class="hidden md:flex h-12 px-6 bg-slate-800 text-white rounded-xl font-black shadow-lg shadow-slate-200 hover:bg-slate-900 transition-all items-center text-sm uppercase tracking-wider active:scale-95">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Réapprovisionner
            </a>
        </div>

        <!-- Desktop Filters (Large Screen) -->
        <div class="hidden md:block mb-4">
            <form action="{{ route('stock.index') }}" method="GET"
                class="space-y-4 lg:space-y-0 lg:grid lg:grid-cols-12 lg:gap-4 items-end">
                <div class="lg:col-span-5">
                    <label
                        class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Rechercher
                        un produit</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Nom de l'article..."
                            class="h-12 w-full pl-11 pr-4 bg-slate-50 border-none rounded-2xl text-sm font-medium focus:ring-2 focus:ring-slate-500/10 focus:bg-white transition-all placeholder:text-slate-400">
                    </div>
                </div>
                <div class="lg:col-span-4">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Période
                        d'archive</label>
                    <div class="flex items-center space-x-2 bg-slate-50 rounded-2xl p-1">
                        <input type="date" name="date_start" value="{{ request('date_start') }}"
                            class="h-10 flex-1 px-3 bg-transparent border-none text-sm font-medium focus:ring-0">
                        <span class="text-slate-300">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </span>
                        <input type="date" name="date_end" value="{{ request('date_end') }}"
                            class="h-10 flex-1 px-3 bg-transparent border-none text-sm font-medium focus:ring-0">
                    </div>
                </div>
                <div class="lg:col-span-3 flex items-center space-x-2">
                    <button type="submit"
                        class="h-12 flex-1 bg-slate-900 text-white rounded-2xl font-bold text-sm hover:bg-black transition-all active:scale-95 shadow-lg shadow-slate-200 uppercase tracking-widest">
                        Explorer
                    </button>
                    <a href="{{ route('stock.index') }}"
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
                <form action="{{ route('stock.index') }}" method="GET">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Rechercher un article..."
                        class="h-11 w-full pl-10 pr-4 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-2 focus:ring-slate-500/10 transition-all">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    @if (request('date_start'))
                        <input type="hidden" name="date_start" value="{{ request('date_start') }}">
                    @endif
                    @if (request('date_end'))
                        <input type="hidden" name="date_end" value="{{ request('date_end') }}">
                    @endif
                </form>
            </div>
            <button @click="filtersOpen = true"
                class="h-11 w-11 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-slate-600 shadow-sm relative">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                @if (request('date_start') || request('date_end'))
                    <span class="absolute -top-1 -right-1 h-3 w-3 bg-blue-600 rounded-full border-2 border-white"></span>
                @endif
            </button>
        </div>

        <!-- Mobile Filters Drawer -->
        <div x-show="filtersOpen" class="fixed inset-0 z-[150] md:hidden" x-cloak>
            <div @click="filtersOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
                class="absolute bottom-0 inset-x-0 bg-white rounded-t-[32px] shadow-2xl flex flex-col p-6 space-y-6">
                <div class="h-1.5 w-12 bg-slate-200 rounded-full mx-auto -mt-2 mb-2 flex-shrink-0"></div>

                <h3 class="text-lg font-black text-slate-900 text-center">Période d'archive</h3>

                <form action="{{ route('stock.index') }}" method="GET" id="mobileStockFilter" class="space-y-4">
                    @if (request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <div>
                        <label
                            class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Début</label>
                        <input type="date" name="date_start" value="{{ request('date_start') }}"
                            class="h-12 w-full px-4 bg-slate-50 border-none rounded-2xl text-sm font-medium">
                    </div>
                    <div>
                        <label
                            class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Fin</label>
                        <input type="date" name="date_end" value="{{ request('date_end') }}"
                            class="h-12 w-full px-4 bg-slate-50 border-none rounded-2xl text-sm font-medium">
                    </div>
                </form>

                <div class="flex space-x-3 pt-4 border-t border-slate-50">
                    <a href="{{ route('stock.index') }}"
                        class="flex-1 h-12 bg-slate-100 text-slate-600 rounded-2xl font-bold flex items-center justify-center">
                        Effacer
                    </a>
                    <button type="submit" form="mobileStockFilter"
                        class="flex-[2] h-12 bg-slate-900 text-white rounded-2xl font-bold uppercase tracking-widest">
                        Appliquer
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Archive (Desktop) / Cards (Mobile) -->
        <div class="space-y-4">
            <!-- Desktop Table -->
            <div class="hidden lg:block bg-white rounded-[20px] shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-wider text-[#6B7280]">Date
                                </th>
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-wider text-[#6B7280]">
                                    Produit
                                </th>
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-wider text-[#6B7280]">Type
                                </th>
                                <th
                                    class="px-6 py-4 text-[11px] font-black uppercase tracking-wider text-[#6B7280] text-center">
                                    Initial</th>
                                <th
                                    class="px-6 py-4 text-[11px] font-black uppercase tracking-wider text-[#6B7280] text-center">
                                    Mouvement</th>
                                <th
                                    class="px-6 py-4 text-[11px] font-black uppercase tracking-wider text-[#6B7280] text-center">
                                    Nouveau Stock</th>
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-wider text-[#6B7280]">
                                    Opérateur</th>
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-wider text-[#6B7280]">Motif
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($movements as $movement)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 text-[13px] text-[#6B7280] font-medium">
                                        {{ $movement->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="h-8 w-8 rounded-lg bg-slate-100 flex items-center justify-center mr-3 flex-shrink-0">
                                                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                                                        stroke-width="2" />
                                                </svg>
                                            </div>
                                            <span
                                                class="text-[14px] font-bold text-[#111827]">{{ $movement->product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($movement->type === 'in')
                                            <span
                                                class="px-2.5 py-1 rounded-md bg-green-50 text-green-600 text-[10px] font-black uppercase border border-green-100">Entrée</span>
                                        @elseif($movement->type === 'out')
                                            <span
                                                class="px-2.5 py-1 rounded-md bg-red-50 text-red-600 text-[10px] font-black uppercase border border-red-100">Sortie</span>
                                        @else
                                            <span
                                                class="px-2.5 py-1 rounded-md bg-blue-50 text-blue-600 text-[10px] font-black uppercase border border-blue-100">Ajustement</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center text-[14px] font-medium text-[#6B7280]">
                                        {{ $movement->previous_stock }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="text-[15px] font-black {{ $movement->type === 'in' ? 'text-[#22C55E]' : ($movement->type === 'out' ? 'text-red-500' : 'text-[#6B7280]') }}">
                                            {{ $movement->type === 'in' ? '+' : ($movement->type === 'out' ? '-' : '') }}{{ $movement->quantity }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-[15px] font-black text-[#111827]">
                                            @if ($movement->type === 'in')
                                                {{ $movement->previous_stock + $movement->quantity }}
                                            @elseif($movement->type === 'out')
                                                {{ $movement->previous_stock - $movement->quantity }}
                                            @else
                                                {{ $movement->previous_stock + $movement->quantity }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-[13px] text-[#111827] font-bold">
                                        {{ $movement->user->name }}
                                    </td>
                                    <td class="px-6 py-4 text-[13px] text-[#6B7280] italic">
                                        {{ $movement->reason ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-[#6B7280]">
                                        Aucun mouvement de stock enregistré.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Cards Stack -->
            <div class="lg:hidden space-y-4 pb-24">
                @forelse($movements as $movement)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden animate-fade-in">
                        <div class="p-4 border-b border-slate-50 flex items-center justify-between">
                            <div>
                                <span
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">{{ $movement->created_at->format('d/m/Y H:i') }}</span>
                                <h4 class="text-sm font-bold text-slate-800">{{ $movement->product->name }}</h4>
                            </div>
                            @if ($movement->type === 'in')
                                <span
                                    class="px-2 py-0.5 rounded text-[10px] font-black uppercase bg-green-50 text-green-600 border border-green-100">Entrée</span>
                            @elseif($movement->type === 'out')
                                <span
                                    class="px-2 py-0.5 rounded text-[10px] font-black uppercase bg-red-50 text-red-600 border border-red-100">Sortie</span>
                            @else
                                <span
                                    class="px-2 py-0.5 rounded text-[10px] font-black uppercase bg-blue-50 text-blue-600 border border-blue-100">Ajustement</span>
                            @endif
                        </div>
                        <div class="p-4 bg-slate-50/30 grid grid-cols-3 gap-2 text-center">
                            <div class="flex flex-col">
                                <span
                                    class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Initial</span>
                                <span class="text-[14px] font-bold text-slate-600">{{ $movement->previous_stock }}</span>
                            </div>
                            <div class="flex flex-col bg-white rounded-xl py-1 border border-slate-100">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Modif</span>
                                <span
                                    class="text-[15px] font-black {{ $movement->type === 'in' ? 'text-green-500' : ($movement->type === 'out' ? 'text-red-500' : 'text-blue-500') }}">
                                    {{ $movement->type === 'in' ? '+' : ($movement->type === 'out' ? '-' : '') }}{{ $movement->quantity }}
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span
                                    class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Nouveau</span>
                                <span class="text-[14px] font-bold text-slate-900">
                                    {{ $movement->type === 'in' ? $movement->previous_stock + $movement->quantity : ($movement->type === 'out' ? $movement->previous_stock - $movement->quantity : $movement->previous_stock + $movement->quantity) }}
                                </span>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-white flex flex-col space-y-1">
                            <div class="flex justify-between items-center text-[12px]">
                                <span class="text-slate-400">Opérateur: <span
                                        class="text-slate-900 font-bold">{{ $movement->user->name }}</span></span>
                            </div>
                            @if ($movement->reason)
                                <p class="text-[11px] text-slate-500 italic">"{{ $movement->reason }}"</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-400 italic bg-white rounded-2xl border border-slate-100">
                        Aucun mouvement enregistré
                    </div>
                @endforelse

                <div class="mt-4">
                    {{ $movements->links() }}
                </div>
            </div>

            <!-- Desktop Pagination -->
            @if ($movements->hasPages())
                <div class="hidden lg:block px-6 py-4 border-t border-slate-100 bg-slate-50/30">
                    {{ $movements->links() }}
                </div>
            @endif
        </div>

        <!-- Floating Action Button (Mobile Only) -->
        <div class="lg:hidden fixed bottom-24 right-6 z-[100]">
            <a href="{{ route('stock.create') }}"
                class="flex items-center justify-center h-14 w-14 bg-slate-800 text-white rounded-2xl shadow-2xl shadow-slate-900/40 active:scale-90 transition-transform">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>
    </div>
@endsection
