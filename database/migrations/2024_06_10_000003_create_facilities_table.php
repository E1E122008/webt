<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis'); // sarana/prasarana
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->string('status')->default('aktif');
            $table->string('bidang')->nullable(); // bidang/kategori: kesehatan, pendidikan, dll
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facilities');
    }
};
