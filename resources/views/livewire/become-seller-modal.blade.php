<div>
    <div class="mt-6 md:mt-8" id="sellerBannerSection">
        <div class="bg-white rounded-2xl md:rounded-[2rem] shadow-sm px-6 py-5 md:px-10 md:py-7 flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-[#eef5e6] flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-7 md:h-7 text-[#5a6b47]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h13L17 13M9 21a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z" />
                    </svg>
                </div>

                <div>
                    <p class="font-serif-title font-bold text-[#3d4530] text-base md:text-xl">
                        ¿Quieres vender en los mercadillos?
                    </p>
                    <p class="text-gray-500 text-xs md:text-sm mt-0.5">
                        Solicita convertirte en vendedor y elige los mercadillos donde quieres tener tu puesto.
                    </p>
                </div>
            </div>

            <button
                type="button"
                id="btnBecomeSeller"
                wire:click="openModal"
                class="flex-shrink-0 w-full md:w-auto bg-[#5a6b47] hover:bg-[#4a5939] text-white px-6 md:px-8 py-2.5 md:py-3 rounded-xl font-bold text-sm md:text-base transition-colors active:scale-95 flex items-center justify-center gap-2 shadow-md"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Registrarse como vendedor
            </button>
        </div>
    </div>

    @if($isOpen)
        <div
            id="sellerModal"
            class="fixed inset-0 z-50 bg-black/40 flex items-center justify-center p-4 modal-open"
            role="dialog"
            aria-modal="true"
            aria-labelledby="sellerModalTitle"
            wire:click="closeModal"
        >
            <div
                id="sellerModalBox"
                class="bg-white rounded-2xl md:rounded-[2rem] shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-6 md:p-10 relative"
                wire:click.stop
            >
                <button
                    type="button"
                    id="btnCloseSellerModal"
                    wire:click="closeModal"
                    class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-[#f2f5eb] hover:bg-[#e1ebd2] text-[#5a6b47] transition-colors"
                    aria-label="Cerrar"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                @if(!$submitted)
                    <div id="sellerFormState">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-[#eef5e6] flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#5a6b47]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h13L17 13M9 21a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z" />
                                </svg>
                            </div>
                            <div>
                                <h2 id="sellerModalTitle" class="font-serif-title font-bold text-[#3d4530] text-xl md:text-2xl">
                                    Solicitud de vendedor
                                </h2>
                                <p class="text-gray-400 text-xs mt-0.5">
                                    Selecciona los mercadillos en los que te gustaría participar
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-6" id="marketList">
                            @forelse($fleaMarkets as $market)
                                <label
                                    class="market-checkbox-label {{ in_array($market->id, $selectedMarkets) ? 'selected' : '' }}"
                                    id="market-label-{{ $market->id }}"
                                >
                                    <input
                                        type="checkbox"
                                        value="{{ $market->id }}"
                                        wire:model.live="selectedMarkets"
                                        class="market-check"
                                    >
                                    <span class="flex flex-col">
                                        <span class="font-semibold text-[#3d4530]">{{ $market->name }}</span>
                                        <span class="text-gray-400 text-xs font-normal">
                                            {{ $market->municipality->name ?? 'Sin municipio' }}
                                        </span>
                                    </span>
                                </label>
                            @empty
                                <p class="text-gray-400 text-sm col-span-2 text-center py-4 italic">
                                    No hay mercadillos disponibles en este momento.
                                </p>
                            @endforelse
                        </div>

                        @error('selectedMarkets')
                            <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
                        @enderror

                        <div class="bg-[#f2f5eb] rounded-xl px-4 py-3 mb-6 flex gap-3 items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#5a6b47] mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-[#4d593c] text-xs leading-relaxed">
                                Puedes seleccionar uno o varios mercadillos. Un administrador revisará tu solicitud y te notificará cuando sea aprobada.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <button
                                type="button"
                                id="btnSubmitSellerRequest"
                                wire:click="submit"
                                wire:loading.attr="disabled"
                                wire:target="submit"
                                class="flex-1 bg-[#5a6b47] hover:bg-[#4a5939] text-white py-2.5 rounded-xl font-bold text-sm transition-colors active:scale-95 flex items-center justify-center gap-2 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span wire:loading.remove wire:target="submit" class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                    </svg>
                                    Enviar solicitud
                                </span>

                                <span wire:loading wire:target="submit" class="flex items-center gap-2">
                                    <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                    </svg>
                                    Enviando...
                                </span>
                            </button>

                            <button
                                type="button"
                                id="btnCancelSellerModal"
                                wire:click="closeModal"
                                class="flex-1 bg-[#f2f5eb] hover:bg-[#e1ebd2] text-[#4d593c] py-2.5 rounded-xl font-bold text-sm transition-colors active:scale-95"
                            >
                                Cancelar
                            </button>
                        </div>
                    </div>
                @else
                    <div id="sellerSuccessState" class="flex flex-col items-center text-center py-4 md:py-6 gap-4">
                        <div class="success-check w-16 h-16 md:w-20 md:h-20 rounded-full bg-[#eef5e6] flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 md:w-10 md:h-10 text-[#5a6b47]" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="font-serif-title font-bold text-[#3d4530] text-xl md:text-2xl mb-2">
                                ¡Solicitud enviada!
                            </h3>
                            <p class="text-gray-500 text-sm md:text-base leading-relaxed max-w-xs mx-auto">
                                Hemos recibido tu solicitud para convertirte en vendedor. Un administrador la revisará en breve y te notificará el resultado.
                            </p>
                        </div>

                        <div id="successMarketList" class="w-full bg-[#f2f5eb] rounded-xl px-4 py-3 text-left">
                            <p class="text-xs font-bold text-[#5a6b47] uppercase tracking-wide mb-2">
                                Mercadillos solicitados
                            </p>
                            <ul id="successMarketItems" class="space-y-1">
                                @foreach($selectedMarketNames as $name)
                                    <li class="flex items-center gap-2 text-sm text-[#3d4530] font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#5a6b47] flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $name }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <button
                            type="button"
                            id="btnCloseSuccess"
                            wire:click="closeSuccess"
                            class="mt-2 bg-[#5a6b47] hover:bg-[#4a5939] text-white px-8 py-2.5 rounded-xl font-bold text-sm transition-colors active:scale-95 shadow-sm"
                        >
                            Entendido
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @script
    <script>
        $wire.on('seller-modal-opened', () => {
            document.body.style.overflow = 'hidden';
        });

        $wire.on('seller-modal-closed', () => {
            document.body.style.overflow = '';
        });
    </script>
    @endscript
</div>