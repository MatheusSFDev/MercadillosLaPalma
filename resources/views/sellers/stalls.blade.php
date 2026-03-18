@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-[#f0f4e8]">
    <div class="max-w-5xl mx-auto px-6 py-8">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-[#3b2f1e]">Tus puestos</h1>
            <span class="text-sm font-medium text-[#c8973a]">Resumen semanal</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($data as $item)
            @php $stall = $item['stallData']; @endphp
            <div class="bg-white rounded-2xl p-5 shadow-sm">

                <div class="flex justify-between items-center mb-1">
                    <h2 class="text-xl font-bold text-[#3b2f1e]">{{ $stall->name }}</h2>
                    @if($stall->active)
                        <span class="flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-semibold bg-[#fff3cd] text-[#c8973a]">
                            <span class="w-2 h-2 rounded-full bg-[#c8973a]"></span>
                            Activo
                        </span>
                    @else
                        <span class="flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-500">
                            <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                            Inactivo
                        </span>
                    @endif
                </div>

                <div class="flex gap-4 text-sm text-gray-500 mb-4">
                    <span class="flex items-center gap-1">
                        <img src="{{ asset('img/icons/marcador.png') }}" class="w-3.5 h-3.5" alt="ubicación">
                        {{ $stall->fleaMarket?->municipality?->name ?? 'Sin ubicación' }}
                    </span>
                    <div class="flex items-center gap-1 flex-wrap">
                        <img src="{{ asset('img/icons/caja-abierta-llena.png') }}" class="w-3.5 h-3.5" alt="categoría">
                        @forelse($item['categories'] as $category)
                            <span>{{ $category }}@unless($loop->last), @endunless</span>
                        @empty
                            <span>Sin categoría</span>
                        @endforelse
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3 mb-4">
                    <div class="bg-[#f6f4f0] rounded-xl py-3 flex flex-col items-center gap-0.5">
                        <img src="{{ asset('img/icons/caja-abierta-llena.png') }}" class="w-6 h-6" alt="productos">
                        <span class="text-lg font-bold text-[#3b2f1e]">{{ $item['products'] }}</span>
                        <span class="text-xs text-gray-500">Productos</span>
                    </div>
                    <div class="bg-[#f6f4f0] rounded-xl py-3 flex flex-col items-center gap-0.5">
                        <img src="{{ asset('img/icons/caja-abierta-llena.png') }}" class="w-6 h-6" alt="pedidos">
                        <span class="text-lg font-bold text-[#3b2f1e]">{{ $item['orders'] }}</span>
                        <span class="text-xs text-gray-500">Pedidos</span>
                    </div>
                    <div class="bg-[#f6f4f0] rounded-xl py-3 flex flex-col items-center gap-0.5">
                        <img src="{{ asset('img/icons/euro.svg') }}" class="w-6 h-6" alt="ingresos">
                        <span class="text-lg font-bold text-[#3b2f1e]">{{ $item['income'] }}</span>
                        <span class="text-xs text-gray-500">Ingresos</span>
                    </div>
                </div>

                <div class="flex gap-2 items-center">
                    <a href="/seller/edit/products" class="flex-1 bg-[#3d5a2e] text-white text-center text-sm font-semibold py-2.5 rounded-lg">
                        Gestionar productos
                    </a>
                    <a href="#" class="text-sm font-semibold text-[#3d5a2e] border border-[#3d5a2e] py-2.5 px-4 rounded-lg">
                        Editar
                    </a>
                    <button class="bg-red-50 text-red-500 hover:bg-red-100 p-2.5 rounded-lg transition">
                        <img src="{{ asset('img/icons/basura.svg') }}" class="w-4 h-4" alt="eliminar">
                    </button>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>

@endsection