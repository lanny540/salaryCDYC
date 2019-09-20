<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherTables extends Migration
{
    public function up()
    {
        // 凭证基础信息表
        Schema::create('voucher', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->comment('凭证名称');
            $table->smallInteger('type_id')->comment('凭证类型ID');
            $table->string('description')->default('')->comment('凭证描述');
            $table->timestamps();
        });
        // 凭证类型表
        Schema::create('voucher_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tname', 100)->comment('凭证类型名称');
            $table->string('tdescription')->default('')->comment('凭证类型描述');
        });
        // 凭证模板表
        Schema::create('voucher_template', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('vid')->index()->comment('凭证ID');
            $table->string('subject_name')->comment('科目名称');
            $table->string('subject_no')->comment('科目编码');
            $table->tinyInteger('isLoan')->default(0)->comment('借贷标识.借 0 贷 1.');
            $table->string('subject_description')->default('')->comment('科目描述');
            $table->string('subject_method')->default('')->comment('计算方法.暂时不用');
            $table->softDeletes();
            $table->timestamps();
        });
        // 凭证数据表
        Schema::create('voucher_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vid')->index()->comment('凭证ID');
            $table->integer('period_id')->index()->comment('会计期ID');

            $table->string('vname')->comment('凭证名称');
            $table->string('vcategory', 32)->comment('凭证类别.手工转账、现金凭证、银行凭证');
            $table->string('vuser', 32)->comment('凭证创建人');
            $table->string('cdate', 32)->comment('凭证日期');
            $table->string('period', 32)->comment('会计周期');
            $table->string('cgroup', 64)->comment('凭证批组');
            $table->string('vdescription')->comment('凭证描述');
            $table->json('vdata')->comment('凭证数据');
            $table->tinyInteger('isUpload')->default(1)->comment('上传成功标识. 失败 0 成功 1.');
            $table->timestamps();
        });

        // 凭证所需的汇总表
        Schema::create('voucher_statistic', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('period_id')->index()->comment('会计期ID');
            $table->string('dwdm', 32)->comment('部门编码');
            $table->integer('sum_number')->comment('人数');
            /**
             * TODO: 需要财务确认字段
             * 岗位工资、保留工资、套级补差、中夜班费、加班工资、年功工资、基本养老金、增机、国家补贴、国家生活、国家小计、地方粮差、地方其他、地方物补、
             * 地方生活、地方小计、行业工龄、行业退补、行业其他、行业小计、企业粮差、企业工龄、企业书报、企业水电、企业生活、企业独子费、企业护理费、企业通讯费、
             * 企业规范增、企业工龄02、企业内退补、企业补发、企业小计、离退休补充、补偿、应发工资
             */
//            $table->float('')->default(0)->comment('');
        });
    }

    public function down()
    {
        Schema::dropIfExists('voucher');
        Schema::dropIfExists('voucher_type');
        Schema::dropIfExists('voucher_template');
        Schema::dropIfExists('voucher_data');
        Schema::dropIfExists('voucher_statistic');
    }
}
