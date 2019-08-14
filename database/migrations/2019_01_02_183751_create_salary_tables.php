<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 工资导入表
         */
        Schema::create('wage', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 10)->index()->comment('人员姓名');
            $table->string('policyNumber', 24)->index()->comment('保险编号');

            $table->float('annual')->default(0)->comment('年薪工资');
            $table->float('post_wage')->default(0)->comment('岗位工资');
            $table->float('retained_wage')->default(0)->comment('保留工资');
            $table->float('compensation')->default(0)->comment('套级补差');
            $table->float('night_shift')->default(0)->comment('中夜班费');
            $table->float('overtime_wage')->default(0)->comment('加班工资');
            $table->float('seniority_wage')->default(0)->comment('年功工资');

            $table->integer('period_id')->default(0)->comment('会计期ID');
            $table->string('upload_files')->nullable()->comment('上传文件地址');
            $table->timestamps();
            $table->unsignedInteger('user_id')->index()->comment('上传人员ID');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });
        /**
         * 奖金类别表
         */
        Schema::create('bonus_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->comment('奖金类别名称');
            $table->unsignedInteger('role_id')->comment('允许使用此类别的角色');
        });
        /**
         * 奖金导入表
         */
        Schema::create('bonus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 10)->index()->comment('人员姓名');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->float('bonus')->default(0)->comment('奖金金额');
            $table->string('comment')->comment('奖金备注');
            $table->unsignedInteger('type_id')->index()->comment('奖金类别:1 月奖 2 专项奖 3节日慰问费');
            $table->integer('period_id')->default(0)->comment('会计期ID');
            $table->string('upload_files')->nullable()->comment('上传文件地址');
            $table->unsignedInteger('user_id')->index()->comment('上传人员ID');
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('bonus_types')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });
        /**
         * 物业费用导入表
         */
        Schema::create('property', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 10)->index()->comment('人员姓名');
            $table->string('policyNumber', 24)->index()->comment('保险编号');

            $table->float('cc_water')->default(0)->comment('成钞水量');
            $table->float('cc_water_rate')->default(0)->comment('成钞水费');
            $table->float('cc_electricity')->default(0)->comment('成钞电费');
            $table->float('cc_property')->default(0)->comment('成钞物管');
            $table->float('xy_water')->default(0)->comment('鑫源水量');
            $table->float('xy_water_rate')->default(0)->comment('鑫源水费');
            $table->float('xy_electricity')->default(0)->comment('鑫源电费');
            $table->float('xy_property')->default(0)->comment('鑫源物管');
            $table->float('water_back')->default(0)->comment('水量退补费');
            $table->float('water_rate_back')->default(0)->comment('水费退补费');
            $table->float('electricity_back')->default(0)->comment('电费退补费');
            $table->float('property_back')->default(0)->comment('物管退补费');
            $table->float('utilities')->default(0)->comment('水电');
            $table->float('property_fee')->default(0)->comment('物管费');
            $table->float('total_property')->default(0)->comment('合计水电物管');

            $table->integer('period_id')->default(0)->comment('会计期ID');
            $table->string('upload_files')->nullable()->comment('上传文件地址');
            $table->timestamps();
            $table->unsignedInteger('user_id')->index()->comment('上传人员ID');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });
        /**
         * 扣款类别表
         */
        Schema::create('deductions_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->comment('扣款类别名称');
            $table->unsignedInteger('role_id')->comment('允许使用此类别的角色');
        });
        /**
         * 扣款导入表
         * 包括 公车费用、固定扣款、其他扣款、临时扣款、扣工会会费、扣欠款、捐赠
         */
        Schema::create('deductions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 10)->index()->comment('人员姓名');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->float('deduction')->default(0)->comment('扣款金额');
            $table->string('comment')->comment('扣款备注');
            $table->unsignedInteger('type_id')->index()->comment('扣款类别');
            $table->integer('period_id')->default(0)->comment('会计期ID');
            $table->string('upload_files')->nullable()->comment('上传文件地址');
            $table->unsignedInteger('user_id')->index()->comment('上传人员ID');
            $table->timestamps();
            $table->foreign('type_id')->references('id')->on('deductions_types')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });
        /**
         * 其他费用类别表
         */
        Schema::create('other_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->comment('其他费用类别名称');
            $table->unsignedInteger('role_id')->comment('允许使用此类别的角色');
        });
        /**
         * 其他费用导入表
         * 包括 稿费、劳务报酬、特许使用权
         */
        Schema::create('otherSalary', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 10)->index()->comment('人员姓名');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->float('otherSalary')->default(0)->comment('其他费用金额');
            $table->string('comment')->comment('其他费用备注');
            $table->unsignedInteger('type_id')->index()->comment('其他费用类别');
            $table->integer('period_id')->default(0)->comment('会计期ID');
            $table->string('upload_files')->nullable()->comment('上传文件地址');
            $table->unsignedInteger('user_id')->index()->comment('上传人员ID');
            $table->timestamps();
            $table->foreign('type_id')->references('id')->on('other_types')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });

        // 一人对应一条记录
        /**
         * 社保导入表
         */
        Schema::create('insurances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 10)->index()->comment('人员姓名');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            /*
             * gjj_classic              公积金标准
             * gjj_deduction            公积金补扣
             * gjj_person               公积金个人
             * gjj_enterprise           公积企业缴
             * annuity_classic          年金标准
             * annuity_deduction        年金补扣
             * annuity_person           年金个人
             * annuity_enterprise       年金企业缴
             * retire_classic           退养金标准
             * retire_deduction         退养金补扣
             * retire_person            退养金个人
             * retire_enterprise        退养企业缴
             * medical_classic          医保金标准
             * medical_deduction        医保金补扣
             * medical_person           医保金个人
             * medical_enterprise       医疗企业缴
             * unemployment_classic     失业金标准
             * unemployment_deduction   失业金补扣
             * unemployment_person      失业金个人
             * unemployment_enterprise  失业企业缴
             * injury_enterprise        工伤企业缴
             * birth_enterprise         生育企业缴
             */
            $table->float('gjj_classic')->default(0)->comment('公积金标准');
            $table->float('gjj_deduction')->default(0)->comment('公积金补扣');
            $table->float('gjj_person')->default(0)->comment('公积金个人');
            $table->float('gjj_enterprise')->default(0)->comment('公积企业缴');
            $table->float('annuity_classic')->default(0)->comment('年金标准');
            $table->float('annuity_deduction')->default(0)->comment('年金补扣');
            $table->float('annuity_person')->default(0)->comment('年金个人');
            $table->float('annuity_enterprise')->default(0)->comment('年金企业缴');
            $table->float('retire_classic')->default(0)->comment('退养金标准');
            $table->float('retire_deduction')->default(0)->comment('退养金补扣');
            $table->float('retire_person')->default(0)->comment('退养金个人');
            $table->float('retire_enterprise')->default(0)->comment('退养企业缴');
            $table->float('medical_classic')->default(0)->comment('医保金标准');
            $table->float('medical_deduction')->default(0)->comment('医保金补扣');
            $table->float('medical_person')->default(0)->comment('医保金个人');
            $table->float('medical_enterprise')->default(0)->comment('医疗企业缴');
            $table->float('unemployment_classic')->default(0)->comment('失业金标准');
            $table->float('unemployment_deduction')->default(0)->comment('失业金补扣');
            $table->float('unemployment_person')->default(0)->comment('失业金个人');
            $table->float('unemployment_enterprise')->default(0)->comment('失业企业缴');
            $table->float('injury_enterprise')->default(0)->comment('工伤企业缴');
            $table->float('birth_enterprise')->default(0)->comment('生育企业缴');

            $table->timestamps();
            $table->unsignedInteger('user_id')->index()->comment('上传人员ID');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });
        /**
         * 补贴导入表
         */
        Schema::create('subsidy', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 10)->index()->comment('人员姓名');
            $table->string('policyNumber', 24)->index()->comment('保险编号');

            /**
             * communication            通讯补贴         人力
             * traffic                  交通费          人力
             * housing                  住房补贴         基建
             * single_classic           独子费标准       医院
             * single_add               独子费补发        医院
             * single                   独子费           医院
             * subsidy                  补贴合计 = 住房补贴 + 独子费标准 + 独子费补发 + 独子费
             */
            $table->float('communication')->default(0)->comment('通讯补贴');
            $table->float('traffic')->default(0)->comment('交通费');
            $table->float('housing')->default(0)->comment('住房补贴');
            $table->float('single_classic')->default(0)->comment('独子费标准');
            $table->float('single_add')->default(0)->comment('独子费补发');
            $table->float('single')->default(0)->comment('独子费');
            $table->float('subsidy')->default(0)->comment('补贴合计');

            $table->timestamps();
            $table->unsignedInteger('user_id')->index()->comment('上传人员ID');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });
        /**
         * 税务导入表
         * 用于导入税务系统的税务数据
         */
        Schema::create('taxImport', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 10)->index()->comment('人员姓名');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            /*
             * income               累计收入额
             * deduct_expenses      累减除费用
             * special_deduction    累计专项扣
             * tax_child            累专附子女
             * tax_old              累专附老人
             * tax_edu              累专附继教
             * tax_loan             累专附房利
             * tax_rent             累专附房租
             * tax_other_deduct     累其他扣除
             * deduct_donate        累计扣捐赠
             * tax_income           累税所得额
             * taxrate              税率(%)
             * quick_deduction      速算扣除数
             * taxable              累计应纳税
             * tax_reliefs          累计减免税
             * should_deducted_tax  累计应扣税
             * have_deducted_tax    累计已扣税
             * have_deducted_tax    累计应补税
             */
            $table->float('income')->default(0)->comment('累计收入额');
            $table->float('deduct_expenses')->default(0)->comment('累减除费用');
            $table->float('special_deduction')->default(0)->comment('累计专项扣');
            $table->float('tax_child')->default(0)->comment('累专附子女');
            $table->float('tax_old')->default(0)->comment('累专附老人');
            $table->float('tax_edu')->default(0)->comment('累专附继教');
            $table->float('tax_loan')->default(0)->comment('累专附房利');
            $table->float('tax_rent')->default(0)->comment('累专附房租');
            $table->float('tax_other_deduct')->default(0)->comment('累其他扣除');
            $table->float('deduct_donate')->default(0)->comment('累计扣捐赠');
            $table->float('tax_income')->default(0)->comment('累税所得额');
            $table->float('taxrate')->default(0)->comment('税率');
            $table->float('quick_deduction')->default(0)->comment('速算扣除数');
            $table->float('taxable')->default(0)->comment('累计应纳税');
            $table->float('tax_reliefs')->default(0)->comment('累计减免税');
            $table->float('should_deducted_tax')->default(0)->comment('累计应扣税');
            $table->float('have_deducted_tax')->default(0)->comment('累计已扣税');
            $table->float('should_be_tax')->default(0)->comment('累计应补税');

            $table->timestamps();
            $table->unsignedInteger('user_id')->index()->comment('上传人员ID');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });

        //todo: 扣除表

        // 薪酬日志
        Schema::create('salaryLog', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index()->comment('用户ID');
            $table->string('content')->default('')->comment('薪酬变更日志');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
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

        Schema::table('wage', function(Blueprint $table){
            $table->dropForeign('wage_user_id_foreign');
        });
        Schema::dropIfExists('wage');

        Schema::table('bonus', function(Blueprint $table){
            $table->dropForeign('bonus_user_id_foreign');
            $table->dropForeign('bonus_type_id_foreign');
        });
        Schema::dropIfExists('bonus');
        Schema::dropIfExists('bonus_types');

        Schema::table('property', function(Blueprint $table){
            $table->dropForeign('property_user_id_foreign');
        });
        Schema::dropIfExists('property');

        Schema::table('deductions', function(Blueprint $table){
            $table->dropForeign('deductions_user_id_foreign');
            $table->dropForeign('deductions_type_id_foreign');
        });
        Schema::dropIfExists('deductions');
        Schema::dropIfExists('deductions_types');

        Schema::table('otherSalary', function(Blueprint $table){
            $table->dropForeign('otherSalary_user_id_foreign');
            $table->dropForeign('otherSalary_type_id_foreign');
        });
        Schema::dropIfExists('otherSalary');
        Schema::dropIfExists('other_types');

        Schema::table('insurances', function (Blueprint $table){
            $table->dropForeign('insurances_user_id_foreign');
        });
        Schema::dropIfExists('insurances');

        Schema::table('subsidy', function (Blueprint $table){
                    $table->dropForeign('subsidy_user_id_foreign');
                });
        Schema::dropIfExists('subsidy');

        Schema::table('taxImport', function(Blueprint $table){
            $table->dropForeign('taxImport_user_id_foreign');
        });
        Schema::dropIfExists('taxImport');


        Schema::table('salaryLog', function(Blueprint $table){
            $table->dropForeign('salaryLog_user_id_foreign');
        });
        Schema::dropIfExists('salaryLog');
    }
}
