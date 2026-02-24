<?php

namespace App\Services;

use App\Model\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerService 
{

    // Hacer que devuelva los datos en orden más reciente a menos
    public function getOrdersCustomer()
    {
        $orders = Auth::user()->orders()->with('products')->orderBy('order_date', 'desc')->get();
        
        foreach($orders as $order){
            foreach($orders as $order){
                $order->numberProducts = $order->products->count();
                $order->stallName = $order->stall->name;
                $order->totalPriceProducts = 0;

                foreach($order->products as $product){ 
                    $order->totalPriceProducts += $product->pivot->quantity * $product->pivot->price_per_unit;
                }
            }
        }

        return $orders;
    } 
}