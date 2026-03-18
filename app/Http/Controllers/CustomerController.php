<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CustomerService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     *  Recupera los datos de los productos del carrito desde localStorage,
     *  incluyendo el precio específico del puesto
     */
    public function showCartProducts(Request $request, CustomerService $customerService)
    {   
        $cartItems = $request->input('cart', []);
        return $customerService->getCartProducts($cartItems);
    }

    public function showCart(){
        return view("customers.cart");
    }

    public function storeCart(Request $request, CustomerService $customerService)
    {
        $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.product_id' => 'required|integer|exists:products,id',
            'cart.*.stall_id' => 'required|integer|exists:stalls,id',
            'cart.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            $result = $customerService->createOrder($request->input('cart'));
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error inesperado al procesar el pedido: ' . $e->getMessage(),
            ], 500);
        }

        if (!$result['success']) {
            return response()->json($result, 422);
        }

        return response()->json($result, 201);
    }

    /**
     *  Recupera los pedidos del usuario junto con los productos relacionados
     */
    public function showOrders(CustomerService $customerService)
    {
        try{        
            $orders = $customerService->getOrdersCustomer();
        }catch(Exception $e){
            abort(404, $e->getMessage());
        }

        // Falta testear que las cantidades y el precio total del pedido sean correctos
        return view("general.orders", ["orders" => $orders]);
    }

    /**
     *  Recupera datps de perfil del usuario, excluyendo campos sensibles
     */
    public function showProfile()
    {
        $userData = Auth::user()->except(['password', 'remember_token', 'created_at', 'updated_at', 'email_verified_at']);
        return view("customers.profile", compact('userData'));
    }

    public function showSellerRequest(){
        $userData = Auth::user()->except(['password', 'remember_token', 'created_at', 'updated_at', 'email_verified_at']);
        return view("customers.seller-request", compact('userData'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
