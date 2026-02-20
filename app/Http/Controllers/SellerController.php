<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\Units;
use App\Models\Order;
use App\Models\Stall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function sellerOrders(){
        if(Auth::user()->hasRole('seller')){
            $orders = Auth::user()->stalls()->orders();
            $data = [];
            foreach($orders as $order){
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
            return view('general.orders', [$data]);
        }else{
            return view('/');
        }
    }

    public function orederDetail($order_id){
        if(Auth::user()->hasRole('seller')){
            $orderData = Order::findOrFail($order_id);
            $order_products = $orderData->products()->map(function ($product_order){
                return [
                    "name" => $product_order->name,
                    "price_data" => [
                        "price_per_unit" => $product_order->pivot->price_per_unit,
                        "unit" => $product_order->unit
                    ],
                    "buy_data" => [
                        "product_cant" => $product_order->pivot->quantity,
                        "total" => $product_order->multiply('order_product.price_per_unit', 'total', 'order_product.quantity')
                    ],
                    "status" => $product_order->status
                ];
            });
        
            $data = [
                "id_pedido" => $orderData->order_id,
                "order_date" => $orderData->order_date,
                "delivery_date" => $orderData->delivery_date,
                "customer_data" => [
                    "name" => $orderData->user()->name,
                    "email" => $orderData->user()->name,
                    "phone" => $orderData->user()?->phone_number ?? 'Sin teléfono asociado'
                ],
                "product_data" => $order_products
            ];

            return view('general.orders', [$data]);
        }else{
            return view('/');
        }
    }
}
