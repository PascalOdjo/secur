<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePerseonnesAPrevenirTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('personnes_a_prevenir', 'personne_a_prevenir');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('personne_a_prevenir', 'personnes_a_prevenir');
    }
}
