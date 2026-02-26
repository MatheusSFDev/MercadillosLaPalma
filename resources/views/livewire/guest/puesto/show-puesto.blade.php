@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 w-full">
        <div class="relative h-64 md:h-80 bg-coffee overflow-hidden">
            {{-- Debug: Muestra el valor de img_url --}}
            <!-- img_url: {{ $stall->img_url }} -->
            @if($stall->img_url && $stall->img_url !== 'img/imgNotAvailable.png')
                <img src="{{ asset($stall->img_url) }}" class="w-full h-full object-cover opacity-60" alt="Banner">
            @else
                <img src="{{ asset('img/imgNotAvailable.png') }}" class="w-full h-full object-cover opacity-60" alt="Banner Default">
            @endif

            <div class="absolute inset-0 flex items-end">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-8">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <div
                            class="w-32 h-32 rounded-full border-4 border-white bg-white overflow-hidden shadow-lg -mb-16 md:mb-0">
                            @if($stall->user->avatar)
                                <img 
                                    src="{{ asset('storage/' . $stall->user->avatar) }}" 
                                    class="w-full h-full object-cover" 
                                    alt="Avatar"
                                >
                            @else
                                <img 
                                    src="{{ asset('img/imgNotAvailable.png') }}" 
                                    class="w-full h-full object-cover" 
                                    alt="Sin avatar"
                                >
                            @endif
                        </div>

                        <div class="text-center md:text-left flex-grow">
                            <h1 class="text-3xl md:text-5xl font-serif font-bold text-white mb-2 drop-shadow-md">
                                {{ $stall->name }}
                            </h1>
                            <p class="text-secondary-cream font-sans font-bold uppercase tracking-widest text-sm">
                                Vendedor: {{ $stall->user->name }} {{ $stall->user->surname }} | {{ $stall->fleaMarket->municipality->name }}
                            </p>
                            @if($stall->information)
                                <p class="text-white mt-3 text-sm md:text-base">
                                    {{ $stall->information }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            @if($productos->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-600 text-lg">Este puesto no tiene productos disponibles por el momento.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($productos as $producto)
                        @php
                            $foto = $producto->photos ? $producto->photos->first() : null;
                            $imagenUrl = $foto && $foto->url ? asset($foto->url) : asset('img/imgNotAvailable.png');
                        @endphp
                        <livewire:guest.puesto.product-card 
                            :key="'prod-' . $producto->id" 
                            :id="$producto->id" 
                            :nombre="$producto->name"
                            :precio="$producto->pivot->price_per_unit ?? 0" 
                            :descripcion="$foto?->description ?? 'Producto disponible'" 
                            :imagen="$imagenUrl" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection