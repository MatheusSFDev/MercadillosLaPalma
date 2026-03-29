<!-- Su componente es \app\Livewire\Seller\ProductInventory.php -->

<div
    x-data="{ isEditModalOpen: @entangle('showEditModal'), isDeleteProductOpen: @entangle('showDeleteProductModal'), isDeleteFromStallOpen: @entangle('showDeleteFromStallModal') }"
    class="py-6 font-atkinson text-status-dark bg-primary-pastel min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-start">
            <div>
                <h1 class="text-coffee font-titulo-principal font-bold text-4xl">Gestión de Productos</h1>
                <p class="text-coffee-light">Vista completa con productos asignados y sin asignar a puestos</p>
            </div>
            <div>
                <button wire:click="openCreateModal"
                    class="bg-primary-offgreen text-primary-pastel flex items-center gap-1 py-3 px-4 rounded-lg text-md font-semibold shadow-lg hover:opacity-90 transition-opacity">
                    <span>+</span> Añadir productos
                </button>
            </div>
        </div>
        <div>
            <div class="bg-status-white rounded-xl p-4 shadow-lg mb-6">
                <h3 class="font-titulo-seccion font-bold text-lg mb-3 text-status-dark">Resumen</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4 text-center">

                    <div class="bg-accent-altorange rounded-3xl py-4 px-1 md:py-4 md:px-4 shadow-sm flex flex-col md:flex-row justify-center items-center md:items-baseline md:gap-2 h-full">
                        <span class="text-coffee-light font-black font-playfair text-3xl leading-none mb-1 md:mb-0">{{ $totalProducts }}</span>
                        <span class="font-dm-serif leading-tight text-sm text-status-dark">
                            <span class="md:hidden">Total de<br>productos</span>
                            <span class="hidden md:inline">Total de productos</span>
                        </span>
                    </div>

                    <div class="bg-accent-lightgreen rounded-3xl py-4 px-1 md:py-4 md:px-4 shadow-sm flex flex-col md:flex-row justify-center items-center md:items-baseline md:gap-2 h-full">
                        <span class="text-primary font-black font-playfair text-3xl leading-none mb-1 md:mb-0">{{ $assignedProducts }}</span>
                        <span class="font-dm-serif leading-tight text-sm text-status-dark">
                            <span class="md:hidden">Productos<br>asignados</span>
                            <span class="hidden md:inline">Productos asignados</span>
                        </span>
                    </div>

                    <div class="bg-accent-lightorange rounded-3xl py-4 px-1 md:py-4 md:px-4 shadow-sm flex flex-col md:flex-row justify-center items-center md:items-baseline md:gap-2 h-full">
                        <span class="text-accent-darkyellow font-black font-playfair text-3xl leading-none mb-1 md:mb-0">{{ $unassignedProducts }}</span>
                        <span class="font-dm-serif leading-tight text-sm text-status-dark">
                            <span class="md:hidden">Productos<br>sin asignar</span>
                            <span class="hidden md:inline">Productos sin asignar</span>
                        </span>
                    </div>

                    <div class="bg-accent-pastelred rounded-3xl py-4 px-1 md:py-4 md:px-4 shadow-sm flex flex-col md:flex-row justify-center items-center md:items-baseline md:gap-2 h-full">
                        <span class="text-accent-orange font-black font-playfair text-3xl leading-none mb-1 md:mb-0">{{ $activeStalls }}</span>
                        <span class="font-dm-serif leading-tight text-sm text-status-dark">
                            <span class="md:hidden">Puestos<br>activos</span>
                            <span class="hidden md:inline">Puestos activos</span>
                        </span>
                    </div>

                </div>
            </div>
            <div class="flex flex-col md:items-center gap-4 bg-status-white rounded-xl p-4 shadow-lg mb-6">

                <div class="grid md:grid-cols-2 md:flex md:justify-end gap-4 w-full shrink-0">
                    <div class="relative w-full md:flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-accent-darkgrey" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar productos..."
                            class="w-full bg-accent-lightred text-status-dark text-sm placeholder:text-accent-grey rounded-lg pl-10 py-3 px-4 border-none focus:ring-1 focus:ring-primary outline-none">
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center gap-1 md:gap-2">
                        <label class="text-status-dark font-dm-serif text-lg md:whitespace-nowrap">Categoría</label>
                        <select wire:model.live="category"
                            class="w-full md:w-48 bg-accent-lightred text-accent-grey text-sm rounded-lg py-3 px-4 border-none outline-none focus:ring-1 focus:ring-primary">
                            <option value="all">Todas las categorías</option>
                            @foreach($categories as $category)
                                <option value="{{ $category['name'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center gap-1 md:gap-2">
                        <label class="text-status-dark font-dm-serif text-lg md:whitespace-nowrap">Estado</label>
                        <select wire:model.live="status"
                            class="w-full md:w-48 bg-accent-lightred text-accent-grey text-sm rounded-lg py-3 px-4 border-none outline-none focus:ring-1 focus:ring-primary">
                            <option value="all">Todos los estados</option>
                            <option value="asignado">Asignado</option>
                            <option value="sin_asignar">Sin asignar</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <div class="bg-status-white rounded-xl shadow-lg overflow-hidden font-dm-serif">
            <div class="overflow-x-auto min-h-[662px] flex flex-col justify-between">
                <table class="w-full text-center">
                    <thead class="bg-accent-olive text-white">
                        <tr>
                            <th class="py-3 px-4 font-normal">Producto</th>
                            <th class="py-3 px-2 font-normal">Estado</th>
                            <th class="py-3 px-2 font-normal">Puestos <br class="md:hidden">asignados</th>
                            <th class="py-3 px-2 font-normal">Stock <br class="md:hidden">Total</th>
                            <th class="py-3 px-2 font-normal">Precio <br class="md:hidden">Promedio</th>
                            <th class="sticky right-0 bg-accent-olive py-3 px-4 font-normal">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-status-dark">
                        @forelse($products as $product)
                            <tr class="border-b border-accent-lightgrey/50 h-[68px]">
                                <td class="py-4 px-4 text-wrap">{{ $product->name }}</td>
                                <td class="py-4 px-2 whitespace-nowrap">
                                    <span class="{{ $product->stalls->isNotEmpty() ? 'bg-accent-lightgreen text-primary' : 'bg-accent-lightorange text-accent-darkyellow' }} px-3 py-1 rounded-full">
                                        {{ $product->stalls->isNotEmpty() ? 'Asignado' : 'Sin asignar' }}
                                    </span>
                                </td>
                                <td class="py-4 px-2 whitespace-nowrap {{ $product->stalls->isNotEmpty() ? '' : 'text-accent-grey' }}">
                                    {{ $product->stalls->pluck('name')->join(', ') ?: '----' }}
                                </td>
                                <td class="py-4 px-2 whitespace-nowrap">
                                    @php $totalStock = $product->stalls->sum(fn($s) => $s->pivot->quantity ?? 0); @endphp
                                    <span class="{{ $totalStock > 0 ? '' : 'text-accent-grey' }}">
                                        {{ $totalStock > 0 ? $totalStock . ' ' . $product->unit : '----' }}
                                    </span>
                                </td>
                                <td class="py-4 px-2 whitespace-nowrap">
                                    @php $avgPrice = $product->stalls->count() ? round($product->stalls->avg(fn($s) => $s->pivot->price_per_unit ?? 0), 2) : null; @endphp
                                    <span class="{{ $avgPrice !== null ? '' : 'text-accent-grey' }}">
                                        {{ $avgPrice !== null ? number_format($avgPrice, 2, ',', '.') . '€' : '----' }}
                                    </span>
                                </td>
                                <td class="sticky right-0 bg-white py-4 px-4 whitespace-nowrap border-l border-accent-lightgrey/50 z-10">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="openEditModal({{ $product->id }})"
                                            class="bg-accent-lightgreen p-1.5 rounded-md hover:bg-primary-pastel transition-colors">
                                            <x-icons.lapiz class="w-6 h-6 text-primary" />
                                        </button>
                                        <button wire:click="confirmDeleteProduct({{ $product->id }})"
                                            class="bg-accent-againorange p-1.5 rounded-md hover:opacity-80 transition-opacity">
                                            <x-icons.papelera class="w-6 h-6 text-status-error" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 px-6 text-center">No hay productos disponibles</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($products->hasPages())
                    <div class="sticky left-0 px-4 py-3">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Modal confirmar borrado de producto --}}
        <div x-show="isDeleteProductOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div x-show="isDeleteProductOpen" x-transition.opacity @click="isDeleteProductOpen = false"
                class="absolute inset-0 bg-status-dark/30 backdrop-blur-sm"></div>
            <div x-show="isDeleteProductOpen" x-transition
                class="relative bg-status-white rounded-xl border border-accent-olive/30 shadow-[6px_6px_0px_0px_#75826A] w-full max-w-sm p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-accent-againorange p-2 rounded-lg">
                        <svg class="w-6 h-6 text-status-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-dm-serif font-bold text-status-dark text-xl">Eliminar producto</h3>
                </div>
                <p class="text-status-dark text-sm mb-6">
                    ¿Estás seguro de que quieres eliminar este producto? Se borrará de todos los puestos y no se podrá recuperar.
                </p>
                <div class="flex justify-end gap-3">
                    <button type="button" wire:click="cancelDeleteProduct"
                        class="bg-accent-lightred text-status-dark px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-80 transition-opacity">
                        Cancelar
                    </button>
                    <button type="button" wire:click="deleteProduct"
                        class="bg-status-error text-status-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors">
                        Sí, eliminar
                    </button>
                </div>
            </div>
        </div>

        {{-- Modal confirmar quitar de un puesto (marca para quitar al guardar) --}}
        <div x-show="isDeleteFromStallOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div x-show="isDeleteFromStallOpen" x-transition.opacity @click="isDeleteFromStallOpen = false"
                class="absolute inset-0 bg-status-dark/30 backdrop-blur-sm"></div>
            <div x-show="isDeleteFromStallOpen" x-transition
                class="relative bg-status-white rounded-xl border border-accent-olive/30 shadow-[6px_6px_0px_0px_#75826A] w-full max-w-sm p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-accent-lightorange p-2 rounded-lg">
                        <svg class="w-6 h-6 text-accent-darkyellow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-dm-serif font-bold text-status-dark text-xl">Quitar del puesto</h3>
                </div>
                <p class="text-status-dark text-sm mb-6">
                    ¿Quieres quitar este producto del puesto? Se aplicará al guardar los cambios.
                </p>
                <div class="flex justify-end gap-3">
                    <button type="button" wire:click="cancelRemoveFromStall"
                        class="bg-accent-lightred text-status-dark px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-80 transition-opacity">
                        Cancelar
                    </button>
                    <button type="button" wire:click="removeProductFromStall"
                        class="bg-accent-darkyellow text-status-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-80 transition-opacity">
                        Sí, quitar
                    </button>
                </div>
            </div>
        </div>

        {{-- Modal crear / editar producto --}}
        <div x-show="isEditModalOpen" x-cloak class="fixed inset-0 z-40 flex items-center justify-center px-4 md:px-0">

            <div x-show="isEditModalOpen" x-transition.opacity @click="$wire.closeEditModal()"
                class="absolute inset-0 bg-status-dark/30 backdrop-blur-sm"></div>

            <div x-show="isEditModalOpen" x-transition
                class="relative bg-status-white rounded-xl border border-accent-olive/30 shadow-[6px_6px_0px_0px_#75826A] w-full max-w-lg flex flex-col h-[80vh] max-h-[80dvh] md:h-[70vh] md:max-h-[70dvh] mt-8 md:mt-0">

                <div class="px-6 pt-6 pb-4 border-b border-accent-lightgrey/60 shrink-0">
                    <h2 class="font-dm-serif font-bold text-status-dark text-xl">
                        {{ $modalMode === 'create' ? 'Añadir producto' : 'Editar producto' }}
                    </h2>
                </div>

                <div class="overflow-y-auto px-6 py-5 space-y-5 font-atkinson flex-1">

                    <div>
                        <label class="block font-dm-serif font-bold text-status-dark text-lg mb-1">Nombre del producto *</label>
                        <input wire:model.defer="editingProductName" type="text"
                            placeholder="Tomate"
                            class="w-full bg-accent-lightred text-status-dark text-sm rounded-lg py-3 px-4 border-none focus:ring-1 focus:ring-primary outline-none placeholder:text-accent-grey">
                        @error('editingProductName') <span class="text-status-error text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-dm-serif font-bold text-status-dark text-lg mb-1">Descripción</label>
                        <textarea wire:model.defer="editingProductDescription" rows="3"
                            placeholder="Describe el producto brevemente..."
                            class="w-full bg-accent-lightred text-status-dark text-sm rounded-lg py-3 px-4 border-none focus:ring-1 focus:ring-primary outline-none resize-none placeholder:text-accent-grey"></textarea>
                        @error('editingProductDescription') <span class="text-status-error text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-dm-serif font-bold text-status-dark text-lg mb-1">Categoría *</label>
                            <select wire:model.defer="editingProductCategoryId"
                                class="w-full bg-accent-lightred text-status-dark text-sm rounded-lg py-3 px-4 pr-8 border-none focus:ring-1 focus:ring-primary outline-none">
                                <option value="">Selecciona una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                @endforeach
                            </select>
                            @error('editingProductCategoryId') <span class="text-status-error text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-dm-serif font-bold text-status-dark text-lg mb-1">Unidad *</label>
                            <select wire:model.live="editingProductUnit"
                                class="w-full bg-accent-lightred text-status-dark text-sm rounded-lg py-3 px-4 pr-8 border-none focus:ring-1 focus:ring-primary outline-none">
                                <option value="">Selecciona unidad</option>
                                @foreach (App\Enums\Units::cases() as $unit)
                                    <option value="{{ $unit->value }}">{{ $unit->name }} ({{ $unit->value }})</option>
                                @endforeach
                            </select>
                            @error('editingProductUnit') <span class="text-status-error text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Sección de imágenes --}}
                    <div>
                        @if ($modalMode === 'edit' && count($editingProductPhotos) > 0)
                            <label class="block font-dm-serif font-bold text-status-dark text-lg mb-2">Imágenes actuales</label>
                            <div class="flex flex-wrap gap-3 mb-3">
                                @foreach ($editingProductPhotos as $photo)
                                    @php $markedForDelete = in_array($photo['id'], $photosToDelete); @endphp
                                    <div class="relative group">
                                        <img src="{{ Storage::url($photo['url']) }}"
                                            class="w-16 h-16 object-cover rounded-md shadow-sm transition-opacity {{ $markedForDelete ? 'opacity-30' : '' }}">
                                        <button type="button"
                                            wire:click="toggleDeletePhoto({{ $photo['id'] }})"
                                            class="absolute -top-1.5 -right-1.5 rounded-full w-5 h-5 flex items-center justify-center shadow transition-colors
                                                {{ $markedForDelete
                                                    ? 'bg-accent-lightgreen text-primary opacity-100'
                                                    : 'bg-status-error text-status-white opacity-0 group-hover:opacity-100' }}">
                                            @if ($markedForDelete)
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                                </svg>
                                            @else
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            @endif
                                        </button>
                                        @if ($markedForDelete)
                                            <span class="absolute bottom-0 left-0 right-0 text-center text-[9px] text-status-error font-bold bg-status-white/80 rounded-b-md">
                                                Se eliminará
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @elseif ($modalMode === 'edit')
                            <p class="text-accent-grey text-sm mb-3">Sin imágenes</p>
                        @endif

                        <label class="block font-dm-serif font-bold text-status-dark text-lg mb-2">
                            {{ $modalMode === 'create' ? 'Imágenes' : 'Añadir imágenes' }}
                        </label>

                        @if (count($newPhotos) > 0)
                            <div class="flex flex-wrap gap-3 mb-3">
                                @foreach ($this->newPhotosPreviews as $photo)
                                    <div class="relative group">
                                        <img src="{{ $photo->temporaryUrl() }}"
                                            class="w-16 h-16 object-cover rounded-md shadow-sm ring-2 ring-primary/40">
                                        <button type="button"
                                            wire:click="removeNewPhoto('{{ array_keys($newPhotos)[$loop->index] }}')"
                                            class="absolute -top-1.5 -right-1.5 rounded-full w-5 h-5 flex items-center justify-center shadow bg-status-error text-status-white opacity-0 group-hover:opacity-100 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                        @if ($modalMode === 'edit')
                                            <span class="absolute bottom-0 left-0 right-0 text-center text-[9px] text-primary font-bold bg-status-white/80 rounded-b-md">
                                                Nueva
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <label for="modal-photos-upload"
                            class="flex flex-col items-center justify-center w-full h-24 bg-accent-lightred rounded-lg cursor-pointer transition-colors border-2 border-dashed border-accent-grey/30 hover:border-primary/40 group">
                            <div class="flex flex-col items-center justify-center gap-1 text-status-dark transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs font-atkinson">Añadir imágenes</span>
                                <span class="text-[10px]">PNG, JPG o WEBP</span>
                            </div>
                            <input id="modal-photos-upload" type="file" wire:model.live="tempPhotos" class="hidden" accept="image/*" multiple />
                        </label>

                        <div wire:loading wire:target="tempPhotos" class="text-sm text-accent-grey mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                            Subiendo...
                        </div>

                        @error('tempPhotos.*') <span class="text-status-error text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Sección de puestos: misma UI para crear y editar --}}
                    <div>
                        <h3 class="font-dm-serif font-bold text-status-dark text-lg">Configuración por puesto</h3>
                        <p class="text-accent-grey text-xs mb-3">
                            {{ $modalMode === 'create' ? 'Opcional. Puedes asignarlo a puestos después.' : 'Edita los puestos asignados o añade nuevos.' }}
                        </p>

                        @if (empty($sellerStalls))
                            <div class="bg-accent-lightorange rounded-lg p-3 text-accent-darkyellow text-sm">
                                No tienes puestos activos. Crea uno para poder asignar productos.
                            </div>
                        @else

                            @error('stallAssignments') <span class="text-status-error text-sm block mb-3">{{ $message }}</span> @enderror

                            {{-- Botón toggle: en crear cuando no hay bloques, en editar nunca (siempre visible) --}}
                            @if ($modalMode === 'create' && !$showStallConfig)
                                <button type="button"
                                    wire:click="toggleStallConfig"
                                    class="w-full mb-4 border-2 border-dashed py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2 font-bold text-sm border-accent-olive/50 text-status-dark hover:bg-accent-lightgreen/30">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Asignar a un puesto
                                </button>
                            @endif

                            @if ($showStallConfig)
                                {{-- Bloques de puestos --}}
                                @php
                                    $visibleAssignments = collect($stallAssignments)->filter(fn($a) => empty($a['marked_for_removal']))->values();
                                    $markedAssignments = collect($stallAssignments)->filter(fn($a) => !empty($a['marked_for_removal']))->values();
                                @endphp

                                <div class="space-y-4">
                                    @foreach ($stallAssignments as $index => $assignment)
                                        @if (!empty($assignment['marked_for_removal']))
                                            {{-- Bloque marcado para quitar: se muestra tachado/deshabilitado --}}
                                            <div class="bg-accent-pastelred/40 rounded-lg p-4 opacity-60 border-2 border-status-error/30">
                                                <div class="flex items-center justify-between">
                                                    @php $stallName = collect($sellerStalls)->firstWhere('id', (int) $assignment['stall_id'])['name'] ?? 'Puesto'; @endphp
                                                    <span class="font-dm-serif text-status-error font-bold text-md">{{ $stallName }}</span>
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-md text-status-error font-dm-serif">Se quitará al guardar</span>
                                                        {{-- Botón para deshacer el marcado --}}
                                                        <button type="button"
                                                            wire:click="$set('stallAssignments.{{ $index }}.marked_for_removal', false)"
                                                            class="text-accent-grey hover:text-status-dark transition-colors p-1 rounded-md hover:bg-accent-lightgrey/30"
                                                            title="Deshacer">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            {{-- Bloque activo --}}
                                            <div class="bg-accent-lightgreen rounded-lg p-4">

                                                <div class="flex items-center justify-between mb-3">
                                                    <span class="font-dm-serif text-status-dark font-bold text-lg">
                                                        @if (!empty($assignment['is_existing']))
                                                            @php $stallName = collect($sellerStalls)->firstWhere('id', (int) $assignment['stall_id'])['name'] ?? 'Puesto'; @endphp
                                                            {{ $stallName }}
                                                        @else
                                                            Puesto {{ $loop->index + 1 }}
                                                        @endif
                                                    </span>
                                                    <button type="button"
                                                        wire:click="confirmRemoveStallAssignment({{ $index }})"
                                                        class="bg-accent-againorange text-status-error hover:text-red-700 transition-colors p-2 rounded-md hover:bg-status-error/20">
                                                        <svg class="w-5 h-5 text-status-error" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                                                            <path d="M448,85.333h-66.133C371.66,35.703,328.002,0.064,277.333,0h-42.667c-50.669,0.064-94.327,35.703-104.533,85.333H64   c-11.782,0-21.333,9.551-21.333,21.333S52.218,128,64,128h21.333v277.333C85.404,464.214,133.119,511.93,192,512h128   c58.881-0.07,106.596-47.786,106.667-106.667V128H448c11.782,0,21.333-9.551,21.333-21.333S459.782,85.333,448,85.333z    M234.667,362.667c0,11.782-9.551,21.333-21.333,21.333C201.551,384,192,374.449,192,362.667v-128  c0-11.782,9.551-21.333,21.333-21.333c11.782,0,21.333,9.551,21.333,21.333V362.667z M320,362.667  c0,11.782-9.551,21.333-21.333,21.333c-11.782,0-21.333-9.551-21.333-21.333v-128c0-11.782,9.551-21.333,21.333-21.333  c11.782,0,21.333,9.551,21.333,21.333V362.667z M174.315,85.333c9.074-25.551,33.238-42.634,60.352-42.667h42.667  c27.114,0.033,51.278,17.116,60.352,42.667H174.315z"></path>
                                                        </svg>
                                                    </button>
                                                </div>

                                                {{-- Selector solo para bloques nuevos --}}
                                                @if (empty($assignment['is_existing']))
                                                    <select wire:model.live="stallAssignments.{{ $index }}.stall_id"
                                                        class="w-full bg-status-white border-none rounded py-2.5 px-3 text-accent-grey text-sm appearance-none focus:ring-2 focus:ring-primary-light mb-3 shadow-sm">
                                                        <option value="">¿En qué puesto vendes este producto?</option>
                                                        @foreach($sellerStalls as $stall)
                                                            @php
                                                                $alreadyUsed = collect($stallAssignments)
                                                                    ->filter(fn($a, $i) => $i !== $index && empty($a['marked_for_removal']))
                                                                    ->pluck('stall_id')
                                                                    ->contains((string) $stall['id']);
                                                            @endphp
                                                            @if (!$alreadyUsed)
                                                                <option value="{{ $stall['id'] }}">{{ $stall['name'] }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error("stallAssignments.{$index}.stall_id")
                                                        <span class="text-status-error text-xs block -mt-2 mb-2">{{ $message }}</span>
                                                    @enderror
                                                @endif

                                                <div class="grid grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block font-dm-serif text-status-dark font-bold text-sm mb-1">Cantidad</label>
                                                        <div class="relative">
                                                            <input type="number"
                                                                wire:model="stallAssignments.{{ $index }}.quantity"
                                                                placeholder="Ej: 20" min="0"
                                                                class="w-full bg-status-white border-none rounded py-2.5 px-3 pr-20 text-sm text-status-dark placeholder:text-accent-grey focus:ring-2 focus:ring-primary-light shadow-sm">
                                                            @if($editingProductUnit)
                                                                <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                                                                    <span class="text-sm font-bold text-accent-darkgrey font-general">{{ $editingProductUnit }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @error("stallAssignments.{$index}.quantity")
                                                            <span class="text-status-error text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label class="block font-dm-serif text-status-dark font-bold text-sm mb-1">Precio</label>
                                                        <div class="relative">
                                                            <input type="text"
                                                                wire:model="stallAssignments.{{ $index }}.price"
                                                                placeholder="Ej: 3.50"
                                                                class="w-full bg-status-white border-none rounded py-2.5 px-3 pr-7 text-sm text-status-dark placeholder:text-accent-grey focus:ring-2 focus:ring-primary-light shadow-sm">
                                                            <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                                                                <x-icons.euro class="w-3.5 h-3.5 text-accent-darkgrey" />
                                                            </div>
                                                        </div>
                                                        @error("stallAssignments.{$index}.price")
                                                            <span class="text-status-error text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label class="block font-dm-serif text-status-dark font-bold text-sm mb-1">Mínimo por pedido</label>
                                                        <div class="relative">
                                                            <input type="number"
                                                                wire:model="stallAssignments.{{ $index }}.min_quantity"
                                                                placeholder="Ej: 1" min="0"
                                                                class="w-full bg-status-white border-none rounded py-2.5 px-3 pr-20 text-sm text-status-dark placeholder:text-accent-grey focus:ring-2 focus:ring-primary-light shadow-sm">
                                                            @if($editingProductUnit)
                                                                <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                                                                    <span class="text-sm font-bold text-accent-darkgrey font-general">{{ $editingProductUnit }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @error("stallAssignments.{$index}.min_quantity")
                                                            <span class="text-status-error text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label class="block font-dm-serif text-status-dark font-bold text-sm mb-1">Se vende cada</label>
                                                        <div class="relative">
                                                            <input type="number"
                                                                wire:model="stallAssignments.{{ $index }}.step_quantity"
                                                                placeholder="Ej: 5" min="1"
                                                                class="w-full bg-status-white border-none rounded py-2.5 px-3 pr-20 text-sm text-status-dark placeholder:text-accent-grey focus:ring-2 focus:ring-primary-light shadow-sm">
                                                            @if($editingProductUnit)
                                                                <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                                                                    <span class="text-sm font-bold text-accent-darkgrey font-general">{{ $editingProductUnit }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @error("stallAssignments.{$index}.step_quantity")
                                                            <span class="text-status-error text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- Botón añadir otro puesto --}}
                                @php
                                    $activeAssignmentsCount = collect($stallAssignments)->filter(fn($a) => empty($a['marked_for_removal']))->count();
                                    $lastVisible = collect($stallAssignments)->filter(fn($a) => empty($a['marked_for_removal']))->last();
                                    $canAddMore = empty($lastVisible) || !empty($lastVisible['stall_id']);
                                @endphp

                                @if ($activeAssignmentsCount < count($sellerStalls))
                                    <button type="button"
                                        wire:click="addStallAssignment"
                                        @class([
                                            'w-full mt-3 border-2 border-dashed py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2 font-bold text-sm',
                                            'border-accent-olive/50 text-status-dark hover:bg-accent-lightgreen/30 cursor-pointer' => $canAddMore,
                                            'border-accent-grey/30 text-accent-grey cursor-not-allowed opacity-50' => !$canAddMore,
                                        ])>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Añadir {{ $activeAssignmentsCount === 0 ? 'un puesto' : 'otro puesto' }}
                                    </button>
                                @endif

                                {{-- Botón cancelar asignación solo en modo crear --}}
                                @if ($modalMode === 'create')
                                    <button type="button"
                                        wire:click="toggleStallConfig"
                                        class="w-full mt-2 border-2 border-dashed py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2 font-bold text-sm border-status-error/50 text-status-error hover:bg-accent-pastelred/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Cancelar asignación a puestos
                                    </button>
                                @endif

                            @else
                                {{-- En modo editar sin puestos, botón para añadir el primero --}}
                                @if ($modalMode === 'edit')
                                    <button type="button"
                                        wire:click="addStallAssignment"
                                        class="w-full border-2 border-dashed py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2 font-bold text-sm border-accent-olive/50 text-status-dark hover:bg-accent-lightgreen/30">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Asignar a un puesto
                                    </button>
                                @endif
                            @endif
                        @endif
                    </div>

                </div>

                <div class="px-6 py-4 border-t border-accent-lightgrey/60 flex justify-end gap-3 shrink-0 bg-status-white rounded-b-xl shadow-t-lg">
                    <button type="button" wire:click="closeEditModal"
                        class="bg-accent-lightred text-status-dark px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-80 transition-opacity">
                        Cancelar
                    </button>
                    <button type="button" wire:click="saveModal"
                        class="bg-accent-lightgreen text-primary px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition-opacity">
                        {{ $modalMode === 'create' ? 'Añadir producto' : 'Guardar cambios' }}
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>