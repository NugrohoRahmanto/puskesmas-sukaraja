<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('history_pasien', function (Blueprint $table) {
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->default('Laki-laki')->after('nama');
        });
    }

    public function down(): void
    {
        Schema::table('history_pasien', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
    }
};
