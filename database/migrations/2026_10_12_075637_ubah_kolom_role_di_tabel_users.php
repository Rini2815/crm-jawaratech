<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ubah kolom `role` menjadi string 50 karakter (sebelumnya terlalu sempit / ENUM)
     * agar nilai seperti "Digital Marketing" dan "Super Administrator" bisa tersimpan.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 50)->nullable()->change();
        });
    }

    /**
     * Rollback: kolom tetap string. Definisi lama tidak diketahui,
     * jadi tidak dikembalikan ke ENUM / ukuran sebelumnya agar data tidak terpotong.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 50)->nullable()->change();
        });
    }
};