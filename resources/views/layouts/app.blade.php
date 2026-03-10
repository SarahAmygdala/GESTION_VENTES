<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ setting('store_name', config('app.name', 'Mi Varotra')) }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Flottaison de l'icône centrale */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-4px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>

<body class="font-sans antialiased bg-[#F8FAFC] text-[#111827] h-full" x-data="{
    sidebarOpen: false,
    sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
    toasts: [],
    resModal: {
        open: false,
        title: '',
        message: '',
        type: 'success'
    },
    confModal: {
        open: false,
        title: '',
        message: '',
        onConfirm: null
    },
    showToast(message, type = 'success') {
        const id = Date.now();
        this.toasts.push({
            id,
            message,
            type,
            visible: true
        });
        setTimeout(() => {
            const toast = this.toasts.find(t => t.id === id);
            if (toast) toast.visible = false;
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }, 500);
        }, 3000);
    },
    showModal(title, message, type = 'success') {
        this.resModal.title = title;
        this.resModal.message = message;
        this.resModal.type = type;
        this.resModal.open = true;
    },
    askConfirm(title, message, callback) {
        this.confModal.title = title;
        this.confModal.message = message;
        this.confModal.onConfirm = callback;
        this.confModal.open = true;
    }
}" x-init="$watch('sidebarCollapsed', value => localStorage.setItem('sidebarCollapsed', value));
@if(session('success'))
showModal('Succès !', '{{ session('success') }}', 'success');
@endif
@if(session('error'))
showModal('Oups !', '{{ session('error') }}', 'error');
@endif"
    @toast.window="showToast($event.detail.message, $event.detail.type || 'success')"
    @modal.window="showModal($event.detail.title, $event.detail.message, $event.detail.type || 'success')"
    @confirm.window="askConfirm($event.detail.title, $event.detail.message, $event.detail.callback)">

    <div class="flex h-full overflow-hidden bg-white relative">
        <!-- Sidebar desktop (240px Fixed) -->
        <aside
            class="hidden md:flex md:flex-col fixed inset-y-0 z-30 transition-all duration-300 ease-in-out bg-white border-r border-slate-200 shadow-sm"
            :class="sidebarCollapsed ? 'w-20' : 'w-[240px]'">

            <!-- Navigation -->
            <div class="pt-8 mb-10 flex flex-col items-center justify-center transition-all duration-300"
                :class="sidebarCollapsed ? 'px-0' : 'px-6 items-start'">
                <div class="flex items-center flex-shrink-0">
                    <!-- Animated Cart Icon -->
                    <div
                        class="h-10 w-10 flex items-center justify-center bg-[#2563EB] rounded-2xl shadow-lg shadow-blue-100 text-white flex-shrink-0 animate-float">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1.5"></circle>
                            <circle cx="20" cy="21" r="1.5"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-black text-blue-600 tracking-tight ml-2 truncate max-w-[140px]"
                        x-show="!sidebarCollapsed" x-transition>{{ setting('store_name', 'Mi Varotra') }}</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-3 space-y-1.5 overflow-y-auto custom-scrollbar">
                @include('layouts.sidebar-links')
            </nav>

            <!-- User Info Block -->
            <div class="mt-auto border-t border-slate-100 transition-all duration-300"
                :class="sidebarCollapsed ? 'p-2' : 'p-4'">
                <div class="bg-slate-50 rounded-[14px] flex items-center transition-colors hover:bg-slate-100 overflow-hidden"
                    :class="sidebarCollapsed ? 'p-2 justify-center' : 'p-3'">
                    <img class="h-9 w-9 rounded-full object-cover border-2 border-white shadow-sm flex-shrink-0"
                        src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=2563EB&background=EFF6FF' }}"
                        alt="">
                    <div class="ml-3 flex-1 min-w-0" x-show="!sidebarCollapsed" x-transition>
                        <p class="text-[14px] font-bold text-[#111827] truncate leading-tight">{{ Auth::user()->name }}
                        </p>
                        <p class="text-[12px] text-[#6B7280] truncate capitalize">{{ Auth::user()->role }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex flex-col flex-1 min-w-0 h-full transition-all duration-300 ease-in-out"
            :class="sidebarCollapsed ? 'md:ml-20' : 'md:ml-[240px]'">

            <!-- Header (Topbar) -->
            <header
                class="h-[72px] flex items-center flex-shrink-0 z-20 px-8 bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0">

                <!-- Desktop Sidebar Toggle -->
                <button @click="sidebarCollapsed = !sidebarCollapsed"
                    class="hidden md:flex p-2 rounded-lg text-slate-400 hover:text-[#2563EB] hover:bg-blue-50 transition-all mr-4">
                    <svg class="h-6 w-6 transition-transform duration-300" :class="sidebarCollapsed ? 'rotate-180' : ''"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M11 19l-7-7 7-7m8 14l-7-7 7-7" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>

                <div class="flex-1 flex items-center overflow-hidden">
                    <h2 class="text-[22px] font-bold text-[#111827] truncate leading-none">
                        @yield('page-title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center space-x-4">
                    <span
                        class="text-[12px] font-bold text-[#6B7280] bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100 whitespace-nowrap">
                        {{ now()->translatedFormat('d F Y') }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="p-2.5 text-[#6B7280] hover:text-[#EF4444] hover:bg-red-50 rounded-xl transition-all group">
                            <svg class="h-5 w-5 group-hover:rotate-180 transition-transform duration-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Application Content -->
            <main
                class="flex-1 overflow-y-auto pb-20 md:pb-0 @yield('main-classes', 'p-8') custom-scrollbar overflow-x-hidden flex flex-col">
                <div class="flex-grow">
                    @yield('content')
                    {{ $slot ?? '' }}
                </div>

                <!-- Footer -->
                <footer class="mt-auto pt-8 pb-2 text-center text-[13px] font-medium text-slate-500">
                    &copy; 2026Sarah. Tous droits réservés.
                </footer>
            </main>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div x-show="sidebarOpen" x-cloak class="md:hidden fixed inset-0 z-40 bg-black/20 backdrop-blur-sm"
        @click="sidebarOpen = false"></div>
    <aside x-show="sidebarOpen" x-cloak x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="md:hidden fixed inset-y-0 left-0 w-[280px] bg-white z-50 flex flex-col shadow-2xl">
        <!-- Content mirrored from Sidebar desktop -->
        <div class="p-8 border-b border-[#F3F4F6]">
            <h2 class="text-title text-[#2563EB]">{{ setting('store_name', 'Mi Varotra') }}</h2>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-1.5">
            @include('layouts.sidebar-links')
        </nav>
    </aside>

    <!-- Global Toast Notifications (Discreet) -->
    <div class="fixed bottom-6 right-6 z-[100] flex flex-col space-y-3 pointer-events-none">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.visible" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
                class="pointer-events-auto flex items-center p-4 rounded-xl shadow-lg min-w-[280px] bg-white border border-slate-100 transition-all">
                <div class="h-8 w-8 rounded-full flex items-center justify-center mr-3"
                    :class="toast.type === 'success' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'">
                    <template x-if="toast.type === 'success'">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </template>
                    <template x-if="toast.type === 'error'">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </template>
                </div>
                <div class="flex-1">
                    <p class="text-[13px] font-bold text-slate-700" x-text="toast.message"></p>
                </div>
            </div>
        </template>
    </div>

    <!-- Modals -->
    <div x-show="resModal.open" x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center p-5 text-center">
        <!-- Backdrop -->
        <div x-show="resModal.open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="resModal.open = false"
            class="absolute inset-0 bg-[#0F172A]/40 backdrop-blur-[6px]"></div>

        <!-- Modal Content -->
        <div x-show="resModal.open" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="scale-90 opacity-0 translate-y-4"
            x-transition:enter-end="scale-100 opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="scale-100 opacity-100 translate-y-0"
            x-transition:leave-end="scale-90 opacity-0 translate-y-4"
            class="relative bg-white rounded-[32px] shadow-2xl p-10 max-w-[420px] w-full border border-slate-100">

            <div class="flex flex-col items-center">
                <div class="h-20 w-20 rounded-full flex items-center justify-center mb-6"
                    :class="resModal.type === 'success' ? 'bg-green-50 text-[#16A34A]' : 'bg-red-50 text-[#DC2626]'">
                    <template x-if="resModal.type === 'success'">
                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </template>
                    <template x-if="resModal.type === 'error'">
                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </template>
                </div>

                <h3 class="text-[20px] font-black leading-tight text-slate-900 mb-2 uppercase tracking-tight"
                    x-text="resModal.title"></h3>
                <p class="text-[15px] font-medium text-slate-500 leading-relaxed" x-text="resModal.message"></p>
            </div>

            <button @click="resModal.open = false"
                class="mt-8 w-full h-[54px] rounded-2xl font-black text-[14px] uppercase tracking-widest transition-all active:scale-95 text-white"
                :class="resModal.type === 'success' ? 'bg-[#16A34A] shadow-lg shadow-green-100 hover:bg-[#15803D]' :
                    'bg-[#DC2626] shadow-lg shadow-red-100 hover:bg-[#B91C1C]'">
                Fermer
            </button>
        </div>
    </div>

    <!-- Global Confirmation Modal -->
    <div x-show="confModal.open" x-cloak class="fixed inset-0 z-[110] flex items-center justify-center p-5">
        <!-- Backdrop -->
        <div x-show="confModal.open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="confModal.open = false"
            class="absolute inset-0 bg-[#0F172A]/60 backdrop-blur-[8px]"></div>

        <!-- Modal Card -->
        <div x-show="confModal.open" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="scale-95 opacity-0 translate-y-8"
            x-transition:enter-end="scale-100 opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="scale-100 opacity-100 translate-y-0"
            x-transition:leave-end="scale-95 opacity-0 translate-y-8"
            class="relative bg-white rounded-[32px] shadow-2xl p-8 max-w-[400px] w-full border border-slate-100 text-center pointer-events-auto">

            <!-- Icon -->
            <div class="h-16 w-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>

            <h3 class="text-[20px] font-black text-slate-900 mb-2" x-text="confModal.title"></h3>
            <p class="text-[15px] text-slate-500 font-medium mb-8 leading-relaxed" x-text="confModal.message"></p>

            <div class="flex space-x-3">
                <button @click="confModal.open = false"
                    class="flex-1 h-[54px] rounded-2xl bg-slate-100 text-slate-600 font-bold text-[14px] uppercase tracking-wider hover:bg-slate-200 transition-all active:scale-95">
                    Annuler
                </button>
                <button @click="confModal.onConfirm(); confModal.open = false"
                    class="flex-1 h-[54px] rounded-2xl bg-[#EF4444] text-white font-black text-[14px] uppercase tracking-wider shadow-lg shadow-red-100 hover:bg-[#DC2626] transition-all active:scale-95">
                    Confirmer
                </button>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation (Mobile Only) -->
    <nav
        class="md:hidden fixed bottom-0 left-0 right-0 py-2 pb-[env(safe-area-inset-bottom,16px)] bg-white border-t hover:bg-white shadow-[0_-4px_20px_-10px_rgba(0,0,0,0.1)] z-[120] pointer-events-auto">
        <div class="flex justify-around items-center h-16 px-2">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
                class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-500 hover:text-slate-900' }}">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="{{ request()->routeIs('dashboard') ? '2.5' : '2' }}"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-[10px] font-medium">Accueil</span>
            </a>

            <!-- POS -->
            <a href="{{ route('pos.index') }}"
                class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('pos.index') ? 'text-blue-600' : 'text-slate-500 hover:text-slate-900' }}">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="{{ request()->routeIs('pos.index') ? '2.5' : '2' }}"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="text-[10px] font-medium">Caisse</span>
            </a>

            <!-- Products -->
            <a href="{{ route('products.index') }}"
                class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('products.*') ? 'text-blue-600' : 'text-slate-500 hover:text-slate-900' }}">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="{{ request()->routeIs('products.*') ? '2.5' : '2' }}"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span class="text-[10px] font-medium">Produits</span>
            </a>

            <!-- Clients -->
            <a href="{{ route('clients.index') }}"
                class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('clients.*') ? 'text-blue-600' : 'text-slate-500 hover:text-slate-900' }}">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="{{ request()->routeIs('clients.*') ? '2.5' : '2' }}"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="text-[10px] font-medium">Clients</span>
            </a>

            <!-- Sales History -->
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('sales.index') }}"
                    class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('sales.index') ? 'text-blue-600' : 'text-slate-500 hover:text-slate-900' }}">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="{{ request()->routeIs('sales.index') ? '2.5' : '2' }}"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <span class="text-[10px] font-medium">Ventes</span>
                </a>
            @endif
        </div>
    </nav>
</body>

</html>
