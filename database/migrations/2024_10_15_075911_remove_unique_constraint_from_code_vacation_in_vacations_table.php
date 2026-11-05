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
    Schema::table('vacations', function (Blueprint $table) {
        if (Schema::hasColumn('vacations', 'code_vacation') && Schema::hasIndex('vacations', 'vacations_code_vacation_unique')) {
            $table->dropUnique('vacations_code_vacation_unique');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacations', function (Blueprint $table) {
            //
        });
    }
};
