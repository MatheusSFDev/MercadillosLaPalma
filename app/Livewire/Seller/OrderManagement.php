<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use App\Models\Stall;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderManagement extends Component
{
    use WithPagination;

    public $filtroAno = '';
    public $filtroMes = '';
    public $filtroPuesto = '';
    public $filtroEstado = '';
    public $busqueda = '';

    public $modalAbierto = false;
    public $pedidoSeleccionado = null;

    public $dropdownAbierto = []; // Control de menús desplegables por producto

    protected $paginationTheme = 'tailwind';

    // Abrir modal y resetear dropdowns
    public function abrirModal($idPedido)
    {
        $this->pedidoSeleccionado = Order::with(['products', 'user', 'stall'])
            ->find($idPedido);

        $this->modalAbierto = true;
        $this->dropdownAbierto = [];
    }

    // Cambiar estado de producto (Aceptado/Rechazado)
    public function cambiarEstadoProducto($productId, $nuevoEstado)
    {
        $orderId = $this->pedidoSeleccionado->id;

        // Actualizar el pivot order_product
        DB::table('order_product')
            ->where('order_id', $orderId)
            ->where('product_id', $productId)
            ->update(['status' => $nuevoEstado]);

        // Recargar pedido con productos actualizados
        $this->pedidoSeleccionado = Order::with(['products', 'user', 'stall'])
            ->find($orderId);

        // Cerrar dropdown del producto actualizado
        $this->dropdownAbierto[$productId] = false;

        // Verificar si todos los productos están aceptados o rechazados
        $todosDefinidos = $this->pedidoSeleccionado->products->every(function ($p) {
            return in_array($p->pivot->status, ['Aceptado', 'Rechazado']);
        });

        if ($todosDefinidos && !$this->pedidoSeleccionado->completed) {
            $this->pedidoSeleccionado->completed = 1;
            $this->pedidoSeleccionado->save();
        }
    }

    public function render()
    {
        $user = Auth::user();

        $pedidosQuery = Order::with(['products', 'user', 'stall']);

        // Filtrar por rol
        if ($user->role === 'vendedor') {
            $pedidosQuery->where('stall_id', $user->stalls()->pluck('id'));
        } elseif ($user->role === 'comprador') {
            $pedidosQuery->where('user_id', $user->id);
        } else {
            $pedidosQuery->limit(0);
        }

        // Filtros
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
        if ($this->filtroPuesto) {
            $pedidosQuery->where('stall_id', $this->filtroPuesto);
        }
        if ($this->busqueda) {
            $pedidosQuery->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->busqueda . '%')
                  ->orWhere('surname', 'like', '%' . $this->busqueda . '%');
            });
        }

        $pedidos = $pedidosQuery->orderBy('order_date', 'desc')->paginate(10);

        $totalPendientes = (clone $pedidosQuery)->where('completed', 0)->count();
        $totalCompletados = (clone $pedidosQuery)->where('completed', 1)->count();

        $puestos = Stall::all();

        return view('livewire.seller.order-management', [
            'pedidos' => $pedidos,
            'totalPendientes' => $totalPendientes,
            'totalCompletados' => $totalCompletados,
            'puestos' => $puestos,
        ]);
    }
}