<!-- Su componente es \app\Livewire\Seller\ProductInventory.php -->

<div
    x-data="{ isEditModalOpen: @entangle('showEditModal'), isDeleteProductOpen: @entangle('showDeleteProductModal'), isDeleteFromStallOpen: @entangle('showDeleteFromStallModal') }"
    class="p-10 font-atkinson text-status-dark bg-primary-pastel min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-coffee font-titulo-principal font-bold text-4xl mb-1">Gestión de Productos</h1>
            <p class="text-coffee-light">Vista completa con productos asignados y sin asignar a puestos</p>
        </div>

        <div class="bg-status-white rounded-xl p-4 shadow-lg mb-6">

            <div class="flex justify-between items-center mb-5">
                <h2 class="text-coffee font-titulo-seccion text-xl font-bold">Mis productos</h2>
                <a href="{{ route('seller.add-product') }}"
                    class="bg-primary-offgreen text-primary-pastel flex items-center gap-1 py-3 px-4 rounded-lg text-sm font-semibold shadow-sm hover:opacity-90 transition-opacity">
                    <span>+</span> Añadir productos
                </a>
            </div>

            <div class="flex flex-col md:flex-row md:items-center gap-4 mb-6">

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

                <div class="grid grid-cols-2 md:flex md:items-center gap-4 w-full md:w-auto shrink-0">
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

            <div class="mb-2">
                <h3 class="text-base font-dm-serif text-lg mb-3 text-status-dark">Resumen</h3>
                <div class="grid grid-cols-4 gap-2 md:gap-4 text-center">

                    <div class="bg-accent-altorange rounded-3xl py-4 px-1 md:py-4 md:px-4 shadow-sm flex flex-col md:flex-row justify-center items-center md:items-baseline md:gap-2 h-full">
                        <span class="text-coffee-light font-bold font-playfair text-3xl leading-none mb-1 md:mb-0">{{ $totalProducts }}</span>
                        <span class="font-dm-serif leading-tight text-sm text-status-dark">
                            <span class="md:hidden">Total de<br>productos</span>
                            <span class="hidden md:inline">Total de productos</span>
                        </span>
                    </div>

                    <div class="bg-accent-lightgreen rounded-3xl py-4 px-1 md:py-4 md:px-4 shadow-sm flex flex-col md:flex-row justify-center items-center md:items-baseline md:gap-2 h-full">
                        <span class="text-primary font-bold font-playfair text-3xl leading-none mb-1 md:mb-0">{{ $assignedProducts }}</span>
                        <span class="font-dm-serif leading-tight text-sm text-status-dark">
                            <span class="md:hidden">Productos<br>asignados</span>
                            <span class="hidden md:inline">Productos asignados</span>
                        </span>
                    </div>

                    <div class="bg-accent-lightorange rounded-3xl py-4 px-1 md:py-4 md:px-4 shadow-sm flex flex-col md:flex-row justify-center items-center md:items-baseline md:gap-2 h-full">
                        <span class="text-accent-darkyellow font-bold font-playfair text-3xl leading-none mb-1 md:mb-0">{{ $unassignedProducts }}</span>
                        <span class="font-dm-serif leading-tight text-sm text-status-dark">
                            <span class="md:hidden">Productos<br>sin asignar</span>
                            <span class="hidden md:inline">Productos sin asignar</span>
                        </span>
                    </div>

                    <div class="bg-accent-pastelred rounded-3xl py-4 px-1 md:py-4 md:px-4 shadow-sm flex flex-col md:flex-row justify-center items-center md:items-baseline md:gap-2 h-full">
                        <span class="text-accent-orange font-bold font-playfair text-3xl leading-none mb-1 md:mb-0">{{ $activeStalls }}</span>
                        <span class="font-dm-serif leading-tight text-sm text-status-dark">
                            <span class="md:hidden">Puestos<br>activos</span>
                            <span class="hidden md:inline">Puestos activos</span>
                        </span>
                    </div>

                </div>
            </div>
        </div>

        <div class="bg-status-white rounded-xl shadow-lg overflow-hidden font-dm-serif">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-center">
                    <thead class="bg-accent-olive text-white">
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
                        @forelse($productRows as $product)
                            <tr class="border-b border-accent-lightgrey/30">
                                <td class="py-4 px-4 text-left whitespace-nowrap">{{ $product['name'] }}</td>
                                <td class="py-4 px-2 whitespace-nowrap">
                                    <span class="{{ $product['status'] === 'Asignado' ? 'bg-accent-lightgreen text-primary' : 'bg-accent-lightorange text-accent-darkyellow' }} px-3 py-1 rounded-full">
                                        {{ $product['status'] }}
                                    </span>
                                </td>
                                <td class="py-4 px-2 whitespace-nowrap {{ $product['stalls'] ? '' : 'text-accent-grey' }}">
                                    {{ $product['stalls'] ?: '----' }}
                                </td>
                                <td class="py-4 px-2 whitespace-nowrap {{ $product['stock'] !== null ? '' : 'text-accent-grey' }}">
                                    {{ $product['stock'] !== null && $product['stock'] > 0 ? $product['stock'] . " " . $product['unit'] : '----' }}
                                </td>
                                <td class="py-4 px-2 whitespace-nowrap {{ $product['price'] !== null ? '' : 'text-accent-grey' }}">
                                    {{ $product['price'] !== null ? number_format($product['price'], 2, ',', '.') . '€' : '----' }}
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="openEditModal({{ $product['id'] }})"
                                            class="bg-accent-lightgreen p-1.5 rounded-md hover:bg-primary-pastel transition-colors">
                                            <x-icons.lapiz class="w-6 h-6 text-primary" />
                                        </button>
                                        <button wire:click="confirmDeleteProduct({{ $product['id'] }})"
                                            class="bg-accent-againorange p-1.5 rounded-md hover:opacity-80 transition-opacity">
                                            <x-icons.papelera class="w-6 h-6 text-status-error" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6">No hay productos disponibles</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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

        {{-- Modal confirmar borrado de puesto --}}
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
                    ¿Quieres quitar este producto del puesto seleccionado? El producto seguirá existiendo y podrás reasignarlo después.
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

        {{-- Modal edición --}}
        <div x-show="isEditModalOpen" x-cloak class="fixed inset-0 z-40 flex items-center justify-center px-4 md:px-0">

            <div x-show="isEditModalOpen" x-transition.opacity @click="isEditModalOpen = false"
                class="absolute inset-0 bg-status-dark/30 backdrop-blur-sm"></div>

            <div x-show="isEditModalOpen" x-transition
                class="relative bg-status-white rounded-xl border border-accent-olive/30 shadow-[6px_6px_0px_0px_#75826A] w-full max-w-md p-6 overflow-y-auto max-h-[90vh]">

                <form wire:submit.prevent="updateProductAtStall" class="space-y-5 font-atkinson">

                    <div>
                        <label class="block font-dm-serif font-bold text-status-dark text-lg mb-1">Producto</label>
                        <input wire:model.defer="editingProductName" type="text"
                            class="w-full bg-accent-lightred text-status-dark text-sm rounded-lg py-3 px-4 border-none focus:ring-1 focus:ring-primary outline-none">
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
                            <label class="block font-dm-serif font-bold text-status-dark text-lg mb-1">Categoría</label>
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
                            <label class="block font-dm-serif font-bold text-status-dark text-lg mb-1">Unidad de medida</label>
                            <select wire:model.defer="editingProductUnit"
                                class="w-full bg-accent-lightred text-status-dark text-sm rounded-lg py-3 px-4 pr-8 border-none focus:ring-1 focus:ring-primary outline-none">
                                @foreach (App\Enums\Units::cases() as $unit)
                                    <option value="{{ $unit->value }}">{{ $unit->name }} - ({{ $unit->value }})</option>
                                @endforeach
                            </select>
                            @error('editingProductUnit') <span class="text-status-error text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block font-dm-serif font-bold text-status-dark text-lg mb-2">Imágenes actuales</label>

                        @if (count($editingProductPhotos) > 0)
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
                        @else
                            <p class="text-accent-grey text-sm mb-3">Sin imágenes</p>
                        @endif

                        <label class="block font-dm-serif font-bold text-status-dark text-lg mb-2">Añadir imágenes</label>

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
                                        <span class="absolute bottom-0 left-0 right-0 text-center text-[9px] text-primary font-bold bg-status-white/80 rounded-b-md">
                                            Nueva
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <label for="new-photos-upload"
                            class="flex flex-col items-center justify-center w-full h-24 bg-accent-lightred rounded-lg cursor-pointer hover:bg-accent-lightred/70 transition-colors border-2 border-dashed border-accent-grey/30 hover:border-primary/40 group">
                            <div class="flex flex-col items-center justify-center gap-1 text-accent-grey group-hover:text-status-dark transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs font-atkinson">Añadir imágenes</span>
                                <span class="text-[10px]">PNG, JPG o WEBP</span>
                            </div>
                            <input id="new-photos-upload" type="file" wire:model.live="tempPhotos" class="hidden" accept="image/*" multiple />
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

                    <div>
                        <label class="block font-dm-serif font-bold text-status-dark text-lg mb-1">Puesto (asignado / disponible)</label>
                        <select wire:model.live="selectedStallId"
                            class="w-full bg-accent-lightred text-status-dark text-sm rounded-lg py-3 px-4 pr-8 border-none focus:ring-1 focus:ring-primary outline-none">
                            <option value="">Selecciona el puesto</option>
                            @foreach($sellerStalls as $stall)
                                @php $assigned = collect($editingProductStalls)->firstWhere('id', $stall['id']); @endphp
                                <option value="{{ $stall['id'] }}">
                                    {{ $stall['name'] }} @if($assigned) (ya asignado) @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if($selectedStallId)
                        @if (collect($editingProductStalls)->firstWhere('id', (int) $selectedStallId))
                            <div>
                                <button type="button"
                                    wire:click="confirmRemoveFromStall"
                                    class="bg-status-error/70 text-status-white px-4 py-2 rounded-lg font-semibold text-sm hover:bg-red-700 transition-colors">
                                    Eliminar de este puesto
                                </button>
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block font-dm-serif font-bold text-status-dark text-lg mb-1">Cantidad</label>
                                <div class="relative">
                                    <input wire:model.defer="editQuantity" type="number" min="0"
                                        class="w-full bg-accent-lightred text-status-dark text-sm rounded-lg py-3 px-4 pr-14 border-none focus:ring-1 focus:ring-primary outline-none">
                                </div>
                                @error('editQuantity') <span class="text-status-error text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block font-dm-serif font-bold text-status-dark text-lg mb-1">Precio</label>
                                <div class="relative">
                                    <input wire:model.defer="editPrice" type="text"
                                        class="w-full bg-accent-lightred text-status-dark text-sm rounded-lg py-3 px-4 pr-8 border-none focus:ring-1 focus:ring-primary outline-none">
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <x-icons.euro class="w-4 h-4 text-accent-darkgrey" />
                                    </div>
                                </div>
                                @error('editPrice') <span class="text-status-error text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block font-dm-serif font-bold text-status-dark text-md mb-1">Mínimo por pedido</label>
                                <div class="relative">
                                    <input wire:model.defer="editMinQuantity" type="number" min="0"
                                        class="w-full bg-accent-lightred text-status-dark text-sm rounded-lg py-3 px-4 pr-14 border-none focus:ring-1 focus:ring-primary outline-none">
                                </div>
                                @error('editMinQuantity') <span class="text-status-error text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block font-dm-serif font-bold text-status-dark text-md mb-1">Incremento mínimo por pedido</label>
                                <div class="relative">
                                    <input wire:model.defer="editStepQuantity" type="number" min="0"
                                        class="w-full bg-accent-lightred text-status-dark text-sm rounded-lg py-3 px-4 pr-14 border-none focus:ring-1 focus:ring-primary outline-none">
                                </div>
                                @error('editStepQuantity') <span class="text-status-error text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @endif

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" wire:click="closeEditModal"
                            class="bg-accent-lightred text-status-dark px-4 py-2 rounded-lg">Cancelar</button>
                        <button type="submit"
                            class="bg-accent-lightgreen text-primary px-4 py-2 rounded-lg font-semibold">Guardar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>