<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fc_ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique()->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->decimal('average_cost', 8, 4)->default(0);
            $table->decimal('last_cost', 8, 4)->default(0);
            $table->decimal('stock', 10, 3)->default(0);
            $table->decimal('minimum_stock', 10, 3)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('fc_categories')
                ->nullOnDelete();

            $table->foreign('unit_id')
                ->references('id')
                ->on('fc_units')
                ->restrictOnDelete();

            $table->foreign('supplier_id')
                ->references('id')
                ->on('fc_suppliers')
                ->nullOnDelete();

            $table->index('category_id');
            $table->index('supplier_id');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fc_ingredients');
    }
};
