<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\Units;
use App\Http\Requests\StoreProductRequest;
use App\Models\Order;
use App\Models\Photo;
use App\Models\Product;
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

    public function sellerStalls(){
        if(Auth::user()->hasRole('seller')){
            $stalls = Auth::user()->stalls();
            $data = [];
            foreach($stalls as $stall){
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

            return view('seller.stalls', [$data]);
        }else{
            return view('/');
        }
    }

    public function sellerProducts(){
        if(Auth::user()->hasRole('seller')){
            $products = Auth::user()->products();
            $data = [
                "total_products" => Auth::user()->products()->count(),
                "assigneds" => 0,
                "unassigneds" => 0,
                "active_stalls" => Auth::user()->stalls()->where('active', true)->count(),
                "products" => []
            ];

            foreach($products as $product){
                $status = $product->stalls()->where('product_id', $product->id)->exists();

                array_push($data['products'], [
                    "name" => $product->name,
                    "status" => $status == false ? 'Sin asignar' : 'Asignado',
                    "stalls" => $status == false ? 'Sin asignar' : $product->stalls()->where('product_id', $product->id)->pluck('name')->first(),
                    "stock" => $status == false ? null : $product->stalls()->where('product_id', $product->id)->sum('product_stall.quantity'),
                    "price" => $status == false ? null : $product->stalls()->where('product_id', $product->id)->sum('product_stall.price_per_unit')
                ]);
            }

            return view('general.products', [$data]);
        }
    }

    public function storeProduct(StoreProductRequest $request){
        if(Auth::user()->hasRole('seller')){
            $data = $request->validated();

            $product = Product::create([
                "name" => $data->name,
                "unit" => $data->unit,
                "user_id" => $data->user_id,
                "category_id" => $data->category_id
            ]);

            $photo = Photo::create([
                "url" => $data->img,
                "product_id" => $product->id
            ]);

            $assigned = false;
            if($request->filled('stall_id')){
                $product->stalls()->attach($data->stall_id, [
                    "quantity" => $data->quantity,
                    "price_per_unit" => $data->price
                ]);
                $assigned = true;
            }

            return response()->json([
                "message" => 'Producto insertado con éxito',
                "data" => [
                    "product" => $product,
                    "img" => $photo,
                    "stalls" => $assigned == false ? null : $product->stall()->where('product_id', $product->id)
                ]
            ]);
        }
    }
}
