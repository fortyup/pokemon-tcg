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
            $table->primary('id');
            $table->string('id');
            $table->string('name');
            $table->string('supertype');
            $table->string('level');
            $table->integer('hp');
            $table->string('evolvesFrom');
            $table->text('flavorText');
            $table->integer('number');
            $table->string('artist');
            $table->string('rarity');
            $table->string('set_id');
            $table->string('smallImage');
            $table->string('largeImage');
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
