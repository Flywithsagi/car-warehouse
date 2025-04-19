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
        Schema::table('mobil', function (Blueprint $table) {
            $table->string('kode_mobil')->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('mobil', function (Blueprint $table) {
            $table->dropColumn('kode_mobil');
        });
    }

};
