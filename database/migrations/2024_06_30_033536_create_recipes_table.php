<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('ingredient');
            $table->text('description');
            $table->string('image'); // URL de la imagen
            $table->string('timeset');
            $table->timestamps(); // Esto agregará created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
