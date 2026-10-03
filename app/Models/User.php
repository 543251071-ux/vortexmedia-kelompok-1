<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Menghubungkan ke tabel db_vortexmedia
    protected $table = 'tb_user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama',
        'nomor_telepon',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Accessor untuk kompatibilitas
    public function getIdAttribute()
    {
        return $this->attributes['id_user'] ?? null;
    }

    public function getNameAttribute()
    {
        return $this->attributes['nama'] ?? null;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['nama'] = $value;
    }
}