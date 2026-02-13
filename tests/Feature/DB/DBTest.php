<?php
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Municipality;
use App\Models\Product;
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
test("CRUD Categorias", function () {
    DB::table('categories')->insert([
        'name' => 'Frutas',
    ]);
    // Verificar creación
    assertDatabaseHas('categories', [
        'name' => 'Frutas',
    ]);
    // Actualizar categoría
    DB::table('categories')
        ->where('name', 'Frutas')
        ->update(['name' => 'Verduras']);
    // Verificar actualización
    assertDatabaseHas('categories', [
        'name' => 'Verduras',
    ]);
    // Verificar que el nombre anterior ya no existe
    assertDatabaseMissing('categories', [
        'name' => 'Frutas',
    ]);
    // Eliminar categoría
    DB::table('categories')
        ->where('name', 'Verduras')
        ->delete();
    // Verificar eliminación
    assertDatabaseMissing('categories', [
        'name' => 'Verduras',
    ]);
});
test("CRUD Productos", function (){
    DB::table('categories')->insert([
        'name' => 'Frutas',
    ]);
    DB::table('users')->insert([
        'name' => 'John',
        'surname' => 'Doe',
        'email' => 'Jhon.2example.com',
        'password' => bcrypt('password'),
    ]);
    DB::table('products')->insert([
        'name' => 'Producto 1',
        'unit'=> 'kg',
        'user_id' => DB::table('users')->where('email', 'Jhon.2example.com')->value('id'),
        'category_id' => DB::table('categories')->where('name', 'Frutas')->value('id'),
    ]);
    // Verificar creación
    assertDatabaseHas('products', [
        'name' => 'Producto 1',
        'unit' => 'kg',
        'user_id' => DB::table('users')->where('email', 'Jhon.2example.com')->value('id'),
        'category_id' => DB::table('categories')->where('name', 'Frutas')->value('id'),
    ]);
    // Actualizar producto
    DB::table('products')
        ->where('name', 'Producto 1')
        ->update(['name' => 'Producto 1 actualizado']);
    // Verificar actualización
    assertDatabaseHas('products', [
        'name' => 'Producto 1 actualizado',
    ]);
    // Verificar que el nombre anterior ya no existe
    assertDatabaseMissing('products', [
        'name' => 'Producto 1',
    ]);
    // Eliminar producto
    DB::table('products')
        ->where('name', 'Producto 1 actualizado')
        ->delete();
    // Verificar eliminación
    assertDatabaseMissing('products', [
        'name' => 'Producto 1 actualizado',
    ]);
    // Limpiar tablas relacionadas
    DB::table('categories')
        ->where('name', 'Frutas')
        ->delete();
    DB::table('users')
        ->where('email', 'Jhon.2example.com')
        ->delete();
});
