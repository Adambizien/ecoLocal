<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id(); // ID auto-incrémenté
            $table->string('title'); 
            $table->text('description')->nullable(); 
            $table->decimal('goal_amount', 10, 2); 
            $table->decimal('raised_amount', 10, 2)->default(0); // Montant collecté (par défaut 0)
            $table->date('start_date'); 
            $table->date('end_date'); 
            $table->unsignedBigInteger('category_id'); 
            $table->unsignedBigInteger('user_id'); // Clé étrangère vers la table `users`
            $table->timestamps(); // Colonnes `created_at` et `updated_at`

            // Clés étrangères
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
}