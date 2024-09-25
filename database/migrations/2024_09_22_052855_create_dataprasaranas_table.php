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
        Schema::create('dataprasaranas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolahs_id')->constrained()->cascadeOnDelete();
            $table->integer('luas_tanah');
            $table->string('status_kepemilikan');
            $table->integer('ruang_kelas')->default(0);
            $table->integer('ruang_kepsek')->default(0);
            $table->integer('ruang_guru')->default(0);
            $table->integer('wc_guru')->default(0);
            $table->integer('wc_siswa')->default(0);
            $table->integer('meja_siswa')->default(0);
            $table->integer('kursi_siswa')->default(0);
            $table->integer('papan_tulis')->default(0);
            $table->integer('komputer')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataprasaranas');
    }
};
