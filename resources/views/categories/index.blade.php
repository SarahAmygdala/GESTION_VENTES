@extends('layouts.app')

@section('page-title', 'Catégories')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-3 md:space-x-4">
                <div
                    class="h-10 w-10 md:h-14 md:w-14 bg-purple-50 text-purple-600 rounded-xl md:rounded-2xl flex items-center justify-center shadow-sm">
                    <svg class="h-6 w-6 md:h-8 md:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg md:text-2xl font-black text-slate-900 tracking-tight">Catégories</h2>
                    <p class="hidden md:block text-sm text-slate-500 font-medium">
                        {{ $categories->count() }} catégories pour l'organisation de vos ventes
                    </p>
                </div>
            </div>
            <button onclick="openModal('addCategoryModal')"
                class="hidden md:flex h-12 px-6 bg-purple-600 text-white rounded-xl font-black shadow-lg shadow-purple-100 hover:bg-purple-700 transition-all items-center text-sm uppercase tracking-wider active:scale-95">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Nouvelle Catégorie
            </button>
        </div>

        <!-- Floating Action Button (Mobile Only) -->
        <div class="md:hidden fixed bottom-24 right-6 z-[100]">
            <button onclick="openModal('addCategoryModal')"
                class="flex items-center justify-center h-14 w-14 bg-purple-600 text-white rounded-2xl shadow-2xl shadow-purple-500/50 active:scale-90 transition-transform">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($categories as $category)
                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group transition-all hover:shadow-md">
                    <!-- Decorative color strip -->
                    <div class="absolute top-0 left-0 w-full h-1" style="background-color: {{ $category->color }}"></div>

                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 rounded-xl"
                            style="background-color: {{ $category->color }}15; color: {{ $category->color }}">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <div class="flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button
                                onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->color }}')"
                                class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                @submit.prevent="$dispatch('confirm', { title: 'Suppression', message: 'Voulez-vous vraiment supprimer cette catégorie ?', callback: () => $el.submit() })">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $category->products_count }} produits associés</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addCategoryModal"
        class="hidden fixed inset-0 z-[150] flex items-end md:items-center justify-center bg-slate-900/60 backdrop-blur-sm p-0 md:p-4 pb-20 md:pb-4">
        <div
            class="bg-white rounded-t-[32px] md:rounded-3xl w-full h-[60vh] md:h-auto md:max-w-md flex flex-col shadow-2xl animate-fade-in relative">
            <div class="md:hidden h-1.5 w-12 bg-slate-200 rounded-full mx-auto mt-3 mb-1"></div>
            <div class="p-6 md:p-8 flex-1 overflow-y-auto">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-800">Nouvelle Catégorie</h3>
                    <button type="button" onclick="closeModal('addCategoryModal')" class="text-slate-400 md:hidden">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('categories.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest">Nom de la
                            catégorie</label>
                        <input type="text" name="name" required
                            class="h-12 w-full px-4 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest">Couleur
                            distinctive</label>
                        <input type="color" name="color" value="#8B5CF6"
                            class="w-full h-12 p-1 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer">
                    </div>
                    <div class="flex flex-row space-x-3 pt-4">
                        <button type="button" onclick="closeModal('addCategoryModal')"
                            class="flex-1 md:flex-none h-12 md:h-10 px-6 text-slate-500 font-bold hover:bg-slate-50 rounded-xl transition-all border border-slate-100 md:border-none">
                            Annuler
                        </button>
                        <button type="submit"
                            class="flex-[2] md:flex-none h-12 md:h-10 px-6 bg-purple-600 text-white rounded-xl font-black shadow-lg shadow-purple-100 hover:bg-purple-700 transition-all uppercase tracking-widest md:normal-case md:tracking-normal text-xs md:text-sm">
                            Créer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editCategoryModal"
        class="hidden fixed inset-0 z-[150] flex items-end md:items-center justify-center bg-slate-900/60 backdrop-blur-sm p-0 md:p-4 pb-20 md:pb-4">
        <div
            class="bg-white rounded-t-[32px] md:rounded-3xl w-full h-[60vh] md:h-auto md:max-w-md flex flex-col shadow-2xl animate-fade-in relative">
            <div class="md:hidden h-1.5 w-12 bg-slate-200 rounded-full mx-auto mt-3 mb-1"></div>
            <div class="p-6 md:p-8 flex-1 overflow-y-auto">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-800">Modifier Catégorie</h3>
                    <button type="button" onclick="closeModal('editCategoryModal')" class="text-slate-400 md:hidden">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form id="editForm" method="POST" class="space-y-5">
                    @csrf @method('PUT')
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest">Nom de la
                            catégorie</label>
                        <input type="text" name="name" id="edit_name" required
                            class="h-12 w-full px-4 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest">Couleur
                            distinctive</label>
                        <input type="color" name="color" id="edit_color"
                            class="w-full h-12 p-1 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer">
                    </div>
                    <div class="flex flex-row space-x-3 pt-4">
                        <button type="button" onclick="closeModal('editCategoryModal')"
                            class="flex-1 md:flex-none h-12 md:h-10 px-6 text-slate-500 font-bold hover:bg-slate-50 rounded-xl transition-all border border-slate-100 md:border-none">
                            Annuler
                        </button>
                        <button type="submit"
                            class="flex-[2] md:flex-none h-12 md:h-10 px-6 bg-purple-600 text-white rounded-xl font-black shadow-lg shadow-purple-100 hover:bg-purple-700 transition-all uppercase tracking-widest md:normal-case md:tracking-normal text-xs md:text-sm">
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
        }

        function editCategory(id, name, color) {
            document.getElementById('editForm').action = '/categories/' + id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_color').value = color;
            openModal('editCategoryModal');
        }
    </script>
@endsection
