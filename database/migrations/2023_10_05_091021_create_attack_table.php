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
        Schema::create('attack', function (Blueprint $table) {
            $table->string('card_id');
            $table->foreign('card_id')->references('id')->on('card');
            $table->string('name');
            $table->json('cost');
            $table->integer('convertedEnergyCost');
            $table->string('damage');
            $table->text('text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attack');
    }
};
