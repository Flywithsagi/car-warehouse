<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration ini menambahkan kolom 'kode_mobil' ke tabel 'mobil'
return new class extends Migration {
    /**
     * Menjalankan migration.
     */
    public function up(): void
    {
        Schema::table('mobil', function (Blueprint $table) {
            // Tambah kolom 'kode_mobil' (tipe string) setelah kolom 'id'
            $table->string('kode_mobil')->after('id');
        });
    }

    /**
     * Membatalkan migration.
     */
    public function down(): void
    {
        Schema::table('mobil', function (Blueprint $table) {
            // Hapus kolom 'kode_mobil' jika rollback
            $table->dropColumn('kode_mobil');
        });
    }
};
