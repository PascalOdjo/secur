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
        Schema::table('vacations', function (Blueprint $table) {
            //
            // Supprimer la contrainte de clé étrangère
            $table->dropForeign('vacations_site_id_foreign');
            // Supprimer la colonne
            $table->dropColumn('site_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacations', function (Blueprint $table) {
            //
            // Restaurer la colonne site_id
            $table->unsignedBigInteger('site_id')->nullable();
            // Restaurer la contrainte de clé étrangère
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('set null');
        });
    }
};
