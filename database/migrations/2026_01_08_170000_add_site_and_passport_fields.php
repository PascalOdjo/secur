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
        Schema::table('sites', function (Blueprint $table) {
            if (!Schema::hasColumn('sites', 'description')) {
                $table->text('description')->nullable()->after('address');
            }
            if (!Schema::hasColumn('sites', 'entreprise')) {
                $table->string('entreprise')->nullable()->after('description');
            }
        });

        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'passport_photo')) {
                $table->string('passport_photo')->nullable()->after('entreprise');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sites', function (Blueprint $table) {
            if (Schema::hasColumn('sites', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('sites', 'entreprise')) {
                $table->dropColumn('entreprise');
            }
        });

        Schema::table('clients', function (Blueprint $table) {
            if (Schema::hasColumn('clients', 'passport_photo')) {
                $table->dropColumn('passport_photo');
            }
        });
    }
};
