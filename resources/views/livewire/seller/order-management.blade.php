<div>
    <div class="print:hidden">
        {{-- Barra de filtros --}}
        <div class="mb-8">
            <h2 class="text-3xl font-bold font-titulo-principal text-coffe mb-4">Filtrar por:</h2>

            <div class="flex flex-wrap font-dm-serif gap-4 items-center">
                <select wire:model.live="filtroAno" class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm font-medium text-[#3d4d3e]">
                    <option value="">Año</option>
                    @for($i=2023;$i<=2026;$i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>

                <select wire:model.live="filtroMes" class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm font-medium text-[#3d4d3e]">
                    <option value="">Mes</option>
                    @foreach(range(1,12) as $mes)
                        <option value="{{ $mes }}">{{ \Carbon\Carbon::create()->month($mes)->locale('es')->monthName }}</option>
                    @endforeach
                </select>

                <select wire:model.live="filtroPuesto" class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm font-medium text-[#3d4d3e]">
                    <option value="">Puesto</option>
                    @foreach($puestos as $stall)
                        <option value="{{ $stall->id }}">{{ $stall->name ?? 'Puesto '.$stall->id }}</option>
                    @endforeach
                </select>

                <select wire:model.live="filtroEstado" class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm font-medium text-[#3d4d3e]">
                    <option value="">Estado</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="completado">Completado</option>
                </select>

                <div class="relative flex-1 min-w-[200px] max-w-xs ml-auto sm:ml-4">
                    <input type="text" wire:model.live="busqueda" placeholder="Buscar" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 pl-3 pr-10">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-6 w-6 text-black font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Resumen --}}
        <h2 class="text-3xl font-bold font-titulo-principal text-coffe mb-4">Resumen</h2>
        <div class="flex flex-wrap font-dm-serif gap-6 mb-10">
            <div class="bg-white rounded-xl shadow px-8 py-6 flex flex-col items-center justify-center min-w-[220px]">
                <div class="flex items-center gap-3">
                    <div class="bg-[#fbece1] p-3 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('img/icons/bagyellow.png') }}" alt="Icono Pendientes" class="w-8 h-8 object-contain">
                    </div>
                    <span class="text-4xl font-bold font-dm-serif text-accent-yellow">{{ $totalPendientes }}</span>
                </div>
                <p class="text-base font-medium mt-3 font-atkinson text-gray-800">Pedidos pendientes</p>
            </div>

            <div class="bg-white rounded-xl shadow px-8 py-6 flex flex-col items-center justify-center min-w-[220px]">
                <div class="flex items-center gap-3">
                    <div class="bg-[#fbece1] p-3 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('img/icons/bagoranje.png') }}" alt="Icono Completados" class="w-8 h-8 object-contain">
                    </div>
                    <span class="text-4xl font-bold font-dm-serif text-accent-orange">{{ $totalCompletados }}</span>
                </div>
                <p class="text-base font-medium mt-3 font-atkinson text-gray-800">Pedidos completados</p>
            </div>
        </div>

        {{-- Pedidos --}}
        <h2 class="text-3xl font-bold font-titulo-principal text-coffe mb-4">Pedidos</h2>
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
                            <span class="px-4 py-1 bg-[#fdf3e7] text-[#e69b55] font-atkinson text-xs font-bold rounded-lg shadow-sm">Pendiente</span>
                        @else
                            <span class="px-4 py-1 bg-[#fbece1] text-[#f08535] font-atkinson text-xs font-bold rounded-lg shadow-sm">Completado</span>
                        @endif
                    </div>
                    <div class="mt-8 flex justify-between items-center">
                        <p class="text-xl font-bold font-dm-serif text-[#3d4d3e]">Total: <span class="text-[#4a5d4e] font-atkinson">{{ number_format($pedido->products->sum(fn($p) => $p->pivot->quantity * $p->pivot->price_per_unit), 2) }}€</span></p>
                        <button wire:click="abrirModal({{ $pedido->id }})" class="bg-[#4a5d4e] hover:bg-[#3d4d3e] font-dm-serif text-white px-5 py-2 rounded-lg text-sm font-bold shadow-md transition">Ver detalles</button>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 bg-white rounded-xl shadow p-10 text-center">
                    <span class="text-4xl">📭</span>
                    <h3 class="text-xl font-bold text-gray-700 mt-4">Aún no tienes pedidos</h3>
                    <p class="text-gray-500 mt-2">Cuando un cliente te compre algo, aparecerá aquí.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modal --}}
    @if ($modalAbierto && $pedidoSeleccionado)
        <div class="fixed inset-0 z-50 overflow-y-auto print:static print:overflow-visible" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0 print:p-0 print:min-h-0">
                <div class="fixed inset-0 bg-black bg-opacity-40 transition-opacity print:hidden" wire:click="$set('modalAbierto', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen print:hidden">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border-t-8 border-[#fbece1] print:border-none print:shadow-none print:w-full print:max-w-none print:m-0">
                    <div class="bg-white px-8 pt-8 pb-8 print:px-0 print:pt-0">

                        {{-- Fechas y cliente --}}
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <h3 class="text-2xl font-bold font-atkinson text-black mb-4">Pedido nº {{ $pedidoSeleccionado->id }}</h3>
                                <div class="grid grid-cols-[130px_1fr] gap-2 text-sm font-atkinson text-gray-800">
                                    <span class="font-bold">Fecha de pedido</span>
                                    <span>{{ \Carbon\Carbon::parse($pedidoSeleccionado->order_date)->format('d/m/Y H:i') }}</span>

                                    <span class="font-bold">Fecha de recogida</span>
                                    <span>{{ $pedidoSeleccionado->delivery_date ? \Carbon\Carbon::parse($pedidoSeleccionado->delivery_date)->format('d/m/Y H:i') : '-' }}</span>

                                    <span class="font-bold mt-2">Datos del cliente</span>
                                    <div class="mt-2">
                                        <p class="font-bold text-black">{{ $pedidoSeleccionado->user->name }} {{ $pedidoSeleccionado->user->surname }}</p>
                                        <p class="text-gray-500">{{ $pedidoSeleccionado->user->email }}</p>
                                        <p class="text-gray-500 font-medium">{{ $pedidoSeleccionado->user->phone_number ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="{{ $pedidoSeleccionado->completed == 0 ? 'bg-[#fdf3e7] text-[#e69b55]' : 'bg-[#fbece1] text-[#f08535]' }} px-6 py-2 rounded-xl font-atkinson font-bold shadow-sm print:border print:border-orange-200">
                                {{ $pedidoSeleccionado->completed == 0 ? 'Pendiente' : 'Completado' }}
                            </div>
                        </div>

                        {{-- Tabla productos con dropdown funcional --}}
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
                                            $disabled = in_array($status, ['Aceptado','Rechazado']);
                                            $isOpen = $dropdownAbierto[$p->id] ?? false;
                                        @endphp
                                        <tr wire:key="producto-{{ $p->id }}">
                                            <td class="bg-[#eef2e6] py-3 px-4 print:bg-transparent print:border-b">{{ $p->name }}</td>
                                            <td class="bg-[#eef2e6] py-3 px-4 print:bg-transparent print:border-b">{{ number_format($p->pivot->price_per_unit, 2) }}€</td>
                                            <td class="bg-[#eef2e6] py-3 px-4 print:bg-transparent print:border-b">{{ $p->pivot->quantity }} - {{ number_format($p->pivot->quantity * $p->pivot->price_per_unit, 2) }}€</td>
                                            <td class="bg-[#fdf3e7] py-3 px-4 font-bold print:bg-transparent print:border-b">
                                                @if($disabled)
                                                    <span class="{{ $status == 'Rechazado' ? 'text-red-600' : 'text-green-700' }}">{{ $status }}</span>
                                                @else
                                                    <div class="relative inline-block text-left">
                                                        <button type="button"
                                                            class="inline-flex justify-center w-full rounded-md bg-[#fdf3e7] text-[#e69b55] px-3 py-1 font-bold shadow-sm"
                                                            wire:click="$toggle('dropdownAbierto.{{ $p->id }}')">
                                                            {{ $status }}
                                                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.23 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                                                            </svg>
                                                        </button>

                                                        @if($isOpen)
                                                            <div class="origin-top-right absolute right-0 mt-1 w-28 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10">
                                                                <div class="py-1 text-sm text-gray-700">
                                                                    <a href="#" wire:click.prevent="cambiarEstadoProducto({{ $p->id }}, 'Aceptado')" class="block px-4 py-1 hover:bg-gray-100">Aceptar</a>
                                                                    <a href="#" wire:click.prevent="cambiarEstadoProducto({{ $p->id }}, 'Rechazado')" class="block px-4 py-1 hover:bg-gray-100 text-red-600">Rechazar</a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
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
                            <button onclick="window.print()" class="bg-[#fbece1] text-[#f08535] hover:bg-orange-200 px-8 py-2 rounded-xl font-atkinson font-bold shadow-sm transition">Imprimir</button>
                            <button wire:click="$set('modalAbierto', false)" class="bg-[#f2e6e6] text-[#b34040] hover:bg-red-200 px-8 py-2 rounded-xl font-atkinson font-bold shadow-sm transition">Cerrar</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>