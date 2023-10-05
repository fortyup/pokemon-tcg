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
        Schema::create('set', function (Blueprint $table) {
            $table->primary('id');
            $table->string('id');
            $table->string('name');
            $table->string('series');
            $table->integer('printedTotal');
            $table->integer('total');
            $table->string('ptcgoCode');
            $table->date('releaseDate');
            $table->datetime('updatedAt');
            $table->string('symbol');
            $table->string('logo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set');
    }
};
