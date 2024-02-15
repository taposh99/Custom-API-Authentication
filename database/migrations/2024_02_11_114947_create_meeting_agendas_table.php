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
        Schema::create('meeting_agendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('agendaTitle')->nullable();
            $table->string('agendaDescription')->nullable();
            $table->string('agendaDocument')->nullable();

            $table->string('poll_1')->nullable();
            $table->string('poll_2')->nullable();
            $table->string('poll_3')->nullable();
            $table->string('poll_4')->nullable();
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_agendas');
    }
};
