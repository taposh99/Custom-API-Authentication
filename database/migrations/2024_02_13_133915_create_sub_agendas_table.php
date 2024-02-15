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
        Schema::create('sub_agendas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('meeting_agenda_id')->constrained('meeting_agendas')->onDelete('cascade');
            $table->text('subagendaTitle')->nullable();
            $table->text('subagendaDescription')->nullable();
            $table->text('subagendaDocument')->nullable();

        
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
        Schema::dropIfExists('sub_agendas');
    }
};
