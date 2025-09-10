<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->uuid('id_pasien')->primary();
            $table->uuid('id_pengguna');
            $table->foreign('id_pengguna')
                  ->references('id_pengguna')
                  ->on('users')
                  ->onDelete('cascade');

            $table->string('nik')->unique();          // nomor induk kependudukan
            $table->string('nama');                   // nama pasien
            $table->enum('pernah_berobat', ['Ya','Tidak']); // status pernah berobat

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
