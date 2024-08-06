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
            $table->string('difficult');
            $table->text('shortdesc');//descripcion breve
            $table->text('ingredient');
            $table->text('description');
            $table->string('image'); // URL de la imagen
            $table->string('timeset');
            $table->timestamps(); // Esto agregará created_at y updated_at
            $table->json('ingredients')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
