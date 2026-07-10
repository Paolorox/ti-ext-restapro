<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fc_recipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->string('name');
            $table->string('type', 20)->default('menu_item');
            $table->decimal('yield_amount', 8, 2)->default(1);
            $table->unsignedBigInteger('yield_unit_id')->nullable();
            $table->decimal('target_food_cost', 5, 2)->default(30.00);
            $table->decimal('calculated_cost', 8, 4)->default(0);
            $table->text('instructions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('menu_id')
                ->references('menu_id')
                ->on('menus')
                ->nullOnDelete();

            $table->foreign('yield_unit_id')
                ->references('id')
                ->on('fc_units')
                ->nullOnDelete();

            $table->index('menu_id');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fc_recipes');
    }
};
