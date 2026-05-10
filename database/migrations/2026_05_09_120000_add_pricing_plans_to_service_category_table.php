<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPricingPlansToServiceCategoryTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('service_category')) {
            return;
        }
        if (Schema::hasColumn('service_category', 'pricing_plans')) {
            return;
        }
        Schema::table('service_category', function (Blueprint $table) {
            $table->json('pricing_plans')->nullable();
        });
    }

    public function down()
    {
        if (!Schema::hasTable('service_category')) {
            return;
        }
        if (!Schema::hasColumn('service_category', 'pricing_plans')) {
            return;
        }
        Schema::table('service_category', function (Blueprint $table) {
            $table->dropColumn('pricing_plans');
        });
    }
}
