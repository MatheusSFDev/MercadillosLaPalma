<?php

namespace App\Livewire\Components;

use Livewire\Component;

class PuestoCard extends Component
{

    public $titulo;
    public $categoria;
    public $imagen;
    public function mount($nombre, $categoria, $imagen = null)
    {
        $this->titulo = $nombre;
        $this->imagen = $imagen ?? 'imagenporDefecto';
        $this->categoria = $categoria;
    }

    public function render()
    {
        return view('livewire.components.puesto-card');
    }

}