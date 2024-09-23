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
    Schema::table('agents', function (Blueprint $table) {
        $table->integer('age')->nullable();
    });
}

 /**
     * Reverse the migrations.
     */

public function down()
{
    Schema::table('agents', function (Blueprint $table) {
        $table->dropColumn('age');
    });
}


   
};
