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
        Schema::create('daily_moods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->date('mood_date');
            $table->tinyInteger('mood_level')->comment('1=Very Bad, 2=Bad, 3=Neutral, 4=Good, 5=Excellent');
            $table->text('notes')->nullable();
            $table->enum('weather_impact', ['sunny', 'cloudy', 'rainy', 'hot', 'cold'])->nullable();
            $table->tinyInteger('workload_level')->nullable()->comment('1=Very Light, 2=Light, 3=Moderate, 4=Heavy, 5=Very Heavy');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            
            // Unique constraint: one mood entry per employee per day
            $table->unique(['employee_id', 'mood_date']);
            
            // Index untuk performa
            $table->index(['mood_date', 'mood_level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_moods');
    }
};
