<div class="bg-primary-pastel py-16">

    <div class="container mx-auto px-4 md:px-8">

        <h2 class="text-4xl text-coffee mb-12 pl-2 font-bold font-playfair">
            Mercadillos
        </h2>

        <div class="grid grid-cols-1 gap-10 w-10/12 mx-auto md:w-full md:grid-cols-2 max-w-6xl">

            @foreach ($markets as $market)
                <div class="bg-white rounded-3xl shadow-sm overflow-hidden flex flex-col md:flex-row hover:shadow-lg transition-shadow duration-300">

                    {{-- Imagen --}}
                    <div class="h-56 w-full md:w-2/5 md:h-auto shrink-0 bg-gray-200 relative">
                        <img
                            src="{{ $market->img_url ? asset($market->img_url) : asset('img/hero.png') }}"
                            alt="Mercadillo {{ $market->municipality->name }}"
                            class="w-full h-full object-cover md:absolute md:inset-0"
                        >
                    </div>

                    {{-- Contenido --}}
                    <div class="p-8 flex flex-col flex-grow">

                        <h3 class="text-center text-3xl text-status-dark mb-6 font-bold font-dm-serif">
                            {{ $market->municipality->name }}
                        </h3>

                        <div class="space-y-5 text-status-dark flex-grow font-general">

                            {{-- Dirección --}}
                            <div class="flex items-start gap-4">
                                <div class="w-6 h-6 flex-shrink-0 mt-1">
                                    <img src="{{ asset('img/icons/marcador.png') }}" class="w-full h-full">
                                </div>
                                <span class="text-xl leading-relaxed">
                                    {{ $market->address }}
                                </span>
                            </div>

                            {{-- Horarios --}}
                            <div class="flex items-center gap-4">
                                <div class="w-6 h-6 flex-shrink-0">
                                    <img src="{{ asset('img/icons/calendario-reloj.png') }}" class="w-full h-full">
                                </div>

                                <div class="relative w-full">
                                    <select
                                        class="w-full bg-gray-100 text-status-dark invalid:text-gray-400 text-xl rounded px-3 py-2 cursor-pointer border-none focus:ring-2 focus:ring-primary/50 appearance-none"
                                    >
                                        <option disabled selected>Ver horarios</option>

                                        @foreach ($market->schedules as $schedule)
                                            <option>
                                                {{ ucfirst($schedule->day) }}:
                                                {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2">
                                        <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Puestos (placeholder) --}}
                            <div class="flex items-start gap-4">
                                <div class="w-6 h-6 flex-shrink-0 mt-1">
                                    <img src="{{ asset('img/icons/tienda-del-mercado.png') }}" class="w-full h-full">
                                </div>
                                <span class="text-xl">
                                    {{ $market->stalls()->count() }} puestos
                                </span>
                            </div>
                        </div>

                        {{-- Botón --}}
                        <div class="mt-6 flex justify-end">
                            <a
                                href="#"
                                class="bg-primary hover:bg-primary-hover text-white px-10 py-3 rounded shadow-md transition font-bold uppercase tracking-wide font-dm-serif"
                            >
                                Acceder
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>