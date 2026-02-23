<?php

namespace App\Livewire\Guest\Puesto;

use Livewire\Component;
use Livewire\Attributes\Layout;

class ShowPuesto extends Component
{
    public $puestoId;
    public $datosPuesto;
    public $productos = [];

    // El $id viene directamente de la URL /showpuesto/{id}
    public function mount($id)
    {
        $this->puestoId = $id;

        // SIMULACIÓN: Datos del Puesto
        $this->datosPuesto = [
            'nombre' => 'Quesería Artesanal Los Volcanes',
            'vendedor' => 'María Hernández',
            'banner' => 'https://media.istockphoto.com/id/1292728617/es/foto/recorte-de-tomates-maduros-en-el-tallo-con-tijeras-en-el-invernadero.jpg?s=612x612&w=is&k=20&c=l76HILlkiAnBzE5zmeCb91GahwCUxbGJNhheiEZlU6w=',
            'logo' => 'https://images.unsplash.com/photo-1550989460-0adf9ea622e2?auto=format&fit=crop&w=300&q=80',
            'descripcion' => 'Llevamos tres generaciones elaborando queso de cabra con leche fresca de nuestra propia ganadería en el norte de La Palma. Tradición y sabor en cada pieza.',
            'poblacion' => 'Puntallana',
        ];

        // SIMULACIÓN: Lista de Productos del Puesto
        $this->productos = [
            [
                'id' => 101,
                'nombre' => 'Queso Tierno Ahumado',
                'precio' => 8.50,
                'descripcion' => 'Ahumado con cáscara de almendra y madera de pino canario.',
                'imagen' => 'https://images.unsplash.com/photo-1552767059-ce182ead6c1b?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'id' => 102,
                'nombre' => 'Queso Curado Gofio',
                'precio' => 12.00,
                'descripcion' => 'Curado durante 6 meses y recubierto con gofio de millo local.',
                'imagen' => 'https://images.unsplash.com/photo-1452195100486-9cc805987862?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'id' => 103,
                'nombre' => 'Mojo Rojo Picón',
                'precio' => 4.50,
                'descripcion' => 'Receta familiar con pimienta palmera seleccionada.',
                'imagen' => 'https://images.unsplash.com/photo-1516100882582-76c9a444dd5a?auto=format&fit=crop&w=600&q=80'
            ],
        ];
    }

    #[Layout('layouts.guest-full')]
    public function render()
    {
        return view('livewire.guest.puesto.show-puesto');
    }
}