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
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->string('code_vacation')->unique();
            $table->enum('type_vacation',['sys_08','sys_06']);
            $table->enum('shift',['jour', 'nuit','journee_entiere','evenementiel']);
            $table->unsignedBigInteger('agent_1_id')->nullable(); // Premier agent assigné
            $table->unsignedBigInteger('agent_2_id')->nullable(); // Second agent assigné
            $table->dateTime('start_time'); // Heure de début 
            $table->dateTime('end_time'); // Heure de fin
            $table->enum('status', ['cree', 'en_cours', 'affecte','termine']);
            $table->timestamps(); 

            // Foreign ids
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');

            // Foreign Keys
            $table->foreign('agent_1_id')->references('id')->on('agents')->onDelete('set null');
            $table->foreign('agent_2_id')->references('id')->on('agents')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacations');
    }
};
