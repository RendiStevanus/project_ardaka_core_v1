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
        Schema::create('master_gelombang', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tahun_akademik_id')
                ->constrained('master_tahun_akademik')
                ->cascadeOnDelete();

            $table->string('kode', 20);
            $table->string('nama', 100);

            $table->unsignedInteger('urutan')->default(1);

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->unsignedInteger('kuota')->nullable();

            $table->enum('status', [
                'draft',
                'aktif',
                'tutup'
            ])->default('draft');

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->unique([
                'tahun_akademik_id',
                'kode'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_gelombang');
    }
};
