<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id('id_antrian');
            $table->uuid('id_pasien');
            $table->foreign('id_pasien')->references('id_pasien')->on('patients')->onDelete('cascade');
            $table->unsignedBigInteger('no_antrian');
            $table->timestamps();
            $table->date('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
