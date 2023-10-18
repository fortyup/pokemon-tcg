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
        Schema::create('ability', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('text');
            $table->string('type');
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
        Schema::dropIfExists('ability');
    }
};
