<?php

use App\Models\Komputer;
use App\Models\Pemesanan;
use App\Models\User;

it('shows today accepted order count and revenue based on duration at 7000 per hour', function () {
    $user = User::factory()->create();
    $komputer = Komputer::create([
        'nomor_komputer' => 1,
        'spek_komputer' => 'Intel i5',
        'status_komputer' => 'kosong',
    ]);

    Pemesanan::create([
        'id_user' => $user->id_user,
        'computer_id' => $komputer->id_komputer,
        'tanggal_pemesanan' => now()->toDateString(),
        'waktu_mulai' => '10:00:00',
        'lama_pemesanan' => 2,
        'waktu_akhir' => '12:00:00',
        'nominal' => 50000,
        'status' => 'diterima',
    ]);

    Pemesanan::create([
        'id_user' => $user->id_user,
        'computer_id' => $komputer->id_komputer,
        'tanggal_pemesanan' => now()->toDateString(),
        'waktu_mulai' => '14:00:00',
        'lama_pemesanan' => 1,
        'waktu_akhir' => '15:00:00',
        'nominal' => 12000,
        'status' => 'diterima',
    ]);

    Pemesanan::create([
        'id_user' => $user->id_user,
        'computer_id' => $komputer->id_komputer,
        'tanggal_pemesanan' => now()->toDateString(),
        'waktu_mulai' => '16:00:00',
        'lama_pemesanan' => 3,
        'waktu_akhir' => '19:00:00',
        'nominal' => 30000,
        'status' => 'pending',
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertOk();
    $response->assertSee('2 Transaksi');
    $response->assertSee('Rp. 21.000');
});
