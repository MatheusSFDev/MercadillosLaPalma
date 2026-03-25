<!-- Su componente es \app\Livewire\Seller\AddProductForm.php -->

<div>
    @auth
    <div class="min-h-screen bg-primary-pastel font-atkinson">
        <div class="max-w-7xl mx-auto p-5 md:p-10">
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
                        <label for="descripcion" class="block text-status-dark font-dm-serif font-bold mb-2">
                            Descripción
                        </label>
                        <textarea wire:model="description" id="descripcion" rows="3"
                            placeholder="Describe el producto brevemente..."
                            class="w-full bg-accent-lightred border-none rounded py-3 px-4 text-status-dark focus:ring-2 focus:ring-primary-light outline-none placeholder:text-accent-grey resize-none"></textarea>
                        @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-status-dark font-bold font-dm-serif mb-3">
                            Unidad de medida para el producto *
                        </label>
                        <div class="flex flex-col space-y-3">
                            @foreach (App\Enums\Units::cases() as $unit)
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="radio" wire:model="unit" value="{{ $unit->value }}"
                                        class="w-5 h-5 text-primary border-none bg-accent-lightgrey focus:ring-primary-light">
                                    <span class="text-status-dark">{{ $unit->name }} - ({{ $unit->value }})</span>
                                </label>
                            @endforeach
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
                            Imágenes
                        </label>

                        @if (count($photos) > 0)
                            <div class="flex flex-wrap gap-3 mb-3">
                                @foreach ($this->photosPreviews as $key => $photo)
                                    <div class="relative group">
                                        <img src="{{ $photo->temporaryUrl() }}"
                                            class="w-16 h-16 object-cover rounded-md shadow-sm ring-2 ring-primary/40">
                                        <button type="button"
                                            wire:click="removePhoto('{{ array_keys($photos)[$loop->index] }}')"
                                            class="absolute -top-1.5 -right-1.5 rounded-full w-5 h-5 flex items-center justify-center shadow bg-status-error text-status-white opacity-0 group-hover:opacity-100 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <label for="img-upload"
                            class="flex flex-col items-center justify-center w-full h-32 bg-accent-lightred rounded-lg cursor-pointer hover:bg-accent-lightred/70 transition-colors border-2 border-dashed border-accent-grey/30 hover:border-primary/40 group overflow-hidden">
                            <div class="flex flex-col items-center justify-center gap-2 text-accent-grey group-hover:text-status-dark transition-colors">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm font-atkinson">Añadir imágenes</span>
                                <span class="text-xs">PNG, JPG o WEBP</span>
                            </div>
                            <input id="img-upload"
                                type="file"
                                wire:model.live="tempPhotos"
                                class="hidden"
                                accept="image/*"
                                multiple />
                        </label>

                        <div wire:loading wire:target="tempPhotos" class="text-sm text-accent-grey mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                            Subiendo...
                        </div>

                        @error('tempPhotos.*') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </section>

                <section>
                    <h2 class="font-playfair text-coffee text-2xl font-bold mb-1">
                        Configuración por Puesto
                    </h2>
                    <p class="text-coffee-light text-sm mb-4">
                        Precio y cantidad específicos de cada puesto
                    </p>

                    @if ($stalls->isEmpty())
                        <div class="bg-accent-lightorange rounded-lg p-4 text-accent-darkyellow text-sm">
                            Aún no tienes puestos creados. Crea uno en tu panel de puestos para poder asignar productos.
                        </div>
                    @else
                        <button type="button"
                            wire:click="toggleStallConfig"
                            class="w-full mb-4 border-2 border-dashed py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2 font-bold
                                {{ $showStallConfig
                                    ? 'border-status-error/50 text-status-error hover:bg-accent-pastelred/20'
                                    : 'border-accent-olive/50 text-status-dark hover:bg-accent-lightgreen/30' }}">
                            @if ($showStallConfig)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Cancelar asignación a puestos
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Asignar a un puesto
                            @endif
                        </button>

                        @error('stallAssignments') <span class="text-red-600 text-sm block mb-3">{{ $message }}</span> @enderror

                        @if ($showStallConfig)
                            <div class="space-y-4">
                                @foreach ($stallAssignments as $index => $assignment)
                                    <div class="bg-accent-lightgreen rounded-lg p-5">

                                        <div class="flex items-center justify-between mb-3">
                                            <label class="font-dm-serif text-status-dark font-bold text-2xl">
                                                Puesto {{ $index + 1 }}
                                            </label>

                                            <button type="button"
                                                wire:click="removeStallAssignment({{ $index }})"
                                                class="text-status-error hover:text-red-700 transition-colors p-1 rounded-md hover:bg-accent-pastelred/40"
                                                title="Eliminar este puesto">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <select wire:model.live="stallAssignments.{{ $index }}.stall_id"
                                            class="w-full bg-status-white border-none rounded py-3 px-4 text-accent-grey appearance-none focus:ring-2 focus:ring-primary-light mb-4 shadow-sm">
                                            <option value="">¿En qué puesto vendes este producto?</option>
                                            @foreach($stalls as $stall)
                                                @php
                                                    $alreadyUsed = collect($stallAssignments)
                                                        ->filter(fn($a, $i) => $i !== $index)
                                                        ->pluck('stall_id')
                                                        ->contains((string) $stall->id);
                                                @endphp
                                                @if (!$alreadyUsed)
                                                    <option value="{{ $stall->id }}">{{ $stall->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error("stallAssignments.{$index}.stall_id")
                                            <span class="text-red-600 text-sm block -mt-3 mb-2">{{ $message }}</span>
                                        @enderror

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block font-dm-serif text-status-dark font-bold text-md mb-2">
                                                    Cantidad
                                                </label>
                                                <div class="relative">
                                                    <input type="number"
                                                        wire:model="stallAssignments.{{ $index }}.quantity"
                                                        placeholder="Ej: 20"
                                                        min="0"
                                                        class="w-full bg-status-white border-none rounded py-3 px-4 pr-14 text-status-dark placeholder:text-accent-grey focus:ring-2 focus:ring-primary-light shadow-sm mb-1">
                                                </div>
                                                @error("stallAssignments.{$index}.quantity")
                                                    <span class="text-red-600 text-sm block">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="block font-dm-serif text-status-dark font-bold text-md mb-2">
                                                    Precio
                                                </label>
                                                <div class="relative">
                                                    <input type="text"
                                                        wire:model="stallAssignments.{{ $index }}.price"
                                                        placeholder="Ej: 3.50"
                                                        class="w-full bg-status-white border-none rounded py-3 px-4 pr-8 text-status-dark placeholder:text-accent-grey focus:ring-2 focus:ring-primary-light shadow-sm mb-1">
                                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                                        <x-icons.euro class="w-4 h-4 text-accent-darkgrey" />
                                                    </div>
                                                </div>
                                                @error("stallAssignments.{$index}.price")
                                                    <span class="text-red-600 text-sm block">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="block font-dm-serif text-status-dark font-bold text-md mb-2">
                                                    Mínimo por pedido
                                                </label>
                                                <div class="relative">
                                                    <input type="number"
                                                        wire:model="stallAssignments.{{ $index }}.min_quantity"
                                                        placeholder="Ej: 1"
                                                        min="0"
                                                        class="w-full bg-status-white border-none rounded py-3 px-4 pr-14 text-status-dark placeholder:text-accent-grey focus:ring-2 focus:ring-primary-light shadow-sm mb-1">
                                                </div>
                                                @error("stallAssignments.{$index}.min_quantity")
                                                    <span class="text-red-600 text-sm block">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="block font-dm-serif text-status-dark font-bold text-md mb-2">
                                                    Incremento mínimo por pedido
                                                </label>
                                                <div class="relative">
                                                    <input type="number"
                                                        wire:model="stallAssignments.{{ $index }}.step_quantity"
                                                        placeholder="Ej: 5"
                                                        min="1"
                                                        class="w-full bg-status-white border-none rounded py-3 px-4 pr-14 text-status-dark placeholder:text-accent-grey focus:ring-2 focus:ring-primary-light shadow-sm mb-1">
                                                </div>
                                                @error("stallAssignments.{$index}.step_quantity")
                                                    <span class="text-red-600 text-sm block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if (count($stallAssignments) < $stalls->count())
                                @php
                                    $lastAssignment = end($stallAssignments);
                                    $canAddMore = !empty($lastAssignment['stall_id']);
                                @endphp
                                <button type="button"
                                    wire:click="addStallAssignment"
                                    @class([
                                        'w-full mt-4 border-2 border-dashed py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2 font-bold',
                                        'border-accent-olive/50 text-status-dark hover:bg-accent-lightgreen/30 cursor-pointer' => $canAddMore,
                                        'border-accent-grey/30 text-accent-grey cursor-not-allowed opacity-50' => !$canAddMore,
                                    ])>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Añadir otro puesto
                                </button>
                            @endif
                        @endif
                    @endif
                </section>

                <div class="md:col-span-2 mt-6 md:mt-4 pt-6 md:pt-8 flex justify-end">
                    <button type="submit"
                        class="w-full md:w-auto bg-accent-yellow hover:bg-accent-darkyellow text-status-dark font-bold py-4 md:py-3 px-6 md:px-10 rounded-lg transition-colors shadow-md text-lg md:text-base">
                        Añadir Producto
                    </button>
                </div>

            </form>
        </div>
    </div>
    @endauth
</div>