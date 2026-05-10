<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIntegrationLogosTable extends Migration
{
    public function up()
    {
        Schema::create('integration_logos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->string('group_key', 32)->index();
            $table->unsignedInteger('position')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        $now = now();
        $defaultLogo = 'https://html.themehour.net/logistik/demo/assets/img/brand/brand_1_1.png';

        DB::table('integration_logos')->insert([
            ['name' => 'GetFly CRM',         'image' => 'https://html.themehour.net/logistik/demo/assets/img/brand/brand_1_1.png', 'link' => '#', 'group_key' => 'crm',      'position' => 1, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Microsoft Dynamics', 'image' => 'https://html.themehour.net/logistik/demo/assets/img/brand/brand_1_2.png', 'link' => '#', 'group_key' => 'crm',      'position' => 2, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'SkyERP',             'image' => 'https://html.themehour.net/logistik/demo/assets/img/brand/brand_1_3.png', 'link' => '#', 'group_key' => 'crm',      'position' => 3, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'BookOK',             'image' => 'https://html.themehour.net/logistik/demo/assets/img/brand/brand_1_4.png', 'link' => '#', 'group_key' => 'crm',      'position' => 4, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],

            ['name' => 'VNPT',               'image' => 'https://html.themehour.net/logistik/demo/assets/img/brand/brand_1_5.png', 'link' => '#', 'group_key' => 'landline', 'position' => 1, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Viettel',            'image' => 'https://html.themehour.net/logistik/demo/assets/img/brand/brand_1_6.png', 'link' => '#', 'group_key' => 'landline', 'position' => 2, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'FPT Telecom',        'image' => 'https://html.themehour.net/logistik/demo/assets/img/brand/brand_1_1.png', 'link' => '#', 'group_key' => 'landline', 'position' => 3, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'CMC Telecom',        'image' => 'https://html.themehour.net/logistik/demo/assets/img/brand/brand_1_2.png', 'link' => '#', 'group_key' => 'landline', 'position' => 4, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],

            ['name' => 'MobiFone',           'image' => 'https://html.themehour.net/logistik/demo/assets/img/brand/brand_1_3.png', 'link' => '#', 'group_key' => 'mobile',   'position' => 1, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'VinaPhone',          'image' => 'https://html.themehour.net/logistik/demo/assets/img/brand/brand_1_4.png', 'link' => '#', 'group_key' => 'mobile',   'position' => 2, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Viettel Mobile',     'image' => 'https://html.themehour.net/logistik/demo/assets/img/brand/brand_1_5.png', 'link' => '#', 'group_key' => 'mobile',   'position' => 3, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Vietnamobile',       'image' => 'https://html.themehour.net/logistik/demo/assets/img/brand/brand_1_6.png', 'link' => '#', 'group_key' => 'mobile',   'position' => 4, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('integration_logos');
    }
}
