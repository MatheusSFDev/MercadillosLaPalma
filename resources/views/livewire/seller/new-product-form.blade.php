<div>
    <div class="min-h-screen bg-background p-8 flex flex-col items-start font-sans">
        <h1 class="text-5xl font-serif text-coffee mb-8 ml-4">Añadir Productos</h1>

        <div class="bg-status-white w-full max-w-2xl p-10 shadow-sm">
            <header class="mb-8">
                <h2 class="text-2xl font-serif text-coffee font-bold">Información General del Producto</h2>
                <p class="text-coffee-light text-sm mt-1">Esta info se aplicará a todos los puestos</p>
            </header>

            <form class="space-y-8">
                <div>
                    <label class="block text-xl font-bold text-coffee mb-3">Nombre del producto *</label>
                    <input type="text" placeholder="Tomate de ensalada" class="w-full bg-gray-100 border-none rounded-sm p-4 placeholder:text-gray-400 focus:ring-0">
                </div>

                <div>
                    <label class="block text-xl font-bold text-coffee mb-4">Unidad de medida para el producto *</label>
                    <div class="space-y-4">
                        {{--@foreach (units as $unit)
                            <label class="inline-flex items-center">
                                <input type="radio" wire:model="unit" value="{{ $unit }}" class="border-gray-300 text-indigo-600 focus:ring-indigo-500 shadow-sm">
                        <span class="ml-2 text-sm text-gray-700">{{ $unit }}</span>
                        </label>
                        @endforeach--}}
                        <div>falta conecion con base de datos</div>
                    </div>
                </div>

                <div>
                    <label class="block text-xl font-bold text-coffee mb-3">Categoría *</label>
                    <select class="w-full bg-gray-100  border-none rounded-sm p-4 text-gray-400 appearance-none focus:ring-0 cursor-pointer">
                        <option>Elige la categoría del producto</option>
                    </select>
                    {{--@foreach (categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach--}}
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-coffee">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <label class="block text-xl font-bold text-coffee mb-3">Imagen</label>
                        <label class="w-full bg-gray-100  border-none rounded-sm p-4 text-gray-200 flex items-center gap-2 cursor-pointer">
                            <svg class="w-6 h-6 rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                            <span>Adjunta las imágenes</span>
                            <input type="file" class="hidden" multiple accept="image/*">
                        </label>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>