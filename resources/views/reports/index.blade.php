@extends('layouts.app')

@section('page-title', 'Rapports & Statistiques')

@section('content')
    <div class="space-y-6">
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm text-center">
            <div class="mx-auto w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Rapports & Analyses</h2>
            <p class="text-gray-500 mt-2 italic">Ce module est en cours de finalisation. Utilisez l'export Excel dans les
                modules Ventes et Produits pour vos rapports actuels.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-gray-800 mb-4">Ventes par période</h3>
                <div
                    class="h-48 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-400 border border-dashed">
                    Indicateurs bientôt disponibles
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-gray-800 mb-4">Top Produits</h3>
                <div
                    class="h-48 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-400 border border-dashed">
                    Classement bientôt disponible
                </div>
            </div>
        </div>
    </div>
@endsection
