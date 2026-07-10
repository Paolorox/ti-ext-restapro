<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fc_recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id');
            $table->unsignedBigInteger('ingredient_id')->nullable();
            $table->unsignedBigInteger('sub_recipe_id')->nullable();
            $table->decimal('quantity', 8, 3);
            $table->unsignedBigInteger('unit_id');
            $table->timestamps();

            $table->foreign('recipe_id')
                ->references('id')
                ->on('fc_recipes')
                ->cascadeOnDelete();

            $table->foreign('ingredient_id')
                ->references('id')
                ->on('fc_ingredients')
                ->cascadeOnDelete();

            $table->foreign('sub_recipe_id')
                ->references('id')
                ->on('fc_recipes')
                ->cascadeOnDelete();

            $table->foreign('unit_id')
                ->references('id')
                ->on('fc_units')
                ->restrictOnDelete();

            $table->index('recipe_id');
            $table->index('ingredient_id');
            $table->index('sub_recipe_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fc_recipe_ingredients');
    }
};
