<?php

use App\Models\Komputer;
use App\Models\User;

it('menambahkan komputer baru ke tb_komputer', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/komputer', [
        'nomor_komputer' => 'Komputer 6',
        'deskripsi' => 'Intel i5 - 3100',
    ]);

    $response
        ->assertRedirect('/komputer')
        ->assertSessionHas('success', 'Komputer 6 berhasil ditambahkan.');

    $this->assertDatabaseHas('tb_komputer', [
        'nomor_komputer' => 6,
        'spek_komputer' => 'Intel i5 - 3100',
        'status_komputer' => 'kosong',
    ]);
});

it('menolak nomor komputer yang sudah ada', function () {
    $user = User::factory()->create();
    Komputer::create([
        'nomor_komputer' => 6,
        'spek_komputer' => 'Intel i5',
        'status_komputer' => 'kosong',
    ]);

    $response = $this->actingAs($user)->post('/komputer', [
        'nomor_komputer' => '6',
        'deskripsi' => 'RTX 2060',
    ]);

    $response
        ->assertRedirect('/komputer')
        ->assertSessionHasErrors('nomor_komputer');

    expect(Komputer::where('nomor_komputer', 6)->count())->toBe(1);
});
