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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('telephone')->nullable();
            $table->string('addresse')->nullable();
            $table->date('sexe')->nullable();
            $table->date('nationalite')->nullable();
            $table->date('taille')->nullable();
            $table->string('type_contrat')->nullable();
            $table->date('date_debut_contrat')->nullable();
            $table->date('date_fin_contrat')->nullable();
            $table->string('carte_identite')->nullable();
            $table->string('passport_photo')->nullable();
            $table->string('casier_judiciaire')->nullable();
            $table->string('certificat_naissance')->nullable();
            $table->string('certificat_medical')->nullable();
            $table->string('permit_residence')->nullable();
            $table->string('role')->default('agent'); // Par exemple
            $table->enum('status', ['active', 'on_leave', 'on_permission'])->default('active');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
