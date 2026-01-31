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
        Schema::table('demandes', function (Blueprint $table) {
            // Nouveau système de calcul
            $table->decimal('valeur_base', 10, 2)->default(128)->after('montant')->comment('Valeur unitaire (128)');
            $table->decimal('prix_par_agent', 10, 2)->default(1015)->after('valeur_base')->comment('Prix par agent (1015)');
            $table->decimal('valeur_contrat', 10, 2)->nullable()->after('prix_par_agent')->comment('valeur_contrat = nombre_agents × 128');
            $table->decimal('montant_brut', 10, 2)->nullable()->after('valeur_contrat')->comment('montant_brut = valeur_contrat × 1015');
            $table->decimal('montant_exploitation', 10, 2)->nullable()->after('montant_brut')->comment('50% du montant_brut');
            $table->decimal('montant_tresorerie', 10, 2)->nullable()->after('montant_exploitation')->comment('50% du montant_brut');
            $table->enum('status_validation', ['en_attente', 'validé'])->default('en_attente')->after('status')->comment('Validé si valeur_contrat >= 512');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->dropColumn(['valeur_base', 'prix_par_agent', 'valeur_contrat', 'montant_brut', 'montant_exploitation', 'montant_tresorerie', 'status_validation']);
        });
    }
};
