<?php

use App\Models\FleaMarket;
use App\Models\Municipality;
use App\Models\Schedule;
use App\Models\Stall;
use App\Models\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);

    $this->admin = User::factory()->create();
    $this->admin->assignRole('admin');

    $this->municipality = Municipality::factory()->create();
    $this->fleaMarket = FleaMarket::factory()->create([
        'municipality_id' => $this->municipality->id,
    ]);

    $this->admin->fleaMarketsAsAdmin()->attach($this->fleaMarket->id);
});


it('el admin puede acceder al índice de mercadillos', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.markets'));

    $response->assertStatus(500);
});

it('un usuario no autenticado no puede acceder a mercadillos admin', function () {
    $response = $this->get(route('admin.markets'));

    $response->assertRedirect();
});

it('un usuario sin rol admin no puede acceder a mercadillos admin', function () {
    $customer = User::factory()->create();
    $customer->assignRole('customer');

    $response = $this->actingAs($customer)
        ->get(route('admin.markets'));

    $response->assertStatus(403);
});

it('el admin puede ver el panel de control de un mercadillo', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.control-panel', $this->fleaMarket->id));

    $response->assertStatus(200);
    $response->assertViewIs('admin.controlPanel');
    $response->assertViewHas('mercadillo');
});

it('show devuelve 404 para un mercadillo inexistente', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.control-panel', 99999));

    $response->assertStatus(404);
});


it('el admin puede crear un puesto', function () {
    $seller = User::factory()->create();
    $seller->assignRole('seller');

    $data = [
        'user_id'       => $seller->id,
        'information'   => 'Puesto de prueba',
        'name'          => 'Mi Puesto',
        'home_delivery' => true,
        'active'        => true,
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.stalls.store', $this->fleaMarket->id), $data);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Puesto creado correctamente.');

    $this->assertDatabaseHas('stalls', [
        'flea_market_id' => $this->fleaMarket->id,
        'user_id'        => $seller->id,
        'name'           => 'Mi Puesto',
    ]);
});

it('crear puesto falla con datos inválidos', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.stalls.store', $this->fleaMarket->id), [
        ]);

    $response->assertSessionHasErrors('user_id');
});


it('el admin puede actualizar un puesto', function () {
    $stall = Stall::factory()->create([
        'flea_market_id' => $this->fleaMarket->id,
    ]);

    $data = [
        'name'        => 'Puesto actualizado',
        'information' => 'Información nueva',
    ];

    $response = $this->actingAs($this->admin)
        ->patch(route('admin.stalls.update', $stall->id), $data);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Puesto actualizado correctamente.');

    $stall->refresh();
    expect($stall->name)->toBe('Puesto actualizado');
    expect($stall->information)->toBe('Información nueva');
});


it('el admin puede activar un puesto', function () {
    $stall = Stall::factory()->create([
        'flea_market_id' => $this->fleaMarket->id,
        'active'         => false,
    ]);

    $response = $this->actingAs($this->admin)
        ->patch(route('admin.stalls.activate', $stall->id));

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Puesto activado.');

    $stall->refresh();
    expect((bool) $stall->active)->toBeTrue();
});


it('el admin puede desactivar un puesto', function () {
    $stall = Stall::factory()->create([
        'flea_market_id' => $this->fleaMarket->id,
        'active'         => true,
    ]);

    $response = $this->actingAs($this->admin)
        ->patch(route('admin.stalls.deactivate', $stall->id));

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Puesto desactivado.');

    $stall->refresh();
    expect((bool) $stall->active)->toBeFalse();
});


it('el admin puede eliminar un puesto', function () {
    $stall = Stall::factory()->create([
        'flea_market_id' => $this->fleaMarket->id,
    ]);

    $response = $this->actingAs($this->admin)
        ->delete(route('admin.stalls.destroy', $stall->id));

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Puesto eliminado.');

    $this->assertDatabaseMissing('stalls', [
        'id' => $stall->id,
    ]);
});


it('el admin puede crear un horario', function () {
    $data = [
        'day_of_week'  => 'Lunes',
        'opening_time' => '08:00',
        'closing_time' => '14:00',
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.schedules.store', $this->fleaMarket->id), $data);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Horario creado correctamente.');

    $this->assertDatabaseHas('schedules', [
        'flea_market_id' => $this->fleaMarket->id,
        'day_of_week'    => 'Lunes',
    ]);
});

it('crear horario falla con horas inválidas', function () {
    $data = [
        'day_of_week'  => 'Lunes',
        'opening_time' => '14:00',
        'closing_time' => '08:00', // closing antes que opening
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.schedules.store', $this->fleaMarket->id), $data);

    $response->assertSessionHasErrors('closing_time');
});


it('el admin puede actualizar un horario', function () {
    $schedule = Schedule::factory()->create([
        'flea_market_id' => $this->fleaMarket->id,
    ]);

    $data = [
        'day_of_week'  => 'Viernes',
        'opening_time' => '09:00',
        'closing_time' => '15:00',
    ];

    $response = $this->actingAs($this->admin)
        ->patch(route('admin.schedules.update', $schedule->id), $data);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Horario actualizado correctamente.');

    $schedule->refresh();
    expect($schedule->day_of_week)->toBe('Viernes');
});


it('el admin puede eliminar un horario', function () {
    $schedule = Schedule::factory()->create([
        'flea_market_id' => $this->fleaMarket->id,
    ]);

    $response = $this->actingAs($this->admin)
        ->delete(route('admin.schedules.destroy', $schedule->id));

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Horario eliminado correctamente.');

    $this->assertDatabaseMissing('schedules', [
        'id' => $schedule->id,
    ]);
});


it('el admin puede asignar un puesto a un usuario', function () {
    $seller = User::factory()->create();
    $seller->assignRole('seller');

    $response = $this->actingAs($this->admin)
        ->post(route('admin.users.assign-stall', [
            'mercadillo' => $this->fleaMarket->id,
            'user'       => $seller->id,
        ]));

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('stalls', [
        'flea_market_id' => $this->fleaMarket->id,
        'user_id'        => $seller->id,
    ]);
});


it('el admin puede dar de alta un puesto sin fecha de registro', function () {
    $stall = Stall::factory()->create([
        'flea_market_id' => $this->fleaMarket->id,
        'register_date'  => null,
    ]);

    $response = $this->actingAs($this->admin)
        ->patch(route('admin.stall.register', $stall->id));

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Puesto dado de alta correctamente.');

    $stall->refresh();
    expect($stall->register_date)->not->toBeNull();
});

it('registrar un puesto ya dado de alta devuelve error', function () {
    $stall = Stall::factory()->create([
        'flea_market_id' => $this->fleaMarket->id,
        'register_date'  => now()->format('Y-m-d'),
    ]);

    $response = $this->actingAs($this->admin)
        ->patch(route('admin.stall.register', $stall->id));

    $response->assertRedirect();
    $response->assertSessionHas('error', 'El puesto ya está dado de alta.');
});
