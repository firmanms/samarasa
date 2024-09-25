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
        Schema::create('datasaranas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolahs_id')->constrained()->cascadeOnDelete();
            $table->mediumText('perabotan')->nullable();
            $table->mediumText('ape_dalam')->nullable();
            $table->mediumText('ape_luar')->nullable();
            $table->mediumText('media_pembelajaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datasaranas');
    }
};
