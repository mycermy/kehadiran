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
        Schema::create('aktivitis', function (Blueprint $table) {
            $table->id();
            $table->text('nama_aktiviti');
            $table->text('keterangan')->nullable();
            $table->date('tarikh');
            $table->time('masa_mula')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivitis');
    }
};
