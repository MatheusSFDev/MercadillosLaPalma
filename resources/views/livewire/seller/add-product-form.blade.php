<div class="min-h-screen bg-accent-cream p-4 font-atkinson">
    
    <h1 class="font-titulo-principal text-status-dark text-4xl mb-6 mt-4">
        Añadir Productos
    </h1>

    <div class="bg-status-white rounded-none md:rounded-lg shadow-sm p-5 pb-8">
        
        <section class="mb-10">
            <h2 class="font-titulo-seccion text-coffee text-2xl font-bold mb-1">
                Información General del Producto
            </h2>
            <p class="font-general text-coffee-light text-sm mb-6">
                Esta info se aplicará a todos los puestos
            </p>

            <div class="mb-6">
                <label for="nombre_producto" class="block font-playfair text-status-dark font-bold mb-2">
                    Nombre del producto *
                </label>
                <input type="text" id="nombre_producto" placeholder="Tomate de ensalada"
                    class="w-full bg-gray-100 border-none rounded py-3 px-4 text-status-dark focus:ring-2 focus:ring-primary-light outline-none">
            </div>

            <div class="mb-6">
                <label class="block font-playfair text-status-dark font-bold mb-3">
                    Unidad de medida para el producto *
                </label>
                <div class="flex flex-col space-y-3">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" name="unidad" class="w-5 h-5 text-primary border-gray-300 focus:ring-primary-light">
                        <span class="text-status-dark">Gramos(g)</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" name="unidad" class="w-5 h-5 text-primary border-gray-300 focus:ring-primary-light">
                        <span class="text-status-dark">Kilogramos(Kg)</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" name="unidad" class="w-5 h-5 text-primary border-gray-300 focus:ring-primary-light">
                        <span class="text-status-dark">Mililitros(ml)</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" name="unidad" class="w-5 h-5 text-primary border-gray-300 focus:ring-primary-light">
                        <span class="text-status-dark">Litros(l)</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" name="unidad" class="w-5 h-5 text-primary border-gray-300 focus:ring-primary-light">
                        <span class="text-status-dark">Unidad/es</span>
                    </label>
                </div>
            </div>

            <div class="mb-6">
                <label for="categoria" class="block font-playfair text-status-dark font-bold mb-2">
                    Categoría *
                </label>
                <select id="categoria" class="w-full bg-gray-100 border-none rounded py-3 px-4 text-gray-500 appearance-none focus:ring-2 focus:ring-primary-light">
                    <option value="">Elige la categoría del producto</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block font-playfair text-status-dark font-bold mb-2">
                    Imagen
                </label>
                <button type="button" class="w-full flex items-center bg-gray-100 rounded py-3 px-4 text-gray-400">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                    Adjunta las imágenes
                </button>
            </div>
        </section>

        <section>
            <h2 class="font-titulo-seccion text-coffee text-2xl font-bold mb-1">
                Configuración por Puesto
            </h2>
            <p class="font-general text-coffee-light text-sm mb-4">
                Precio y cantidad específicos de cada puesto
            </p>

            <div class="bg-primary-pastel rounded-lg p-5 mb-4">
                
                <label for="puesto_seleccion" class="block font-playfair text-status-dark font-bold mb-2">
                    Selecciona tu puesto
                </label>
                <select id="puesto_seleccion" class="w-full bg-status-white border-none rounded py-3 px-4 text-gray-500 appearance-none focus:ring-2 focus:ring-primary mb-5 shadow-sm">
                    <option value="">¿En qué puesto vendes este producto?</option>
                </select>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="cantidad" class="block font-playfair text-status-dark font-bold text-sm mb-2">
                            Cantidad
                        </label>
                        <input type="number" id="cantidad" placeholder="Ej: 20"
                            class="w-full bg-status-white border-none rounded py-3 px-4 text-status-dark focus:ring-2 focus:ring-primary outline-none shadow-sm mb-1">
                        <span class="text-[10px] text-status-dark font-bold">Unidades en este puesto</span>
                    </div>

                    <div>
                        <label for="precio" class="block font-playfair text-status-dark font-bold text-sm mb-2">
                            Precio
                        </label>
                        <input type="text" id="precio" placeholder="Ej: 3.50€"
                            class="w-full bg-status-white border-none rounded py-3 px-4 text-status-dark focus:ring-2 focus:ring-primary outline-none shadow-sm mb-1">
                        <span class="text-[10px] text-status-dark font-bold">Precio en este puesto</span>
                    </div>
                </div>
            </div>

            <button type="button" class="w-full flex items-center justify-center py-3 border border-dashed border-status-dark rounded text-status-dark text-sm font-bold hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Añadir otro puesto
            </button>
        </section>

    </div>
</div>
