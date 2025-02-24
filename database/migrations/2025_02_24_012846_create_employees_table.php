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
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->nullable();
            $table->string('email', 100)->unique();
            $table->string('phone', 15)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('avatar', 200)->nullable();
            $table->tinyInteger('gender')->default(0);
            $table->string('position', 100)->nullable();
            $table->string('username')->nullable();
            $table->string('password', 100)->nullable();
            $table->unsignedInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
