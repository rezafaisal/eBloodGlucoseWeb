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
        Schema::create('blood_glucose_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('blood_glucose', 5, 1);
            $table->enum('context', ['before_breakfast', 'after_breakfast', 'random'])->default('random');
            $table->timestamp('reading_time');
            $table->timestamps();

            $table->index(['user_id', 'reading_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_glucose_readings');
    }
};
