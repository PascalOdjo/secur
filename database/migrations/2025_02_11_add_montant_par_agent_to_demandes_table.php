<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Ajoute le champ montant_par_agent qui représente le montant d'enregistrement
     * saisi par le demandeur (105,000 CFA, 130,000 CFA, etc.)
     */
    public function up(): void
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->decimal('montant_par_agent', 10, 2)->nullable()->comment('Montant d\'enregistrement par agent saisi par le demandeur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->dropColumn('montant_par_agent');
        });
    }
};
