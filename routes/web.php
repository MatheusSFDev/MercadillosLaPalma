<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get("/general", [UserController::class, 'index']);

Route::controller(UserController::class)
    ->prefix("general")
    ->name("general.")
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/login', 'login')->name("login");
        Route::get('/register', 'create')->name("register");

        // Añadir middleware Auth && Role
        Route::get("/orders", "orders")->name("orders");
        Route::get("/profile", "profile")->name("profile");
        Route::get("/products", "showProducts")->name("products"); 
});

// Añadir middleware Auth && Role
Route::controller(CustomerController::class)
    ->prefix("customer")
    ->name("customer.")
    ->group(function () {
        Route::get('/cart', 'showCart')->name("cart");
        Route::get('/stalls', 'showStalls')->name("stalls");
});

// Añadir middleware Auth && Role
Route::controller(SellerController::class)
    ->prefix("seller")
    ->name("seller.")
    ->group(function () {
        Route::get('/create/product', 'createProduct')->name("create-product");
        Route::get('/edit/products', 'editProducts')->name("edit-products");
        Route::get('/index', 'indexStalls')->name("index-stalls");
});

// Añadir middleware Auth && Role
Route::controller(AdminController::class)
    ->prefix("admin")
    ->name("admin.")
    ->group(function () {
        Route::get('/controlpanel', 'controlPanel')->name("control-panel");
        Route::get('/markets', 'indexMarkets')->name("markets");
});

require __DIR__.'/auth.php';
