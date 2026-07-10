<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fc_stock_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ingredient_id');
            $table->string('type', 20);
            $table->decimal('quantity', 10, 3);
            $table->decimal('unit_cost', 8, 4)->default(0);
            $table->string('reference_id')->nullable();
            $table->string('reference_type')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('ingredient_id')
                ->references('id')
                ->on('fc_ingredients')
                ->cascadeOnDelete();

            $table->index('ingredient_id');
            $table->index('type');
            $table->index('created_at');
            $table->index(['reference_type', 'reference_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fc_stock_movements');
    }
};
