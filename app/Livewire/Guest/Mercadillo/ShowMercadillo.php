<?php

namespace App\Livewire\Guest\Mercadillo;

use App\View\Components\GuestLayout;
use Livewire\Component;
use Livewire\Attributes\Layout;



class ShowMercadillo extends Component
{

    public $puestos = [];
    public $nombreMercadillo;

    public function mount()
    {
        $this->nombreMercadillo = "Mercadillo de Puntallana";

        // SIMULACIÓN DE BASE DE DATOS (MOCK DATA)
        // Cuando el backend esté listo, esto se sustituirá por: Puesto::all();
        $this->puestos = [
            [
                'id' => 1,
                'nombre' => 'La Huerta de Juan',
                'categoria' => 'Verduras',
                'imagen' => 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?auto=format&fit=crop&w=800&q=80',
                'descripcion' => 'Tomates, lechugas y pimientos frescos recogidos esta misma mañana. Cultivo 100% ecológico sin pesticidas.',
                'ubicacion' => 'Puesto 12 - Entrada Norte'
            ],
            [
                'id' => 2,
                'nombre' => 'Quesos Luna',
                'categoria' => 'Lácteos',
                'imagen' => 'https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?auto=format&fit=crop&w=800&q=80',
                'descripcion' => 'Queso de cabra ahumado tradicional de La Palma. Ganador del premio agrocanarias 2024.',
                'ubicacion' => 'Puesto 05 - Zona Central'
            ],
            [
                'id' => 3,
                'nombre' => 'Artesanía Volcánica',
                'categoria' => 'Artesanía',
                'imagen' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=800&q=80',
                'descripcion' => 'Joyas hechas a mano con piedra volcánica y plata. Diseños únicos inspirados en la isla.',
                'ubicacion' => 'Puesto 22 - Pasillo B'
            ],
            [
                'id' => 4,
                'nombre' => 'Dulces Palmeros',
                'categoria' => 'Repostería',
                'imagen' => 'https://images.unsplash.com/photo-1559598467-f8b76c8155d0?auto=format&fit=crop&w=800&q=80',
                'descripcion' => 'Rapaduras, bienmesabe y príncipe Alberto. El sabor más dulce de nuestra tierra.',
                'ubicacion' => 'Puesto 08 - Zona Central'
            ],
        ];
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.guest.mercadillo.show-mercadillo');
    }
}
