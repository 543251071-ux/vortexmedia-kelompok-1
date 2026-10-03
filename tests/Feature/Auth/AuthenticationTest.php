<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using email', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users can authenticate using username (nama)', function () {
    $user = User::factory()->create(['nama' => 'adminuser']);

    $response = $this->post('/login', [
        'email' => 'adminuser',
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('email');
});

test('users can not authenticate with non-existent email or username', function () {
    $response = $this->post('/login', [
        'email' => 'nonexistent@example.com',
        'password' => 'password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('email');
});

test('users with legacy plain text password can authenticate and password is auto hashed', function () {
    $user = User::query()->create([
        'nama' => 'ryan_legacy',
        'email' => 'ryan_legacy@example.com',
        'password' => 'anjai',
    ]);

    $response = $this->post('/login', [
        'email' => 'ryan_legacy',
        'password' => 'anjai',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
    $this->assertTrue(\Illuminate\Support\Str::startsWith($user->refresh()->password, ['$2y$', '$2b$', '$2a$']));
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
