<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jenis', function (Blueprint $table) {
            $table->id(); // Menambahkan kolom 'id' sebagai primary key
            $table->string('name'); // Menambahkan kolom 'name' untuk nama jenis
            $table->string('type'); // Menambahkan kolom 'type' untuk tipe jenis
            $table->timestamps(); // Menambahkan kolom 'created_at' dan 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis'); // Menghapus tabel jika migration di-rollback
    }
};
