<?php

// Su vista es \resources\views\livewire\seller\product-inventory.blade.php
namespace App\Livewire\Seller;

use App\Enums\Units;
use App\Models\Category;
use App\Models\Product;
use App\Models\Photo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Validation\Rule;

class ProductInventory extends Component
{
    use WithFileUploads;

    // --- Colección de productos del vendedor y métricas del resumen ---
    public $products;
    public $totalProducts = 0;
    public $assignedProducts = 0;
    public $unassignedProducts = 0;
    public $activeStalls = 0;
    public $productRows = [];

    // --- Filtros de la tabla ---
    public $search = '';
    public $category = 'all';
    public $status = 'all';
    public $categories = [];

    // --- Control de modales ---
    public $showEditModal = false;
    public $showDeleteProductModal = false;
    public $showDeleteFromStallModal = false;
    public $deletingProductId = null;

    // --- Estado del modal de edición ---
    public $editingProductId = null;
    public $editingProductName = null;
    public $editingProductDescription = null;
    public $editingProductCategoryId = null;
    public $editingProductUnit = null;
    public $editingProductStalls = [];
    public $editingProductPhotos = [];
    public $photosToDelete = [];
    public $newPhotos = [];
    public $tempPhotos = [];
    public $sellerStalls = [];
    public $selectedStallId = null;
    public $editQuantity = null;
    public $editPrice = null;
    public $editMinQuantity = null;
    public $editStepQuantity = null;

    // Carga inicial del componente
    public function mount()
    {
        // Si el usuario no está autenticado o no es vendedor, se inicializa vacío
        if (!Auth::check() || !Auth::user()->hasRole('seller')) {
            $this->products = collect();
            $this->categories = [];
            $this->sellerStalls = [];
            $this->activeStalls = 0;
            $this->prepareData();
            return;
        }

        $this->loadProducts();

        $this->categories = Category::orderBy('name')
            ->get()
            ->map(fn($cat) => ['id' => $cat->id, 'name' => $cat->name])
            ->toArray();

        $this->activeStalls = Auth::user()->stalls()->where('active', true)->count();

        // Solo se cargan los puestos activos para el selector del modal
        $this->sellerStalls = Auth::user()
            ->stalls()
            ->where('active', true)
            ->get()
            ->map(fn($stall) => ['id' => $stall->id, 'name' => $stall->name])
            ->toArray();

        $this->prepareData();
    }

    // Carga los productos del vendedor con sus relaciones necesarias
    protected function loadProducts(): void
    {
        $this->products = Auth::user()->products()
            ->with(['stalls', 'category', 'photos'])
            ->get();
    }

    // Detecta cambios en los filtros y regenera las filas de la tabla
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'category', 'status'])) {
            $this->prepareData();
        }
    }

    // Se dispara cuando el usuario selecciona archivos en el input de fotos
    // Valida, guarda el filename del archivo temporal con clave UUID y limpia el input
    public function updatedTempPhotos()
    {
        $this->validate(['tempPhotos.*' => 'image|max:2048']);

        foreach ($this->tempPhotos as $photo) {
            // UUID como clave para poder borrar fotos individuales sin reindexar
            $this->newPhotos[(string) Str::uuid()] = $photo->getFilename();
        }

        $this->tempPhotos = [];
    }

    // Abre el modal de edición y carga todos los datos del producto seleccionado
    public function openEditModal($productId)
    {
        $product = $this->products->firstWhere('id', $productId);

        if (!$product || $product->user_id !== Auth::id()) {
            return;
        }

        $this->editingProductId = $product->id;
        $this->editingProductName = $product->name;
        $this->editingProductDescription = $product->description;
        $this->editingProductCategoryId = $product->category_id;
        $this->editingProductUnit = $product->unit;

        // Se cargan los puestos con los datos de la tabla pivot (precio, stock, etc.)
        $this->editingProductStalls = $product->stalls->map(fn($stall) => [
            'id' => $stall->id,
            'name' => $stall->name,
            'quantity' => $stall->pivot->quantity,
            'price' => $stall->pivot->price_per_unit,
            'min_quantity' => $stall->pivot->min_quantity,
            'step_quantity' => $stall->pivot->step_quantity,
        ])->toArray();

        // Se cargan las fotos existentes (solo id y url para mostrar y marcar para borrar)
        $this->editingProductPhotos = $product->photos->map(fn($photo) => [
            'id' => $photo->id,
            'url' => $photo->url,
        ])->toArray();

        // Se limpian los estados temporales por si quedaron datos de una edición anterior
        $this->photosToDelete = [];
        $this->newPhotos = [];
        $this->tempPhotos = [];
        $this->selectedStallId = null;
        $this->editQuantity = null;
        $this->editPrice = null;
        $this->editMinQuantity = null;
        $this->editStepQuantity = null;
        $this->showEditModal = true;
    }

    // Cuando se selecciona un puesto en el modal, se precargan sus datos de pivot
    // Si el puesto no está asignado aún, se inicializan los campos a 0
    public function updatedSelectedStallId($value)
    {
        $stall = collect($this->editingProductStalls)->firstWhere('id', (int) $value);

        if ($stall) {
            $this->editQuantity = $stall['quantity'];
            $this->editPrice = $stall['price'];
            $this->editMinQuantity = $stall['min_quantity'];
            $this->editStepQuantity = $stall['step_quantity'];
        } elseif ($value) {
            $this->editQuantity = 0;
            $this->editPrice = 0;
            $this->editMinQuantity = 0;
            $this->editStepQuantity = 0;
        } else {
            $this->editQuantity = null;
            $this->editPrice = null;
            $this->editMinQuantity = null;
            $this->editStepQuantity = null;
        }
    }

    // Alterna el marcado de una foto existente para eliminar al guardar
    public function toggleDeletePhoto($photoId)
    {
        if (in_array($photoId, $this->photosToDelete)) {
            $this->photosToDelete = array_values(array_filter(
                $this->photosToDelete,
                fn($id) => $id !== $photoId
            ));
        } else {
            $this->photosToDelete[] = $photoId;
        }
    }

    // Elimina una foto nueva (aún no guardada) del mapa por su clave UUID
    public function removeNewPhoto($key)
    {
        unset($this->newPhotos[$key]);
    }

    // Propiedad computada: reconstruye los objetos TemporaryUploadedFile
    // a partir de los filenames guardados en $newPhotos para poder hacer temporaryUrl()
    public function getNewPhotosPreviewsProperty()
    {
        return collect($this->newPhotos)->map(function ($filename) {
            return TemporaryUploadedFile::createFromLivewire($filename);
        })->filter();
    }

    // Cierra el modal de edición y resetea todos sus campos
    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingProductId = null;
        $this->editingProductName = null;
        $this->editingProductDescription = null;
        $this->editingProductCategoryId = null;
        $this->editingProductUnit = null;
        $this->editingProductStalls = [];
        $this->editingProductPhotos = [];
        $this->photosToDelete = [];
        $this->newPhotos = [];
        $this->tempPhotos = [];
        $this->selectedStallId = null;
        $this->editQuantity = null;
        $this->editPrice = null;
        $this->editMinQuantity = null;
        $this->editStepQuantity = null;
    }

    // Guarda los cambios del producto: datos generales, fotos y asignación al puesto seleccionado
    public function updateProductAtStall()
    {
        $product = Product::where('id', $this->editingProductId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $rules = [
            'editingProductName' => 'required|string|max:255',
            'editingProductDescription' => 'nullable|string|max:1000',
            'editingProductCategoryId' => 'required|exists:categories,id',
            'editingProductUnit' => ['required', Rule::enum(Units::class)],
        ];

        // Solo se validan los campos del puesto si hay uno seleccionado
        if ($this->selectedStallId) {
            $rules['selectedStallId'] = [
                'required',
                'exists:stalls,id',
                function ($attribute, $value, $fail) {
                    if (!Auth::user()->stalls()->where('id', $value)->exists()) {
                        $fail('El puesto seleccionado no te pertenece.');
                    }
                },
            ];
            $rules['editQuantity'] = 'required|numeric|min:0';
            $rules['editPrice'] = 'required|numeric|min:0';
            $rules['editMinQuantity'] = 'required|numeric|min:0';
            $rules['editStepQuantity'] = 'required|numeric|min:1';
        }

        $this->validate($rules);

        $product->name = $this->editingProductName;
        $product->description = $this->editingProductDescription;
        $product->unit = $this->editingProductUnit;
        $product->category_id = $this->editingProductCategoryId;
        $product->save();

        // Elimina del disco y de la BD las fotos marcadas para borrar
        foreach ($this->photosToDelete as $photoId) {
            $photo = Photo::whereHas('product', function ($q) {
                $q->where('user_id', Auth::id());
            })->find($photoId);

            if ($photo) {
                Storage::disk('public')->delete($photo->url);
                $photo->delete();
            }
        }

        // Guarda las fotos nuevas reconstruyendo el archivo temporal desde su filename
        foreach ($this->newPhotos as $filename) {
            $file = TemporaryUploadedFile::createFromLivewire($filename);
            Photo::create([
                'url' => $file->store('products', 'public'),
                'product_id' => $product->id,
            ]);
        }

        // Actualiza o crea la asignación del producto al puesto con syncWithoutDetaching
        // para no afectar otros puestos ya asignados
        if ($this->selectedStallId) {
            $product->stalls()->syncWithoutDetaching([
                $this->selectedStallId => [
                    'quantity' => $this->editQuantity,
                    'price_per_unit' => $this->editPrice,
                    'min_quantity' => $this->editMinQuantity,
                    'step_quantity' => $this->editStepQuantity,
                ],
            ]);
        }

        // Reemplaza el producto en la colección en memoria para no tener que recargar todo
        $this->products = $this->products->map(function ($p) use ($product) {
            if ($p->id == $product->id) {
                return $product->load(['stalls', 'category', 'photos']);
            }
            return $p;
        });

        $this->prepareData();
        $this->closeEditModal();
    }

    // Abre el modal de confirmación para quitar el producto del puesto seleccionado
    public function confirmRemoveFromStall()
    {
        $this->showDeleteFromStallModal = true;
    }

    // Ejecuta la desvinculación del producto del puesto tras confirmación
    public function removeProductFromStall()
    {
        $product = Product::where('id', $this->editingProductId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $this->validate([
            'selectedStallId' => [
                'required',
                'exists:stalls,id',
                function ($attribute, $value, $fail) {
                    if (!Auth::user()->stalls()->where('id', $value)->exists()) {
                        $fail('El puesto seleccionado no te pertenece.');
                    }
                },
            ],
        ]);

        $product->stalls()->detach($this->selectedStallId);

        $this->products = $this->products->map(function ($p) use ($product) {
            if ($p->id == $product->id) {
                return $product->load(['stalls', 'category', 'photos']);
            }
            return $p;
        });

        $this->showDeleteFromStallModal = false;
        $this->prepareData();
        $this->closeEditModal();
    }

    // Guarda el ID del producto a eliminar y abre el modal de confirmación
    public function confirmDeleteProduct($productId)
    {
        $this->deletingProductId = $productId;
        $this->showDeleteProductModal = true;
    }

    // Elimina el producto completo: fotos del disco, desvincula puestos y borra el registro
    public function deleteProduct()
    {
        $product = Product::where('id', $this->deletingProductId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        foreach ($product->photos as $photo) {
            Storage::disk('public')->delete($photo->url);
        }

        $product->stalls()->detach();
        $product->delete();

        // Se elimina de la colección en memoria para actualizar la tabla sin recargar
        $this->products = $this->products->reject(fn($p) => $p->id === $product->id);
        $this->showDeleteProductModal = false;
        $this->deletingProductId = null;
        $this->prepareData();
    }

    // Cancela la eliminación del producto y cierra el modal
    public function cancelDeleteProduct()
    {
        $this->showDeleteProductModal = false;
        $this->deletingProductId = null;
    }

    // Cancela la eliminación del producto de un puesto y cierra el modal
    public function cancelRemoveFromStall()
    {
        $this->showDeleteFromStallModal = false;
    }

    // Calcula métricas del resumen y aplica los filtros activos para generar $productRows
    protected function prepareData(): void
    {
        $allProducts = $this->products->loadMissing(['stalls', 'category']);

        $this->totalProducts = $allProducts->count();
        $this->assignedProducts = $allProducts->filter(fn($p) => $p->stalls->isNotEmpty())->count();
        $this->unassignedProducts = $this->totalProducts - $this->assignedProducts;

        $filtered = $allProducts;

        if (!empty($this->search)) {
            $search = mb_strtolower($this->search, 'UTF-8');
            $filtered = $filtered->filter(
                fn($p) => str_contains(mb_strtolower($p->name, 'UTF-8'), $search)
            );
        }

        if ($this->category !== 'all') {
            $filtered = $filtered->filter(
                fn($p) => optional($p->category)->name === $this->category
            );
        }

        if ($this->status === 'asignado') {
            $filtered = $filtered->filter(fn($p) => $p->stalls->isNotEmpty());
        } elseif ($this->status === 'sin_asignar') {
            $filtered = $filtered->filter(fn($p) => $p->stalls->isEmpty());
        }

        // Transforma cada producto en un array plano con los datos que necesita la tabla
        $this->productRows = $filtered->map(function ($product) {
            $stalls = $product->stalls;
            $totalStock = $stalls->sum(fn($s) => $s->pivot->quantity ?? 0);
            $avgPrice = $stalls->count()
                ? $stalls->avg(fn($s) => $s->pivot->price_per_unit ?? 0)
                : null;

            return [
                'id' => $product->id,
                'name' => $product->name,
                'status' => $stalls->isNotEmpty() ? 'Asignado' : 'Sin asignar',
                'stalls' => $stalls->pluck('name')->join(', '),
                'stock' => $totalStock,
                'price' => $avgPrice ? round($avgPrice, 2) : null,
                'unit' => $product->unit,
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.seller.product-inventory', [
            'totalProducts' => $this->totalProducts,
            'assignedProducts' => $this->assignedProducts,
            'unassignedProducts' => $this->unassignedProducts,
            'activeStalls' => $this->activeStalls,
            'productRows' => $this->productRows,
        ]);
    }
}