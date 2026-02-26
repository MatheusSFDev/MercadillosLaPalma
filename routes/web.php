<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\GenericController;
use App\Livewire\Guest\Puesto\ShowPuesto;
use App\Http\Controllers\RootController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Guest\Mercadillo\ShowMercadillo;
use Database\Seeders\AdministratorSeeder;
use Database\Seeders\CategoriesSeeder;
use Database\Seeders\FleaMarketSeeder;
use Database\Seeders\MunicipalitiesSeeder;
use Database\Seeders\OrderProductSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Database\Seeders\PaymentMethodStallSeeder;
use Database\Seeders\PhotosSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ProductStallSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StallsCategorySeeder;
use Database\Seeders\StallsSeeders;
use Database\Seeders\UserSeeder;
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
            Route::get("/stall/{id}", ShowPuesto::class)->name("stall");
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
    ->middleware(['auth', 'verified', 'role:customer|root']) //Añadido un Auth y Role, aunque primitivo
    ->group(function () {

        Route::get("/profile", "profile")->name("profile");
        Route::get("/orders", "showOrders")->name("orders");
        Route::get('/cart', 'showCart')->name("cart");
        Route::get('/cart/store', 'storeCart')->name("store");
        Route::get('/stalls', 'showStalls')->name("stalls");
    });

Route::controller(SellerController::class)
    ->prefix("seller")
    ->name("seller.")
    ->middleware(['auth', 'verified', 'role:seller|root']) //Añadido un Auth y Role, aunque primitivo
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
    ->middleware(['auth', 'verified', 'role:admin|root']) //Añadido un Auth y Role, aunque primitivo
    ->group(function (): void {

        Route::get('/controlpanel/markets', 'indexMarket')->name("markets");
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

    Route::get('/fresh/{key}', function ($key) {
        checkDeployKey($key);
        Artisan::call('migrate:fresh', ['--force' => true]);
        return 'Base de datos refrescada (Tablas eliminadas y recreadas): <br>' . nl2br(Artisan::output());
    });

    Route::get('/seed/{key}', function ($key) {
        checkDeployKey($key);

        $seeders = [
            RoleSeeder::class,
            CategoriesSeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
            MunicipalitiesSeeder::class,
            FleaMarketSeeder::class,
            AdministratorSeeder::class,
            StallsSeeders::class,
            PaymentMethodSeeder::class,
            PaymentMethodStallSeeder::class,
            StallsCategorySeeder::class,
            PhotosSeeder::class,
            OrderSeeder::class,
            OrderProductSeeder::class,
            ProductStallSeeder::class
        ];

        foreach ($seeders as $seed) {
            Artisan::call('db:seed', [
                '--class' => $seed,
                '--force' => true
            ]);
        }
        
        return "Seeders Completados: <br>" . nl2br(Artisan::output());
    });

    Route::get('/unzip/{key}', function ($key) {
        checkDeployKey($key);

        $zipPath = base_path('deploy.zip');

        if (!file_exists($zipPath)) {
            abort(404, "Error: No se encontró el archivo ZIP en la ruta: {$zipPath}");
        }

        $zip = new ZipArchive;
        $res = $zip->open($zipPath);

        if ($res === TRUE) {
            $zip->extractTo(base_path());
            $zip->close();

            if (unlink($zipPath)) {
                $mensajeBorrado = "<br>🧹 El archivo ZIP original ha sido eliminado por seguridad.";
            } else {
                $mensajeBorrado = "<br>⚠️ El ZIP se extrajo, pero no se pudo borrar automáticamente.";
            }

            return '✅ ¡Despliegue completado! Los archivos se han extraído correctamente.' . $mensajeBorrado;
        } else {
            return "❌ Error crítico: No se pudo abrir el archivo ZIP. Código de error: {$res}";
        }
    });
});

Route::middleware(['auth', 'role:root'])
    ->prefix('root')
    ->name('root.')
    ->group(function () {
        Route::get('/', [RootController::class, 'index'])->name('index');
    });

require __DIR__ . '/auth.php';


// RUTAS DE TESTEO

//RUTA TESTEO DE AÑADIR PRODUCTOS

Route::get('/addProducts', function () {
    return view('sellers.addProducts');
});
