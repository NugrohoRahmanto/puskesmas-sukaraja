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
            $table->uuid('id_pengguna')->nullable();
            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('users')
                ->nullOnDelete();

            $table->string('nik')->unique();          // nomor induk kependudukan
            $table->string('nama');                   // nama pasien
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->default('Laki-laki');
            $table->enum('pernah_berobat', ['Ya','Tidak']); // status pernah berobat

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
