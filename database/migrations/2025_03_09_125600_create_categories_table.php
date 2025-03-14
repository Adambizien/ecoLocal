<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // ID auto-incrémenté
            $table->string('title'); // Titre de la catégorie
            $table->timestamps(); // Colonnes `created_at` et `updated_at`
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}