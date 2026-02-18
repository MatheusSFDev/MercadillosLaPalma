<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     *  Recupera los IDs de los productos del carrito y manda los datos
     *  para mostrarlos en la vista 
     */
    public function showCartProducts(Request $request)
    {   
        $ids = $request->ids ?? [];
        return Product::whereIn('id', $ids)->get();
    }

    /**
     *  Recupera los pedidos del usuario junto con los productos relacionados
     */
    public function showOrders()
    {
        $pedidos = Auth::user()->orders()->with('products')->get();
        return view("customers.orders", compact('pedidos'));
    }

    /**
     *  Recupera datps de perfil del usuario, excluyendo campos sensibles
     */
    public function showProfile()
    {
        $userData = Auth::user()->except(['password', 'remember_token', 'created_at', 'updated_at', 'email_verified_at']);
        return view("customers.profile", compact('userData'));
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
