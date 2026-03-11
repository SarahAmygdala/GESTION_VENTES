@extends('layouts.app')

@section('page-title', 'Tableau de Bord')

@section('content')
    <div class="space-y-6" x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)">

        {{-- ═══════════════ KPI Cards ═══════════════ --}}
        <div class="grid grid-cols-2 gap-3 md:gap-5 lg:grid-cols-4"
            x-show="show"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0">

            {{-- Card 1: CA Jour --}}
            <div class="relative overflow-hidden rounded-2xl p-5 md:p-6 text-white shadow-lg shadow-blue-200/50"
                style="background: linear-gradient(135deg, #2563EB 0%, #3B82F6 50%, #60A5FA 100%);">
                <div class="absolute -top-4 -right-4 h-24 w-24 rounded-full bg-white/10"></div>
                <div class="absolute -bottom-6 -right-2 h-32 w-32 rounded-full bg-white/5"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest bg-white/20 px-2 py-1 rounded-lg">Aujourd'hui</span>
                    </div>
                    <p class="text-[11px] font-bold uppercase tracking-widest text-blue-100 mb-1">Chiffre d'affaires</p>
                    <p class="text-2xl md:text-3xl font-black leading-none">
                        {{ number_format($stats['total_sales_today'], 0, '.', ' ') }}
                        <span class="text-sm font-bold text-blue-200">{{ setting('currency') }}</span>
                    </p>
                </div>
            </div>

            {{-- Card 2: Volume Ventes --}}
            <div class="relative overflow-hidden rounded-2xl p-5 md:p-6 text-white shadow-lg shadow-emerald-200/50"
                style="background: linear-gradient(135deg, #059669 0%, #10B981 50%, #34D399 100%);">
                <div class="absolute -top-4 -right-4 h-24 w-24 rounded-full bg-white/10"></div>
                <div class="absolute -bottom-6 -right-2 h-32 w-32 rounded-full bg-white/5"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest bg-white/20 px-2 py-1 rounded-lg">Ventes</span>
                    </div>
                    <p class="text-[11px] font-bold uppercase tracking-widest text-emerald-100 mb-1">Transactions</p>
                    <p class="text-2xl md:text-3xl font-black leading-none">
                        {{ $stats['sales_count_today'] }}
                        <span class="text-sm font-bold text-emerald-200">commandes</span>
                    </p>
                </div>
            </div>

            {{-- Card 3: Stock Faible --}}
            <div class="relative overflow-hidden rounded-2xl p-5 md:p-6 text-white shadow-lg shadow-red-200/50"
                style="background: linear-gradient(135deg, #DC2626 0%, #EF4444 50%, #F87171 100%);">
                <div class="absolute -top-4 -right-4 h-24 w-24 rounded-full bg-white/10"></div>
                <div class="absolute -bottom-6 -right-2 h-32 w-32 rounded-full bg-white/5"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest bg-white/20 px-2 py-1 rounded-lg">Alerte</span>
                    </div>
                    <p class="text-[11px] font-bold uppercase tracking-widest text-red-100 mb-1">Stock faible</p>
                    <p class="text-2xl md:text-3xl font-black leading-none">
                        {{ $stats['low_stock_count'] }}
                        <span class="text-sm font-bold text-red-200">produits</span>
                    </p>
                </div>
            </div>

            {{-- Card 4: Clients --}}
            <div class="relative overflow-hidden rounded-2xl p-5 md:p-6 text-white shadow-lg shadow-violet-200/50"
                style="background: linear-gradient(135deg, #7C3AED 0%, #8B5CF6 50%, #A78BFA 100%);">
                <div class="absolute -top-4 -right-4 h-24 w-24 rounded-full bg-white/10"></div>
                <div class="absolute -bottom-6 -right-2 h-32 w-32 rounded-full bg-white/5"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest bg-white/20 px-2 py-1 rounded-lg">Total</span>
                    </div>
                    <p class="text-[11px] font-bold uppercase tracking-widest text-violet-100 mb-1">Clients</p>
                    <p class="text-2xl md:text-3xl font-black leading-none">
                        {{ $stats['total_clients'] }}
                        <span class="text-sm font-bold text-violet-200">enregistrés</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- ═══════════════ Charts & Alerts ═══════════════ --}}
        <div class="grid grid-cols-1 gap-5 lg:grid-cols-5"
            x-show="show"
            x-transition:enter="transition ease-out duration-700 delay-150"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0">

            {{-- Sales Chart (3/5 width) --}}
            <div class="lg:col-span-3 bg-white shadow-sm border border-slate-100 rounded-2xl overflow-hidden">
                <div class="p-5 flex items-center justify-between border-b border-slate-50">
                    <div>
                        <h3 class="text-[15px] font-black text-slate-800 uppercase tracking-wider">Évolution des Ventes</h3>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">7 derniers jours</p>
                    </div>
                    <div class="h-9 w-9 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                        </svg>
                    </div>
                </div>
                <div class="p-5">
                    <div class="h-52 md:h-64">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Stock Alerts (2/5 width) --}}
            <div class="lg:col-span-2 bg-white shadow-sm border border-slate-100 rounded-2xl overflow-hidden">
                <div class="p-5 flex items-center justify-between border-b border-slate-50">
                    <div>
                        <h3 class="text-[15px] font-black text-slate-800 uppercase tracking-wider">Alertes Stock</h3>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">Produits critiques</p>
                    </div>
                    <a href="{{ route('products.index') }}"
                        class="text-xs font-bold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                        Voir tout
                    </a>
                </div>
                <div class="divide-y divide-slate-50 max-h-[320px] overflow-y-auto custom-scrollbar">
                    @forelse($low_stock_products as $product)
                        <div class="flex items-center p-4 hover:bg-red-50/30 transition-colors group">
                            <div class="h-9 w-9 rounded-xl flex items-center justify-center flex-shrink-0 mr-3"
                                style="background: {{ $product->category->color ?? '#EF4444' }}15;">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    style="color: {{ $product->category->color ?? '#EF4444' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[13px] font-bold text-slate-800 truncate">{{ $product->name }}</p>
                                <p class="text-[11px] text-slate-400 font-medium truncate">{{ $product->category->name }}</p>
                            </div>
                            <span class="ml-2 flex-shrink-0 text-xs font-black px-2.5 py-1 rounded-lg
                                {{ $product->stock <= 0 ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $product->stock <= 0 ? 'Rupture' : 'Stk: '.$product->stock }}
                            </span>
                        </div>
                    @empty
                        <div class="p-10 text-center">
                            <div class="h-14 w-14 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <svg class="h-7 w-7 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <p class="text-sm font-bold text-slate-500">Tous les stocks sont OK</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesData = @json($sales_chart);

            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.25)');
            gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: salesData.map(d => d.date),
                    datasets: [{
                        label: 'Ventes',
                        data: salesData.map(d => d.total),
                        borderColor: '#2563EB',
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#2563EB',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#94a3b8',
                            bodyColor: '#fff',
                            bodyFont: { weight: 'bold', size: 14 },
                            padding: 12,
                            cornerRadius: 12,
                            callbacks: {
                                label: function(ctx) {
                                    return ' ' + new Intl.NumberFormat('fr-FR').format(ctx.raw) + ' {{ setting('currency') }}';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                            ticks: { 
                                font: { size: 11, weight: 'bold' }, 
                                color: '#94a3b8',
                                callback: v => new Intl.NumberFormat('fr-FR', { notation: 'compact' }).format(v)
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11, weight: 'bold' }, color: '#94a3b8' }
                        }
                    }
                }
            });
        });
    </script>
@endsection
