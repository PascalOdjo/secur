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
        $table->time('shift_jour_start_time')->nullable();
        $table->time('shift_jour_end_time')->nullable();
        $table->time('shift_nuit_start_time')->nullable();
        $table->time('shift_nuit_end_time')->nullable();
    });
}

public function down()
{
    Schema::table('vacations', function (Blueprint $table) {
        $table->dropColumn('shift_jour_start_time');
        $table->dropColumn('shift_jour_end_time');
        $table->dropColumn('shift_nuit_start_time');
        $table->dropColumn('shift_nuit_end_time');
    });
}


    /**
     * Reverse the migrations.
     */
    
};
