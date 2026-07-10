<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fc_purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_order_id');
            $table->unsignedBigInteger('ingredient_id');
            $table->decimal('quantity', 10, 3);
            $table->decimal('unit_cost', 8, 4);
            $table->unsignedBigInteger('unit_id');
            $table->date('expiry_date')->nullable();
            $table->timestamps();

            $table->foreign('purchase_order_id')
                ->references('id')
                ->on('fc_purchase_orders')
                ->cascadeOnDelete();

            $table->foreign('ingredient_id')
                ->references('id')
                ->on('fc_ingredients')
                ->restrictOnDelete();

            $table->foreign('unit_id')
                ->references('id')
                ->on('fc_units')
                ->restrictOnDelete();

            $table->index('purchase_order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fc_purchase_order_items');
    }
};
