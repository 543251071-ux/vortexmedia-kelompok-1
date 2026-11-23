<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertOk();
    $response->assertSee('action="'.route('register.perform').'"', false);
    $response->assertSee('name="name"', false);
    $response->assertSee('name="password_confirmation"', false);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertRedirect(route('login', absolute: false));
    $response->assertSessionHas('status', 'Akun berhasil dibuat. Silakan login kembali.');
    $this->get('/login')->assertSee('Akun berhasil dibuat. Silakan login kembali.');
    $this->assertDatabaseHas('tb_user', [
        'nama' => 'Test User',
        'email' => 'test@example.com',
        'role' => 'user',
    ]);
});
