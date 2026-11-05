<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\site;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('clients', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->string('prenom');
        $table->string('email')->unique();
        $table->string('telephone')->unique();
        $table->string('adresse');
        $table->string('entreprise')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }

    
   
};
