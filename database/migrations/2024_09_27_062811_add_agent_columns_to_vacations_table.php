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
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacations', function (Blueprint $table) {
            $table->unsignedBigInteger('agent_1_id')->nullable(); // Agent pour le shift de jour
            $table->unsignedBigInteger('agent_2_id')->nullable(); // Agent pour le shift de nuit
            $table->foreign('agent_1_id')->references('id')->on('agents')->onDelete('set null');
            $table->foreign('agent_2_id')->references('id')->on('agents')->onDelete('set null');
        });
    }
};
