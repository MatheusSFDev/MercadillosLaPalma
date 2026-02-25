<?php

namespace App\Livewire\Guest\Puesto;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Stall;

class ShowPuesto extends Component
{
    public $stall;
    public $productos;

    // El $id viene directamente de la URL /stall/{id}
    public function mount($id)
    {
        $this->stall = Stall::with(['user', 'fleaMarket', 'products'])
            ->findOrFail($id);
        
        $this->productos = $this->stall->products;
    }

    #[Layout('layouts.guest-full')]
    public function render()
    {
        return view('livewire.guest.puesto.show-puesto');
    }
}
