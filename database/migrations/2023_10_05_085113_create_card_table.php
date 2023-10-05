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
        Schema::create('card', function (Blueprint $table) {
            $table->id();
            $table->string('id_card');
            $table->string('name');
            $table->string('supertype');
            $table->string('level');
            $table->integer('hp');
            $table->string('evolvesFrom');
            $table->text('flavorText');
            $table->integer('number');
            $table->string('artist');
            $table->string('rarity');
            $table->string('smallImage');
            $table->string('largeImage');
            $table->string('typeWeakness');
            $table->string('valueWeakness');
            $table->string('typeResistance');
            $table->string('valueResistance');
            $table->json('retreatCost');
            $table->integer('convertedRetreatCost');
            $table->unsignedBigInteger('set_id'); // foreign key
            $table->foreign('set_id')->references('id')->on('set');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card');
    }
};
