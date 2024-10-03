<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('vacations', function (Blueprint $table) {
        $table->dropColumn('demand_id');
    });
}

public function down()
{
    Schema::table('vacations', function (Blueprint $table) {
        $table->unsignedBigInteger('demand_id');
    });
}


    
    
};
