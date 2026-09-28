<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'tb_pemesanan';
    protected $primaryKey = 'id_pemesanan';

    protected $fillable = [
        'kode_pemesanan',
        'id_user',            // Siapa pelanggan yang main
        'computer_id',         // Meja PC mana yang dipesan
        'tanggal_pemesanan',  // Tanggal booking
        'waktu_mulai',        // Jam mulai main (contoh: 14:00)
        'lama_pemesanan',     // Durasi main dalam jam (contoh: 3 jam)
        'waktu_akhir',        // Jam selesai main (contoh: 17:00)
        'nominal',            // Biaya billing (contoh: 15000)
        'status',             // belum dibayar, diterima, dibatalkan, selesai
        'alasan_ditolak',
    ];

    /**
     * Relasi: Pemesanan ini menggunakan 1 Unit Meja PC Warnet tertentu
     */
    public function komputer()
    {
        return $this->belongsTo(Komputer::class, 'computer_id', 'id_komputer');
    }

    /**
     * Relasi: Pemesanan dilakukan oleh 1 Pelanggan/User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi: Pemesanan ini punya riwayat pembayaran
     */
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_pemesanan', 'id_pemesanan');
    }
}