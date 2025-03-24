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
        Schema::create('detail_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('schedule_id');
            $table->unsignedInteger('employee_id');
            $table->date('workday')->nullable();
            $table->unsignedInteger('KPI')->nullable();
            $table->foreign('schedule_id')->references('id')->on('schedules');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->unique(['schedule_id', 'employee_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_schedules');
    }
};
