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
        Schema::create('attack', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->json('cost')->nullable();
            $table->integer('convertedEnergyCost')->nullable();
            $table->string('damage')->nullable();
            $table->text('text')->nullable();
            $table->unsignedBigInteger('card_id'); // foreign key
            $table->foreign('card_id')->references('id')->on('card');
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
