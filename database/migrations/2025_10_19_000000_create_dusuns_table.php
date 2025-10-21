<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dusuns', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        
        // Insert default dusun data
        DB::table('dusuns')->insert([
            ['id' => 1, 'nama' => 'Dusun 1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama' => 'Dusun 2', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama' => 'Dusun 3', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dusuns');
    }
};
