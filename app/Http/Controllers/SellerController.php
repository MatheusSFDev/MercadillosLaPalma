<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * Return the view 'sellers.stallSellers'
     * @return \Illuminate\Contracts\View\View
     */
    public function indexStalls()
    {
        return view("sellers.stallSellers");
    }

    /**
     * Return the view 'sellers.addProducts'
     * @return \Illuminate\Contracts\View\View
     */
    public function createProduct()
    {
        return view("sellers.addProducts");
    }
    
    public function storeProduct(Request $request){
        $product_validated = $request->validate([
            "name" => "required|string",
            "unit" => "required|in:Kg,gr,L,mL,unidad/es",
            "category_id"=> "required|integer",
            "user_id" => "required|integer",
        ]);

        $stock_validation = $request->validate([
            "product_id"=> "required|integer",
            "stall_id" => "required|integer",
            "quantity" => "required|integer",
            "price_per_unit" => "required|numeric|decimal:0,2",
        ]);

        

        $product = Product::create();

        return response()->json($product);
    }

    public function editProducts()
    {
        return view("sellers.editProducts");
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
