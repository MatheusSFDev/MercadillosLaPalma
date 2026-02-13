<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Guest\Mercadillo\ShowMercadillo;



Route::view("profile", "profile")
    ->middleware(["auth"])
    ->name("profile");

Route::view("register", "register")
    ->middleware(["auth"])
    ->name("profile");

Route::controller(UserController::class)
    ->prefix("general")
    ->name("general.")
    ->group(function () {
        // Modificar prefix y name y colocar debajo de ruta index
        Route::get('/', 'index');
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

Route::prefix('deploy')->group(function () {
    // Función auxiliar para verificar la clave
        function checkDeployKey($key) {
            $serverKey = env('DEPLOY_KEY');

            if (empty($serverKey) || $key !== $serverKey) {
                abort(403, 'Acceso denegado o clave no configurada.');
            }
        }

        Route::get('/migrate/{key}', function ($key) {
            checkDeployKey($key);
            Artisan::call('migrate', ['--force' => true]);
            return 'Migración completada: <br>' . nl2br(Artisan::output());
        }
        );

        Route::get('/optimize/{key}', function ($key) {
            checkDeployKey($key);
            Artisan::call('optimize:clear');
            return 'Caché borrada: <br>' . nl2br(Artisan::output());
        }
        );

        Route::get('/link/{key}', function ($key) {
            checkDeployKey($key);
            Artisan::call('storage:link');
            return 'Storage linkeado: <br>' . nl2br(Artisan::output());
        }
        );

    });

Route::get('/showmercadillo', ShowMercadillo::class)->name('showmercadillo');

require __DIR__ . '/auth.php';