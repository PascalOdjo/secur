<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contrats', function (Blueprint $table) {
            if (!Schema::hasColumn('contrats', 'agent_id')) {
                $table->unsignedBigInteger('agent_id')->nullable()->after('id');
                $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
            }
            if (!Schema::hasColumn('contrats', 'vacation_id')) {
                $table->unsignedBigInteger('vacation_id')->nullable()->after('agent_id');
                $table->foreign('vacation_id')->references('id')->on('vacations')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contrats', function (Blueprint $table) {
            if (Schema::hasColumn('contrats', 'agent_id')) {
                $table->dropForeign(['agent_id']);
                $table->dropColumn('agent_id');
            }
            if (Schema::hasColumn('contrats', 'vacation_id')) {
                $table->dropForeign(['vacation_id']);
                $table->dropColumn('vacation_id');
            }
        });
    }
};
