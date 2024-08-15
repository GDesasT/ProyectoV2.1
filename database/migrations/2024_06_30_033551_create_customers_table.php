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
        Schema::create('customers', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('number', 45);
            $table->string('name', 45);
            $table->string('lastname', 45);
            $table->string('email', 45);
            $table->foreignId('enterprise_id')->constrained('enterprises')->onDelete('cascade');
            $table->timestamps();

            // Agregar índice único compuesto para enterprise_id y number
            $table->unique(['enterprise_id', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
