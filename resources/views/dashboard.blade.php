@extends('layouts.app')

@section('page-title', 'Tableau de Bord')

@section('content')
    <div class="space-y-6">
        <div class="grid grid-cols-2 gap-3 md:gap-5 lg:grid-cols-4">
            <div
                class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-2xl p-4 md:p-6 text-center md:text-left flex flex-col items-center md:items-start">
                <div class="p-2.5 md:p-3 rounded-xl bg-blue-50 text-blue-600 mb-2 md:mb-0">
                    <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] md:text-sm font-black text-slate-400 uppercase tracking-widest truncate">Ventes
                        (Jour)</p>
                    <p class="text-xl md:text-3xl font-black text-slate-800 tracking-tight">
                        {{ number_format($stats['total_sales_today'], 0, '.', ' ') }} <span
                            class="text-xs md:text-lg opacity-50">{{ setting('currency') }}</span>
                    </p>
                </div>
            </div>

            <div
                class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-2xl p-4 md:p-6 text-center md:text-left flex flex-col items-center md:items-start">
                <div class="p-2.5 md:p-3 rounded-xl bg-green-50 text-green-600 mb-2 md:mb-0">
                    <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] md:text-sm font-black text-slate-400 uppercase tracking-widest truncate">Volume
                    </p>
                    <p class="text-xl md:text-2xl font-black text-slate-800 tracking-tight">
                        {{ $stats['sales_count_today'] }}</p>
                </div>
            </div>

            <div
                class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-2xl p-4 md:p-6 text-center md:text-left flex flex-col items-center md:items-start">
                <div class="p-2.5 md:p-3 rounded-xl bg-red-50 text-red-600 mb-2 md:mb-0">
                    <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] md:text-sm font-black text-slate-400 uppercase tracking-widest truncate">Stock
                        Faible</p>
                    <p class="text-xl md:text-2xl font-black text-slate-800 tracking-tight">{{ $stats['low_stock_count'] }}
                    </p>
                </div>
            </div>

            <div
                class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-2xl p-4 md:p-6 text-center md:text-left flex flex-col items-center md:items-start">
                <div class="p-2.5 md:p-3 rounded-xl bg-purple-50 text-purple-600 mb-2 md:mb-0">
                    <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] md:text-sm font-black text-slate-400 uppercase tracking-widest truncate">Clients
                    </p>
                    <p class="text-xl md:text-2xl font-black text-slate-800 tracking-tight">{{ $stats['total_clients'] }}
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
            <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-4 md:p-6">
                <h3 class="text-sm md:text-lg font-black text-slate-800 uppercase tracking-widest mb-4">Évolution Ventes
                </h3>
                <div class="h-44 md:h-64">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Alertes Stock</h3>
                    <a href="{{ route('products.index') }}"
                        class="text-sm text-blue-600 hover:text-blue-700 font-medium">Tout voir</a>
                </div>
                <div class="flow-root">
                    <ul role="list" class="-my-5 divide-y divide-gray-100">
                        @forelse($low_stock_products as $product)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                                        <p class="text-sm text-gray-500 truncate">{{ $product->category->name }}</p>
                                    </div>
                                    <div>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Stock: {{ $product->stock }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="py-8 text-center text-gray-500 italic text-sm">Aucune alerte stock</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesData = @json($sales_chart);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: salesData.map(d => d.date),
                    datasets: [{
                        label: 'Ventes (Ar)',
                        data: salesData.map(d => d.total),
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
