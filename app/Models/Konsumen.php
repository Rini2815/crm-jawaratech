<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsumen extends Model
{
    protected $table = 'ms_konsumen';
    protected $primaryKey = 'id_konsumen';

    protected $fillable = ['nama', 'no_whatsapp', 'alamat'];

    public function unit()
    {
        return $this->hasMany(Unit::class, 'id_konsumen', 'id_konsumen');
    }
}