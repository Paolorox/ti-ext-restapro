<?php

namespace Paolorox\Restapro\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fc_ingredients', function (Blueprint $table) {
            $table->date('expiry_date')->nullable();
            $table->integer('expiry_alert_days')->default(3);
        });
    }

    public function down(): void
    {
        Schema::table('fc_ingredients', function (Blueprint $table) {
            $table->dropColumn(['expiry_date', 'expiry_alert_days']);
        });
    }
};
