<?php

use App\Models\Category;
use App\Models\User;
use App\Models\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Municipality;
use App\Models\Product;
use App\Models\FleaMarket;
use App\Models\Holiday;
use App\Models\Stall;
use App\Models\Order;
use App\Models\Schedule;
use App\Models\PaymentMethod;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

uses(RefreshDatabase::class);

/* Test que crea un usuario y verifica que se haya introducido en la base de datos */
test('CRUD completo de un usuario', function () {
    // Crear usuario
    $user = User::create([
        'name' => 'John',
        'surname' => 'Doe',
        'email' => 'john@example.com',
        'password' => bcrypt('password'),
    ]);

    // Verificar creación
    assertDatabaseHas('users', [
        'email' => 'john@example.com',
        'name' => 'John',
    ]);

    // Actualizar usuario
    $user->update([
        'name' => 'Juan',
        'surname' => 'Pérez',
    ]);

    // Verificar actualización
    assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Juan',
        'surname' => 'Pérez',
    ]);

    // Verificar que el nombre anterior ya no existe
    assertDatabaseMissing('users', [
        'id' => $user->id,
        'name' => 'John',
    ]);

    // Eliminar usuario
    $user->delete();

    // Verificar eliminación
    assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);
});

// Test CRUD Municipio
test("CRUD Municipios", function () {
    $municipality = Municipality::create([
        'name' => 'Santa Cruz de La Palma',
    ]);

    // Verificar creación
    assertDatabaseHas('municipalities', [
        'name' => 'Santa Cruz de La Palma',
    ]);

    // Actualizar municipio
    $municipality->update([
        'name' => 'Los Llanos de Aridane',
    ]);

    // Verificar actualización
    assertDatabaseHas('municipalities', [
        'id' => $municipality->id,
        'name' => 'Los Llanos de Aridane',
    ]);

    // Verificar que el nombre anterior ya no existe
    assertDatabaseMissing('municipalities', [
        'id' => $municipality->id,
        'name' => 'Santa Cruz de La Palma',
    ]);

    // Eliminar municipio
    $municipality->delete();

    // Verificar eliminación
    assertDatabaseMissing('municipalities', [
        'id' => $municipality->id,
    ]);
});

// Test CRUD Categorías
test("CRUD Categorías (Con modelo)", function () {
    $category = Category::create([
        'name' => 'Frutas',
    ]);

    // Verificar creación
    assertDatabaseHas('categories', [
        'name' => 'Frutas',
    ]);

    // Actualizar categoría
    $category->update([
        'name' => 'Verduras',
    ]);

    // Verificar actualización
    assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Verduras',
    ]);

    // Verificar que el nombre anterior ya no existe
    assertDatabaseMissing('categories', [
        'id' => $category->id,
        'name' => 'Frutas',
    ]);

    // Eliminar categoría
    $category->delete();

    // Verificar eliminación
    assertDatabaseMissing('categories', [
        'id' => $category->id,
        'name' => 'Verduras',
    ]);
});

// Test CRUD Productos y Fotos
test("CRUD Productos y Fotos (Con modelo)", function () {
    // Crear dependencias
    $user = User::create([
        'name' => 'John',
        'surname' => 'Doe',
        'email' => 'john.2@example.com',
        'password' => bcrypt('password'),
    ]);

    $category = Category::create([
        'name' => 'Frutas',
    ]);

    $product = Product::create([
        'name' => 'Producto 1',
        'unit' => 'Kg',
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $photo = Photo::create([
        'product_id' => $product->id,
        'url' => 'http://example.com/photo.jpg',
        'description' => 'Foto del producto',
    ]);

    // Verificar creación
    assertDatabaseHas('products', [
        'name' => 'Producto 1',
        'unit' => 'Kg',
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    assertDatabaseHas('photos', [
        'product_id' => $product->id,
        'url' => 'http://example.com/photo.jpg',
        'description' => 'Foto del producto',
    ]);

    // Actualizar producto
    $product->update([
        'name' => 'Producto 1 actualizado',
    ]);

    $photo->update([
        'description' => 'Foto actualizada',
    ]);

    // Verificar actualización
    assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Producto 1 actualizado',
    ]);

    assertDatabaseHas('photos', [
        'id' => $photo->id,
        'description' => 'Foto actualizada',
    ]);

    // Verificar que el nombre anterior ya no existe
    assertDatabaseMissing('products', [
        'id' => $product->id,
        'name' => 'Producto 1',
    ]);

    assertDatabaseMissing('photos', [
        'id' => $photo->id,
        'description' => 'Foto del producto',
    ]);

    // Eliminar producto
    $product->delete();
    $photo->delete();

    // Verificar eliminación
    assertDatabaseMissing('products', [
        'id' => $product->id,
        'name' => 'Producto 1 actualizado',
    ]);

    assertDatabaseMissing('photos', [
        'id' => $photo->id,
        'description' => 'Foto actualizada',
    ]);

    // Limpiar tablas relacionadas
    $category->delete();
    $user->delete();
});

// Test CRUD Mercadillos
test('CRUD Mercadillos', function () {
    $municipality = Municipality::create([
        'name' => 'Santa Cruz de La Palma',
    ]);

    $fleaMarket = FleaMarket::create([
        'address' => 'Calle Falsa 123',
        'municipality_id' => $municipality->id,
        'img_url' => 'http://example.com/mercadillo.jpg',
    ]);

    // Verificar creación
    assertDatabaseHas('flea_markets', [
        'address' => 'Calle Falsa 123',
        'municipality_id' => $municipality->id,
        'img_url' => 'http://example.com/mercadillo.jpg',
    ]);

    // Actualizar mercadillo
    $fleaMarket->update([
        'address' => 'Calle Verdadera 456',
    ]);

    // Verificar actualización
    assertDatabaseHas('flea_markets', [
        'id' => $fleaMarket->id,
        'address' => 'Calle Verdadera 456',
    ]);

    // Verificar que la dirección anterior ya no existe
    assertDatabaseMissing('flea_markets', [
        'id' => $fleaMarket->id,
        'address' => 'Calle Falsa 123',
    ]);

    // Eliminar mercadillo
    $fleaMarket->delete();

    // Verificar eliminación
    assertDatabaseMissing('flea_markets', [
        'id' => $fleaMarket->id,
    ]);

    // Limpiar tabla relacionada
    $municipality->delete();
});

// Test CRUD Días festivos/Vacaciones
test('CRUD Días festivos/Vacaciones', function () {
    $municipality = Municipality::create([
        'name' => 'Santa Cruz de La Palma',
    ]);

    $fleaMarket = FleaMarket::create([
        'address' => 'Calle Falsa 123',
        'municipality_id' => $municipality->id,
        'img_url' => 'http://example.com/mercadillo.jpg',
    ]);

    $holiday = Holiday::create([
        'flea_market_id' => $fleaMarket->id,
        'start_date' => '2024-12-24',
        'end_date' => '2024-12-26',
    ]);

    // Verificar creación
    assertDatabaseHas('holidays', [
        'flea_market_id' => $fleaMarket->id,
        'start_date' => '2024-12-24',
        'end_date' => '2024-12-26',
    ]);

    // Actualizar día festivo
    $holiday->update([
        'end_date' => '2024-12-27',
    ]);

    // Verificar actualización
    assertDatabaseHas('holidays', [
        'id' => $holiday->id,
        'end_date' => '2024-12-27',
    ]);

    // Verificar que la fecha anterior ya no existe
    assertDatabaseMissing('holidays', [
        'id' => $holiday->id,
        'end_date' => '2024-12-26',
    ]);

    // Eliminar día festivo
    $holiday->delete();

    // Verificar eliminación
    assertDatabaseMissing('holidays', [
        'id' => $holiday->id,
    ]);

    // Limpiar tablas relacionadas
    $fleaMarket->delete();
    $municipality->delete();
});

// Test CRUD Puestos
test('CRUD completo de un puesto', function () {
    $user = User::create([
        'name' => 'John',
        'surname' => 'Doe',
        'email' => 'john.doe@example.com',
        'password' => bcrypt('password'),
    ]);

    $municipality = Municipality::create([
        'name' => 'Santa Cruz de La Palma',
    ]);

    $fleaMarket = FleaMarket::create([
        'address' => 'Calle Falsa 123',
        'municipality_id' => $municipality->id,
        'img_url' => 'http://example.com/mercadillo.jpg',
    ]);

    $stall = Stall::create([
        'flea_market_id' => $fleaMarket->id,
        'user_id' => $user->id,
        'home_delivery' => 1,
        'information' => 'Información del puesto',
        'active' => 1,
        'reset_date' => '2024-12-31',
        'register_date' => '2024-01-01',
        'name' => 'Puesto de Juan',
        'img_url' => 'http://example.com/puesto.jpg',
    ]);

    // Verificar creación
    assertDatabaseHas('stalls', [
        'flea_market_id' => $fleaMarket->id,
        'user_id' => $user->id,
        'home_delivery' => 1,
        'information' => 'Información del puesto',
        'active' => 1,
        'reset_date' => '2024-12-31',
        'register_date' => '2024-01-01',
        'name' => 'Puesto de Juan',
        'img_url' => 'http://example.com/puesto.jpg',
    ]);

    // Actualizar puesto
    $stall->update([
        'home_delivery' => 0,
        'information' => 'Información actualizada del puesto',
        'active' => 0,
        'reset_date' => '2025-01-31',
        'register_date' => '2024-02-01',
        'name' => 'Puesto de Juan actualizado',
        'img_url' => 'http://example.com/puesto_actualizado.jpg',
    ]);

    // Verificar actualización
    assertDatabaseHas('stalls', [
        'id' => $stall->id,
        'home_delivery' => 0,
        'information' => 'Información actualizada del puesto',
        'active' => 0,
        'reset_date' => '2025-01-31',
        'register_date' => '2024-02-01',
        'name' => 'Puesto de Juan actualizado',
        'img_url' => 'http://example.com/puesto_actualizado.jpg',
    ]);

    // Verificar que los datos anteriores ya no existen
    assertDatabaseMissing('stalls', [
        'id' => $stall->id,
        'home_delivery' => 1,
        'information' => 'Información del puesto',
        'active' => 1,
        'reset_date' => '2024-12-31',
        'register_date' => '2024-01-01',
        'name' => 'Puesto de Juan',
        'img_url' => 'http://example.com/puesto.jpg',
    ]);

    // Eliminar puesto
    $stall->delete();

    // Verificar eliminación
    assertDatabaseMissing('stalls', [
        'id' => $stall->id,
    ]);

    // Limpiar tablas relacionadas
    $fleaMarket->delete();
    $municipality->delete();
    $user->delete();
});

// Test CRUD Pedidos
test('CRUD completo de un pedido', function () {
    // Crear dependencias
    $user = User::create([
        'name' => 'John',
        'surname' => 'Doe',
        'email' => 'john.doe@example.com',
        'password' => bcrypt('password'),
    ]);

    $municipality = Municipality::create([
        'name' => 'Santa Cruz de La Palma',
    ]);

    $fleaMarket = FleaMarket::create([
        'address' => 'Calle Falsa 123',
        'municipality_id' => $municipality->id,
        'img_url' => 'http://example.com/mercadillo.jpg',
    ]);

    $stall = Stall::create([
        'flea_market_id' => $fleaMarket->id,
        'user_id' => $user->id,
        'home_delivery' => 1,
        'information' => 'Información del puesto',
        'active' => 1,
        'reset_date' => '2024-12-31',
        'register_date' => '2024-01-01',
        'name' => 'Puesto de Juan',
        'img_url' => 'http://example.com/puesto.jpg',
    ]);

    $order = Order::create([
        'user_id' => $user->id,
        'stall_id' => $stall->id,
        'order_date' => '2024-01-15',
        'delivery_date' => '2024-01-20',
    ]);

    // Verificar creación
    assertDatabaseHas('orders', [
        'user_id' => $user->id,
        'stall_id' => $stall->id,
        'order_date' => '2024-01-15',
        'delivery_date' => '2024-01-20',
    ]);

    // Actualizar pedido
    $order->update([
        'order_date' => '2024-01-16',
        'delivery_date' => '2024-01-21',
    ]);

    // Verificar actualización
    assertDatabaseHas('orders', [
        'id' => $order->id,
        'order_date' => '2024-01-16',
        'delivery_date' => '2024-01-21',
    ]);

    // Verificar que las fechas anteriores ya no existen
    assertDatabaseMissing('orders', [
        'id' => $order->id,
        'order_date' => '2024-01-15',
        'delivery_date' => '2024-01-20',
    ]);

    // Eliminar pedido
    $order->delete();

    // Verificar eliminación
    assertDatabaseMissing('orders', [
        'id' => $order->id,
    ]);

    // Limpiar tablas relacionadas
    $stall->delete();
    $user->delete();
    $fleaMarket->delete();
    $municipality->delete();
});

// Test CRUD Horarios
test('CRUD completo de un horario', function () {
    $municipality = Municipality::create([
        'name' => 'Santa Cruz de La Palma',
    ]);

    $fleaMarket = FleaMarket::create([
        'address' => 'Calle Falsa 123',
        'municipality_id' => $municipality->id,
        'img_url' => 'http://example.com/mercadillo.jpg',
    ]);

    $schedule = Schedule::create([
        'flea_market_id' => $fleaMarket->id,
        'day_of_week' => 1,
        'opening_time' => '08:00:00',
        'closing_time' => '14:00:00',
    ]);

    // Verificar creación
    assertDatabaseHas('schedules', [
        'flea_market_id' => $fleaMarket->id,
        'day_of_week' => 1,
        'opening_time' => '08:00:00',
        'closing_time' => '14:00:00',
    ]);

    // Actualizar horario
    $schedule->update([
        'opening_time' => '09:00:00',
        'closing_time' => '15:00:00',
    ]);

    // Verificar actualización
    assertDatabaseHas('schedules', [
        'id' => $schedule->id,
        'opening_time' => '09:00:00',
        'closing_time' => '15:00:00',
    ]);

    // Verificar que los horarios anteriores ya no existen
    assertDatabaseMissing('schedules', [
        'id' => $schedule->id,
        'opening_time' => '08:00:00',
        'closing_time' => '14:00:00',
    ]);

    // Eliminar horario
    $schedule->delete();

    // Verificar eliminación
    assertDatabaseMissing('schedules', [
        'id' => $schedule->id,
    ]);

    // Limpiar tablas relacionadas
    $fleaMarket->delete();
    $municipality->delete();
});

// Test CRUD Métodos de pago
test('CRUD completo de métodos de pago', function () {
    $paymentMethod = PaymentMethod::create([
        'name' => 'Tarjeta de crédito',
    ]);

    // Verificar creación
    assertDatabaseHas('payment_methods', [
        'name' => 'Tarjeta de crédito',
    ]);

    // Actualizar método de pago
    $paymentMethod->update([
        'name' => 'Pago móvil',
    ]);

    // Verificar actualización
    assertDatabaseHas('payment_methods', [
        'id' => $paymentMethod->id,
        'name' => 'Pago móvil',
    ]);

    // Verificar que el nombre anterior ya no existe
    assertDatabaseMissing('payment_methods', [
        'id' => $paymentMethod->id,
        'name' => 'Tarjeta de crédito',
    ]);

    // Eliminar método de pago
    $paymentMethod->delete();

    // Verificar eliminación
    assertDatabaseMissing('payment_methods', [
        'id' => $paymentMethod->id,
    ]);
});