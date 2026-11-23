<?php

use App\Models\User;

test('confirmed payments can open the receipt without logging in', function () {
    $token = 'payment-token';

    $this->postJson(route('payment.confirm', $token))
        ->assertOk()
        ->assertJson(['status' => 'paid']);

    $this->assertGuest();
    $this->get(route('payment.struk', $token))
        ->assertOk()
        ->assertViewIs('struk')
        ->assertViewHas('token', $token);
});

test('browser payment confirmation redirects to the receipt', function () {
    $token = 'browser-payment-token';

    $this->post(route('payment.confirm', $token))
        ->assertRedirect(route('payment.struk', $token));

    $this->get(route('payment.struk', $token))
        ->assertOk()
        ->assertViewIs('struk');
});

test('rent confirmation button only navigates to the receipt', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->withSession([
            'success' => true,
            'payment_token' => 'navigation-only-token',
        ])
        ->get(route('rent'))
        ->assertOk()
        ->assertSee('href="'.route('struk').'"', false)
        ->assertSee('Konfirmasi Bayar');
});

test('unconfirmed payments cannot open the receipt', function () {
    $this->get(route('payment.struk', 'unconfirmed-token'))
        ->assertNotFound();
});
