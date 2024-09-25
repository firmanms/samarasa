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
        Schema::create('databantuans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bantuan');
            $table->string('rincian_bantuan')->nullable();
            $table->year('tahun');
            $table->string('jenjang')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('databantuans');
    }
};
