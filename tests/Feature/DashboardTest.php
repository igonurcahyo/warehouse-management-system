<?php

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

test('dashboard redirects guests to login', function () {
    $this->get('/dashboard')
        ->assertRedirect(route('login'));
});

test('dashboard renders warehouse metrics for verified users', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertSee('Total Produk')
        ->assertSee('Total Stok')
        ->assertSee('Stok Menipis')
        ->assertSee('Total Gudang')
        ->assertSee('Permintaan Tertunda');
});

test('sidebar renders product navigation only when the user has its permission', function () {
    $user = User::factory()->create();
    Permission::findOrCreate('view products');

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertDontSee('<span>Produk</span>', false);

    $user->givePermissionTo('view products');

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertSee('<span>Produk</span>', false);
});

test('admin sees administrative navigation links', function () {
    $user = User::factory()->create();
    $admin = Role::findOrCreate('Admin');
    $user->assignRole($admin);

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertSee('<span>Pengguna &amp; Peran</span>', false)
        ->assertSee('<span>Log Aktivitas</span>', false);
});
