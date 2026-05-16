<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telepon');
            $table->string('email')->nullable();
            $table->string('lokasi');
            $table->text('deskripsi');
            $table->text('keterangan')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['menunggu', 'diterima', 'selesai', 'ditolak'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan');
    }
};