<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-white/50 group-focus-within:text-white transition-colors" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <!-- Glassmorphism styling -->
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                autocomplete="username"
                class="block w-full h-[52px] pl-12 pr-4 bg-white/10 backdrop-blur-md border border-white/20 text-white placeholder-white/60 focus:bg-white/20 focus:border-white/50 focus:ring-0 transition-all outline-none text-sm uppercase font-medium caret-pink-400 hover:bg-white/15"
                placeholder="ADRESSE E-MAIL">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-pink-300 text-xs font-bold" />
        </div>

        <div class="relative group pt-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-white/50 group-focus-within:text-white transition-colors" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="block w-full h-[52px] pl-12 pr-4 bg-white/10 backdrop-blur-md border border-white/20 text-white placeholder-white/60 focus:bg-white/20 focus:border-white/50 focus:ring-0 transition-all outline-none text-sm uppercase font-medium caret-pink-400 hover:bg-white/15"
                placeholder="MOT DE PASSE">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-pink-300 text-xs font-bold" />
        </div>

        <div class="hidden">
            <input id="remember_me" type="checkbox" name="remember" checked>
        </div>

        <div class="pt-4 md:pt-8 relative group">
            <div
                class="absolute -inset-1 bg-gradient-to-r from-blue-600 via-pink-500 to-indigo-600 rounded-lg blur opacity-40 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 animate-gradient-xy">
            </div>

            <button type="submit"
                class="relative w-full h-[54px] bg-white text-blue-900 font-extrabold uppercase tracking-[0.2em] text-[15px] rounded border border-white/50 transition-all duration-300 hover:scale-[1.02] shadow-[0_8px_30px_rgb(0,0,0,0.15)] active:scale-95 flex items-center justify-center space-x-2">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-800 to-indigo-700">
                    {{ __('CONNEXION') }}
                </span>
                <svg class="w-5 h-5 text-indigo-600 group-hover:translate-x-1 transition-transform duration-300"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>
        </div>

        <div class="flex items-center justify-center mt-8">
            @if (Route::has('password.request'))
                <a class="text-[12px] text-white/50 hover:text-white transition-colors duration-300 font-medium tracking-widest uppercase"
                    href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>
    </form>

    <div class="mt-8 pt-6 border-t border-white/20">
        <form method="POST" action="{{ route('demo.login') }}">
            @csrf
            <button type="submit"
                class="w-full h-10 flex items-center justify-center space-x-2 border border-white/50 bg-transparent hover:bg-white/10 text-white font-medium uppercase tracking-wider text-xs transition-all">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span>Accès Démo</span>
            </button>
        </form>
    </div>
</x-guest-layout>
