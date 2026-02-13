<?php

namespace App\Livewire\Components;

use Livewire\Component;

class PuestoCard extends Component
{

    public $nombre;
    public $categoria;
    public $imagen;
        public function mount($nombre , $categoria , $imagen=null) {
        $this->nombre = $nombre;
        $this->imagen = $imagen ??'imagenporDefecto' ;
        $this->categoria = $categoria;
    }

    public function render()
    {
        return view('livewire.components.puesto-card');
    }

}
