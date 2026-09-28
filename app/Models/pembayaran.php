<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'tb_pembayaran';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_pemesanan',
        'id_transaksi',
        'nominal',
        'status_pembayaran', // pending, settlement, expire, cancel
        'dibayar_pada',
        'kode_qris',
    ];

    /**
     * Relasi: Pembayaran ini untuk 1 transaksi pemesanan warnet
     */
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }
}