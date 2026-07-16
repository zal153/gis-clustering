<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('unauthenticated user is redirected to login', function () {
    $response = $this->get('/dashboard');
    $response->assertStatus(302);
    $response->assertRedirect('/login');
});

test('authenticated user can access dashboard', function () {
    $user = \App\Models\User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
});
