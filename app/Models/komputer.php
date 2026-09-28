<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komputer extends Model
{
    // Nama tabel di database
    protected $table = 'tb_komputer';

    // Primary Key di tabel tb_komputer
    protected $primaryKey = 'id_komputer';

    // Kolom yang boleh diisi secara massal (mass assignable)
    protected $fillable = [
        'nomor_komputer',
        'spek_komputer',
        'status_komputer',
    ];

    /**
     * Relasi: Satu Komputer bisa memiliki banyak Pemesanan
     */
    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'computer_id', 'id_komputer');
    }
}