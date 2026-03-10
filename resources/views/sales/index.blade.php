@extends('layouts.app')

@section('page-title', 'Historique des Ventes')

@section('content')
    <div class="space-y-6" x-data="{ show: false, filtersOpen: false }" x-init="setTimeout(() => show = true, 50)">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4" x-show="show"
            x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center space-x-4">
                <div
                    class="h-12 w-12 md:h-14 md:w-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center shadow-sm">
                    <svg class="h-6 w-6 md:h-8 md:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg md:text-2xl font-black text-slate-900 tracking-tight">Historique des Ventes</h2>
                    <p class="text-[11px] md:text-sm text-slate-500 font-medium">
                        {{ $sales->total() }} transactions enregistrées
                    </p>
                </div>
            </div>
            <div class="hidden md:flex items-center space-x-2">
                <a href="{{ route('sales.export') }}"
                    class="h-11 md:h-12 px-4 md:px-6 bg-white text-slate-700 border border-slate-200 rounded-xl font-bold shadow-sm hover:bg-slate-50 transition-all flex items-center text-sm active:scale-95">
                    <svg class="w-5 h-5 md:mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="hidden md:inline">Exporter Excel</span>
                </a>
            </div>
        </div>

        <!-- Desktop Filters (Large Screen) -->
        <div class="hidden md:block mb-4">
            <form action="{{ route('sales.index') }}" method="GET"
                class="space-y-4 md:grid md:grid-cols-12 md:gap-4 items-end">
                <div class="md:col-span-3 lg:col-span-2">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">N°
                        Vente</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="VTE-..."
                            class="h-12 w-full pl-10 pr-4 bg-slate-50 border-none rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500/10 focus:bg-white transition-all placeholder:text-slate-400">
                    </div>
                </div>
                <div class="md:col-span-4 lg:col-span-3">
                    <label
                        class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Client</label>
                    <div class="relative">
                        <select name="client_id"
                            class="h-12 w-full pl-4 pr-10 bg-slate-50 bg-none border-none rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500/10 focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">Tous les clients</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}"
                                    {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}</option>
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
                <div class="md:col-span-5 lg:col-span-4">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Période
                        du rapport</label>
                    <div class="flex items-center space-x-2 bg-slate-50 rounded-2xl p-1">
                        <input type="date" name="date_start" value="{{ request('date_start') }}"
                            class="h-10 flex-1 px-2 md:px-3 bg-transparent border-none text-[12px] md:text-sm font-medium focus:ring-0">
                        <span class="text-slate-300">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </span>
                        <input type="date" name="date_end" value="{{ request('date_end') }}"
                            class="h-10 flex-1 px-2 md:px-3 bg-transparent border-none text-[12px] md:text-sm font-medium focus:ring-0">
                    </div>
                </div>
                <div class="md:col-span-12 lg:col-span-3 flex items-center space-x-2">
                    <button type="submit"
                        class="h-12 flex-1 bg-slate-900 text-white rounded-2xl font-bold text-sm hover:bg-black transition-all active:scale-95 shadow-lg shadow-slate-200 uppercase tracking-widest">
                        Filtrer
                    </button>
                    <a href="{{ route('sales.index') }}"
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

        <!-- Mobile Filter Bar (Small Screens) -->
        <div class="md:hidden flex items-center space-x-2 mb-4">
            <div class="flex-1 relative">
                <form action="{{ route('sales.index') }}" method="GET">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="N° Vente (VTE-...)"
                        class="h-11 w-full pl-10 pr-4 bg-white border border-slate-100 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500/10 transition-all placeholder:text-slate-400 shadow-sm">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    @foreach (request()->except(['search', 'page']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                </form>
            </div>
            <button @click="filtersOpen = true"
                class="h-11 w-11 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-slate-600 shadow-sm relative">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                @if (request('client_id') || request('date_start') || request('date_end'))
                    <span class="absolute -top-1 -right-1 h-3 w-3 bg-blue-600 rounded-full border-2 border-white"></span>
                @endif
            </button>
        </div>

        <!-- Mobile Filters Drawer (Bottom Sheet) -->
        <div x-show="filtersOpen" class="fixed inset-0 z-[150] md:hidden" x-cloak>
            <div x-show="filtersOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="filtersOpen = false"
                class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

            <div x-show="filtersOpen" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
                x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-y-0"
                x-transition:leave-end="translate-y-full"
                class="absolute bottom-0 inset-x-0 bg-white rounded-t-[32px] shadow-2xl overflow-hidden max-h-[85vh] flex flex-col">

                <div class="h-1.5 w-12 bg-slate-200 rounded-full mx-auto mt-3 mb-2 flex-shrink-0"></div>

                <div class="px-6 py-2 flex items-center justify-between flex-shrink-0 border-b border-slate-50">
                    <h3 class="text-lg font-black text-slate-900">Filtres avancés</h3>
                    <button @click="filtersOpen = false" class="p-2 text-slate-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto space-y-6">
                    <form action="{{ route('sales.index') }}" method="GET" id="mobileFilterForm">
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Client</label>
                                <div class="relative">
                                    <select name="client_id"
                                        class="h-12 w-full pl-4 pr-10 bg-slate-50 border-none rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500/10 transition-all appearance-none cursor-pointer">
                                        <option value="">Tous les clients</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    <span
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Début
                                    de période</label>
                                <input type="date" name="date_start" value="{{ request('date_start') }}"
                                    class="h-12 w-full px-4 bg-slate-50 border-none rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500/10 transition-all">
                            </div>

                            <div>
                                <label
                                    class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Fin
                                    de période</label>
                                <input type="date" name="date_end" value="{{ request('date_end') }}"
                                    class="h-12 w-full px-4 bg-slate-50 border-none rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500/10 transition-all">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="p-6 bg-white border-t border-slate-50 flex items-center space-x-3 flex-shrink-0">
                    <a href="{{ route('sales.index') }}"
                        class="flex-1 h-12 bg-slate-100 text-slate-600 rounded-2xl font-bold text-sm flex items-center justify-center active:scale-95 transition-all">
                        Tout effacer
                    </a>
                    <button type="submit" form="mobileFilterForm"
                        class="flex-[2] h-12 bg-slate-900 text-white rounded-2xl font-bold text-sm shadow-lg shadow-slate-200 active:scale-95 transition-all uppercase tracking-widest">
                        Appliquer
                    </button>
                </div>
            </div>
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left font-bold text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-400 uppercase tracking-wider">N° Vente</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-400 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-400 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-400 uppercase tracking-wider">Méthode</th>
                        <th class="px-6 py-4 text-right font-bold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($sales as $sale)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                {{ $sale->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-blue-600">{{ $sale->sale_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800">
                                {{ $sale->client->name ?? 'Client Occasionnel' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                {{ number_format($sale->total, 0, '.', ' ') }} {{ setting('currency') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap uppercase text-[10px] font-bold">
                                <span
                                    class="px-2 py-0.5 rounded {{ $sale->payment_method == 'espèces' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $sale->payment_method }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                                <a href="{{ route('sales.show', $sale) }}"
                                    class="inline-flex p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                    title="Détails">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('sales.pdf', $sale) }}"
                                    class="inline-flex p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                    title="Télécharger Factures">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 9h3m-3 4h6m-6 4h6" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">Aucune vente
                                enregistrée
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $sales->links() }}
            </div>
        </div>

        <!-- Mobile Sales Cards -->
        <div class="md:hidden space-y-4 pb-20">
            @forelse($sales as $sale)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-slate-50 flex items-center justify-between">
                        <div>
                            <span
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">{{ $sale->created_at->format('d M Y à H:i') }}</span>
                            <h4 class="text-sm font-bold text-blue-600">{{ $sale->sale_number }}</h4>
                        </div>
                        <span
                            class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $sale->payment_method == 'espèces' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $sale->payment_method }}
                        </span>
                    </div>
                    <div class="p-4 flex items-center justify-between bg-slate-50/30">
                        <div class="flex items-center space-x-3">
                            <div
                                class="h-8 w-8 bg-white rounded-lg flex items-center justify-center text-slate-400 border border-slate-100">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <span
                                class="text-[13px] font-medium text-slate-700">{{ $sale->client->name ?? 'Client Occasionnel' }}</span>
                        </div>
                        <div class="text-right">
                            <span
                                class="text-[14px] font-black text-slate-900">{{ number_format($sale->total, 0, '.', ' ') }}
                                Ar</span>
                        </div>
                    </div>
                    <div class="p-3 bg-white flex items-center justify-around border-t border-slate-100">
                        <a href="{{ route('sales.show', $sale) }}"
                            class="flex items-center space-x-2 text-slate-500 font-bold text-xs uppercase tracking-wider py-1 px-3 rounded-lg hover:bg-slate-50">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span>Détails</span>
                        </a>
                        <div class="h-4 w-px bg-slate-100"></div>
                        <a href="{{ route('sales.pdf', $sale) }}"
                            class="flex items-center space-x-2 text-slate-500 font-bold text-xs uppercase tracking-wider py-1 px-3 rounded-lg hover:bg-slate-50">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2zM9 9h3m-3 4h6m-6 4h6" />
                            </svg>
                            <span>Facture</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-slate-400 italic bg-white rounded-2xl border border-slate-100">
                    Aucune vente enregistrée
                </div>
            @endforelse

            <div class="mt-4">
                {{ $sales->links() }}
            </div>
        </div>
    </div>
@endsection
