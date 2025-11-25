<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('history_pasien', function (Blueprint $table) {
            $table->uuid('id_history')->primary();

            $table->uuid('id_pasien')->nullable();
            $table->foreign('id_pasien')->references('id_pasien')->on('patients')->nullOnDelete();

            $table->string('nik');
            $table->string('nama');
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable();
            $table->enum('pernah_berobat', ['Ya', 'Tidak']);

            $table->date('tanggal');
            $table->integer('no_antrian');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('history_pasien');
    }
};
