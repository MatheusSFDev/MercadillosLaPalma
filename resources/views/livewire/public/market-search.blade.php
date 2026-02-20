<div class="bg-primary-pastel py-16">

    <div class="container mx-auto px-4 md:px-8">

        <h2 class="text-4xl text-coffee mb-12 pl-2 font-bold font-playfair">
            Mercadillos
        </h2>

        <div class="grid grid-cols-1 gap-10 w-10/12 mx-auto md:w-full md:grid-cols-2 max-w-6xl">

            <div class="bg-white rounded-3xl shadow-sm overflow-hidden flex flex-col md:flex-row hover:shadow-lg transition-shadow duration-300">

                <div class="h-56 w-full md:w-2/5 md:h-auto shrink-0 bg-gray-200 relative">
                    <img src="{{ asset('img/hero.png') }}" alt="Mercadillo Mazo" class="w-full h-full object-cover md:absolute md:inset-0">
                </div>

                <div class="p-8 flex flex-col flex-grow">

                    <h3 class="text-center text-3xl text-status-dark mb-6 font-bold font-dm-serif">
                        Villa de Mazo
                    </h3>

                    <div class="space-y-5 text-sm text-status-dark flex-grow font-general">

                        <div class="flex items-start gap-4">
                            <div class="w-6 h-6 flex-shrink-0 mt-0.5">
                                <img src="{{ asset('img/icons/marcador.png') }}" alt="Ubicación" class="w-full h-full object-contain">
                            </div>
                            <span class="leading-relaxed text-xl font-open-sans">Calle Enlace Doctor Morera Bravo (El Pueblo), 38730 Villa de Mazo, Santa Cruz de Tenerife</span>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-6 h-6 flex-shrink-0">
                                <img src="{{ asset('img/icons/calendario-reloj.png') }}" alt="Horario" class="w-full h-full object-contain">
                            </div>
                            <div class="relative w-full">
                                <select required class="w-full bg-gray-100 text-status-dark invalid:text-gray-400 text-xl rounded px-3 py-2 cursor-pointer font-open-sans border-none focus:ring-2 focus:ring-primary/50 outline-none appearance-none bg-none">
                                    <option value="" disabled selected>Ver horarios</option>
                                    <option value="sabado" class="text-status-dark">Sábados: 09:00 - 14:00</option>
                                    <option value="domingo" class="text-status-dark">Domingos: 09:00 - 14:00</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-status-dark">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-6 h-6 flex-shrink-0 mt-0.5">
                                <img src="{{ asset('img/icons/tienda-del-mercado.png') }}" alt="Puestos" class="w-full h-full object-contain">
                            </div>
                            <span class="leading-relaxed text-xl font-open-sans">25 puestos</span>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button class="bg-primary hover:bg-primary-hover text-white px-10 py-3 rounded shadow-md transition font-bold text-base uppercase tracking-wide font-dm-serif">
                            Acceder
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm overflow-hidden flex flex-col md:flex-row hover:shadow-lg transition-shadow duration-300">

                <div class="h-56 w-full md:w-2/5 md:h-auto shrink-0 bg-gray-200 relative">
                     <img src="{{ asset('img/hero.png') }}" alt="Mercadillo Puntagorda" class="w-full h-full object-cover md:absolute md:inset-0">
                </div>

                <div class="p-8 flex flex-col flex-grow">

                    <h3 class="text-center text-3xl text-status-dark mb-6 font-bold font-dm-serif">
                        Puntagorda
                    </h3>

                    <div class="space-y-5 text-sm text-status-dark flex-grow font-general">

                        <div class="flex items-start gap-4">
                            <div class="w-6 h-6 flex-shrink-0 mt-0.5">
                                <img src="{{ asset('img/icons/marcador.png') }}" alt="Ubicación" class="w-full h-full object-contain">
                            </div>
                            <span class="leading-relaxed text-xl font-open-sans">Camino el Pinar, 56A, 38789 Puntagorda, Santa Cruz de Tenerife</span>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-6 h-6 flex-shrink-0">
                                <img src="{{ asset('img/icons/calendario-reloj.png') }}" alt="Horario" class="w-full h-full object-contain">
                            </div>
                            <div class="relative w-full">
                                <select required class="w-full bg-gray-100 text-status-dark invalid:text-gray-400 text-xl rounded px-3 py-2 cursor-pointer font-bold font-open-sans border-none focus:ring-2 focus:ring-primary/50 outline-none appearance-none bg-none">
                                    <option value="" disabled selected>Ver horarios</option>
                                    <option value="sabado" class="text-status-dark">Sábados: 15:00 - 19:00</option>
                                    <option value="domingo" class="text-status-dark">Domingos: 11:00 - 15:00</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-status-dark">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-6 h-6 flex-shrink-0 mt-0.5">
                                <img src="{{ asset('img/icons/tienda-del-mercado.png') }}" alt="Puestos" class="w-full h-full object-contain">
                            </div>
                            <span class="leading-relaxed text-xl font-open-sans">15 puestos</span>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button class="bg-primary hover:bg-primary-hover text-white px-10 py-3 rounded shadow-md transition font-bold text-base uppercase tracking-wide font-dm-serif">
                            Acceder
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>