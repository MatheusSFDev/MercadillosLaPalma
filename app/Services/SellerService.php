<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Enums\Status;

class SellerService 
{
    public function getSellerOrders(){
        $stalls = Auth::user()->stalls(); 
        
        $data = [];

        foreach($stalls as $stall){
            foreach($stall->orders() as $order){
                $stall_name = $order->stall()->name;
                $products = $order->products()->count('order_product.product_id')->orderBy('order_product.order_id');
                $total = $order->products()->multiply('order_product.price_per_unit', 'total', 'order_product.quantity');
                $status = $order->completed == false ? Status::Pendiente : Status::Compleado;
                array_push($data, [
                    "stall_name" => $stall_name,
                    "order_date" => $order->order_date,
                    "products" => $products,
                    "total" => $total,
                    "status" => $status
                ]);
            }
        }

        return $data;
    }

    // Falta test
    public function getSellerStalls(){
        $stalls = Auth::user()->stalls();
        $data = [];
        foreach($stalls as $stall){
            if($stall->orders()){
                
            } 
            $total = $stall->orders()
                        ->join('order_product', 'orders.id', '=', 'order_product.order_id')
                        ->whereBetween('orders.order_date', [
                            now()->startOfWeek(),
                            now()->endOfWeek()
                        ])
                        ->selectRaw('SUM(order_product.price_per_unit * order_product.quantity)')
                        ->value('SUM(order_product.price_per_unit * order_product.quantity)');

            array_push($data, [
                "name" => $stall->name,
                "municipio" => $stall->fleaMarket()->municipality()->name,
                "category" => $stall->categries,
                "status" => $stall->active,
                "products" => $stall->products()->count(),
                "orders" => $stall->orders()->count(),
                "total" => $total,
            ]);
        }

        return $data;
    }
}