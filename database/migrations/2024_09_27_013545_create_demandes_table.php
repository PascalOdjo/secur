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
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->enum('status', ['en_cours', 'affecte','termine','annule']);
            $table->string('type_contrat');
            $table->integer('nombre_contrats');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
