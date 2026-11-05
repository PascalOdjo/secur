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
        Schema::table('contrats', function (Blueprint $table) {
            $table->string('group')->nullable()->after('vacation_id');
            $table->string('sub_pair')->nullable()->after('group');
            $table->string('code')->nullable()->after('sub_pair');
            $table->boolean('is_real')->default(false)->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contrats', function (Blueprint $table) {
            $table->dropColumn(['group', 'sub_pair', 'code', 'is_real']);
        });
    }
};
