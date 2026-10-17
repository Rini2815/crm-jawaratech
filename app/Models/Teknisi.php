<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teknisi extends Model
{
    protected $table = 'ms_teknisi';
    protected $primaryKey = 'id_teknisi';

    protected $fillable = ['nama_teknisi'];
}