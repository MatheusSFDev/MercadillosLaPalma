<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\GenericController;
use App\Http\Controllers\RootController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Guest\Mercadillo\ShowMercadillo;
use Illuminate\Support\Facades\Artisan;

//RedirectLivewire
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');

//GenericController
Route::controller(GenericController::class)  
    ->group(function () {
    // Index Vista Mercadillos
    Route::get('/', 'index');

    Route::prefix("general")
        ->name("general.")
        ->middleware(['auth', 'verified']) //Añadido un Auth, aunque primitivo
        ->group(function (){

            Route::get("/orders", "orders")->name("orders");
            Route::get("/profile", "profile")->name("profile");
            Route::put("/profile", "update")->name("profile.update"); 
            Route::get("/products", "showProducts")->name("products");

            Route::get('fleamarket/{id}/stalls', 'showStalls')->name("stalls");
            Route::get("/stall/{id}", "showStallProducts")->name("stall");
    });   
});

Route::put("/profile", [GenericController::class, 'update'])->name("profile.update");

Route::prefix('root')
    ->middleware(['auth', 'role:root'])
    ->name('root.')
    ->group(function () {

        Route::get('/', [RootController::class, 'index'])
            ->name('dashboard');

        Route::get('/users', [RootController::class, 'users'])
            ->name('users');

        Route::get('/users/{user}/roles', [RootController::class, 'editRoles'])
            ->name('users.roles.edit');

        Route::post('/users/{user}/roles', [RootController::class, 'updateRoles'])
            ->name('users.roles.update');

        Route::delete('/users/{user}', [RootController::class, 'destroyUser'])
            ->name('users.destroy');
    });

Route::controller(CustomerController::class)
    ->prefix("customer")
    ->name("customer.")
    ->middleware(['auth', 'verified', 'role:customer']) //Añadido un Auth y Role, aunque primitivo
    ->group(function () {

        Route::get("/profile", "profile")->name("profile");
        Route::get("/orders", "orders")->name("orders");
        Route::get('/cart', 'showCart')->name("cart");
        Route::get('/cart/store', 'storeCart')->name("store");
        Route::get('/stalls', 'showStalls')->name("stalls");
    });

Route::controller(SellerController::class)
    ->prefix("seller")
    ->name("seller.")
    ->middleware(['auth', 'verified', 'role:seller']) //Añadido un Auth y Role, aunque primitivo
    ->group(function () {

        Route::get("/orders", "orders")->name("orders");
        Route::get('/create/product', 'createProduct')->name("create-product");
        Route::get('/edit/products', 'editProducts')->name("edit-products");
        // Cambiar nombre
        Route::get('/index', 'indexStalls')->name("index-stalls");
        Route::get("stall/{id}/products", "showSellerProducts")->name("products");
});

Route::controller(AdminController::class)
    ->prefix("admin")
    ->name("admin.")
    ->middleware(['auth', 'verified', 'role:admin']) //Añadido un Auth y Role, aunque primitivo
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
        Route::post('/controlpanel/market/{mercadillo}/assign-stall/{user}', 'assignStallToUser')->name('users.assign-stall');
        Route::patch('/controlpanel/stall/{stall}/register', 'registerStall')->name('stall.register');


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
    }
});

Route::get('/showmercadillo', ShowMercadillo::class)->name('showmercadillo');

require __DIR__ . '/auth.php';
