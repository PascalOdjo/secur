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
                $table->unsignedBigInteger('vacation_id')->nullable()->change(); // Rendre la colonne nullable
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
                // Ici, tu devrais revenir à l'ancienne structure, si besoin
                $table->unsignedBigInteger('vacation_id')->nullable(false)->change();
            });
        });
    }
};
