<?php

namespace App\Livewire\Seller;

use Livewire\Component;

class OrderManagement extends Component
{
    // Variables enlazadas a los filtros del HTML
    public $filtroAno = '';
    public $filtroMes = '';
    public $filtroPuesto = '';
    public $filtroEstado = '';
    public $busqueda = '';

    // Variables para el modal
    public $modalAbierto = false;
    public $pedidoSeleccionado = null;

    public function abrirModal($idPedido)
    {
        // Aquí luego buscarás el pedido en la BD: Order::find($idPedido)
        $this->pedidoSeleccionado = $idPedido; 
        $this->modalAbierto = true;
    }

public function render()
    {
        /* * 1. CUANDO EL BACKEND ESTÉ LISTO, USARÁS ALGO COMO ESTO:
         * $pedidos = auth()->user()->orders()->where('estado', $this->filtroEstado)->get();
         */

        // 2. MIENTRAS TANTO, USAMOS DATOS FALSOS (MOCK) PARA PODER DISEÑAR
        // Cambia esto a un array vacío [] para ver cómo queda la pantalla cuando no hay datos
        $pedidos = [
            (object)['id' => 1456, 'fecha' => '2026-01-25', 'hora' => '09:30', 'total' => 36.95, 'estado' => 'pendiente', 'cantidad_productos' => 5],
            (object)['id' => 1457, 'fecha' => '2026-01-26', 'hora' => '10:15', 'total' => 12.50, 'estado' => 'completado', 'cantidad_productos' => 2],
        ];

        // 3. Calculamos el resumen contando los estados
        $totalPendientes = collect($pedidos)->where('estado', 'pendiente')->count();
        $totalCompletados = collect($pedidos)->where('estado', 'completado')->count();

        // 4. Se lo enviamos a la vista HTML
        return view('livewire.seller.order-management', [
            'pedidos' => $pedidos,
            'totalPendientes' => $totalPendientes,
            'totalCompletados' => $totalCompletados,
        ]);
    }
}
