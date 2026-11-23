<?php

use App\Models\User;

it('mengeluarkan pengguna dan mengarahkan ke halaman login', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $response
        ->assertRedirect('/login');

    $this->assertGuest();
});
