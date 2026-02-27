@auth
<div class="min-h-screen bg-primary-pastel font-atkinson">
    <div class="max-w-5xl mx-auto p-5 md:p-10">
        <h1 class="font-titulo-principal text-coffee font-bold text-4xl mb-6 mt-4">
            Añadir Productos
        </h1>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="submit" class="bg-status-white rounded-lg shadow-lg p-5 pb-8 md:p-8 md:grid md:grid-cols-2 md:gap-10">

            <section class="mb-10 md:mb-0">
                <h2 class="font-playfair text-coffee text-2xl font-bold mb-1">
                    Información General del Producto
                </h2>
                <p class="text-coffee-light text-sm mb-6">
                    Esta info se aplicará a todos los puestos
                </p>

                <div class="mb-6">
                    <label for="nombre_producto" class="block text-status-dark font-dm-serif font-bold mb-2">
                        Nombre del producto *
                    </label>
                    <input type="text" wire:model="name" id="nombre_producto" placeholder="Tomate de ensalada"
                        class="w-full bg-accent-lightred border-none rounded py-3 px-4 text-status-dark focus:ring-2 focus:ring-primary-light outline-none placeholder:text-accent-grey">
                    @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-status-dark font-bold font-dm-serif mb-3">
                        Unidad de medida para el producto *
                    </label>
                    <div class="flex flex-col space-y-3">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" wire:model="unit" value="gr"
                                class="w-5 h-5 text-primary border-none bg-accent-lightgrey focus:ring-primary-light">
                            <span class="text-status-dark">Gramos (g)</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" wire:model="unit" value="Kg"
                                class="w-5 h-5 text-primary border-none bg-accent-lightgrey focus:ring-primary-light">
                            <span class="text-status-dark">Kilogramos (Kg)</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" wire:model="unit" value="mL"
                                class="w-5 h-5 text-primary border-none bg-accent-lightgrey focus:ring-primary-light">
                            <span class="text-status-dark">Mililitros (mL)</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" wire:model="unit" value="L"
                                class="w-5 h-5 text-primary border-none bg-accent-lightgrey focus:ring-primary-light">
                            <span class="text-status-dark">Litros (L)</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" wire:model="unit" value="unidad/es"
                                class="w-5 h-5 text-primary border-none bg-accent-lightgrey focus:ring-primary-light">
                            <span class="text-status-dark">Unidad/es</span>
                        </label>
                    </div>
                    @error('unit') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label for="categoria" class="block font-dm-serif text-status-dark font-bold mb-2">
                        Categoría *
                    </label>
                    <select wire:model="category_id" id="categoria"
                        class="w-full bg-accent-lightred border-none rounded py-3 px-4 text-accent-grey focus:ring-2 focus:ring-primary-light">
                        <option value="">Elige la categoría del producto</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6 md:mb-0">
                    <label class="block font-dm-serif text-status-dark font-bold mb-2">
                        Imagen
                    </label>
                    <input type="file" wire:model="img" class="w-full" />
                    @error('img') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </section>

            <section>
                <h2 class="font-playfair text-coffee text-2xl font-bold mb-1">
                    Configuración por Puesto
                </h2>
                <p class="text-coffee-light text-sm mb-4">
                    Precio y cantidad específicos de cada puesto
                </p>

                <div class="bg-accent-lightgreen rounded-lg p-5 mb-4">

                    <label for="puesto_seleccion" class="block font-dm-serif text-status-dark font-bold text-2xl mb-2">
                        Selecciona tu puesto
                    </label>
                    <select wire:model="stall_id" id="puesto_seleccion"
                        class="w-full bg-status-white border-none rounded py-3 px-4 text-accent-grey appearance-none focus:ring-2 focus:ring-primary-light mb-5 shadow-sm">
                        <option value="">¿En qué puesto vendes este producto?</option>
                        @foreach($stalls as $stall)
                            <option value="{{ $stall->id }}">{{ $stall->name }}</option>
                        @endforeach
                    </select>
                    @error('stall_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="cantidad" class="block font-dm-serif text-status-dark font-bold text-xl mb-2">
                                Cantidad
                            </label>
                            <input type="number" wire:model="quantity" id="cantidad" placeholder="Ej: 20"
                                class="w-full bg-status-white border-none rounded py-3 px-4 text-status-dark placeholder:text-accent-grey focus:ring-2 focus:ring-primary-light shadow-sm mb-1">
                            <span class="text-primary text-lg font-bold mt-1 inline-block">Unidades en este puesto</span>
                            @error('quantity') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="precio" class="block font-dm-serif text-status-dark font-bold text-xl mb-2">
                                Precio
                            </label>
                            <input type="text" wire:model="price" id="precio" placeholder="Ej: 3.50€"
                                class="w-full bg-status-white border-none rounded py-3 px-4 text-status-dark placeholder:text-accent-grey focus:ring-2 focus:ring-primary-light shadow-sm mb-1">
                            <span class="text-primary text-lg font-bold mt-1 inline-block">Precio en este puesto</span>
                            @error('price') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

            </section> <div class="md:col-span-2 mt-6 md:mt-4 pt-6 md:pt-8 border-t border-accent-lightgrey flex justify-end">
            <button type="submit"
                class="w-full md:w-auto bg-accent-yellow hover:bg-accent-darkyellow text-status-dark font-bold py-4 md:py-3 px-6 md:px-10 rounded-lg transition-colors shadow-md text-lg md:text-base">
                Añadir Producto
            </button>
        </div>
        </form>
    </div>
</div>
@endauth