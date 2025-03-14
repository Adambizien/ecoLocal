<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiersTable extends Migration
{
    public function up()
    {
        Schema::create('tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade'); // Relation avec le projet
            $table->string('title'); // Nom du palier
            $table->decimal('goal_amount', 15, 2); // Montant cible pour atteindre ce palier
            $table->text('description')->nullable(); // Description du palier
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tiers');
    }
}