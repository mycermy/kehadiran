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
        Schema::create('ahlis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')
                  ->constrained('kelas','id','fk_ahli_kelas')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->string('nama');
            $table->string('nokp')->unique();
            $table->string('tahap');
            $table->string('katalaluan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ahlis');
    }
};
