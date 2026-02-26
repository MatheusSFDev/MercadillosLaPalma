<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Hero extends Component
{
    public $titulo;
    public $subtitulo;
    public $imagen;
    public $logo; // Opcional

    public function mount($titulo, $subtitulo = '', $imagen = '', $logo = null)
    {
        $this->titulo = $titulo;
        $this->subtitulo = $subtitulo;
        $this->imagen = $imagen;
        $this->logo = $logo;
    }

    public function render()
    {
        return view('livewire.components.hero');
    }
}