<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servis extends Model
{
    protected $table = 'tr_servis';
    protected $primaryKey = 'id_servis';

    protected $fillable = [
        'id_unit', 'id_teknisi', 'no_tiket', 'tanggal_masuk',
        'tanggal_estimasi_selesai', 'keluhan', 'kelengkapan', 'status',
        'no_invoice', 'tanggal_closing', 'biaya_jasa', 'jumlah_dp',
        'biaya_sparepart', 'diskon', 'total_bayar', 'masa_garansi_hari',
        'garansi_berakhir', 'status_pembayaran', 'tanggal_dp',
        'tanggal_pelunasan', 'jumlah_pelunasan', 'metode_pembayaran', 'catatan',
    ];

    protected $casts = [
        'tanggal_masuk'            => 'date',
        'tanggal_estimasi_selesai' => 'date',
        'tanggal_closing'          => 'date',
        'garansi_berakhir'         => 'date',
        'tanggal_dp'               => 'date',
        'tanggal_pelunasan'        => 'date',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_unit', 'id_unit');
    }

    public function teknisi()
    {
        return $this->belongsTo(Teknisi::class, 'id_teknisi', 'id_teknisi');
    }

    // Contoh hasil: "AC Daikin (Inverter 1 PK)"
    public function getLabelUnitAttribute(): string
    {
        $u = $this->unit;
        if (!$u) {
            return '-';
        }

        return trim($u->jenis_unit . ' ' . $u->merek . ($u->tipe_model ? ' (' . $u->tipe_model . ')' : ''));
    }

    // Contoh hasil: "30 Hari" atau "Tanpa Garansi"
    public function getLabelGaransiAttribute(): string
    {
        return $this->masa_garansi_hari > 0 ? $this->masa_garansi_hari . ' Hari' : 'Tanpa Garansi';
    }

    // Sisa yang masih harus dibayar konsumen
    public function getSisaBayarAttribute(): int
    {
        if ($this->status_pembayaran === 'Lunas') {
            return 0;
        }

        return max(0, (int) $this->total_bayar - (int) $this->jumlah_dp);
    }
}