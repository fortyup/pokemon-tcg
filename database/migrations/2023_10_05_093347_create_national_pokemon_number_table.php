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
        Schema::create('national_pokemon_number', function (Blueprint $table) {
            $table->id();
            $table->json('national_pokemon_number');
            $table->timestamps();
            $table->unsignedBigInteger('card_id'); // foreign key
            $table->foreign('card_id')->references('id')->on('card');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('national_pokemon_number');
    }
};
