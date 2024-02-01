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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('month')->nullable();
            $table->integer('date')->nullable();
            $table->string('startTime')->nullable();
            $table->string('meetingTopic')->nullable();
            $table->string('meetingCreator')->nullable();
            $table->string('meetingDiscussion')->nullable();
            $table->string('zoomLink')->nullable();
            $table->string('image')->nullable();
            $table->integer('status')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
