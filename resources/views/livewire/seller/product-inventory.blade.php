<div class="p-10 font-atkinson text-status-dark bg-primary-pastel min-h-screen">

    <div class="mb-6">
        <h1 class="text-coffee font-titulo-principal font-bold text-4xl mb-1">Gestión de Productos</h1>
        <p class="text-coffee-light">Vista completa con productos asignados y sin asignar a puestos</p>
    </div>

    <div class="bg-status-white rounded-xl p-4 shadow-sm mb-6">

        <div class="flex justify-between items-center mb-5">
            <h2 class="text-coffee font-titulo-seccion text-xl font-bold">Mis productos</h2>
            <button
                class="bg-primary-offgreen text-primary-pastel flex items-center gap-1 px-4 py-2 rounded-lg text-sm font-semibold shadow-sm hover:opacity-90 transition-opacity">
                <span>+</span> Añadir productos
            </button>
        </div>

        <div class="flex flex-col md:flex-row md:items-center gap-4 mb-6">
            
            <div class="relative w-full md:flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-accent-darkgrey" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" placeholder="Buscar productos..."
                    class="w-full bg-accent-lightred text-status-dark text-sm placeholder:text-accent-grey rounded-lg pl-10 pr-3 py-2 border-none focus:ring-1 focus:ring-primary outline-none">
            </div>

            <div class="grid grid-cols-2 md:flex md:items-center gap-4 w-full md:w-auto shrink-0">
                
                <div class="flex flex-col md:flex-row md:items-center gap-1 md:gap-2">
                    <label class="text-status-dark font-dm-serif text-lg md:whitespace-nowrap">Categoría</label>
                    <select class="w-full md:w-48 bg-accent-lightred text-accent-grey text-sm rounded-lg px-3 py-2 border-none outline-none focus:ring-1 focus:ring-primary">
                        <option>Todas las categorías</option>
                    </select>
                </div>

                <div class="flex flex-col md:flex-row md:items-center gap-1 md:gap-2">
                    <label class="text-status-dark font-dm-serif text-lg md:whitespace-nowrap">Estado</label>
                    <select class="w-full md:w-48 bg-accent-lightred text-accent-grey text-sm rounded-lg px-3 py-2 border-none outline-none focus:ring-1 focus:ring-primary">
                        <option>Todos los estados</option>
                    </select>
                </div>

            </div>

        </div>

        <div class="mb-2">
            <h3 class="text-base font-dm-serif text-lg mb-3 text-status-dark">Resumen</h3>
            <div class="grid grid-cols-4 gap-2 md:gap-4 text-center">

                <div
                    class="bg-accent-altorange rounded-3xl py-4 px-1 md:py-4 md:px-4 shadow-sm flex flex-col md:flex-row justify-center items-center md:items-baseline md:gap-2 h-full">
                    <span class="text-coffee-light font-bold font-playfair text-3xl leading-none mb-1 md:mb-0">12</span>
                    <span class="font-dm-serif leading-tight text-sm text-status-dark">
                        <span class="md:hidden">Total de<br>productos</span>
                        <span class="hidden md:inline">Total de productos</span>
                    </span>
                </div>

                <div
                    class="bg-accent-lightgreen rounded-3xl py-4 px-1 md:py-4 md:px-4 shadow-sm flex flex-col md:flex-row justify-center items-center md:items-baseline md:gap-2 h-full">
                    <span class="text-primary font-bold font-playfair text-3xl leading-none mb-1 md:mb-0">8</span>
                    <span class="font-dm-serif leading-tight text-sm text-status-dark">
                        <span class="md:hidden">Productos<br>asignados</span>
                        <span class="hidden md:inline">Productos asignados</span>
                    </span>
                </div>

                <div
                    class="bg-accent-lightorange rounded-3xl py-4 px-1 md:py-4 md:px-4 shadow-sm flex flex-col md:flex-row justify-center items-center md:items-baseline md:gap-2 h-full">
                    <span class="text-accent-darkyellow font-bold font-playfair text-3xl leading-none mb-1 md:mb-0">4</span>
                    <span class="font-dm-serif leading-tight text-sm text-status-dark">
                        <span class="md:hidden">Productos<br>sin asignar</span>
                        <span class="hidden md:inline">Productos sin asignar</span>
                    </span>
                </div>

                <div
                    class="bg-accent-pastelred rounded-3xl py-4 px-1 md:py-4 md:px-4 shadow-sm flex flex-col md:flex-row justify-center items-center md:items-baseline md:gap-2 h-full">
                    <span class="text-accent-orange font-bold font-playfair text-3xl leading-none mb-1 md:mb-0">2</span>
                    <span class="font-dm-serif leading-tight text-sm text-status-dark">
                        <span class="md:hidden">Puestos<br>activos</span>
                        <span class="hidden md:inline">Puestos activos</span>
                    </span>
                </div>

            </div>
        </div>
    </div>

    <div class="bg-status-white rounded-xl shadow-sm overflow-hidden font-dm-serif">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-center">
                <thead class="bg-accent-olive text-primary-pastel">
                    <tr>
                        <th class="py-3 px-4 text-left">Producto</th>
                        <th class="py-3 px-2">Estado</th>
                        <th class="py-3 px-2">Puestos <br class="md:hidden">asignados</th>
                        <th class="py-3 px-2">Stock <br class="md:hidden">Total</th>
                        <th class="py-3 px-2">Precio<br class="md:hidden">Promedio</th>
                        <th class="py-3 px-4">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-status-dark">

                    <tr class="border-b border-accent-lightgrey/30">
                        <td class="py-4 px-4 text-left whitespace-nowrap">Tomate de<br class="md:hidden"> ensalada</td>
                        <td class="py-4 px-2 whitespace-nowrap">
                            <span class="bg-accent-lightgreen text-primary px-3 py-1 rounded-full">Asignado</span>
                        </td>
                        <td class="py-4 px-2 whitespace-nowrap">Villa de Mazo</td>
                        <td class="py-4 px-2 whitespace-nowrap">20<br class="md:hidden"> uds</td>
                        <td class="py-4 px-2 whitespace-nowrap">3.50€</td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <button
                                    class="bg-accent-lightgreen p-1.5 rounded-md hover:bg-primary-pastel transition-colors">
                                    <x-icons.lapiz class="w-4 h-4 text-primary" />
                                </button>
                                <button
                                    class="bg-accent-againorange p-1.5 rounded-md hover:opacity-80 transition-opacity">
                                    <x-icons.papelera class="w-4 h-4 text-status-error" />
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="border-b border-accent-lightgrey/30">
                        <td class="py-4 px-4 text-left whitespace-nowrap">Manzanas<br class="md:hidden"> Rojas</td>
                        <td class="py-4 px-2 whitespace-nowrap">
                            <span class="bg-accent-lightgreen text-primary px-3 py-1 rounded-full">Asignado</span>
                        </td>
                        <td class="py-4 px-2 whitespace-nowrap leading-tight">Villa de Mazo<br>Puntallana</td>
                        <td class="py-4 px-2 whitespace-nowrap">25<br class="md:hidden"> uds</td>
                        <td class="py-4 px-2 whitespace-nowrap">5.75€</td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <button
                                    class="bg-accent-lightgreen p-1.5 rounded-md hover:bg-primary-pastel transition-colors">
                                    <x-icons.lapiz class="w-4 h-4 text-primary" />
                                </button>
                                <button
                                    class="bg-accent-againorange p-1.5 rounded-md hover:opacity-80 transition-opacity">
                                    <x-icons.papelera class="w-4 h-4 text-status-error" />
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="border-b border-accent-lightgrey/30">
                        <td class="py-4 px-4 text-left whitespace-nowrap">Cebollas</td>
                        <td class="py-4 px-2 whitespace-nowrap">
                            <span class="bg-accent-lightorange px-3 py-1 rounded-full text-accent-darkyellow">Sin Asignar</span>
                        </td>
                        <td class="py-4 px-2 whitespace-nowrap text-accent-grey">Sin Asignar</td>
                        <td class="py-4 px-2 whitespace-nowrap text-accent-grey">----</td>
                        <td class="py-4 px-2 whitespace-nowrap text-accent-grey">----</td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <button
                                    class="bg-accent-lightgreen p-1.5 rounded-md hover:bg-primary-pastel transition-colors">
                                    <x-icons.lapiz class="w-4 h-4 text-primary" />
                                </button>
                                <button
                                    class="bg-accent-againorange p-1.5 rounded-md hover:opacity-80 transition-opacity">
                                    <x-icons.papelera class="w-4 h-4 text-status-error" />
                                </button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>