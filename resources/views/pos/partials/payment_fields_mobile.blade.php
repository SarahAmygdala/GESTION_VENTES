<div class="space-y-2" x-data="{ open: false, clientSearch: '' }">
    <label class="text-[12px] font-black uppercase text-[#6B7280]">Client (Optionnel)</label>
    <div class="relative">
        <button @click="open = !open" type="button"
            class="w-full h-[54px] px-12 border-2 border-[#F3F4F6] rounded-2xl text-[14px] text-left focus:border-blue-500 bg-white transition-all relative">
            <span class="truncate font-bold"
                x-text="selectedClientId ? clients.find(c => c.id == selectedClientId).name : 'Client de passage'"></span>
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-blue-500">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </span>
        </button>
        <div x-show="open" @click.away="open = false" x-cloak
            class="absolute z-[160] bottom-full mb-2 w-full bg-white border border-[#E5E7EB] rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[250px]">
            <div class="p-3 border-b border-slate-50 bg-slate-50">
                <input type="text" x-model="clientSearch" placeholder="Chercher un client..."
                    class="w-full h-[40px] px-4 rounded-xl border border-[#E5E7EB] text-[13px] outline-none">
            </div>
            <div class="overflow-y-auto flex-1 h-[200px]">
                <button @click="selectedClientId = ''; open = false"
                    class="w-full px-5 py-3 text-left text-[13px] border-b border-slate-50 hover:bg-blue-50">Client de
                    passage</button>
                <template
                    x-for="client in clients.filter(c => c.name.toLowerCase().includes(clientSearch.toLowerCase()))">
                    <button @click="selectedClientId = client.id; open = false"
                        class="w-full px-5 py-3 text-left text-[13px] border-b border-slate-50 hover:bg-blue-50 flex flex-col">
                        <span class="font-bold" x-text="client.name"></span>
                        <span class="text-[10px] text-slate-400" x-text="client.phone"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-5">
    <div class="flex flex-col space-y-2">
        <label class="text-[12px] font-black uppercase text-[#6B7280]">Remise (%)</label>
        <input type="number" x-model="discount"
            class="h-[54px] w-full px-6 border-2 border-[#F3F4F6] rounded-2xl text-[16px] font-black text-right focus:border-blue-500 outline-none">
    </div>

    <div class="space-y-3">
        <label class="text-[12px] font-black uppercase text-[#6B7280]">Mode de règlement</label>
        <div class="grid grid-cols-3 gap-3">
            <template x-for="method in ['espèces', 'carte', 'mobile']">
                <button @click="paymentMethod = method"
                    class="h-[54px] rounded-2xl border-2 transition-all flex items-center justify-center"
                    :class="paymentMethod === method ? 'border-blue-600 bg-blue-50 text-blue-600' :
                        'border-[#F3F4F6] text-slate-500'">
                    <span class="text-[12px] font-black capitalize" x-text="method"></span>
                </button>
            </template>
        </div>
    </div>

    <div class="space-y-2">
        <label class="text-[12px] font-black uppercase text-[#6B7280]">Montant Reçu (Ar)</label>
        <input type="number" x-model="amountReceived"
            class="w-full h-[64px] px-6 border-2 border-slate-900 rounded-2xl font-black text-[24px] text-right focus:border-blue-500 outline-none placeholder:text-slate-200"
            placeholder="0">
    </div>

    <div class="flex justify-between items-center p-5 rounded-2xl bg-slate-900 text-white shadow-lg shadow-slate-200">
        <div class="flex flex-col">
            <span class="text-[11px] font-bold uppercase opacity-60">Rendre</span>
            <span :class="change() < 0 ? 'text-red-400' : 'text-green-400'" class="text-[24px] font-black"
                x-text="formatCurrency(Math.max(0, change()))"></span>
        </div>
        <div class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    stroke-width="2" />
            </svg>
        </div>
    </div>

    <button @click="processPayment()" :disabled="cart.length === 0 || amountReceived < total()"
        class="w-full h-[64px] rounded-2xl bg-green-500 text-white font-black text-[16px] shadow-xl shadow-green-100 uppercase tracking-widest active:scale-95 transition-all disabled:opacity-50">
        Valider la vente
    </button>
</div>
