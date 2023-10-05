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
        Schema::create('blasons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('couleur_champs_id')->constrained(
                table: 'couleurs'
            );
            $table->foreignId('couleur_meuble_id')->nullable()->constrained(
                table: 'couleurs'
            );
            $table->foreignId('meuble_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blasons');
    }
};
