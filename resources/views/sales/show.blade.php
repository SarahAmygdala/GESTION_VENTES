@extends('layouts.app')

@section('page-title', 'Détails Vente #' . $sale->sale_number)

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('sales.index') }}"
                    class="p-2 bg-white border border-gray-100 rounded-xl text-gray-400 hover:text-gray-600 transition-all shadow-sm">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="text-xl font-bold text-gray-800 tracking-tight">Vente Numero : {{ $sale->sale_number }}</h2>
            </div>
            <a href="{{ route('sales.pdf', $sale) }}"
                class="bg-blue-600 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Télécharger Facture (PDF)
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-6 bg-gray-50/50 border-b border-gray-100">
                        <h3 class="font-bold text-gray-800">Articles vendus</h3>
                    </div>
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-white text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Désignation</th>
                                <th class="px-6 py-4">Qte</th>
                                <th class="px-6 py-4">Prix Unitaire</th>
                                <th class="px-6 py-4 text-right">Sous-total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @foreach ($sale->items as $item)
                                <tr>
                                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $item->product_name }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ number_format($item->unit_price, 0, '.', ' ') }}
                                        {{ setting('currency') }}</td>
                                    <td class="px-6 py-4 text-right font-bold text-gray-900">
                                        {{ number_format($item->subtotal, 0, '.', ' ') }} {{ setting('currency') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-gray-800 mb-4 border-b border-gray-50 pb-2">Résumé Vente</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Sous-total :</span>
                            <span class="font-semibold text-gray-800">{{ number_format($sale->subtotal, 0, '.', ' ') }}
                                {{ setting('currency') }}</span>
                        </div>
                        @if ($sale->discount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Remise ({{ $sale->discount }}%) :</span>
                                <span class="font-semibold text-red-500">-
                                    {{ number_format($sale->discount_amount, 0, '.', ' ') }}
                                    {{ setting('currency') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                            <span class="font-bold text-gray-800 uppercase text-xs">Total :</span>
                            <span class="text-xl font-black text-blue-600">{{ number_format($sale->total, 0, '.', ' ') }}
                                {{ setting('currency') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-gray-800 mb-4 border-b border-gray-50 pb-2">Informations</h3>
                    <div class="space-y-4 text-sm">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Client</p>
                            <p class="font-semibold text-gray-800">{{ $sale->client->name ?? 'Client Occasionnel' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Caissier</p>
                            <p class="font-semibold text-gray-800">{{ $sale->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Paiement</p>
                            <p class="font-semibold text-gray-800 uppercase">{{ $sale->payment_method }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Reçu / Monnaie</p>
                            <p class="font-semibold text-gray-800">{{ number_format($sale->amount_paid, 0, '.', ' ') }} /
                                {{ number_format($sale->change_amount, 0, '.', ' ') }} Ar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
