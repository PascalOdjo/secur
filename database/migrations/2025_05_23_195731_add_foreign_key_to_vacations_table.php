<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('vacations', function (Blueprint $table) {
            $table->foreign('site_id')
                ->references('id')
                ->on('sites')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('vacations', function (Blueprint $table) {
            $table->dropForeign(['site_id']);
        });
    }
};