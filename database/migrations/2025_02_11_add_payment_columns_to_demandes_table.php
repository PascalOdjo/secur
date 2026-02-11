<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Ajoute les colonnes manquantes pour le nouveau système de paiement des agents:
     * Les colonnes montant_brut, montant_exploitation, montant_tresorerie, montant_par_agent
     * existent déjà. On ajoute seulement:
     * - salaire_par_agent: Montant_par_agent / 2 (c'est ce qui sera distribué aux agents)
     * - montant_par_vacation: Salaire par agent / 64 (divisé entre 64 vacations par agent)
     */
    public function up(): void
    {
        Schema::table('demandes', function (Blueprint $table) {
            if (!Schema::hasColumn('demandes', 'salaire_par_agent')) {
                $table->decimal('salaire_par_agent', 10, 2)->nullable()->comment('Salaire distribué à chaque agent = montant_par_agent / 2');
            }
            if (!Schema::hasColumn('demandes', 'montant_par_vacation')) {
                $table->decimal('montant_par_vacation', 10, 2)->nullable()->comment('Montant par vacation par agent = salaire_par_agent / 64');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demandes', function (Blueprint $table) {
            if (Schema::hasColumn('demandes', 'salaire_par_agent')) {
                $table->dropColumn('salaire_par_agent');
            }
            if (Schema::hasColumn('demandes', 'montant_par_vacation')) {
                $table->dropColumn('montant_par_vacation');
            }
        });
    }
};
