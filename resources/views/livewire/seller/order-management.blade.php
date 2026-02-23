<div>
    <div class="mb-8">
        <h2 class="text-3xl font-serif font-bold font-titulo-principal text-coffe mb-4">Filtrar por:</h2>

        <div class="flex flex-wrap font-dm-serif gap-4 items-center">
            <select wire:model.live="filtroAno"
                class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm font-medium text-[#3d4d3e]">
                <option value="">Año</option>
                <option value="2026">2026</option>
            </select>

            <select wire:model.live="filtroMes"
                class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm font-medium text-[#3d4d3e]">
                <option value="">Mes</option>
                <option value="1">Enero</option>
            </select>

            <select wire:model.live="filtroPuesto"
                class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm font-medium text-[#3d4d3e]">
                <option value="">Puesto</option>
                <option value="1">Puesto Principal</option>
            </select>

            <select wire:model.live="filtroEstado"
                class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm font-medium text-[#3d4d3e]">
                <option value="">Estado</option>
                <option value="pendiente">Pendiente</option>
                <option value="completado">Completado</option>
            </select>

            <div class="relative flex-1 min-w-[200px] max-w-xs ml-auto sm:ml-4">
                <input type="text" wire:model.live="busqueda" placeholder="Buscar"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 pl-3 pr-10">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-6 w-6 text-black font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <h2 class="text-3xl font-serif font-bold font-titulo-principal text-coffe mb-4">Resumen</h2>
    <div class="flex flex-wrap font-dm-serif gap-6 mb-10">
        <div class="bg-white rounded-xl shadow px-8 py-6 flex flex-col items-center justify-center min-w-[220px]">
            <div class="flex items-center gap-3">
                <div class="bg-[#fbece1] p-3 rounded-xl flex items-center justify-center">

                    <img src="{{ asset('img/icons/bagyellow.png') }}" alt="Icono Pendientes"
                        class="w-8 h-8 object-contain">

                </div>
                <span class="text-4xl font-bold font-dm-serif text-accent-yellow">{{ $totalPendientes }}</span>
            </div>
            <p class="text-base font-medium mt-3 font-atkinson text-gray-800">Pedidos pendientes</p>
        </div>

        <div class="bg-white rounded-xl shadow px-8 py-6 flex flex-col items-center justify-center min-w-[220px]">
            <div class="flex items-center gap-3">
                <div class="bg-[#fbece1] p-3 rounded-xl flex items-center justify-center">

                    <img src="{{ asset('img/icons/bagoranje.png') }}" alt="Icono Completados"
                        class="w-8 h-8 object-contain">

                </div>
                <span class="text-4xl font-bold font-dm-serif text-accent-orange">{{ $totalCompletados }}</span>
            </div>
            <p class="text-base font-medium mt-3 font-atkinson text-gray-800">Pedidos completados</p>
        </div>
    </div>

    <h2 class="text-3xl font-serif font-bold font-titulo-principal text-coffe mb-4">Pedidos</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-16">

        @forelse ($pedidos as $pedido)
            <div class="bg-white rounded-xl shadow p-6 relative">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold font-atkinson text-black">nº {{ $pedido->id }}</h3>
                        <p class="text-sm font-medium font-atkinson text-gray-800 mt-1">
                            {{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') }} - {{ $pedido->hora }}</p>
                        <p class="text-sm font-atkinson text-gray-600 mt-1">{{ $pedido->cantidad_productos }} productos</p>
                    </div>

                    @if ($pedido->estado === 'pendiente')
                        <span
                            class="px-4 py-1 bg-[#fdf3e7] text-[#e69b55] font-atkinson text-xs font-bold rounded-lg shadow-sm">Pendiente</span>
                    @else
                        <span
                            class="px-4 py-1 bg-[#fbece1] text-[#f08535] font-atkinson text-xs font-bold rounded-lg shadow-sm">Completado</span>
                    @endif
                </div>
                <div class="mt-8 flex justify-between items-center">
                    <p class="text-xl font-bold font-dm-serif text-[#3d4d3e]">Total: <span
                            class="text-[#4a5d4e] font-atkinson">{{ number_format($pedido->total, 2) }}€</span></p>

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
                <p class="text-gray-500 mt-2">Cuando un cliente te compre algo, aparecerá aquí.</p>
            </div>
        @endforelse

    </div>

    @if ($modalAbierto)
    @endif
</div>
