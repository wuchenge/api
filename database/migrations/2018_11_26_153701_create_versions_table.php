<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versions', function (Blueprint $table) {
            $table->increments('id');
            // 平台
            $table->unsignedTinyInteger('type')->index();
            // 版本
            $table->string('version', 10);
            // 强制更新
            $table->unsignedTinyInteger('status')->index();
            // 下载路径
            $table->string('url', 200);
            // 语言
            $table->string('language', 10)->index();
            // 说明
            $table->text('intro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('versions');
    }
}
