<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // 用户表
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 32)->unique()->comment('登录名');
            $table->string('password')->comment('登录密码');
            $table->rememberToken();
            $table->timestamps();
        });

        // 用户信息表
        Schema::create('userProfile', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->comment('用户ID，外键');
            $table->string('userName', 16)->comment('姓名');
            $table->string('sex', 4)->nullable()->comment('性别');
            $table->unsignedInteger('department_id')->index()->comment('部门ID');
            $table->unsignedInteger('organization_id')->index()->comment('组织ID');
            $table->string('uid', 50)->unique()->comment('身份证');
            $table->string('mobile', 16)->nullable()->comment('手机');
            $table->string('phone', 16)->nullable()->comment('电话');
            $table->string('address')->nullable()->comment('住址');
            $table->string('policyNumber', 24)->unique()->comment('保险编号');
            $table->string('wageCard', 32)->default('0')->comment('工资卡');
            $table->string('bonusCard', 32)->default('0')->comment('奖金卡');
            // 如果 非工行卡 去 card_info 表查询相关信息
            $table->tinyInteger('flag')->default(0)->comment('非工行工资卡标识符. 0 工行卡 1 非工行卡');
            $table->string('status', 32)->default('在职')->comment('员工状态:在职、离职、行业内交流');
            $table->date('hiredate')->nullable()->comment('入职时间');
            $table->date('departure')->nullable()->comment('离职时间');
            $table->tinyInteger('handicapped')->default(0)->comment('是否残疾人. 0 否 1 是');
            $table->float('tax_rebates')->default(0)->comment('减免税率');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::table('userProfile', function (Blueprint $table) {
            $table->dropForeign('userProfile_user_id_foreign');
        });
        Schema::dropIfExists('userProfile');
        Schema::dropIfExists('users');
    }
}
