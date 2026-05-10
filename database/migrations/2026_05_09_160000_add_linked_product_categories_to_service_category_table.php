<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkedProductCategoriesToServiceCategoryTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('service_category')) {
            return;
        }
        if (Schema::hasColumn('service_category', 'linked_product_categories')) {
            return;
        }
        Schema::table('service_category', function (Blueprint $table) {
            $table->json('linked_product_categories')->nullable();
        });
    }

    public function down()
    {
        if (!Schema::hasTable('service_category')) {
            return;
        }
        if (!Schema::hasColumn('service_category', 'linked_product_categories')) {
            return;
        }
        Schema::table('service_category', function (Blueprint $table) {
            $table->dropColumn('linked_product_categories');
        });
    }
}
