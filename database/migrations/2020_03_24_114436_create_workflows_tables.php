<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowsTables extends Migration
{
    public function up()
    {
        Schema::create('workflows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('流程名称');
            $table->integer('uploader')->index()->comment('上传用户ID');
            $table->string('upload_file')->nullable()->comment('上传文件地址');
            $table->boolean('isconfirm')->default(false)->comment('上传数据是否被财务确认');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('workflows');
    }
}
