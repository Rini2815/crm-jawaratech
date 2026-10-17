<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    protected $table = 'tr_follow_up';
    protected $primaryKey = 'id_follow_up';

    protected $fillable = [
        'id_unit', 'id_servis', 'id_pengguna', 'kategori', 'tanggal_jadwal',
        'waktu_kontak', 'status', 'catatan_hasil', 'tanggal_jadwal_ulang',
    ];

    protected $casts = [
        'tanggal_jadwal'       => 'date',
        'tanggal_jadwal_ulang' => 'date',
        'waktu_kontak'         => 'datetime',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_unit', 'id_unit');
    }

    public function servis()
    {
        return $this->belongsTo(Servis::class, 'id_servis', 'id_servis');
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }

    /**
     * Ubah nomor lokal (08xxx) menjadi format internasional untuk wa.me (628xxx)
     */
    public static function nomorWa(?string $no): string
    {
        $angka = preg_replace('/\D/', '', (string) $no);

        if (str_starts_with($angka, '0')) {
            return '62' . substr($angka, 1);
        }
        if (str_starts_with($angka, '62')) {
            return $angka;
        }
        if (str_starts_with($angka, '8')) {
            return '62' . $angka;
        }

        return $angka;
    }

    public static function linkWa(?string $no, string $pesan): string
    {
        return 'https://wa.me/' . self::nomorWa($no) . '?text=' . rawurlencode($pesan);
    }
}