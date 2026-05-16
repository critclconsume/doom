<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up()
{
    Schema::create('fasilitas_photos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('fasilitas_id')->constrained()->onDelete('cascade');
        $table->string('photo');
        $table->integer('urutan')->default(0);
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('fasilitas_photos');
}
};
