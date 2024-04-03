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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('healthcare_professionals_id');
            $table->foreign('healthcare_professionals_id')->references('id')->on('healthcare_professionals');
            $table->timestamp('appointment_start_time')->useCurrent();
            $table->timestamp('appointment_end_time')->useCurrent();
            $table->integer('status')->default(1)->comment('1 = booked, 2 = completed, 3 = cancelled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
