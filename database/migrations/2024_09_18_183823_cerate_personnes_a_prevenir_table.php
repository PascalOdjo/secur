<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('personnes_a_prevenir', function (Blueprint $table) {
        $table->id();
        $table->foreignId('agent_id')->constrained()->onDelete('cascade');
        $table->string('nom');
        $table->string('prenom');
        $table->string('contact');
        $table->string('profession')->nullable();
        $table->string('adresse')->nullable();
        $table->timestamps();

        // Clé étrangère vers la table agents
        $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
