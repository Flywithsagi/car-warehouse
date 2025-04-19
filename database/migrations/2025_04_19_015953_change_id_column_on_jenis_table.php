<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIdColumnOnJenisTable extends Migration
{
    public function up()
    {
        Schema::table('jenis', function (Blueprint $table) {
            // Mengubah kolom 'id' untuk tidak menggunakan auto-increment
            $table->unsignedBigInteger('id')->primary()->change();
        });
    }

    public function down()
    {
        Schema::table('jenis', function (Blueprint $table) {
            // Mengembalikan kolom 'id' ke auto-increment
            $table->bigIncrements('id')->primary()->change();
        });
    }
}
