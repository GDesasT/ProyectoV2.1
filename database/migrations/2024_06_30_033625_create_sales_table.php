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
        Schema::create('sales', function (Blueprint $table) {
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('name',45);
            $table->string('lastName',45);
            $table->double('total', 10, 2);
            $table->enum('dish_type', ['platillo normal', 'platillo ligero']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
