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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vacation_id')->constrained()->onDelete('cascade'); // Lien avec la vacation
            $table->decimal('total_amount', 10, 2); // Montant total de la facture
            $table->decimal('agent_payment', 10, 2); // Le montant versé aux agents (1/4)
            $table->decimal('agency_payment', 10, 2); // Le montant versé à l'agence (3/4)
            $table->string('status')->default('pending'); // Statut de la facture (ex : pending, paid)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
