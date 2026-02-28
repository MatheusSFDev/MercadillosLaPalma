<div x-data="{ isEditModalOpen: false }" class="p-10 font-atkinson text-status-dark bg-primary-pastel min-h-screen">

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
                    <select
                        class="w-full md:w-48 bg-accent-lightred text-accent-grey text-sm rounded-lg px-3 py-2 border-none outline-none focus:ring-1 focus:ring-primary">
                        <option>Todas las categorías</option>
                    </select>
                </div>

                <div class="flex flex-col md:flex-row md:items-center gap-1 md:gap-2">
                    <label class="text-status-dark font-dm-serif text-lg md:whitespace-nowrap">Estado</label>
                    <select
                        class="w-full md:w-48 bg-accent-lightred text-accent-grey text-sm rounded-lg px-3 py-2 border-none outline-none focus:ring-1 focus:ring-primary">
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
                    <span
                        class="text-accent-darkyellow font-bold font-playfair text-3xl leading-none mb-1 md:mb-0">4</span>
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
                        <th class="py-3 px-2">Precio <br class="md:hidden">Promedio</th>
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
                                <button @click="isEditModalOpen = true"
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
                                <button @click="isEditModalOpen = true"
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
                            <span class="bg-accent-lightorange px-3 py-1 rounded-full text-accent-darkyellow">Sin
                                Asignar</span>
                        </td>
                        <td class="py-4 px-2 whitespace-nowrap text-accent-grey">Sin Asignar</td>
                        <td class="py-4 px-2 whitespace-nowrap text-accent-grey">----</td>
                        <td class="py-4 px-2 whitespace-nowrap text-accent-grey">----</td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <button @click="isEditModalOpen = true"
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

    <div x-show="isEditModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4 md:px-0">

        <div x-show="isEditModalOpen" x-transition.opacity @click="isEditModalOpen = false"
            class="absolute inset-0 bg-status-dark/30 backdrop-blur-sm">
        </div>

        <div x-show="isEditModalOpen" x-transition
            class="relative bg-status-white rounded-xl border border-accent-olive/30 shadow-[6px_6px_0px_0px_#75826A] w-full max-w-md p-6 overflow-y-auto max-h-[90vh]">

            <form action="#" class="space-y-5 font-atkinson">

                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <label class="block font-dm-serif font-bold text-status-dark text-lg mb-1">Nombre</label>
                        <input type="text" value="Zanahoria"
                            class="w-full bg-accent-lightred text-status-dark text-sm rounded-lg px-3 py-2 border-none focus:ring-1 focus:ring-primary outline-none">
                    </div>
                    <div class="pt-1">
                        <span
                            class="bg-accent-lightorange text-accent-darkyellow font-bold px-3 py-1.5 rounded-lg text-sm whitespace-nowrap">
                            Sin Asignar
                        </span>
                    </div>
                </div>

                <div>
                    <label class="block font-dm-serif font-bold text-status-dark text-lg mb-1">Unidad de medida</label>
                    <div class="relative">
                        <select
                            class="w-full bg-accent-lightred text-status-dark text-sm rounded-lg px-3 py-2 pr-8 border-none focus:ring-1 focus:ring-primary outline-none">
                            <option>Kilogramos(Kg)</option>
                            <option>Gramos(g)</option>
                            <option>Unidades(uds)</option>
                        </select>

                    </div>
                </div>

                <div>
                    <label class="block font-dm-serif font-bold text-status-dark text-lg mb-1">Categoría</label>
                    <div class="relative">
                        <select
                            class="w-full bg-accent-lightred text-status-dark text-sm rounded-lg px-3 py-2 pr-8 border-none focus:ring-1 focus:ring-primary outline-none">
                            <option>Verdulería</option>
                            <option>Frutería</option>
                        </select>

                    </div>
                </div>

                <div>
                    <label class="block font-dm-serif font-bold text-status-dark text-lg mb-2">Imagen</label>

                    <div x-data="{ 
                            imagenActiva: null, 
                            imagenes: [
                                'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=150&h=150&fit=crop',
                                'https://images.unsplash.com/photo-1444858291040-58f756a3bdd6?w=150&h=150&fit=crop',
                                'https://images.unsplash.com/photo-1601493700631-2b16ec4b4716?w=150&h=150&fit=crop'
                            ]
                        }" class="flex flex-wrap gap-3 items-center">

                        <template x-for="(img, index) in imagenes" :key="index">
                            <div class="flex gap-3">
                                <img :src="img" @click="imagenActiva = imagenActiva === index ? null : index"
                                    class="w-16 h-16 object-cover rounded-md cursor-pointer border border-transparent hover:opacity-80 transition-opacity shadow-sm"
                                    :class="imagenActiva === index ? 'ring-2 ring-status-error ring-offset-1' : ''"
                                    alt="Imagen producto">

                                <button x-show="imagenActiva === index"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 w-0 -ml-3"
                                    x-transition:enter-end="opacity-100 w-16 ml-0" type="button"
                                    class="w-16 h-16 bg-accent-altorange flex flex-col items-center justify-center rounded-md text-status-error hover:bg-accent-pastelred transition-colors shrink-0 shadow-sm overflow-hidden">
                                    <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    <span class="text-[10px] font-bold font-atkinson tracking-wide">Eliminar</span>
                                </button>
                            </div>
                        </template>

                        <button type="button"
                            class="w-14 h-14 bg-accent-lightred flex items-center justify-center rounded-md text-accent-darkgrey hover:bg-accent-lightgrey/40 transition-colors shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>

                    </div>
                </div>

                <div>
                    <label class="block font-dm-serif font-bold text-status-dark text-lg mb-1">Puesto</label>
                    <div class="relative">
                        <select
                            class="w-full bg-accent-lightred text-status-dark text-sm rounded-lg px-3 py-2 pr-8 border-none focus:ring-1 focus:ring-primary outline-none">
                            <option>Selecciona el puesto</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-dm-serif font-bold text-status-dark text-lg mb-1">Cantidad</label>
                    <input type="number" placeholder="Indica la cantidad del producto"
                        class="w-full bg-accent-lightred text-status-dark text-sm placeholder:text-accent-grey rounded-lg px-3 py-2 border-none focus:ring-1 focus:ring-primary outline-none">
                </div>

                <div>
                    <label class="block font-titulo-seccion font-bold text-status-dark text-lg mb-1">Precio</label>
                    <div class="relative">
                        <input type="text" placeholder="Indica el precio del producto" 
                            class="w-full bg-accent-lightred text-status-dark text-sm placeholder:text-accent-grey rounded-lg pl-3 pr-8 py-2 border-none focus:ring-1 focus:ring-primary outline-none">
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                            <x-icons.euro class="w-4 h-4 text-accent-darkgrey" />
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>