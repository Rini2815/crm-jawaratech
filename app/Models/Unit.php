<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'ms_unit';
    protected $primaryKey = 'id_unit';

    protected $fillable = [
        'id_konsumen', 'jenis_unit', 'merek', 'tipe_model',
        'tanggal_masuk', 'interval_bulan', 'status_garansi',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, 'id_konsumen', 'id_konsumen');
    }
}