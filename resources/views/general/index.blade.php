@extends('layouts.app')

@section('content')
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Mercadillos La Palma</title>
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        </head>
        <body class="font-titulo-principal text-status-dark">

            <header class="relative w-full h-[500px] md:h-[400px] bg-gray-100">
            
            <img src="{{ asset('img/hero.png') }}" alt="Hero" class="absolute inset-0 w-full h-full object-cover object-top md:object-center opacity-90">

            <div class="relative z-10 container mx-auto px-6 h-full flex flex-col justify-between pb-12 md:pb-8">
                <h1 class="font-titulo-principal font-bold text-4xl text-right ml-auto leading-none">
                    Bienvenido a los <span class="text-primary">mercadillos</span><br>
                    en la <span class="text-primary">palma</span>
                </h1>
                
                <div class="mt-8 ml-auto text-right max-w-xs md:max-w-lg font-dm-serif">
                    <p class="text-xl md:text-3xl leading-tight font-semibold">
                        La web donde podrás informarte <br>
                        sobre los <span class="text-primary">mercadillos</span> y sus <span class="text-primary">productos</span>
                    </p>
                </div>
            </div>
        </header>

            <div class="relative z-30 w-full px-2 font-atkinson">
                <div class="max-w-5xl mx-auto -mt-8 relative">

                    <div class="absolute top-8 left-[16.5%] right-[16.5%] border-t-[6px] border-dotted border-accent-olive z-0"></div>

                    <div class="grid grid-cols-3 gap-1 relative z-10">
                        
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-full border-[5px] border-accent-olive bg-primary-pastel flex items-center justify-center shadow-md overflow-hidden relative z-10">
                                <img src="{{ asset('img/icons/calendario.png') }}" class="w-8 object-cover">
                            </div>
                            <div class="mt-2 text-center">
                                <h3 class="text-[10px] md:text-xs font-bold font-general leading-tight">
                                    Consulta los horarios
                                </h3>
                                <p class="text-[9px] leading-tight">
                                    de cada uno de los mercadillos
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-full border-[5px] border-accent-olive bg-primary-pastel flex items-center justify-center shadow-md overflow-hidden relative z-10">
                                <img src="{{ asset('img/icons/mercado.png') }}" class="w-8 object-cover">
                            </div>
                            <div class="mt-2 text-center border-l border-r border-gray-200 px-1 md:px-4 w-full"> 
                                <h3 class="text-[10px] md:text-xs font-bold leading-tight">
                                    Conoce la información
                                </h3>
                                <p class="text-[9px] ">
                                    completa de los puestos
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-full border-[5px] border-accent-olive bg-primary-pastel flex items-center justify-center shadow-md overflow-hidden relative z-10">
                                <img src="{{ asset('img/icons/euro.png') }}" class="w-8 object-cover">
                            </div>
                            <div class="mt-2 text-center">
                                <h3 class="text-[10px] md:text-xs font-bold leading-tight">
                                    Reserva productos
                                </h3>
                                <p class="text-[9px]">
                                    y recógelos en el mercadillo
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="pt-12 bg-gray-50"> 
                <livewire:public.market-search />
            </div>

        </body>
    </html>
@endsection