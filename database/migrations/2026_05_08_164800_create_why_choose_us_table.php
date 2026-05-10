<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateWhyChooseUsTable extends Migration
{
    public function up()
    {
        Schema::create('why_choose_us', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        $now = now();
        DB::table('why_choose_us')->insert([
            [
                'title' => 'Tính linh hoạt',
                'icon' => 'fa-solid fa-bolt',
                'description' => 'Hệ thống có thể được triển khai nhanh chóng trong vòng 60 phút và chỉ cần khách hàng có hạ tầng Internet.',
                'position' => 1,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Tích hợp với phần mềm thứ ba',
                'icon' => 'fa-solid fa-puzzle-piece',
                'description' => 'Hệ thống API/Webservice đầy đủ, sẵn sàng kết nối với phần mềm bên thứ ba. Đã tích hợp thành công với GetFly CRM, Microsoft Dynamics, BookOK, SkyERP,...',
                'position' => 2,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Quản lý dễ dàng, chặt chẽ',
                'icon' => 'fa-solid fa-sliders',
                'description' => 'Hệ thống VoiceCloud được quản lý, thiết lập và giám sát thông qua web portal. Quản trị viên có thể thao tác từ bất cứ đâu khi có Internet.',
                'position' => 3,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Bảo mật và độ ổn định cao',
                'icon' => 'fa-solid fa-shield-halved',
                'description' => 'Hệ thống máy chủ được đặt tại các Data Center đạt tiêu chuẩn Tier 3 tại FPT, VNPT. Cam kết về chất lượng và tiêu chuẩn thoại cho khách hàng.',
                'position' => 4,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Khắc phục sự cố nhanh chóng',
                'icon' => 'fa-solid fa-rotate',
                'description' => 'Máy chủ VoiceCloud hoạt động trên nền tảng Cloud, luôn đảm bảo dự phòng và khắc phục sự cố trong thời gian ngắn nhất.',
                'position' => 5,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Tương thích thiết bị đầu cuối',
                'icon' => 'fa-solid fa-mobile-screen-button',
                'description' => 'Tương thích với hầu hết thiết bị chuẩn SIP trên thị trường. Một số dòng tiêu biểu được đề xuất: Yealink, Grandstream, Snom Phone, Polycom.',
                'position' => 6,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('why_choose_us');
    }
}
