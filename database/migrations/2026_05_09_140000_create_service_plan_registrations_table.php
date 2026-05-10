<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicePlanRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::create('service_plan_registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_category_id');
            $table->string('plan_title', 500)->nullable();
            $table->string('full_name', 255);
            $table->string('phone', 50);
            $table->string('email', 255);
            $table->text('address');
            $table->string('ip', 45)->nullable();
            $table->timestamps();

            $table->index('service_category_id');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_plan_registrations');
    }
}
