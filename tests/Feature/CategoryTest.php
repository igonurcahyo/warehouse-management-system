<?php

use App\Models\Category;
use App\Models\User;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    Permission::findOrCreate('view categories');
    Permission::findOrCreate('manage categories');
});

test('categories redirects guests to login', function () {
    $this->get(route('categories.index'))
        ->assertRedirect(route('login'));
});

test('user without permission cannot access categories', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('categories.index'))
        ->assertForbidden();
});

test('user with view categories permission can list categories', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('view categories');

    $category = Category::factory()->create();

    $this->actingAs($user)
        ->get(route('categories.index'))
        ->assertOk()
        ->assertSee('Kategori')
        ->assertSee($category->name);
});

test('user without manage categories cannot access create form', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('view categories');

    $this->actingAs($user)
        ->get(route('categories.create'))
        ->assertForbidden();
});

test('user with manage categories can create category', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('manage categories');

    $this->actingAs($user)
        ->post(route('categories.store'), [
            'name' => 'Alat Tulis',
            'description' => 'Berbagai macam alat tulis kantor',
        ])
        ->assertRedirect(route('categories.index'));

    $this->assertDatabaseHas('categories', [
        'name' => 'Alat Tulis',
        'description' => 'Berbagai macam alat tulis kantor',
    ]);
});

test('category name must be unique', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('manage categories');

    Category::factory()->create(['name' => 'Elektronik']);

    $this->actingAs($user)
        ->post(route('categories.store'), [
            'name' => 'Elektronik',
        ])
        ->assertSessionHasErrors('name');
});

test('user with manage categories can update category', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('manage categories');

    $category = Category::factory()->create(['name' => 'Lama']);

    $this->actingAs($user)
        ->patch(route('categories.update', $category), [
            'name' => 'Baru',
            'description' => 'Deskripsi Baru',
        ])
        ->assertRedirect(route('categories.index'));

    expect($category->fresh()->name)->toBe('Baru');
});

test('user with manage categories can delete category', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('manage categories');

    $category = Category::factory()->create();

    $this->actingAs($user)
        ->delete(route('categories.destroy', $category))
        ->assertRedirect(route('categories.index'));

    $this->assertModelMissing($category);
});
