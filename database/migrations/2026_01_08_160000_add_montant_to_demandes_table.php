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
            // Add montant column for the total amount to be used for agent payments
            $table->decimal('montant', 10, 2)->nullable()->after('type_vacation');

            // Add direct foreign keys if they don't exist
            if (!Schema::hasColumn('demandes', 'client_id')) {
                $table->unsignedBigInteger('client_id')->nullable()->after('id');
                $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            }
            if (!Schema::hasColumn('demandes', 'site_id')) {
                $table->unsignedBigInteger('site_id')->nullable()->after('client_id');
                $table->foreign('site_id')->references('id')->on('sites')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demandes', function (Blueprint $table) {
            if (Schema::hasColumn('demandes', 'montant')) {
                $table->dropColumn('montant');
            }
        });
    }
};
