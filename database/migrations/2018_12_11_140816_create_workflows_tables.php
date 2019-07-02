<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 工作流程表
        Schema::create('workFlows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200)->comment('工作流程名称');
            $table->unsignedInteger('category_id')->index()->comment('流程对应的薪酬分类');
            $table->tinyInteger('statusCode')->default(1)->comment('工作流程状态:详细见状态表');
            $table->unsignedInteger('createdUser')->index()->comment('工作流程创建人ID');
            $table->string('fileUrl')->nullable()->comment('流程对应文件存放的地址');
            $table->timestamps();
//            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade');
            $table->foreign('createdUser')->references('id')->on('users')->onUpdate('cascade');
        });

        //工作流程日志表
        Schema::create('workFlowLogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wf_id')->unsigned()->index()->comment('工作流程ID，外键');
            $table->integer('user_id')->unsigned()->index()->comment('流程处理人ID');
            $table->string('action', 50)->comment('流程操作动作：审核、退回');
            $table->string('content')->nullable()->comment('流程处理意见');
            $table->timestamps();
            $table->foreign('wf_id')->references('id')->on('workFlows')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });

        // 流程状态表
        Schema::create('workFlowStatus', function (Blueprint $table) {
            $table->tinyInteger('statusCode')->unique()->comment('工作流程状态:1未发起;2等待部门审核;3等待财务工资岗审核;4等待财务领导审核;8流程已办结;9上传数据');
            $table->string('description')->comment('状态描述');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::table('workFlowLogs', function(Blueprint $table){
            $table->dropForeign('workFlowLogs_wf_id_foreign');
            $table->dropForeign('workFlowLogs_user_id_foreign');
        });
        Schema::table('workFlows', function(Blueprint $table){
//            $table->dropForeign('workFlows_category_id_foreign');
            $table->dropForeign('workFlows_createdUser_foreign');
        });

        Schema::dropIfExists('workFlowLogs');
        Schema::dropIfExists('workFlows');
        Schema::dropIfExists('workFlowStatus');
    }
}
