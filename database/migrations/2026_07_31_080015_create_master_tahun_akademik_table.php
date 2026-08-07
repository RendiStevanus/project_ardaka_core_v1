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
        Schema::create('master_tahun_akademik', function (Blueprint $table) {
            $table->id();

            $table->string('kode', 10)->unique();

            $table->smallInteger('tahun_awal');
            $table->smallInteger('tahun_akhir');

            $table->enum('semester', [
                'ganjil',
                'genap',
                'pendek',
            ]);

            $table->string('nama', 50);

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->boolean('is_aktif')->default(false);

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->unique([
                'tahun_awal',
                'semester'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_tahun_akademik');
    }
};
