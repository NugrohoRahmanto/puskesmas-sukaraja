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
            Schema::create('history_pasien', function (Blueprint $table) {
                $table->uuid('id_history')->primary();
                $table->string('nama_lengkap');
                $table->integer('usia');
                $table->enum('jenis_kelamin', ['L', 'P']);
                $table->string('no_tel')->nullable();
                $table->date('tanggal');
                $table->integer('no_antrian');
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('history_pasien');
        }
    };
