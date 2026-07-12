<?php

namespace Paolorox\Restapro\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fc_ingredients', function (Blueprint $table) {
            if (!Schema::hasColumn('fc_ingredients', 'yield_percentage')) {
                $table->decimal('yield_percentage', 5, 2)->default(100.00)->after('expiry_alert_days');
            }
        });
    }

    public function down()
    {
        Schema::table('fc_ingredients', function (Blueprint $table) {
            if (Schema::hasColumn('fc_ingredients', 'yield_percentage')) {
                $table->dropColumn('yield_percentage');
            }
        });
    }
};
