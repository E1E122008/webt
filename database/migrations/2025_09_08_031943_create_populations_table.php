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
        Schema::create('populations', function (Blueprint $table) {
            $table->id();
            
            // Data Kartu Keluarga
            $table->string('no_kk')->nullable();
            $table->string('nik')->unique()->default('NIK-DEFAULT');
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->string('hubungan_kepala')->nullable();
            $table->string('keluarga')->nullable();
            
            // Data Pribadi
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->string('suku')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            
            // Kepemilikan Kendaraan
            $table->integer('motor')->default(0);
            $table->integer('mobil')->default(0);
            $table->integer('sepeda')->default(0);
            
            // Kepemilikan Ternak
            $table->integer('sapi')->default(0);
            $table->integer('kambing')->default(0);
            $table->integer('ayam')->default(0);
            
            // Data Pertanian
            $table->decimal('luas_lahan_pertanian', 10, 2)->default(0);
            $table->decimal('luas_lahan_peternakan', 10, 2)->default(0);
            $table->string('komoditas_utama')->nullable();
            $table->string('komoditas_buah_sayur')->nullable();
            $table->text('bantuan')->nullable();
            
            // Status Rumah
            $table->string('status_kepemilikan_rumah')->nullable();
            $table->string('status_dinding')->nullable();
            $table->string('status_atap')->nullable();
            $table->string('status_lantai')->nullable();

            // Dusun
            $table->string('dusun')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('populations');
    }
};
