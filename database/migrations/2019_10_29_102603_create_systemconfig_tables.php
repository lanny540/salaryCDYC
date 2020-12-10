<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemconfigTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systemconfig', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('config_key')->comment('系统常量设置key值');
            $table->string('config_value')->comment('系统常量设置value值');
            $table->string('description')->nullable()->comment('字段描述');
            $table->string('type')->nullable()->comment('常量类型');
            $table->timestamps();
        });

        Schema::create('systemlog', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content')->comment('系统常量修改日志内容');
            $table->integer('user_id')->comment('修改人员');
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
        Schema::dropIfExists('systemconfig');
        Schema::dropIfExists('systemlog');
    }
}
