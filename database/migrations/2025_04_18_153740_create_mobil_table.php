<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Menjalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('mobil', function (Blueprint $table) {
            $table->id(); // Kolom id sebagai primary key
            $table->string('name'); // Nama mobil
            $table->string('brand'); // Merk mobil
            $table->integer('year'); // Tahun mobil
            $table->integer('quantity'); // Jumlah kendaraan
            $table->foreignId('jenis_id')->constrained()->onDelete('cascade'); // Relasi dengan tabel 'jenis'
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Membalikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobil'); // Menghapus tabel jika migrasi di-rollback
    }
};
