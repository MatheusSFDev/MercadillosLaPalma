<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\User;
use App\Enums\Units;
use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Stall;
use App\Services\SellerService;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function sellerOrders(SellerService $sellerService){
        try{
            $data = $sellerService->getSellerOrders();
            return view('general.orders', [$data]);
        }catch(Exception $e){
            abort(404, "Pagina no encontrada");
        }
    }

    // Función con nombre mal escrito que no es llamada por ningúna ruta del archivo web, quien llama a esta función?
    // El responsable que le cambia el nombre al menos...
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

    // Falta tests - Solo he refactorizado y modularizado, falta comprobar logica de sql query
    public function sellerStalls(){
        try{
            $stalls = Auth::user()->stalls;
            $data = [];
            foreach($stalls as $stall){
                $products = $stall->products()->count();
                $orders = $stall->orders;
                
                $incomes = 0;
                $ordersCount = 0;

                foreach($orders as $order){
                    foreach($order->products as $product){
                        $q = $product->pivot->quantity;
                        $ppu = $product->pivot->price_per_unit;

                        $incomes += $q * $ppu;
                    }

                    $ordersCount++;
                }

                $categories = [];

                foreach($stall->categories as $category){
                    array_push($categories, $category->name);
                }

                array_push($data, [
                    "products" => $products,
                    "orders" => $ordersCount,
                    "income" => $incomes,
                    "categories" => $categories,
                    "stallData" => $stall
                ]);
            }
            return view('sellers.stalls', compact('data'));
        }catch(Exception $e){
            echo "ERROR: Ha ocurrido el error " . $e->getMessage();
            /*abort(404, "Pagina no encontrada");*/
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

    public function addProduct(){
        return view('sellers.addProducts');
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

    public function editProducts(){
        return view('sellers.showProducts');
    }
}
