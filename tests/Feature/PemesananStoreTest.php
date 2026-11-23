<?php

use App\Models\Komputer;
use App\Models\Pemesanan;
use App\Models\User;

it('menyimpan pemesanan dengan durasi dan menghitung biaya', function () {
    $user = User::factory()->create();
    $komputer = Komputer::create([
        'nomor_komputer' => 1,
        'spek_komputer' => 'Intel i5',
        'status_komputer' => 'kosong',
    ]);

    $response = $this->actingAs($user)->post('/rent', [
        'nama' => 'Budi',
        'computer_id' => $komputer->id_komputer,
        'tanggal_pemesanan' => now()->addDay()->toDateString(),
        'lama_pemesanan' => 3,
    ]);

    $response
        ->assertRedirect('/rent')
        ->assertSessionHas('payment_token')
        ->assertSessionHas('pemesanan_id');

    $this->assertDatabaseHas('tb_pemesanan', [
        'id_user' => $user->id_user,
        'computer_id' => $komputer->id_komputer,
        'tanggal_pemesanan' => now()->addDay()->toDateString(),
        'waktu_mulai' => '00:00:00',
        'lama_pemesanan' => 3,
        'waktu_akhir' => '03:00:00',
        'nominal' => 21000,
        'status' => 'pending',
    ]);
    $this->assertDatabaseHas('tb_komputer', [
        'id_komputer' => $komputer->id_komputer,
        'status_komputer' => 'dipesan',
    ]);

    $this->actingAs($user)
        ->get('/struk')
        ->assertOk()
        ->assertSee('#'.str_pad((string) Pemesanan::first()->id_pemesanan, 6, '0', STR_PAD_LEFT))
        ->assertSee('Pemesanan Berhasil!');

    $this->actingAs($user)
        ->get('/rent')
        ->assertOk()
        ->assertViewHas('komputers', fn ($komputers) => $komputers->isEmpty());
});

it('menolak pemesanan yang bentrok dengan komputer yang sama', function () {
    $user = User::factory()->create();
    $komputer = Komputer::create([
        'nomor_komputer' => 2,
        'spek_komputer' => 'Intel i5',
        'status_komputer' => 'kosong',
    ]);

    Pemesanan::create([
        'id_user' => $user->id_user,
        'computer_id' => $komputer->id_komputer,
        'tanggal_pemesanan' => now()->addDay()->toDateString(),
        'waktu_mulai' => '10:00:00',
        'lama_pemesanan' => 2,
        'waktu_akhir' => '12:00:00',
        'nominal' => 14000,
        'status' => 'diterima',
    ]);

    $response = $this->actingAs($user)->from('/rent')->post('/rent', [
        'nama' => 'Budi',
        'computer_id' => $komputer->id_komputer,
        'tanggal_pemesanan' => now()->addDay()->toDateString(),
        'lama_pemesanan' => 1,
    ]);

    $response
        ->assertRedirect('/rent')
        ->assertSessionHasErrors('computer_id');
});
