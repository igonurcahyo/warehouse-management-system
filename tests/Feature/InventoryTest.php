<?php

use App\Models\Inventory;
use App\Models\Product;
use App\Models\User;
use App\Models\Warehouse;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    Permission::findOrCreate('view inventory');
    Permission::findOrCreate('manage inventory');
});

test('inventory redirects guests to login', function () {
    $this->get(route('inventory.index'))
        ->assertRedirect(route('login'));
});

test('user without permission cannot access inventory', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('inventory.index'))
        ->assertForbidden();
});

test('user with view inventory permission can list inventory', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('view inventory');

    Inventory::factory()->create();

    $this->actingAs($user)
        ->get(route('inventory.index'))
        ->assertOk()
        ->assertSee('Inventaris');
});

test('user without manage inventory cannot access create form', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('view inventory');

    $this->actingAs($user)
        ->get(route('inventory.create'))
        ->assertForbidden();
});

test('user with manage inventory can create inventory record', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('manage inventory');

    $product = Product::factory()->create();
    $warehouse = Warehouse::factory()->create();

    $this->actingAs($user)
        ->post(route('inventory.store'), [
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity' => 100,
        ])
        ->assertRedirect(route('inventory.index'));

    $this->assertDatabaseHas('inventory', [
        'product_id' => $product->id,
        'warehouse_id' => $warehouse->id,
        'quantity' => 100,
    ]);
});

test('quantity cannot be negative', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('manage inventory');

    $product = Product::factory()->create();
    $warehouse = Warehouse::factory()->create();

    $this->actingAs($user)
        ->post(route('inventory.store'), [
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity' => -1,
        ])
        ->assertSessionHasErrors('quantity');
});

test('duplicate product and warehouse combination is rejected', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('manage inventory');

    $inventory = Inventory::factory()->create();

    $this->actingAs($user)
        ->post(route('inventory.store'), [
            'product_id' => $inventory->product_id,
            'warehouse_id' => $inventory->warehouse_id,
            'quantity' => 50,
        ])
        ->assertSessionHasErrors('warehouse_id');
});

test('user with manage inventory can update inventory', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('manage inventory');

    $inventory = Inventory::factory()->create(['quantity' => 10]);

    $this->actingAs($user)
        ->patch(route('inventory.update', $inventory), [
            'product_id' => $inventory->product_id,
            'warehouse_id' => $inventory->warehouse_id,
            'quantity' => 250,
        ])
        ->assertRedirect(route('inventory.index'));

    expect($inventory->fresh()->quantity)->toBe(250);
});

test('user with manage inventory can delete inventory', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('manage inventory');

    $inventory = Inventory::factory()->create();

    $this->actingAs($user)
        ->delete(route('inventory.destroy', $inventory))
        ->assertRedirect(route('inventory.index'));

    $this->assertModelMissing($inventory);
});
