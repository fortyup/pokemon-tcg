<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('card', function (Blueprint $table) {
            $table->id();
            $table->string('id_card')->nullable();
            $table->string('name')->nullable();
            $table->string('supertype')->nullable();
            $table->integer('hp')->nullable();
            $table->text('flavorText')->nullable();
            $table->string('number')->nullable();
            $table->string('artist')->nullable();
            $table->string('rarity')->nullable();
            $table->string('smallImage')->nullable();
            $table->string('largeImage')->nullable();
            $table->string('typeWeakness')->nullable();
            $table->string('valueWeakness')->nullable();
            $table->string('typeResistance')->nullable();
            $table->string('valueResistance')->nullable();
            $table->json('retreatCost')->nullable();
            $table->integer('convertedRetreatCost')->nullable();
            $table->unsignedBigInteger('set_id'); // foreign key
            $table->foreign('set_id')->references('id')->on('set')->onUpdate('cascade')->onDelete('cascade');
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
