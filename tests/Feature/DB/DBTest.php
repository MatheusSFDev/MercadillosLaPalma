<?php
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Municipality;
/*
Permite hacer Pruebas en la base de datos, se encarga de limpiar la base de datos después de cada prueba, para evitar que los datos de una prueba afecten a otra prueba.
*/ 
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\post;
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
