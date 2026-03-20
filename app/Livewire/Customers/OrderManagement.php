<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use App\Models\Order;
use App\Models\Stall;

class OrderManagement extends Component
{
    public $busqueda = '';
    public $modalAbierto = false;
    public $pedidoSeleccionado = null;
    public $filtroAno = '';
    public $filtroMes = '';
    public $filtroEstado = '';

    public function abrirModal($idPedido)
    {
        $this->pedidoSeleccionado = Order::with('products') // solo productos
            ->where('user_id', auth()->id())
            ->find($idPedido);

        // Cargamos los stalls y mercadillos de los productos del pedido
        foreach ($this->pedidoSeleccionado->products as $p) {
            $p->stall = Stall::with('fleaMarket')
                ->whereHas('products', fn($q) => $q->where('id', $p->id))
                ->first();
        }

        $this->modalAbierto = true;
    }

    public function render()
    {
        $pedidosQuery = Order::with('products') // solo productos
            ->where('user_id', auth()->id());

        if ($this->busqueda) {
            $pedidosQuery->whereHas('products', function($q){
                $q->where('name', 'like', '%' . $this->busqueda . '%');
            });
        }

        if ($this->filtroAno) {
            $pedidosQuery->whereYear('order_date', $this->filtroAno);
        }

        if ($this->filtroMes) {
            $pedidosQuery->whereMonth('order_date', $this->filtroMes);
        }

        if ($this->filtroEstado) {
            $estado = $this->filtroEstado === 'pendiente' ? 0 : 1;
            $pedidosQuery->where('completed', $estado);
        }

        $pedidos = $pedidosQuery->orderBy('order_date', 'desc')->paginate(10);

        return view('livewire.customers.order-management', [
            'pedidos' => $pedidos,
        ]);
    }
}