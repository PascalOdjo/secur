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
        Schema::table('contrat', function (Blueprint $table) {
            $table->integer('nombre_contrats_journee_entiere')->nullable();
            $table->integer('nombre_contrats_demi_journee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contrat', function (Blueprint $table) {
            $table->dropColumn(['nombre_contrats_journee_entiere', 'nombre_contrats_demi_journee']);
        });
    }
};
