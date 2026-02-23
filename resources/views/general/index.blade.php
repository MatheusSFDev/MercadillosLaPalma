@extends('layouts.app')

@section('content')

    <header class="relative w-full h-[500px] md:h-[400px] bg-gray-100">
        <img
            src="{{ asset('img/hero.png') }}"
            alt="Hero"
            class="absolute inset-0 w-full h-full object-cover object-top md:object-center opacity-90"
        >

        <div class="relative z-10 container mx-auto px-6 h-full flex flex-col justify-between pb-12 md:pb-8">

            {{-- TÍTULO --}}
            <h1
                class="font-titulo-principal font-bold text-2xl text-right ml-auto leading-none pt-10 md:text-4xl
                    max-w-[500px]"
            >
                Bienvenido a los
                <span class="text-primary">mercadillos</span>
                en la
                <span class="text-primary">palma</span>
            </h1>

            {{-- SUBTÍTULO --}}
            <div
                class="mt-8 ml-auto text-right font-dm-serif
                    max-w-[270px] md:max-w-[700px]"
            >
                <p class="text-md md:text-4xl leading-tight">
                    La web donde podrás informarte sobre los
                    <span class="text-primary">mercadillos</span>
                    y sus
                    <span class="text-primary">productos</span>
                </p>
            </div>

        </div>
    </header>

    {{-- ICONOS --}}
    <div class="relative z-30 w-full px-2 font-atkinson pb-5">
        <div class="max-w-5xl mx-auto -mt-8 relative">

            <div
                class="absolute top-8 left-[16.5%] right-[16.5%]
                    border-t-[6px] border-dotted border-accent-olive z-0"
            ></div>

            <div class="grid grid-cols-3 gap-1 relative z-10">

                {{-- ITEM --}}
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 rounded-full border-[5px] border-accent-olive bg-primary-pastel flex items-center justify-center shadow-md">
                        <img src="{{ asset('img/icons/calendario.png') }}" class="w-8 object-cover">
                    </div>

                    <p class="mt-5 text-center text-xs max-w-[160px] md:text-[18px] md:max-w-[230px]">
                        <span class="font-bold">Consulta los horarios</span>
                        de cada uno de los mercadillos
                    </p>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 rounded-full border-[5px] border-accent-olive bg-primary-pastel flex items-center justify-center shadow-md">
                        <img src="{{ asset('img/icons/mercado.png') }}" class="w-8 object-cover">
                    </div>

                    <p class="mt-5 text-center text-xs max-w-[160px] md:text-[18px] md:max-w-[230px]">
                        <span class="font-bold">Conoce la información</span>
                        completa de los puestos
                    </p>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 rounded-full border-[5px] border-accent-olive bg-primary-pastel flex items-center justify-center shadow-md">
                        <img src="{{ asset('img/icons/euro.png') }}" class="w-8 object-cover">
                    </div>

                    <p class="mt-5 text-center text-xs max-w-[160px] md:text-[18px] md:max-w-[230px]">
                        <span class="font-bold">Reserva productos</span>
                        y recógelos en el mercadillo
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- MERCADILLOS --}}
    <div class="bg-gray-50">
        <livewire:public.market-search />
    </div>

@endsection