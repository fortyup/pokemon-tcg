<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('legalities', function (Blueprint $table) {
            $table->id();
            $table->string('standard')->nullable();
            $table->string('unlimited')->nullable();
            $table->string('expanded')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('set_id'); // foreign key
            $table->foreign('set_id')->references('id')->on('set');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legalities');
    }
};
