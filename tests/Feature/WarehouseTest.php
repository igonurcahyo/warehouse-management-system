<?php

use App\Models\User;
use App\Models\Warehouse;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    Permission::findOrCreate('view warehouses');
    Permission::findOrCreate('manage warehouses');
});

test('warehouses redirects guests to login', function () {
    $this->get(route('warehouses.index'))
        ->assertRedirect(route('login'));
});

test('user without permission cannot access warehouses', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('warehouses.index'))
        ->assertForbidden();
});

test('user with view warehouses permission can list warehouses', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('view warehouses');

    $warehouse = Warehouse::factory()->create();

    $this->actingAs($user)
        ->get(route('warehouses.index'))
        ->assertOk()
        ->assertSee('Gudang')
        ->assertSee($warehouse->name);
});

test('user without manage warehouses cannot access create form', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('view warehouses');

    $this->actingAs($user)
        ->get(route('warehouses.create'))
        ->assertForbidden();
});

test('user with manage warehouses can create warehouse', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('manage warehouses');

    $this->actingAs($user)
        ->post(route('warehouses.store'), [
            'name' => 'Gudang Utama',
            'location' => 'Jakarta',
            'capacity' => 5000,
        ])
        ->assertRedirect(route('warehouses.index'));

    $this->assertDatabaseHas('warehouses', [
        'name' => 'Gudang Utama',
        'location' => 'Jakarta',
        'capacity' => 5000,
    ]);
});

test('warehouse name must be unique', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('manage warehouses');

    Warehouse::factory()->create(['name' => 'Gudang A']);

    $this->actingAs($user)
        ->post(route('warehouses.store'), [
            'name' => 'Gudang A',
            'location' => 'Bandung',
            'capacity' => 1000,
        ])
        ->assertSessionHasErrors('name');
});

test('user with manage warehouses can update warehouse', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('manage warehouses');

    $warehouse = Warehouse::factory()->create([
        'name' => 'Gudang Lama',
        'capacity' => 1000,
    ]);

    $this->actingAs($user)
        ->patch(route('warehouses.update', $warehouse), [
            'name' => 'Gudang Baru',
            'location' => $warehouse->location,
            'capacity' => 2000,
        ])
        ->assertRedirect(route('warehouses.index'));

    expect($warehouse->fresh()->name)->toBe('Gudang Baru');
    expect($warehouse->fresh()->capacity)->toBe(2000);
});

test('user with manage warehouses can delete warehouse', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('manage warehouses');

    $warehouse = Warehouse::factory()->create();

    $this->actingAs($user)
        ->delete(route('warehouses.destroy', $warehouse))
        ->assertRedirect(route('warehouses.index'));

    $this->assertModelMissing($warehouse);
});
