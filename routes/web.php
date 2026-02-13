<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\GenericController;
use Illuminate\Support\Facades\Route;

//GenericController
Route::controller(GenericController::class)  
    ->group(function () {
    // Index Vista Mercadillos
    Route::get('/', 'index');

    Route::prefix("general")
        ->name("general.")
        ->group(function (){
        // Añadir middleware Auth && Role
        Route::get("/orders", "orders")->name("orders");
        Route::get("/profile", "profile")->name("profile");
        Route::get("/products", "showProducts")->name("products");
        Route::get('fleamarket/{id}/stalls', 'showStalls')->name("stalls");
        Route::get("/stall/{id}", "showStallProducts")->name("stall");
    });   
});

// Añadir middleware Auth && Role
Route::controller(CustomerController::class)
    ->prefix("customer")
    ->name("customer.")
    ->group(function () {
        Route::get("/profile", "profile")->name("profile");
        Route::get("/orders", "orders")->name("orders");
        Route::get('/cart', 'showCart')->name("cart");
        Route::get('/stalls', 'showStalls')->name("stalls");
    });

// Añadir middleware Auth && Role
Route::controller(SellerController::class)
    ->prefix("seller")
    ->name("seller.")
    ->group(function () {
        Route::get("/orders", "orders")->name("orders");
        Route::get('/create/product', 'createProduct')->name("create-product");
        Route::get('/edit/products', 'editProducts')->name("edit-products");
        // Cambiar nombre
        Route::get('/index', 'indexStalls')->name("index-stalls");
        Route::get("stall/{id}/products", "showSellerProducts")->name("products");
});

// Añadir middleware Auth && Role
Route::controller(AdminController::class)
    ->prefix("admin")
    ->name("admin.")
    ->group(function (): void {
        Route::get('/controlpanel/markets', 'indexMarkets')->name("markets");
        Route::get('/controlpanel/market/{id}', 'show')->name("control-panel");
        Route::post('/controlpanel/market/{mercadilloId}/stalls', 'createStall')->name('stalls.store');
        Route::patch('/controlpanel/stalls/{stall}', 'updateStall')->name('stalls.update');
        Route::patch('/controlpanel/stalls/{stall}/activate', 'activateStall')->name('stalls.activate');
        Route::patch('/controlpanel/stalls/{stall}/deactivate', 'deactivateStall')->name('stalls.deactivate');
        Route::delete('/controlpanel/stalls/{stall}', 'deleteStall')->name('stalls.destroy');
        Route::post('/controlpanel/market/{mercadilloId}/schedules', 'createSchedule')->name('schedules.store');
        Route::patch('/controlpanel/schedules/{schedule}', 'updateSchedule')->name('schedules.update');
        Route::delete('/controlpanel/schedules/{schedule}', 'deleteSchedule')->name('schedules.destroy');
        Route::post('/controlpanel/market/{mercadilloId}/holidays', 'createHoliday')->name('holidays.store');
        Route::patch('/controlpanel/holidays/{holiday}', 'updateHoliday')->name('holidays.update');
        Route::delete('/controlpanel/holidays/{holiday}', 'deleteHoliday')->name('holidays.destroy');
        Route::get('/controlpanel/market/{id}', 'controlPanel')->name("control-panel");
});

Route::prefix('deploy')->group(function () {
    // Función auxiliar para verificar la clave
    if (!function_exists('checkDeployKey')) {
        function checkDeployKey($key) {
            $serverKey = env('DEPLOY_KEY');
    
            if (empty($serverKey) || $key !== $serverKey) {
                abort(403, 'Acceso denegado o clave no configurada.');
            }
        }
    }

    Route::get('/migrate/{key}', function ($key) {
        checkDeployKey($key);
        Artisan::call('migrate', ['--force' => true]);
        return 'Migración completada: <br>' . nl2br(Artisan::output());
    });

    Route::get('/optimize/{key}', function ($key) {
        checkDeployKey($key);
        Artisan::call('optimize:clear');
        return 'Caché borrada: <br>' . nl2br(Artisan::output());
    });
    
    Route::get('/link/{key}', function ($key) {
        checkDeployKey($key);
        Artisan::call('storage:link');
        return 'Storage linkeado: <br>' . nl2br(Artisan::output());
    });
});

require __DIR__ . '/auth.php';
