<?php

use App\Models\Category;
use App\Models\User;
use App\Models\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Municipality;
use App\Models\Product;
use App\Models\FleaMarket;
use App\Models\Holiday;
use Illuminate\Support\Facades\DB;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
uses(RefreshDatabase::class);
/*Test que crea un usuario y verifica que se haya introductido en la base de datos*/ 


test('CRUD completo de un usuario', function () {

    //  Crear usuario
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

    //  Actualizar usuario
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

    // 3 Eliminar usuario
    $user->delete();

    // Verificar eliminación
    assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);

});
// Test CRUD Municipio
// Crear municipio
test("CRUD Municipios", function (){
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
        'id' => $municipality->id,    ]);
});
test("CRUD Categproas (Con modelo)",function (){
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
test("Crud Productos  y Fotos (Con modelo)", function (){
    //Crear Dependencias
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
        'unit'=> 'kg',
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
        'unit' => 'kg',
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
test('Crud Mercadillos', function () {
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
test('Crud Dias festivos/Vacaciones', function () { 
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
