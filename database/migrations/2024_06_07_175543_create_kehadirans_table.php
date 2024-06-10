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
        Schema::create('kehadirans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aktiviti_id')
                  ->constrained('aktivitis','id','fk_kehadiran_xtvt')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->foreignId('ahli_id')
                  ->constrained('ahlis','id','fk_kehadiran_ahli')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->time('masa_hadir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadirans');
    }
};
