<?php

// Su vista es \resources\views\livewire\seller\add-product-form.blade.php
namespace App\Livewire\Seller;

use App\Enums\Units;
use App\Models\Category;
use App\Models\Product;
use App\Models\Photo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Validation\Rule;

class AddProductForm extends Component
{
    use WithFileUploads;

    // --- Campos del formulario principal ---
    public $name;
    public $description;
    public $unit;
    public $category_id;
    public $categories = [];

    // --- Puestos del vendedor y configuración por puesto ---
    public $stalls;
    public $stallAssignments = [];
    public $showStallConfig = false;

    // --- Fotos del producto ---
    public $photos = [];
    public $tempPhotos = [];

    // Carga inicial: verifica rol y carga categorías y puestos del vendedor
    public function mount()
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('seller')) {
            abort(403);
        }

        $this->categories = Category::all();

        // Se intentan cargar primero los puestos activos
        $this->stalls = $user->stalls()
            ->where('active', true)
            ->with(['products'])
            ->get();

        // Si no tiene puestos activos, se cargan todos (para mostrar el aviso en la vista)
        if ($this->stalls->isEmpty()) {
            $this->stalls = $user->stalls()->with(['products'])->get();
        }
    }

    // Alterna la sección de asignación a puestos
    // Al abrir, añade el primer bloque vacío; al cerrar, limpia las asignaciones
    public function toggleStallConfig()
    {
        $this->showStallConfig = !$this->showStallConfig;

        if ($this->showStallConfig && empty($this->stallAssignments)) {
            $this->stallAssignments = [
                ['stall_id' => '', 'quantity' => '', 'price' => '', 'min_quantity' => '', 'step_quantity' => ''],
            ];
        }

        if (!$this->showStallConfig) {
            $this->stallAssignments = [];
        }
    }

    // Se dispara cuando el usuario selecciona archivos en el input de fotos
    // Valida, guarda el filename del archivo temporal con clave UUID y limpia el input
    public function updatedTempPhotos()
    {
        $this->validate(['tempPhotos.*' => 'image|max:2048']);

        foreach ($this->tempPhotos as $photo) {
            // UUID como clave para poder borrar fotos individuales sin reindexar
            $this->photos[(string) Str::uuid()] = $photo->getFilename();
        }

        $this->tempPhotos = [];
    }

    // Elimina una foto nueva (aún no guardada) del mapa por su clave UUID
    public function removePhoto($key)
    {
        unset($this->photos[$key]);
    }

    // Propiedad computada: reconstruye los objetos TemporaryUploadedFile
    // a partir de los filenames guardados en $photos para poder hacer temporaryUrl()
    public function getPhotosPreviewsProperty()
    {
        return collect($this->photos)->map(function ($filename) {
            return TemporaryUploadedFile::createFromLivewire($filename);
        })->filter();
    }

    // Añade un nuevo bloque de asignación de puesto
    // Solo permite añadir si el último bloque ya tiene un puesto seleccionado
    // y no se ha llegado al límite de puestos disponibles
    public function addStallAssignment()
    {
        $last = end($this->stallAssignments);

        if (empty($last['stall_id'])) {
            return;
        }

        if (count($this->stallAssignments) >= $this->stalls->count()) {
            return;
        }

        $this->stallAssignments[] = ['stall_id' => '', 'quantity' => '', 'price' => '', 'min_quantity' => '', 'step_quantity' => ''];
    }

    // Elimina un bloque de asignación por su índice
    // Si era el único bloque, cierra la sección de configuración por puesto
    public function removeStallAssignment($index)
    {
        if (count($this->stallAssignments) > 1) {
            array_splice($this->stallAssignments, $index, 1);
        } else {
            $this->stallAssignments = [];
            $this->showStallConfig = false;
        }
    }

    // Valida, crea el producto, guarda fotos y vincula a los puestos configurados
    public function submit()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'unit' => ['required', Rule::enum(Units::class)],
            'category_id' => 'required|exists:categories,id',
        ];

        // Solo se validan las asignaciones si la sección está activa y tiene datos
        if ($this->showStallConfig && !empty($this->stallAssignments)) {
            $rules['stallAssignments'] = 'array';
            $rules['stallAssignments.*.stall_id'] = [
                'nullable',
                'exists:stalls,id',
                function ($attribute, $value, $fail) {
                    if ($value && !Auth::user()->stalls()->where('id', $value)->exists()) {
                        $fail('El puesto seleccionado no te pertenece.');
                    }
                },
            ];
            $rules['stallAssignments.*.quantity'] = 'nullable|numeric|min:0';
            $rules['stallAssignments.*.price'] = 'nullable|numeric|min:0';
            $rules['stallAssignments.*.min_quantity'] = 'nullable|numeric|min:0';
            $rules['stallAssignments.*.step_quantity'] = 'nullable|numeric|min:0';
        }

        $validated = $this->validate($rules);

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'unit' => $validated['unit'],
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
        ]);

        // Guarda las fotos reconstruyendo el archivo temporal desde su filename
        foreach ($this->photos as $filename) {
            $file = TemporaryUploadedFile::createFromLivewire($filename);
            Photo::create([
                'url' => $file->store('products', 'public'),
                'product_id' => $product->id,
            ]);
        }

        if ($this->showStallConfig && !empty($this->stallAssignments)) {
            // Comprueba que no se haya seleccionado el mismo puesto dos veces
            $stallIds = collect($this->stallAssignments)
                ->filter(fn($a) => !empty($a['stall_id']))
                ->pluck('stall_id');

            if ($stallIds->count() !== $stallIds->unique()->count()) {
                $this->addError('stallAssignments', 'No puedes asignar el mismo puesto dos veces.');
                return;
            }

            // Vincula el producto a cada puesto con sus datos de pivot
            $usedStalls = [];
            foreach ($this->stallAssignments as $assignment) {
                if (!empty($assignment['stall_id']) && !in_array($assignment['stall_id'], $usedStalls)) {
                    $product->stalls()->attach($assignment['stall_id'], [
                        'quantity' => $assignment['quantity'] ?? 0,
                        'price_per_unit' => $assignment['price'] ?? 0,
                        'min_quantity' => $assignment['min_quantity'] ?? 0,
                        'step_quantity' => $assignment['step_quantity'] ?? 1,
                    ]);
                    $usedStalls[] = $assignment['stall_id'];
                }
            }
        }

        session()->flash('message', 'Producto añadido con éxito.');

        // Resetea los campos del formulario manteniendo las listas de categorías y puestos
        $this->reset(['name', 'description', 'unit', 'category_id', 'tempPhotos']);
        $this->photos = [];
        $this->stallAssignments = [];
        $this->showStallConfig = false;
    }

    public function render()
    {
        return view('livewire.seller.add-product-form');
    }
}