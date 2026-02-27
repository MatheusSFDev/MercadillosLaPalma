<?php

namespace App\Livewire\Seller;

use App\Models\Category;
use App\Models\Product;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddProductForm extends Component
{
    public $name;
    public $unit;
    public $category_id;
    public $categories = [];

    public $stalls = [];
    public $stall_id;
    public $quantity;
    public $price;

    public $img;

    public function mount()
    {
        // ensure only logged in sellers reach this component
        $user = Auth::user();
        if (!$user || !$user->hasRole('seller')) {
            abort(403);
        }

        // preload data for dropdowns
        $this->categories = Category::all();
        $this->stalls = $user->stalls()->get();
    }

    public function submit()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|in:Kg,gr,L,mL,unidad/es',
            'category_id' => 'required|exists:categories,id',
            'stall_id' => 'nullable|exists:stalls,id',
            'quantity' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'img' => 'nullable|image|max:2048',
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'unit' => $validated['unit'],
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
        ]);

        if (isset($validated['img'])) {
            Photo::create([
                'url' => $validated['img']->store('products', 'public'),
                'product_id' => $product->id,
            ]);
        }

        if (!empty($validated['stall_id'])) {
            $product->stalls()->attach($validated['stall_id'], [
                'quantity' => $validated['quantity'] ?? 0,
                'price_per_unit' => $validated['price'] ?? 0,
            ]);
        }

        session()->flash('message', 'Producto añadido con éxito.');
        // reset form
        $this->reset(['name','unit','category_id','stall_id','quantity','price','img']);
    }

    public function render()
    {
        return view('livewire.seller.add-product-form');
    }
}
