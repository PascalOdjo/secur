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
            if (!Schema::hasColumn('vacations', 'demande_id')) {
                $table->unsignedBigInteger('demande_id')->nullable()->after('id');
                $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacations', function (Blueprint $table) {
            if (Schema::hasColumn('vacations', 'demande_id')) {
                $table->dropForeign(['demande_id']);
                $table->dropColumn('demande_id');
            }
        });
    }
};
