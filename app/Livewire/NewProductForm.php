<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class NewProductForm extends Component
{
    public function render()
    {
        return view('livewire.Seller.new-product-form');
    }
}
