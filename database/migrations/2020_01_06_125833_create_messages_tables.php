<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('sender')->default(0)->comment('发送者ID');
            $table->unsignedInteger('receiver')->index()->comment('接收者ID');
            $table->tinyInteger('type_id')->index()->comment('消息类型：系统消息、部门消息');
            $table->text('content')->comment('消息内容');
            $table->string('attachment')->nullable()->comment('附件地址');
            $table->tinyInteger('isread')->default(0)->comment('是否已读.0否1是');
            $table->softDeletes();
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
        Schema::dropIfExists('messages');
    }
}
