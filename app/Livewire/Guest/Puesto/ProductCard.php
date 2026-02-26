<?php

namespace App\Livewire\Guest\Puesto;

use Livewire\Component;

class ProductCard extends Component
{
    // Las propiedades que recibiremos del componente padre
    public $nombre;
    public $precio;
    public $descripcion;
    public $imagen;
    public $productoId;

    public function mount($nombre, $precio, $descripcion = '', $imagen = null, $id = null)
    {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->imagen = $imagen ?? 'https://via.placeholder.com/400x400?text=Producto';
        $this->productoId = $id;
    }

    public function render()
    {
        return view('livewire.guest.puesto.product-card');
    }
}