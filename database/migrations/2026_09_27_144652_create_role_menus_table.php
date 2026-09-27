<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_menus', function (Blueprint $table) {
            $table->id();
            $table->string('role');      // Menyimpan nama role (Superadmin, Digital Marketing, dll)
            $table->string('menu_key');  // Menyimpan kode menu (misal: 'hak-akses', 'kelola-akun', 'layanan-servis')
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_menus');
    }
};