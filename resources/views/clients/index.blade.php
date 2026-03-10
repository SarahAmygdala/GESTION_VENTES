@extends('layouts.app')

@section('page-title', 'Clients')

@section('content')
    <div class="space-y-6" x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4" x-show="show"
            x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center space-x-4">
                <div
                    class="h-12 w-12 md:h-14 md:w-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shadow-sm">
                    <svg class="h-6 w-6 md:h-8 md:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg md:text-2xl font-black text-slate-900 tracking-tight">Gestion des Clients</h2>
                    <p class="text-[11px] md:text-sm text-slate-500 font-medium">
                        {{ $clients->total() }} clients enregistrés
                    </p>
                </div>
            </div>
            <button onclick="openModal('clientModal')"
                class="hidden md:flex h-12 px-6 bg-emerald-600 text-white rounded-xl font-black shadow-lg shadow-emerald-100 hover:bg-emerald-700 transition-all items-center text-sm uppercase tracking-wider active:scale-95">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Nouveau
            </button>
        </div>

        <div class="mb-4">
            <form action="{{ route('clients.index') }}" method="GET"
                class="space-y-3 md:space-y-0 md:grid md:grid-cols-12 md:gap-4 items-end">
                <div class="md:col-span-9">
                    <label
                        class="hidden md:block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Rechercher</label>
                    <div class="relative group">
                        <span
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            x-on:input.debounce.500ms="$el.form.submit()" placeholder="Nom du client, téléphone..."
                            class="h-11 md:h-12 w-full pl-11 pr-4 bg-white md:bg-slate-50 border border-slate-100 md:border-none rounded-xl md:rounded-2xl text-sm font-medium shadow-sm md:shadow-none focus:ring-2 focus:ring-emerald-500/10 md:focus:bg-white transition-all placeholder:text-slate-400">
                    </div>
                </div>
            </form>
        </div>

        <div class="space-y-4">
            <div class="hidden md:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Nom
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Contact
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Adresse
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($clients as $client)
                            <tr class="hover:bg-gray-50/50 transition-colors text-sm">
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-800">{{ $client->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                    <div class="flex flex-col">
                                        <span>{{ $client->phone ?? 'N/A' }}</span>
                                        <span class="text-xs text-gray-400">{{ $client->email ?? '' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500 truncate max-w-xs">
                                    {{ $client->address ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button
                                            onclick="editClient({{ $client->id }}, '{{ $client->name }}', '{{ $client->phone }}', '{{ $client->email }}', '{{ $client->address }}')"
                                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('clients.destroy', $client) }}" method="POST"
                                            @submit.prevent="$dispatch('confirm', { title: 'Suppression', message: 'Voulez-vous vraiment supprimer ce client ?', callback: () => $el.submit() })">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg">
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
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">Aucun client
                                    enregistré</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden space-y-4 pb-24">
                @forelse($clients as $client)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden animate-fade-in">
                        <div class="p-4 border-b border-slate-50 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="h-10 w-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center font-bold">
                                    {{ substr($client->name, 0, 1) }}
                                </div>
                                <h4 class="text-sm font-bold text-slate-800">{{ $client->name }}</h4>
                            </div>
                            <div class="flex items-center space-x-1">
                                <button
                                    onclick="editClient({{ $client->id }}, '{{ $client->name }}', '{{ $client->phone }}', '{{ $client->email }}', '{{ $client->address }}')"
                                    class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <form action="{{ route('clients.destroy', $client) }}" method="POST"
                                    @submit.prevent="$dispatch('confirm', { title: 'Suppression', message: 'Supprimer ce client ?', callback: () => $el.submit() })">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-slate-300 hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="p-4 grid grid-cols-2 gap-4 bg-slate-50/30">
                            <div>
                                <span
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Téléphone</span>
                                <span class="text-[13px] font-medium text-slate-700">{{ $client->phone ?? '-' }}</span>
                            </div>
                            <div>
                                <span
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Email</span>
                                <span
                                    class="text-[13px] font-medium text-slate-700 truncate block">{{ $client->email ?? '-' }}</span>
                            </div>
                            <div class="col-span-2">
                                <span
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Adresse</span>
                                <span
                                    class="text-[13px] font-medium text-slate-700 block">{{ $client->address ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-400 italic bg-white rounded-2xl border border-slate-100">
                        Aucun client enregistré
                    </div>
                @endforelse

                <div class="mt-4">
                    {{ $clients->links() }}
                </div>
            </div>

            <!-- Pagination Desktop only (to avoid double links if not handled carefully) -->
            <div class="hidden md:block px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $clients->links() }}
            </div>
        </div>

        <div class="md:hidden fixed bottom-24 right-6 z-[100]">
            <button onclick="openModal('clientModal')"
                class="flex items-center justify-center h-14 w-14 bg-emerald-600 text-white rounded-2xl shadow-2xl shadow-emerald-500/50 active:scale-90 transition-transform">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>
    </div>

    <div id="clientModal"
        class="hidden fixed inset-0 z-[150] flex items-end md:items-center justify-center bg-slate-900/60 backdrop-blur-sm p-0 md:p-4 pb-20 md:pb-4">
        <div
            class="bg-white rounded-t-[32px] md:rounded-3xl w-full h-[75vh] md:h-auto md:max-w-xl flex flex-col shadow-2xl animate-fade-in relative overflow-hidden">

            <!-- Mobile Handle -->
            <div class="md:hidden h-1.5 w-12 bg-slate-200 rounded-full mx-auto mt-3 mb-1"></div>

            <div class="p-6 md:p-8 flex-1 overflow-y-auto pb-32 md:pb-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 id="modalTitle" class="text-xl font-bold text-slate-800">Nouveau Client</h3>
                    <button type="button" onclick="closeModal('clientModal')"
                        class="text-slate-400 hover:text-slate-600 md:hidden">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form id="clientForm" action="{{ route('clients.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">

                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest">Nom Complet <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" id="c_name" required
                            class="h-12 w-full px-4 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all"
                            placeholder="Ex: Jean Dupont">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label
                                class="block text-xs font-black text-slate-400 uppercase tracking-widest">Téléphone</label>
                            <input type="tel" name="phone" id="c_phone" inputmode="tel"
                                class="h-12 w-full px-4 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all"
                                placeholder="034 00 000 00">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest">Email</label>
                            <input type="email" name="email" id="c_email" inputmode="email"
                                class="h-12 w-full px-4 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all"
                                placeholder="client@exemple.com">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest">Adresse</label>
                        <textarea name="address" id="c_address" rows="3"
                            class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all resize-none"
                            placeholder="Détails de localisation..."></textarea>
                    </div>

                    <!-- Sticky footer on mobile, standard on desktop -->
                    <div
                        class="fixed md:static bottom-0 left-0 right-0 p-4 md:p-0 bg-white md:bg-transparent border-t md:border-none flex flex-row space-x-3 pt-4 z-[160]">
                        <button type="button" onclick="closeModal('clientModal')"
                            class="flex-1 md:flex-none h-12 md:h-10 px-6 text-slate-500 font-bold hover:bg-slate-50 rounded-xl transition-all border border-slate-100 md:border-none">
                            Annuler
                        </button>
                        <button type="submit"
                            class="flex-[2] md:flex-none h-12 md:h-10 px-6 bg-blue-600 text-white rounded-xl font-black shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-widest md:normal-case md:tracking-normal text-xs md:text-sm">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            // Reset form
            document.getElementById('clientForm').action = '{{ route('clients.store') }}';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('modalTitle').innerText = 'Nouveau Client';
            document.getElementById('clientForm').reset();
        }

        function editClient(id, name, phone, email, address) {
            document.getElementById('clientForm').action = '/clients/' + id;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('modalTitle').innerText = 'Modifier Client';
            document.getElementById('c_name').value = name;
            document.getElementById('c_phone').value = phone;
            document.getElementById('c_email').value = email;
            document.getElementById('c_address').value = address;
            openModal('clientModal');
        }
    </script>
@endsection
