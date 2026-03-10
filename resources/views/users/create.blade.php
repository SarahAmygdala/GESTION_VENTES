@extends('layouts.app')

@section('page-title', 'Nouvel Utilisateur')

@section('content')
    <div class="max-w-4xl mx-auto pb-24 md:pb-6" x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)">

        <!-- Header -->
        <div class="flex items-center justify-between mb-4 md:mb-6" x-show="show"
            x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center space-x-3 md:space-x-4">
                <a href="{{ route('users.index') }}"
                    class="h-9 w-9 md:h-10 md:w-10 bg-white text-slate-600 rounded-lg flex items-center justify-center border border-slate-200 shadow-sm hover:bg-slate-50 hover:text-blue-600 transition-all active:scale-95">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-slate-900 tracking-tight">Ajouter un membre</h2>
                </div>
            </div>
        </div>

        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-4 md:space-y-6" x-show="show"
                x-transition:enter="transition ease-out duration-500 delay-100"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

                <!-- Section: Identité -->
                <div class="bg-white p-5 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center">
                        <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mr-2">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        Identité & Rôle
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <!-- Nom Complet -->
                        <div class="col-span-1 md:col-span-1">
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nom Complet <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="John Doe"
                                class="h-11 w-full px-4 bg-slate-50 md:bg-white border border-slate-200 rounded-xl text-sm font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                        </div>

                        <!-- Email -->
                        <div class="col-span-1 md:col-span-1">
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Adresse E-mail <span
                                    class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required inputmode="email"
                                placeholder="email@exemple.com"
                                class="h-11 w-full px-4 bg-slate-50 md:bg-white border border-slate-200 rounded-xl text-sm font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rôle -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Rôle <span
                                    class="text-red-500">*</span></label>
                            <select name="role" required
                                class="h-11 w-full px-4 bg-slate-50 md:bg-white border border-slate-200 rounded-xl text-sm font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all appearance-none">
                                <option value="caissier">Caissier</option>
                                <option value="admin">Administrateur</option>
                            </select>
                        </div>

                        <!-- Photo -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Photo de profil</label>
                            <input type="file" name="photo"
                                class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer border border-slate-100 rounded-xl p-1.5">
                        </div>
                    </div>
                </div>

                <!-- Section: Sécurité -->
                <div class="bg-white p-5 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center">
                        <span class="w-6 h-6 rounded-lg bg-red-50 text-red-600 flex items-center justify-center mr-2">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        Sécurité du Compte
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Mot de passe <span
                                    class="text-red-500">*</span></label>
                            <input type="password" name="password" required
                                class="h-11 w-full px-4 bg-slate-50 md:bg-white border border-slate-200 rounded-xl text-sm font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Confirmation <span
                                    class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" required
                                class="h-11 w-full px-4 bg-slate-50 md:bg-white border border-slate-200 rounded-xl text-sm font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                        </div>
                    </div>

                    <div class="mt-6 flex items-center p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <input type="checkbox" name="active" id="active" value="1" checked
                            class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500 bg-white cursor-pointer transition-all">
                        <label for="active"
                            class="ml-3 text-sm font-bold text-slate-700 cursor-pointer select-none">Compte activé (peut se
                            connecter)</label>
                    </div>
                </div>
            </div>

            <!-- Action Bar (Desktop: Normal, Mobile: Sticky above Nav) -->
            <div class="mt-8 flex items-center justify-end space-x-3 md:relative fixed bottom-20 md:bottom-0 left-0 right-0 p-4 md:p-0 bg-white/90 backdrop-blur-sm md:bg-transparent border-t border-slate-100 md:border-none z-[110]"
                x-show="show" x-transition:enter="transition ease-out duration-500 delay-200"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <a href="{{ route('users.index') }}"
                    class="h-12 flex-1 md:flex-none md:h-10 px-6 flex items-center justify-center text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl md:rounded-lg font-bold md:font-medium text-sm transition-all active:scale-95">
                    Annuler
                </a>
                <button type="submit"
                    class="h-12 flex-[2] md:flex-none md:h-10 px-8 bg-blue-600 text-white rounded-xl md:rounded-lg font-black md:font-medium text-sm shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all active:scale-95 uppercase tracking-widest md:normal-case md:tracking-normal">
                    Créer le membre
                </button>
            </div>
        </form>
    </div>
@endsection
