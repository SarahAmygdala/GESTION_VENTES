@extends('layouts.app')

@section('page-title', 'Paramètres de la Boutique')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6" x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6" x-show="show"
            x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center space-x-4">
                <div
                    class="h-10 w-10 bg-white text-blue-600 rounded-lg flex items-center justify-center border border-slate-200 shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">Paramètres Généraux</h2>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('settings.update') }}" method="POST">
            @csrf

            <div class="bg-white p-6 md:p-8 rounded-xl border border-slate-200 shadow-sm box-border" x-show="show"
                x-transition:enter="transition ease-out duration-500 delay-100"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- Informations Boutique (Gauche) -->
                    <div class="col-span-2 md:col-span-1 space-y-6">
                        <div class="pb-2 border-b border-slate-100">
                            <h3 class="text-sm font-bold text-slate-800">Informations de la Boutique</h3>
                            <p class="text-xs text-slate-500 mt-1">Ces informations apparaîtront sur vos factures et tickets
                                PDF.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nom de la boutique <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="store_name" value="{{ $settings['store_name'] ?? 'Mi Varotra' }}"
                                required
                                class="h-11 w-full px-4 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder:text-slate-400">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Contact (Téléphone) <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="store_contact"
                                value="{{ $settings['store_contact'] ?? '+261 34 00 000 00' }}" required
                                class="h-11 w-full px-4 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder:text-slate-400">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Adresse physique</label>
                            <input type="text" name="store_address" value="{{ $settings['store_address'] ?? '' }}"
                                class="h-11 w-full px-4 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder:text-slate-400">
                        </div>
                    </div>

                    <!-- Préférences (Droite) -->
                    <div class="col-span-2 md:col-span-1 space-y-6">
                        <div class="pb-2 border-b border-slate-100">
                            <h3 class="text-sm font-bold text-slate-800">Préférences Régionales</h3>
                            <p class="text-xs text-slate-500 mt-1">Définissez la monnaie et la langue utilisées sur
                                l'interface.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Monnaie de base <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="currency" required
                                    class="h-11 w-full pl-4 pr-10 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all appearance-none cursor-pointer">
                                    <option value="Ar" {{ ($settings['currency'] ?? '') == 'Ar' ? 'selected' : '' }}>
                                        Ariary (Ar)</option>
                                    <option value="€" {{ ($settings['currency'] ?? '') == '€' ? 'selected' : '' }}>Euro
                                        (€)</option>
                                    <option value="$" {{ ($settings['currency'] ?? '') == '$' ? 'selected' : '' }}>
                                        Dollar ($)</option>
                                    <option value="Fr" {{ ($settings['currency'] ?? '') == 'Fr' ? 'selected' : '' }}>
                                        Francs (Fr)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Langue de l'interface <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="language" required
                                    class="h-11 w-full pl-4 pr-10 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all appearance-none cursor-pointer">
                                    <option value="fr" {{ ($settings['language'] ?? '') == 'fr' ? 'selected' : '' }}>
                                        Français</option>
                                    <option value="en" {{ ($settings['language'] ?? '') == 'en' ? 'selected' : '' }}>
                                        Anglais</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-6 flex items-center justify-end space-x-3" x-show="show"
                x-transition:enter="transition ease-out duration-500 delay-200"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <button type="submit"
                    class="h-10 px-6 bg-blue-600 text-white rounded-lg font-medium text-sm shadow-sm hover:bg-blue-700 transition-all active:scale-95 flex items-center">
                    Enregistrer les paramètres
                </button>
            </div>
        </form>
    </div>
@endsection
