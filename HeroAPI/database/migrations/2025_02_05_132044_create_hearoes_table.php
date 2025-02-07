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
        Schema::create('heroes', function (Blueprint $table) {
            $table->uuid("HeroId")->primary();
            $table->string("Name");
            $table->string("Sex",10);
            $table->string("OriginPlanet");
            $table->text("Description");
            $table->string("Powers")->nullable();
            $table->string("Town");
            $table->string("Gadgets")->nullable();
            $table->string("Team")->nullable();
            $table->string("Vehicule")->nullable();
            $table->string("UserId");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heroes');
    }
};
