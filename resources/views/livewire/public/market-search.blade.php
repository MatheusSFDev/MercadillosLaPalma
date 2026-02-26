<div class="bg-primary-pastel py-6 md:py-8 min-h-screen">

    <div class="container mx-auto px-4 md:px-12 max-w-7xl">

        {{-- Título Principal: Sin exceso de padding --}}
        <h2 class="text-4xl md:text-5xl text-coffee mb-6 md:mb-8 font-bold font-playfair pl-1 leading-none">
            Mercadillos
        </h2>

        {{-- Grid: 2 columnas en escritorio --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            @foreach ($markets as $market)
                {{-- Tarjeta: Altura mínima controlada --}}
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col md:flex-row md:h-40 lg:h-36 hover:shadow-md transition-all duration-300 border border-white/50">

                    {{-- Imagen --}}
                    <div class="w-full md:w-[32%] p-2 shrink-0">
                        <div class="h-40 md:h-full w-full overflow-hidden rounded-xl">
                            <img
                                src="{{ $market->img_url ? asset($market->img_url) : asset('img/hero.png') }}"
                                alt="Mercadillo {{ $market->municipality->name }}"
                                class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500"
                            >
                        </div>
                    </div>

                    {{-- Contenido --}}
                    <div class="p-4 flex flex-col justify-center flex-grow text-status-dark min-w-0">
                        
                        {{-- Nombre del municipio --}}
                        <h3 class="text-xl font-bold font-dm-serif mb-2 leading-tight truncate">
                            {{ $market->municipality->name }}
                        </h3>

                        {{-- Fila de datos y botón alineados --}}
                        <div class="flex items-end justify-between gap-2">
                            
                            {{-- Columna de Información --}}
                            <div class="space-y-1.5 font-general flex-grow">
                                {{-- Dirección --}}
                                <div class="flex items-center gap-2">
                                    <div class="w-3.5 h-3.5 flex-shrink-0">
                                        <img src="{{ asset('img/icons/marcador.png') }}" class="w-full h-full opacity-80">
                                    </div>
                                    <p class="text-[11px] leading-none truncate opacity-90 max-w-[180px]">
                                        {{ $market->address }}
                                    </p>
                                </div>

                                {{-- Selector de Horarios: Flecha duplicada eliminada --}}
                                <div class="flex items-center gap-2">
                                    <div class="w-3.5 h-3.5 flex-shrink-0">
                                        <img src="{{ asset('img/icons/calendario-reloj.png') }}" class="w-full h-full opacity-80">
                                    </div>
                                    <div class="relative w-full max-w-[150px]">
                                        <select
                                            class="w-full bg-gray-100 text-status-dark text-[11px] 
                                                   rounded-md px-2 py-1 pr-6 cursor-pointer border-none
                                                   focus:ring-1 focus:ring-primary/50 appearance-none leading-tight"
                                            style="-webkit-appearance: none; -moz-appearance: none;"
                                        >
                                            <option disabled selected>Ver horarios</option>
                                            @foreach ($market->schedules as $schedule)
                                                <option class="bg-white">
                                                    {{ ucfirst($schedule->day) }}: {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Puestos --}}
                                <div class="flex items-center gap-2">
                                    <div class="w-3.5 h-3.5 flex-shrink-0">
                                        <img src="{{ asset('img/icons/tienda-del-mercado.png') }}" class="w-full h-full opacity-80">
                                    </div>
                                    <span class="text-[11px] leading-none opacity-90">
                                        {{ $market->stalls()->count() }} puestos
                                    </span>
                                </div>
                            </div>

                            {{-- Botón: Alineado con los datos, sin bold ni uppercase --}}
                            <div class="flex-shrink-0">
                                <a
                                    href="{{ route('general.stalls', $market->id) }}"
                                    class="bg-primary hover:bg-primary-hover text-white px-5 py-2 rounded-lg text-sm transition font-normal font-dm-serif shadow-sm inline-block"
                                >
                                    Ver mercadillo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>