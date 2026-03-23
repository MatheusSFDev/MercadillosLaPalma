<div>
    <div class="print:hidden">
        {{-- Barra de filtros --}}
        <div class="mb-8">
            <h2 class="text-3xl font-bold font-titulo-principal text-coffe mb-4">Filtrar por:</h2>
            <div class="flex flex-wrap font-dm-serif gap-4 items-center">
                <select wire:model.live="filtroAno"
                    class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm font-medium text-[#3d4d3e]">
                    <option value="">Año</option>
                    @for($i=2023;$i<=2026;$i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>

                <select wire:model.live="filtroMes"
                    class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm font-medium text-[#3d4d3e]">
                    <option value="">Mes</option>
                    @foreach(range(1,12) as $mes)
                        <option value="{{ $mes }}">{{ \Carbon\Carbon::create()->month($mes)->locale('es')->monthName }}</option>
                    @endforeach
                </select>

                <select wire:model.live="filtroEstado"
                    class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm font-medium text-[#3d4d3e]">
                    <option value="">Estado</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="completado">Completado</option>
                </select>

                <div class="relative flex-1 min-w-[200px] max-w-xs ml-auto sm:ml-0">
                    <input type="text" wire:model.live="busqueda" placeholder="Buscar"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 pl-3 pr-10">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-6 w-6 text-black font-bold" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pedidos --}}
        <h2 class="text-3xl font-bold font-titulo-principal text-coffe mb-4">Mis Pedidos</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-16">
            @forelse ($pedidos as $pedido)
                <div class="bg-white rounded-xl shadow p-6 relative">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold font-atkinson text-black">nº {{ $pedido->id }}</h3>
                            <p class="text-sm font-medium font-atkinson text-gray-800 mt-1">
                                {{ \Carbon\Carbon::parse($pedido->order_date)->format('d/m/Y') }} - 
                                {{ $pedido->delivery_date ? \Carbon\Carbon::parse($pedido->delivery_date)->format('d/m/Y') : '-' }}</p>
                            <p class="text-sm font-atkinson text-gray-600 mt-1">{{ $pedido->products->count() }} productos</p>
                        </div>

                        @if ($pedido->completed == 0)
                            <span
                                class="px-4 py-1 bg-[#fdf3e7] text-[#e69b55] font-atkinson text-xs font-bold rounded-lg shadow-sm">Pendiente</span>
                        @else
                            <span
                                class="px-4 py-1 bg-[#fbece1] text-green-700 font-atkinson text-xs font-bold rounded-lg shadow-sm">Completado</span>
                        @endif
                    </div>
                    <div class="mt-8 flex justify-between items-center">
                        <p class="text-xl font-bold font-dm-serif text-[#3d4d3e]">Total: <span
                                class="text-[#4a5d4e] font-atkinson">{{ number_format($pedido->products->sum(fn($p) => $p->pivot->quantity * $p->pivot->price_per_unit), 2) }}€</span></p>

                        <button wire:click="abrirModal({{ $pedido->id }})"
                            class="bg-[#4a5d4e] hover:bg-[#3d4d3e] font-dm-serif text-white px-5 py-2 rounded-lg text-sm font-bold shadow-md transition">
                            Ver detalles
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 bg-white rounded-xl shadow p-10 text-center">
                    <span class="text-4xl">📭</span>
                    <h3 class="text-xl font-bold text-gray-700 mt-4">Aún no tienes pedidos</h3>
                    <p class="text-gray-500 mt-2">Cuando compres algo, aparecerá aquí.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modal de pedido --}}
    @if ($modalAbierto && $pedidoSeleccionado)
        <div class="fixed inset-0 z-50 overflow-y-auto print:static print:overflow-visible" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0 print:p-0 print:min-h-0">
                <div class="fixed inset-0 bg-black bg-opacity-40 transition-opacity print:hidden" wire:click="$set('modalAbierto', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen print:hidden">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border-t-8 border-[#fbece1] print:border-none print:shadow-none print:w-full print:max-w-none print:m-0">
                    <div class="bg-white px-8 pt-8 pb-8 print:px-0 print:pt-0">

                        {{-- Fechas, puesto y mercadillo --}}
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <h3 class="text-2xl font-bold font-atkinson text-black mb-4">Pedido nº {{ $pedidoSeleccionado->id }}</h3>
                                <div class="grid grid-cols-[130px_1fr] gap-2 text-sm font-atkinson text-gray-800">
                                    <span class="font-bold">Fecha de pedido:</span>
                                    <span>{{ \Carbon\Carbon::parse($pedidoSeleccionado->order_date)->format('d/m/Y H:i') }}</span>

                                    <span class="font-bold">Fecha de recogida:</span>
                                    <span>{{ $pedidoSeleccionado->delivery_date ? \Carbon\Carbon::parse($pedidoSeleccionado->delivery_date)->format('d/m/Y H:i') : '-' }}</span>

                                    @php
                                        $firstProduct = $pedidoSeleccionado->products->first();
                                        $stall = $firstProduct?->stall ?? null;
                                        $fleaMarket = $stall?->fleaMarket ?? null;
                                    @endphp

                                    <span class="font-bold">Puesto:</span>
                                    <span>{{ $stall->name ?? '-' }}</span>

                                    <span class="font-bold">Mercadillo:</span>
                                    <span>{{ $fleaMarket->address ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="{{ $pedidoSeleccionado->completed == 0 ? 'bg-[#fdf3e7] text-[#e69b55]' : 'bg-[#fbece1] text-green-700' }} px-6 py-2 rounded-xl font-atkinson font-bold shadow-sm print:border print:border-orange-200">
                                {{ $pedidoSeleccionado->completed == 0 ? 'Pendiente' : 'Completado' }}
                            </div>
                        </div>

                        {{-- Tabla de productos --}}
                        <div class="overflow-x-auto mb-8">
                            <table class="w-full text-sm font-atkinson text-center border-separate border-spacing-y-2 print:border-collapse print:border-spacing-0">
                                <thead class="bg-[#4a5d4e] text-white font-bold print:bg-gray-200 print:text-black">
                                    <tr>
                                        <th class="py-3 px-4 rounded-l-lg w-1/4 print:rounded-none">Producto</th>
                                        <th class="py-3 px-4 w-1/4">Precio</th>
                                        <th class="py-3 px-4 w-1/4">Compra</th>
                                        <th class="py-3 px-4 rounded-r-lg w-1/4 print:rounded-none">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-800 font-medium">
                                    @foreach($pedidoSeleccionado->products as $p)
                                        @php
                                            $status = $p->pivot->status;
                                            $bgColor = $status === 'Rechazado' ? 'bg-[#fdf3e7] text-red-600' : 'bg-[#fbece1] text-green-700';
                                        @endphp
                                        <tr>
                                            <td class="bg-[#eef2e6] py-3 px-4 print:bg-transparent print:border-b">{{ $p->name }}</td>
                                            <td class="bg-[#eef2e6] py-3 px-4 print:bg-transparent print:border-b">{{ number_format($p->pivot->price_per_unit, 2) }}€</td>
                                            <td class="bg-[#eef2e6] py-3 px-4 print:bg-transparent print:border-b">{{ $p->pivot->quantity }} - {{ number_format($p->pivot->quantity * $p->pivot->price_per_unit, 2) }}€</td>
                                            <td class="py-3 px-4 font-bold {{ $bgColor }} print:bg-transparent print:border-b">{{ $status }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Total --}}
                        <div class="flex items-center justify-center gap-6 mb-8 border-t border-b border-gray-100 py-6">
                            <span class="text-4xl font-dm-serif font-bold text-black">Total:</span>
                            <span class="text-4xl font-atkinson font-bold text-[#4a5d4e] print:text-black">{{ number_format($pedidoSeleccionado->products->sum(fn($p) => $p->pivot->quantity * $p->pivot->price_per_unit), 2) }}€</span>
                        </div>

                        {{-- Botones --}}
                        <div class="flex justify-center gap-4 print:hidden">
                            <button onclick="window.print()"
                                class="bg-[#fbece1] text-[#f08535] hover:bg-orange-200 px-8 py-2 rounded-xl font-atkinson font-bold shadow-sm transition">
                                Imprimir
                            </button>

                            <button wire:click="$set('modalAbierto', false)"
                                class="bg-[#f2e6e6] text-[#b34040] hover:bg-red-200 px-8 py-2 rounded-xl font-atkinson font-bold shadow-sm transition">
                                Cerrar
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>