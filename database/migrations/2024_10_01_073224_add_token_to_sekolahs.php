<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sekolahs', function (Blueprint $table) {
            $table->string('token')->after('nip')->nullable(); // Specify the column type and position if needed
        });

        // Update all existing rows with a random 5-digit number
    DB::table('sekolahs')->update([
        'token' => DB::raw('LPAD(FLOOR(RAND() * 100000), 5, "0")')
    ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sekolahs', function (Blueprint $table) {
            //
        });
    }

};
