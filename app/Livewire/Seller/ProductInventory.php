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
use Livewire\WithPagination;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Validation\Rule;

class ProductInventory extends Component
{
    use WithFileUploads;
    use WithPagination;

    // --- Métricas del resumen ---
    public $totalProducts = 0;
    public $assignedProducts = 0;
    public $unassignedProducts = 0;
    public $activeStalls = 0;

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
    public $removingStallIndex = null;

    // --- Modo del modal: 'create' o 'edit' ---
    public $modalMode = 'edit';

    // --- Estado del modal ---
    public $editingProductId = null;
    public $editingProductName = null;
    public $editingProductDescription = null;
    public $editingProductCategoryId = null;
    public $editingProductUnit = null;
    public $editingProductPhotos = [];
    public $photosToDelete = [];
    public $newPhotos = [];
    public $tempPhotos = [];
    public $sellerStalls = [];

    // --- Asignaciones de puestos
    // Cada bloque: ['stall_id', 'quantity', 'price', 'min_quantity', 'step_quantity', 'is_existing', 'marked_for_removal']
    public $stallAssignments = [];
    public $showStallConfig = false;

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasRole('seller')) {
            $this->categories = [];
            $this->sellerStalls = [];
            return;
        }

        $this->categories = Category::orderBy('name')
            ->get()
            ->map(fn($cat) => ['id' => $cat->id, 'name' => $cat->name])
            ->toArray();

        $this->activeStalls = Auth::user()->stalls()->where('active', true)->count();

        $this->sellerStalls = Auth::user()
            ->stalls()
            ->where('active', true)
            ->get()
            ->map(fn($stall) => ['id' => $stall->id, 'name' => $stall->name])
            ->toArray();
    }

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedCategory(): void { $this->resetPage(); }
    public function updatedStatus(): void { $this->resetPage(); }

    public function updatedTempPhotos()
    {
        $this->validate(['tempPhotos.*' => 'mimes:jpg,jpeg,png,webp|max:2048'],
            [
                'tempPhotos.*.mimes' => 'Solo se permiten imagenes en los formatos :values.',
                'tempPhotos.*.max' => 'Cada imagen no debe superar los :max KB.',
            ]
        );

        foreach ($this->tempPhotos as $photo) {
            $this->newPhotos[(string) Str::uuid()] = $photo->getFilename();
        }

        $this->tempPhotos = [];
    }

    public function openCreateModal()
    {
        $this->resetModalState();
        $this->modalMode = 'create';
        $this->showEditModal = true;
    }

    // En edición, pre-carga los puestos asignados como bloques editables con is_existing = true
    public function openEditModal($productId)
    {
        $product = Product::where('id', $productId)
            ->where('user_id', Auth::id())
            ->with(['stalls', 'photos'])
            ->firstOrFail();

        $this->resetModalState();
        $this->modalMode = 'edit';

        $this->editingProductId = $product->id;
        $this->editingProductName = $product->name;
        $this->editingProductDescription = $product->description;
        $this->editingProductCategoryId = $product->category_id;
        $this->editingProductUnit = $product->unit;

        $this->stallAssignments = $product->stalls->map(fn($stall) => [
            'stall_id' => (string) $stall->id,
            'quantity' => $stall->pivot->quantity,
            'price' => $stall->pivot->price_per_unit,
            'min_quantity' => $stall->pivot->min_quantity,
            'step_quantity' => $stall->pivot->step_quantity,
            'is_existing' => true,
            'marked_for_removal' => false,
        ])->toArray();

        // En edición siempre se muestra la sección de puestos
        $this->showStallConfig = true;

        $this->editingProductPhotos = $product->photos->map(fn($photo) => [
            'id' => $photo->id,
            'url' => $photo->url,
        ])->toArray();

        $this->showEditModal = true;
    }

    protected function resetModalState(): void
    {
        $this->cleanupTempPhotos();
        $this->editingProductId = null;
        $this->editingProductName = null;
        $this->editingProductDescription = null;
        $this->editingProductCategoryId = null;
        $this->editingProductUnit = null;
        $this->editingProductPhotos = [];
        $this->photosToDelete = [];
        $this->newPhotos = [];
        $this->tempPhotos = [];
        $this->stallAssignments = [];
        $this->showStallConfig = false;
        $this->removingStallIndex = null;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetModalState();
    }

    // Alterna la sección de puestos en modo crear
    public function toggleStallConfig()
    {
        $this->showStallConfig = !$this->showStallConfig;

        if ($this->showStallConfig && empty($this->stallAssignments)) {
            $this->stallAssignments = [
                ['stall_id' => '', 'quantity' => '', 'price' => '', 'min_quantity' => '', 'step_quantity' => '', 'is_existing' => false, 'marked_for_removal' => false],
            ];
        }

        if (!$this->showStallConfig) {
            $this->stallAssignments = [];
        }
    }

    // Añade un nuevo bloque vacío de asignación de puesto
    public function addStallAssignment()
    {
        // Filtra los bloques visibles (no marcados para quitar) para la comprobación del último
        $visibleAssignments = collect($this->stallAssignments)
            ->filter(fn($a) => empty($a['marked_for_removal']))
            ->values();

        $last = $visibleAssignments->last();

        if ($last && empty($last['stall_id'])) {
            return;
        }

        // Cuenta puestos ya usados (incluyendo los marcados para quitar, para no confundir al usuario)
        $usedStallIds = collect($this->stallAssignments)
            ->filter(fn($a) => !empty($a['stall_id']))
            ->pluck('stall_id')
            ->unique();

        if ($usedStallIds->count() >= count($this->sellerStalls)) {
            return;
        }

        $this->stallAssignments[] = [
            'stall_id' => '',
            'quantity' => '',
            'price' => '',
            'min_quantity' => '',
            'step_quantity' => '',
            'is_existing' => false,
            'marked_for_removal' => false,
        ];
    }

    // Marca un bloque para quitar al guardar (si es existente) o lo elimina directamente (si es nuevo)
    public function confirmRemoveStallAssignment($index)
    {
        $assignment = $this->stallAssignments[$index] ?? null;

        if (!$assignment) {
            return;
        }

        // Los bloques nuevos (no guardados) se eliminan directamente sin confirmación
        if (empty($assignment['is_existing'])) {
            $this->removeStallAssignmentDirect($index);
            return;
        }

        // Los bloques existentes se marcan para quitar: se pide confirmación
        $this->removingStallIndex = $index;
        $this->showDeleteFromStallModal = true;
    }

    // Elimina un bloque nuevo directamente del array
    protected function removeStallAssignmentDirect($index)
    {
        array_splice($this->stallAssignments, $index, 1);
        $this->stallAssignments = array_values($this->stallAssignments);

        // Si no quedan bloques visibles en modo crear, cierra la sección
        $visibleCount = collect($this->stallAssignments)
            ->filter(fn($a) => empty($a['marked_for_removal']))
            ->count();

        if ($visibleCount === 0 && $this->modalMode === 'create') {
            $this->stallAssignments = [];
            $this->showStallConfig = false;
        }
    }

    // Marca el bloque existente como pendiente de quitar al guardar (no lo quita de BD todavía)
    public function removeProductFromStall()
    {
        if ($this->removingStallIndex === null) {
            return;
        }

        if (isset($this->stallAssignments[$this->removingStallIndex])) {
            $this->stallAssignments[$this->removingStallIndex]['marked_for_removal'] = true;
        }

        $this->removingStallIndex = null;
        $this->showDeleteFromStallModal = false;
    }

    public function cancelRemoveFromStall()
    {
        $this->removingStallIndex = null;
        $this->showDeleteFromStallModal = false;
    }

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

    public function removeNewPhoto($key)
    {
        if (isset($this->newPhotos[$key])) {
            $tmpPath = storage_path('app/livewire-tmp/' . $this->newPhotos[$key]);
            if (file_exists($tmpPath)) {
                unlink($tmpPath);
            }
            unset($this->newPhotos[$key]);
        }
    }

    protected function cleanupTempPhotos(): void
    {
        foreach ($this->newPhotos as $filename) {
            $tmpPath = storage_path('app/livewire-tmp/' . $filename);
            if (file_exists($tmpPath)) {
                unlink($tmpPath);
            }
        }
    }

    public function getNewPhotosPreviewsProperty()
    {
        return collect($this->newPhotos)->map(function ($filename) {
            return TemporaryUploadedFile::createFromLivewire($filename);
        })->filter();
    }

    public function saveModal()
    {
        if ($this->modalMode === 'create') {
            $this->createProduct();
        } else {
            $this->updateProduct();
        }
    }

    // Reglas de validación para los puestos, ignorando los marcados para quitar
    protected function stallValidationRules(): array
    {
        $activeAssignments = collect($this->stallAssignments)
            ->filter(fn($a) => empty($a['marked_for_removal']))
            ->values()
            ->toArray();

        if (empty($activeAssignments)) {
            return [];
        }

        return [
            'stallAssignments.*.stall_id' => [
                'nullable',
                'exists:stalls,id',
                function ($attribute, $value, $fail) {
                    // Ignora la validación para los marcados para quitar
                    $index = (int) explode('.', $attribute)[1];
                    if (!empty($this->stallAssignments[$index]['marked_for_removal'])) {
                        return;
                    }
                    if ($value && !Auth::user()->stalls()->where('id', $value)->exists()) {
                        $fail('El puesto seleccionado no te pertenece.');
                    }
                },
            ],
            'stallAssignments.*.quantity' => 'required|numeric|min:1',
            'stallAssignments.*.price' => 'required|numeric|min:0',
            'stallAssignments.*.min_quantity' => 'required|numeric|min:1',
            'stallAssignments.*.step_quantity' => 'required|numeric|min:1',
        ];
    }

    // Ejecuta los detach de puestos marcados y el sync de los activos
    protected function saveStallAssignments(Product $product): bool
    {
        // Separa los marcados para quitar de los activos
        $toRemove = collect($this->stallAssignments)
            ->filter(fn($a) => !empty($a['marked_for_removal']) && !empty($a['stall_id']))
            ->pluck('stall_id');

        $active = collect($this->stallAssignments)
            ->filter(fn($a) => empty($a['marked_for_removal']) && !empty($a['stall_id']));

        // Comprueba duplicados entre los activos
        if ($active->pluck('stall_id')->count() !== $active->pluck('stall_id')->unique()->count()) {
            $this->addError('stallAssignments', 'No puedes asignar el mismo puesto dos veces.');
            return false;
        }

        // Desvincula los marcados para quitar
        foreach ($toRemove as $stallId) {
            $product->stalls()->detach($stallId);
        }

        // Guarda o actualiza los activos
        foreach ($active as $assignment) {
            $quantity = is_numeric($assignment['quantity'] ?? null) ? (int) $assignment['quantity'] : 1;
            $price = is_numeric($assignment['price'] ?? null) ? (float) $assignment['price'] : 0;
            $minQuantity = is_numeric($assignment['min_quantity'] ?? null) ? (int) $assignment['min_quantity'] : 1;
            $stepQuantity = is_numeric($assignment['step_quantity'] ?? null) ? (int) $assignment['step_quantity'] : 1;

            $product->stalls()->syncWithoutDetaching([
                $assignment['stall_id'] => [
                    'quantity' => $quantity,
                    'price_per_unit' => $price,
                    'min_quantity' => $minQuantity,
                    'step_quantity' => $stepQuantity,
                ],
            ]);
        }

        return true;
    }

    protected function createProduct()
    {
        $rules = [
            'editingProductName' => 'required|string|max:255',
            'editingProductDescription' => 'nullable|string|max:1000',
            'editingProductUnit' => ['required', Rule::enum(Units::class)],
            'editingProductCategoryId' => 'required|exists:categories,id',
            ...$this->stallValidationRules(),
        ];

        // Validaciones
        $this->validate($rules, 
            [
                '*.required' => 'Campo requerido',
                'stallAssignments.*.*.numeric' => "El campo debe ser numérico",
                'stallAssignments.*.*.min' => "El valor mínimo es :min",
            ]
        );

        $product = Product::create([
            'name' => $this->editingProductName,
            'description' => $this->editingProductDescription ?? null,
            'unit' => $this->editingProductUnit,
            'user_id' => Auth::id(),
            'category_id' => $this->editingProductCategoryId,
        ]);

        foreach ($this->newPhotos as $filename) {
            $file = TemporaryUploadedFile::createFromLivewire($filename);
            Photo::create([
                'url' => $file->store('products', 'public'),
                'product_id' => $product->id,
            ]);
        }

        if (!$this->saveStallAssignments($product)) {
            return;
        }

        $this->closeEditModal();
    }

    protected function updateProduct()
    {
        $product = Product::where('id', $this->editingProductId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $rules = [
            'editingProductName' => 'required|string|max:255',
            'editingProductDescription' => 'nullable|string|max:1000',
            'editingProductCategoryId' => 'required|exists:categories,id',
            'editingProductUnit' => ['required', Rule::enum(Units::class)],
            ...$this->stallValidationRules(),
        ];

        // Validaciones
        $this->validate($rules, 
            [
                '*.required' => 'Campo requerido',
                'stallAssignments.*.*.numeric' => "El campo debe ser numérico",
                'stallAssignments.*.*.min' => "El valor mínimo es :min",
                'editingProductUnit.enum' => 'La unidad seleccionada no es válida.',
                '*.max' => 'El límite es :max caracteres'
            ]
        );

        $product->name = $this->editingProductName;
        $product->description = $this->editingProductDescription;
        $product->unit = $this->editingProductUnit;
        $product->category_id = $this->editingProductCategoryId;
        $product->save();

        foreach ($this->photosToDelete as $photoId) {
            $photo = Photo::whereHas('product', function ($q) {
                $q->where('user_id', Auth::id());
            })->find($photoId);

            if ($photo) {
                Storage::disk('public')->delete($photo->url);
                $photo->delete();
            }
        }

        foreach ($this->newPhotos as $filename) {
            $file = TemporaryUploadedFile::createFromLivewire($filename);
            Photo::create([
                'url' => $file->store('products', 'public'),
                'product_id' => $product->id,
            ]);
        }

        if (!$this->saveStallAssignments($product)) {
            return;
        }

        $this->closeEditModal();
    }

    public function confirmDeleteProduct($productId)
    {
        $this->deletingProductId = $productId;
        $this->showDeleteProductModal = true;
    }

    public function deleteProduct()
    {
        $product = Product::where('id', $this->deletingProductId)
            ->where('user_id', Auth::id())
            ->with('photos')
            ->firstOrFail();

        foreach ($product->photos as $photo) {
            Storage::disk('public')->delete($photo->url);
        }

        $product->stalls()->detach();
        $product->delete();

        $this->showDeleteProductModal = false;
        $this->deletingProductId = null;
    }

    public function cancelDeleteProduct()
    {
        $this->showDeleteProductModal = false;
        $this->deletingProductId = null;
    }

    public function render()
    {
        $baseQuery = Auth::user()->products()->with(['stalls', 'category']);

        $this->totalProducts = (clone $baseQuery)->count();
        $this->assignedProducts = (clone $baseQuery)->has('stalls')->count();
        $this->unassignedProducts = $this->totalProducts - $this->assignedProducts;

        $filteredQuery = (clone $baseQuery);

        if (!empty($this->search)) {
            $filteredQuery->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->category !== 'all') {
            $filteredQuery->whereHas('category', fn($q) => $q->where('name', $this->category));
        }

        if ($this->status === 'asignado') {
            $filteredQuery->has('stalls');
        } elseif ($this->status === 'sin_asignar') {
            $filteredQuery->doesntHave('stalls');
        }

        $products = $filteredQuery->paginate(8);

        return view('livewire.seller.product-inventory', [
            'totalProducts' => $this->totalProducts,
            'assignedProducts' => $this->assignedProducts,
            'unassignedProducts' => $this->unassignedProducts,
            'activeStalls' => $this->activeStalls,
            'products' => $products,
        ]);
    }
}