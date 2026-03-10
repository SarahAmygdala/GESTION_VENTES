<div class="md:w-[360px] flex flex-col bg-white border border-[#E5E7EB] rounded-[14px] shadow-sm overflow-hidden h-full">
    <div class="p-5 border-b border-[#F3F4F6] bg-[#2563EB]">
        <h3 class="text-subtitle text-white text-center uppercase tracking-widest">Détails du Paiement</h3>
    </div>

    <div class="p-6 flex-1 space-y-6 overflow-y-auto custom-scrollbar">
        <div class="bg-[#F8FAFC] p-4 rounded-2xl border border-[#F3F4F6] space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col">
                    <span class="text-[11px] font-black text-[#6B7280] uppercase tracking-wider mb-1">Sous-total</span>
                    <span x-text="formatCurrency(subtotal())" class="text-[14px] font-bold text-[#111827]"></span>
                </div>
                <div class="flex flex-col text-right">
                    <span class="text-[11px] font-black text-[#EF4444] uppercase tracking-wider mb-1 text-right">Remise
                        (<span x-text="discount"></span>%)</span>
                    <span x-text="'- ' + formatCurrency((subtotal() * discount / 100))"
                        class="text-[14px] font-bold text-[#EF4444]"></span>
                </div>
            </div>

            <div class="bg-[#EFF6FF] rounded-[16px] p-4 border-2 border-[#DBEAFE] mt-4 flex flex-col items-center">
                <span class="text-[10px] font-black text-[#2563EB] uppercase tracking-[0.2em] mb-1 opacity-70">Total à
                    payer</span>
                <span class="text-3xl font-black text-gray-900 tracking-tight" x-text="formatCurrency(total())"></span>
            </div>
        </div>

        <div class="space-y-2" x-data="{ open: false, clientSearch: '' }">
            <label class="text-[12px] font-black uppercase text-[#6B7280]">Client (Optionnel)</label>
            <div class="relative">
                <button @click="open = !open" type="button"
                    class="w-full h-[44px] px-10 border border-[#E5E7EB] rounded-[10px] text-[14px] text-left focus:ring-2 focus:ring-[#2563EB]/20 focus:border-[#2563EB] bg-white transition-all relative">
                    <span class="truncate"
                        x-text="selectedClientId ? clients.find(c => c.id == selectedClientId).name : 'Client de passage (Anonyme)'"></span>
                    <span
                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-[#6B7280]"><svg
                            class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg></span>
                    <span
                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#6B7280]"><svg
                            class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg></span>
                </button>
                <div x-show="open" @click.away="open = false" x-cloak
                    class="absolute z-[150] bottom-full mb-2 md:bottom-auto md:top-full md:mt-2 w-full bg-white border border-[#E5E7EB] rounded-xl shadow-xl overflow-hidden animate-fade-in max-h-[300px] flex flex-col">
                    <div class="p-2 border-b border-slate-50 bg-slate-50">
                        <input type="text" x-model="clientSearch" placeholder="Rechercher un client..."
                            class="w-full h-[36px] px-3 rounded-lg border border-[#E5E7EB] text-[13px] outline-none">
                    </div>
                    <div class="overflow-y-auto flex-1 custom-scrollbar">
                        <button @click="selectedClientId = ''; open = false"
                            class="w-full px-4 py-2 text-left text-[13px] hover:bg-slate-50 border-b border-slate-50">Client
                            de passage</button>
                        <template
                            x-for="client in clients.filter(c => c.name.toLowerCase().includes(clientSearch.toLowerCase()))">
                            <button @click="selectedClientId = client.id; open = false"
                                class="w-full px-4 py-2 text-left text-[13px] hover:bg-slate-50 border-b border-slate-50"><span
                                    x-text="client.name"></span></button>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5">
            <div class="flex flex-col space-y-2">
                <label class="text-[12px] font-black uppercase text-[#6B7280]">Remise (%)</label>
                <input type="number" x-model="discount"
                    class="h-[44px] w-full px-4 border border-[#E5E7EB] rounded-[10px] text-[14px] text-right font-black">
            </div>
            <div class="space-y-3">
                <label class="text-[12px] font-black uppercase text-[#6B7280]">Mode de règlement</label>
                <div class="grid grid-cols-3 gap-2">
                    <template x-for="method in ['espèces', 'carte', 'mobile']">
                        <button @click="paymentMethod = method"
                            class="h-[44px] rounded-xl border-2 transition-all text-[11px] font-bold capitalize"
                            :class="paymentMethod === method ? 'border-[#2563EB] bg-[#EFF6FF] text-[#2563EB]' :
                                'border-[#F3F4F6] text-[#6B7280] hover:border-[#E5E7EB]'"
                            x-text="method"></button>
                    </template>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[12px] font-black uppercase text-[#6B7280]">Montant Reçu (Ar)</label>
                <input type="number" x-model="amountReceived"
                    class="w-full h-[50px] px-6 border-2 border-[#E5E7EB] rounded-xl font-black text-[20px] text-right focus:border-[#2563EB] outline-none">
            </div>
            <div
                class="flex justify-between items-center p-4 rounded-xl bg-white border-2 border-[#F3F4F6] shadow-inner">
                <div class="flex flex-col">
                    <span class="text-[11px] font-black text-[#6B7280] uppercase">Monnaie à rendre</span>
                    <span :class="change() < 0 ? 'text-[#EF4444]' : 'text-[#22C55E]'" class="text-[20px] font-black"
                        x-text="formatCurrency(Math.max(0, change()))"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="p-5 border-t border-[#F3F4F6] bg-[#F8FAFC]">
        <button @click="processPayment()" :disabled="cart.length === 0 || amountReceived < total()"
            class="w-full h-[54px] rounded-[16px] bg-[#22C55E] text-white font-black text-[15px] shadow-lg shadow-green-100 uppercase tracking-widest hover:bg-[#16A34A] disabled:grayscale">
            Valider la vente
        </button>
    </div>
</div>
