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
        Schema::table('attendance', function (Blueprint $table) {
            $table->integer('late_penalty')->default(0);
            $table->integer('overtime_hours')->default(0);
            $table->integer('overtime_pay')->default(0);
            $table->integer('total_daily_salary')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->dropColumn(['late_penalty', 'overtime_hours', 'overtime_pay', 'total_daily_salary']);
        });
    }
};
