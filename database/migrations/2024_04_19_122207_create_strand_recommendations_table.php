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
        Schema::create('strand_recommendations', function (Blueprint $table) {
            $table->id();
            $table->integer('ranking');
            $table->foreignId('strand_id')->constrained();
            $table->foreignId('examinee_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strand_recommendations');
    }
};
