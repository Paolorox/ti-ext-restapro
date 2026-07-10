<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fc_purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->string('reference')->nullable();
            $table->string('status', 20)->default('draft');
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->date('order_date')->nullable();
            $table->date('received_date')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('supplier_id')
                ->references('id')
                ->on('fc_suppliers')
                ->restrictOnDelete();

            $table->index('supplier_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fc_purchase_orders');
    }
};
