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
        Schema::table('invoices', function (Blueprint $table) {
            // Ajouter demande_id si elle n'existe pas
            if (!Schema::hasColumn('invoices', 'demande_id')) {
                $table->foreignId('demande_id')->nullable()->after('id')->constrained('demandes')->onDelete('cascade');
            }

            // Rendre vacation_id nullable pour la rétrocompatibilité
            $table->dropForeign(['vacation_id']);
            $table->unsignedBigInteger('vacation_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['demande_id']);
            $table->dropColumn('demande_id');
            $table->foreign('vacation_id')->references('id')->on('vacations')->onDelete('cascade');
        });
    }
};
