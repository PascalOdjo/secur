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
            Schema::table('invoices', function (Blueprint $table) {
                $table->unsignedBigInteger('demande_id')->after('id'); // Ajoute la colonne après 'id'
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->dropColumn('demande_id');
            });
        });
    }
};
