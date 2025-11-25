<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('patients', 'gender')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->enum('gender', ['Laki-laki', 'Perempuan'])->default('Laki-laki')->after('nama');
            });
        }

        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['id_pengguna']);
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->uuid('id_pengguna')->nullable()->change();
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['id_pengguna']);
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->uuid('id_pengguna')->nullable(false)->change();
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('users')
                ->onDelete('cascade');
        });

        if (Schema::hasColumn('patients', 'gender')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->dropColumn('gender');
            });
        }
    }
};
