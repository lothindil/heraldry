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
        Schema::create('attributs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nom');
            $table->foreignId('meuble_id')->constrained();
        });

        Schema::create('attribut_blason', function (Blueprint $table) {
            $table->foreignId('attribut_id')->constrained();
            $table->foreignId('blason_id')->constrained();
            $table->primary(['attribut_id', 'blason_id']);
            $table->foreignId('couleur_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribut_blason');
        Schema::dropIfExists('attributs');
    }
};
