<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            // 标题
            $table->string('title', 50)->index();
            // 内容
            $table->text('content');
            // 类别
            $table->unsignedInteger('type')->index();
            // 状态
            $table->unsignedInteger('status')->index();
            // 别名，translate
            $table->string('alias', 200)->index();
            // 语言
            $table->string('language', 20)->index();
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
        Schema::dropIfExists('articles');
    }
}
