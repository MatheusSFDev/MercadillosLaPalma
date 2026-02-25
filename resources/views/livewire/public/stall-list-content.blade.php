{{-- resources/views/livewire/public/stall-list.blade.php --}}
<div> {{-- ESTE ES EL ÚNICO ELEMENTO RAÍZ --}}
    
    <div class="min-h-screen font-sans bg-white">
        <header class="relative h-64 md:h-80 flex items-center justify-center overflow-hidden">
            @if($fleaMarket->img_url && $fleaMarket->img_url !== 'img/imgNotAvailable.png')
                <img src="{{ asset($fleaMarket->img_url) }}" 
                     class="absolute inset-0 object-cover w-full h-full brightness-50" alt="Mercadillo">
            @else
                <img src="{{ asset('img/hero.png') }}" 
                     class="absolute inset-0 object-cover w-full h-full brightness-50" alt="Mercadillo Default">
            @endif
            <h1 class="relative z-10 text-3xl md:text-5xl font-serif font-bold text-white text-center px-4">
                Mercadillo {{ $fleaMarket->municipality->name }}
            </h1>
        </header>

        <div class="flex border-b border-gray-200 bg-white">
            <div class="flex-1 flex items-center justify-center py-4 border-r border-gray-200">
                <img src={{ asset('img/icons/calendario.png') }} class="w-10 h-10 mr-2 opacity-80">
                <select class="text-xs border-gray-300 rounded bg-gray-50 focus:ring-0 border-none">
                    <option>Ver horarios</option>
                </select>
            </div>
            <div class="flex-1 flex items-center justify-center py-4 px-2 text-center">
                <img src={{ asset('img/icons/marcador.png') }} class="w-10 h-10 mr-2 opacity-80">
                <p class="text-[10px] md:text-xs font-semibold text-gray-700 uppercase leading-tight">
                    {{ $fleaMarket->address }}
                </p>
            </div>
        </div>

        <main class="bg-[#e6ead3] py-8 px-4 md:px-12">
            
            <section class="max-w-6xl mx-auto mb-12">
                <h2 class="text-2xl font-serif font-bold text-[#5d4037] mb-6">Filtrar por categorías</h2>
                
                <div class="block md:hidden mb-6">
                    <div class="relative">
                        <select class="w-full p-3 bg-white border-none rounded-lg shadow-sm text-sm appearance-none focus:ring-2 focus:ring-[#556b2f] font-serif">
                            <option>Selecciona una Categoría</option>
                            {{-- Aquí podrías iterar tus categorías reales --}}
                            <option>Verdulería</option>
                            <option>Artesanía</option>
                        </select>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="hidden md:grid md:grid-cols-8 gap-3">
                    @php
                        $categories = [
                            ['name' => 'Carnicería', 'icon' => '🥩'],
                            ['name' => 'Pescadería', 'icon' => '🐟'],
                            ['name' => 'Verdulería', 'icon' => '🍎'],
                            ['name' => 'Artesanía', 'icon' => '🏺'],
                            ['name' => 'Quesería', 'icon' => '🧀'],
                            ['name' => 'Floristería', 'icon' => '🪴'],
                            ['name' => 'Panadería', 'icon' => '🍞'],
                            ['name' => 'Otros', 'icon' => '💬'],
                        ];
                    @endphp
                    @foreach($categories as $cat)
                        <div class="bg-white p-4 rounded-xl shadow-sm flex flex-col items-center justify-center cursor-pointer hover:bg-gray-50 transition border border-transparent hover:border-[#556b2f]">
                            <span class="text-3xl mb-2">{{ $cat['icon'] }}</span>
                            <span class="text-[11px] font-bold text-gray-700 uppercase text-center">{{ $cat['name'] }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="max-w-6xl mx-auto">
                <h2 class="text-3xl font-serif font-bold text-[#5d4037] mb-8">Puestos</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($stalls as $stall)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm flex flex-col md:flex-row md:items-center relative transition-transform hover:scale-[1.01]">
                            
                            <div class="w-full md:w-1/3 h-48 md:h-40 min-h-[160px]">
                                @if($stall->img_url && $stall->img_url !== 'img/imgNotAvailable.png')
                                    <img src="{{ asset($stall->img_url) }}" 
                                         class="w-full h-full object-cover" alt="{{ $stall->name }}">
                                @else
                                    <img src="{{ asset('img/imgNotAvailable.png') }}" 
                                         class="w-full h-full object-cover" alt="Sin imagen">
                                @endif
                            </div>

                            <div class="flex-1 p-6 flex flex-col items-center md:items-start">
                                <h3 class="text-2xl md:text-xl font-serif font-bold text-[#1d3a1a] mb-2 text-center md:text-left leading-tight">
                                    {{ $stall->name }}
                                </h3>
                                
                                <div class="mb-6 md:mb-0 text-3xl">
                                    🍎 {{-- Aquí podrías poner el icono según $stall->category --}}
                                </div>

                                <a href="{{ route('general.stall', $stall->id) }}" 
                                   class="md:absolute md:bottom-4 md:right-4 px-8 py-2 bg-[#556b2f] text-white text-xs font-bold rounded-lg hover:bg-[#4b6b2f] transition uppercase">
                                    Acceder
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white p-12 rounded-2xl text-center shadow-sm">
                            <p class="text-gray-500 font-serif text-lg">No hay puestos disponibles en este momento.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </main>
    </div>

</div> {{-- FIN DEL ELEMENTO RAÍZ --}}