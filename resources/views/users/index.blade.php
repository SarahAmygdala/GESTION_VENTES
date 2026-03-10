@extends('layouts.app')

@section('page-title', 'Utilisateurs')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="h-14 w-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shadow-sm">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Gestion de l'Équipe</h2>
                    <p class="text-sm text-slate-500 font-medium">
                        {{ $users->total() }} collaborateurs accèdent au système
                    </p>
                </div>
            </div>
            <a href="{{ route('users.create') }}"
                class="h-12 px-6 bg-indigo-600 text-white rounded-xl font-black shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center text-sm uppercase tracking-wider active:scale-95">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Nouvel Utilisateur
            </a>
        </div>

        <!-- Table (Desktop) / Cards (Mobile) -->
        <div class="space-y-4">
            <!-- Desktop Table -->
            <div class="hidden md:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Membre
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Rôle
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Statut
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 italic">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full object-cover border"
                                            src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                                            alt="">
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-800">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($user->active)
                                        <span class="flex items-center text-green-600 text-xs font-bold">
                                            <span class="h-2 w-2 rounded-full bg-green-500 mr-2"></span> Actif
                                        </span>
                                    @else
                                        <span class="flex items-center text-red-400 text-xs font-bold">
                                            <span class="h-2 w-2 rounded-full bg-red-400 mr-2"></span> Inactif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                            @submit.prevent="$dispatch('confirm', { title: 'Suppression', message: 'Voulez-vous vraiment supprimer cet utilisateur ?', callback: () => $el.submit() })">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all {{ $user->id === Auth::id() ? 'opacity-20 cursor-not-allowed' : '' }}"
                                                {{ $user->id === Auth::id() ? 'disabled' : '' }}>
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards Stack -->
            <div class="md:hidden space-y-4 pb-24 italic">
                @foreach ($users as $user)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden p-4">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <img class="h-12 w-12 rounded-2xl object-cover border border-slate-100"
                                    src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                                    alt="">
                                <div class="ml-4">
                                    <div class="text-[14px] font-bold text-gray-800">{{ $user->name }}</div>
                                    <div class="text-[11px] text-gray-400">{{ $user->email }}</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-1">
                                <a href="{{ route('users.edit', $user) }}"
                                    class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                @if ($user->id !== Auth::id())
                                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                                        @submit.prevent="$dispatch('confirm', { title: 'Suppression', message: 'Supprimer ce membre ?', callback: () => $el.submit() })">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-slate-300 hover:text-red-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t border-slate-50">
                            <span
                                class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $user->role }}
                            </span>
                            @if ($user->active)
                                <span class="flex items-center text-green-600 text-[11px] font-bold">
                                    <span class="h-1.5 w-1.5 rounded-full bg-green-500 mr-2"></span> Actif
                                </span>
                            @else
                                <span class="flex items-center text-red-400 text-[11px] font-bold">
                                    <span class="h-1.5 w-1.5 rounded-full bg-red-400 mr-2"></span> Inactif
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop Pagination -->
            <div class="hidden md:block px-6 py-4 bg-gray-50 border-t border-gray-100 italic">
                {{ $users->links() }}
            </div>
            <!-- Mobile Pagination -->
            <div class="md:hidden mt-4 italic">
                {{ $users->links() }}
            </div>
        </div>

        <!-- Floating Action Button (Mobile Only) -->
        <div class="md:hidden fixed bottom-24 right-6 z-[100]">
            <a href="{{ route('users.create') }}"
                class="flex items-center justify-center h-14 w-14 bg-indigo-600 text-white rounded-2xl shadow-2xl shadow-indigo-500/50 active:scale-90 transition-transform">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </a>
        </div>
    </div>
    </div>
@endsection
