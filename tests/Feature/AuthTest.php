<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('login page is accessible', function () {
    $response = $this->get('/login');
    $response->assertStatus(200);
});

test('user can login with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'operator@gmail.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post('/login', [
        'email' => 'operator@gmail.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);
});

test('user cannot login with invalid credentials', function () {
    User::factory()->create([
        'email' => 'operator@gmail.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post('/login', [
        'email' => 'operator@gmail.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('user can register an account', function () {
    $response = $this->post('/register', [
        'name' => 'Operator Desa',
        'email' => 'newoperator@gmail.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertDatabaseHas('users', [
        'email' => 'newoperator@gmail.com',
        'name' => 'Operator Desa',
    ]);
});

test('authenticated user can view user management page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/user');
    $response->assertStatus(200);
});

test('authenticated user can update profile', function () {
    $user = User::factory()->create([
        'name' => 'Old Name',
        'email' => 'oldemail@gmail.com',
    ]);

    $response = $this->actingAs($user)->put('/profil', [
        'name' => 'New Name',
        'email' => 'newemail@gmail.com',
    ]);

    $response->assertSessionHasNoErrors();
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'New Name',
        'email' => 'newemail@gmail.com',
    ]);
});

test('main admin user cannot be deleted', function () {
    $mainAdmin = User::factory()->create([
        'email' => 'admin@gmail.com',
    ]);

    $otherUser = User::factory()->create();

    $response = $this->actingAs($otherUser)->delete("/user/{$mainAdmin->id}");

    $response->assertSessionHas('error', 'Akun admin utama tidak dapat dihapus dari sistem.');
    $this->assertDatabaseHas('users', [
        'email' => 'admin@gmail.com',
    ]);
});
