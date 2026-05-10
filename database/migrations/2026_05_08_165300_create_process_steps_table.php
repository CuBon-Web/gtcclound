<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProcessStepsTable extends Migration
{
    public function up()
    {
        Schema::create('process_steps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('icon')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        $now = now();
        DB::table('process_steps')->insert([
            [
                'title' => 'Tiếp nhận yêu cầu',
                'icon' => 'https://html.themehour.net/logistik/demo/assets/img/icon/process_1_1.svg',
                'position' => 1,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Tư vấn giải pháp',
                'icon' => 'https://html.themehour.net/logistik/demo/assets/img/icon/process_1_2.svg',
                'position' => 2,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Triển khai hệ thống',
                'icon' => 'https://html.themehour.net/logistik/demo/assets/img/icon/process_1_3.svg',
                'position' => 3,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Bàn giao & hỗ trợ',
                'icon' => 'https://html.themehour.net/logistik/demo/assets/img/icon/process_1_4.svg',
                'position' => 4,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('process_steps');
    }
}
