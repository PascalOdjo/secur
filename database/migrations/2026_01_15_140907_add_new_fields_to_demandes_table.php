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
            // Ajouter les champs du nouveau système s'ils n'existent pas
            if (!Schema::hasColumn('demandes', 'valeur_base')) {
                $table->decimal('valeur_base', 10, 2)->default(128)->after('montant')->comment('Valeur unitaire (128)');
            }
            if (!Schema::hasColumn('demandes', 'prix_par_agent')) {
                $table->decimal('prix_par_agent', 10, 2)->default(1015)->after('valeur_base')->comment('Prix par agent (1015)');
            }
            if (!Schema::hasColumn('demandes', 'valeur_contrat')) {
                $table->decimal('valeur_contrat', 10, 2)->nullable()->after('prix_par_agent')->comment('valeur_contrat = nombre_agents × 128');
            }
            if (!Schema::hasColumn('demandes', 'montant_brut')) {
                $table->decimal('montant_brut', 10, 2)->nullable()->after('valeur_contrat')->comment('montant_brut = valeur_contrat × 1015');
            }
            if (!Schema::hasColumn('demandes', 'montant_exploitation')) {
                $table->decimal('montant_exploitation', 10, 2)->nullable()->after('montant_brut')->comment('50% du montant_brut');
            }
            if (!Schema::hasColumn('demandes', 'montant_tresorerie')) {
                $table->decimal('montant_tresorerie', 10, 2)->nullable()->after('montant_exploitation')->comment('50% du montant_brut');
            }
            if (!Schema::hasColumn('demandes', 'status_validation')) {
                $table->enum('status_validation', ['en_attente', 'validé'])->default('en_attente')->after('status')->comment('Validé si valeur_contrat >= 512');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demandes', function (Blueprint $table) {
            if (Schema::hasColumn('demandes', 'valeur_base')) {
                $table->dropColumn('valeur_base');
            }
            if (Schema::hasColumn('demandes', 'prix_par_agent')) {
                $table->dropColumn('prix_par_agent');
            }
            if (Schema::hasColumn('demandes', 'valeur_contrat')) {
                $table->dropColumn('valeur_contrat');
            }
            if (Schema::hasColumn('demandes', 'montant_brut')) {
                $table->dropColumn('montant_brut');
            }
            if (Schema::hasColumn('demandes', 'montant_exploitation')) {
                $table->dropColumn('montant_exploitation');
            }
            if (Schema::hasColumn('demandes', 'montant_tresorerie')) {
                $table->dropColumn('montant_tresorerie');
            }
            if (Schema::hasColumn('demandes', 'status_validation')) {
                $table->dropColumn('status_validation');
            }
        });
    }
};
