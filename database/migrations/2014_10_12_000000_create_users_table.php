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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id_pengguna')->primary();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('no_tel')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('nama_lengkap');
            $table->enum('role', ['admin', 'user'])->default('user'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
