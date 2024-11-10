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
    Schema::table('demandes', function (Blueprint $table) {
        $table->string('type_contrat')->nullable(); // demi-journée ou journée entière
        $table->integer('valeur_exploitation')->nullable();
        $table->integer('valeur_tresorerie')->nullable();
        $table->string('status_contrat')->nullable(); // validée ou annulée
    });
}



/**
 * Reverse the migrations.
 */

public function down()
{
    Schema::table('demandes', function (Blueprint $table) {
        $table->dropColumn(['type_contrat', 'valeur_exploitation', 'valeur_tresorerie', 'status_contrat']);
    });
}
};
