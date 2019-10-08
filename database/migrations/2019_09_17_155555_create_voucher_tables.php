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
            $table->string('name', 50)->comment('部门名称');
            $table->integer('sum_number')->comment('人数');
            /*
             * 工资
             * 岗位工资、保留工资、套级补差、中夜班费、加班工资、年功工资、基本养老金、增机、国家小计、地方小计、行业小计、企业独子费、企业小计、离退休补充、应发工资
             */
            $table->float('wage')->default(0)->comment('岗位工资');
            $table->float('retained_wage')->default(0)->comment('保留工资');
            $table->float('compensation')->default(0)->comment('套级补差');
            $table->float('night_shift')->default(0)->comment('中夜班费');
            $table->float('overtime_wage')->default(0)->comment('加班工资');
            $table->float('seniority_wage')->default(0)->comment('年功工资');
            $table->float('jbylj')->default(0)->comment('基本养老金');
            $table->float('zj')->default(0)->comment('增机');
            $table->float('gjxj')->default(0)->comment('国家小计');
            $table->float('dfxj')->default(0)->comment('地方小计');
            $table->float('hyxj')->default(0)->comment('行业小计');
            $table->float('qydzf')->default(0)->comment('企业独子费');
            $table->float('qyxj')->default(0)->comment('企业小计');
            $table->float('ltxbc')->default(0)->comment('离退休补充');
            $table->float('wage_total')->default(0)->comment('应发工资');
            /*
             * 奖金
             * 月奖
             */
            $table->float('month_bonus')->default(0)->comment('月奖');
            /*
             * 补贴
             * 通讯补贴、交通费、住房补贴、独子费
             */
            $table->float('communication')->default(0)->comment('通讯补贴');
            $table->float('traffic')->default(0)->comment('交通费');
            $table->float('housing')->default(0)->comment('住房补贴');
            $table->float('single')->default(0)->comment('独子费');
            /*
             * 补发
             * 补发工资、补发补贴、补发其他、补发合计
             */
            $table->float('reissue_wage')->default(0)->comment('补发工资');
            $table->float('reissue_subsidy')->default(0)->comment('补发补贴');
            $table->float('reissue_other')->default(0)->comment('补发其他');
            $table->float('reissue_total')->default(0)->comment('补发合计');
            /*
             * 社保
             * 公积金个人、公积企业缴、年金个人、年金企业缴、退养金个人、退养企业缴、医保金个人、医疗企业缴、失业金个人、失业企业缴、工伤企业缴、生育企业缴
             */
            $table->float('gjj_person')->default(0)->comment('公积金个人');
            $table->float('gjj_enterprise')->default(0)->comment('公积企业缴');
            $table->float('annuity_person')->default(0)->comment('年金个人');
            $table->float('annuity_enterprise')->default(0)->comment('年金企业缴');
            $table->float('retire_person')->default(0)->comment('退养金个人');
            $table->float('retire_enterprise')->default(0)->comment('退养企业缴');
            $table->float('medical_person')->default(0)->comment('医保金个人');
            $table->float('medical_enterprise')->default(0)->comment('医疗企业缴');
            $table->float('unemployment_person')->default(0)->comment('失业金个人');
            $table->float('unemployment_enterprise')->default(0)->comment('失业企业缴');
            $table->float('injury_enterprise')->default(0)->comment('工伤企业缴');
            $table->float('birth_enterprise')->default(0)->comment('生育企业缴');
            /*
             * 扣款
             * 成钞水费、成钞电费、鑫源水费、鑫源电费、车库水费、车库电费、退补水费、退补电费、水电、物管费、扣工会会费、公车费用、
             * 固定扣款、临时扣款、其他扣款、上期余欠款、已销欠款、扣欠款、税差、个人所得税
             */
            $table->float('cc_water')->default(0)->comment('成钞水费');
            $table->float('cc_electric')->default(0)->comment('成钞电费');
            $table->float('xy_water')->default(0)->comment('鑫源水费');
            $table->float('xy_electric')->default(0)->comment('鑫源电费');
            $table->float('garage_water')->default(0)->comment('车库水费');
            $table->float('garage_electric')->default(0)->comment('车库电费');
            $table->float('back_water')->default(0)->comment('退补水费');
            $table->float('back_electric')->default(0)->comment('退补电费');
            $table->float('water_electric')->default(0)->comment('水电');
            $table->float('property_fee')->default(0)->comment('物管费');
            $table->float('union_deduction')->default(0)->comment('扣工会会费');
            $table->float('car_fee')->default(0)->comment('公车费用');
            $table->float('fixed_deduction')->default(0)->comment('固定扣款');
            $table->float('temp_deduction')->default(0)->comment('临时扣款');
            $table->float('other_deduction')->default(0)->comment('其他扣款');
            $table->float('prior_deduction')->default(0)->comment('上期余欠款');
            $table->float('had_debt')->default(0)->comment('已销欠款');
            $table->float('debt')->default(0)->comment('扣欠款');
            $table->float('tax_diff')->default(0)->comment('税差');
            $table->float('personal_tax')->default(0)->comment('个人所得税');
            /*
             * 特殊
             * 代汇、银行发放、余欠款、法院转提
             */
            $table->float('instead_salary')->default(0)->comment('代汇');
            $table->float('bank_salary')->default(0)->comment('银行发放');
            $table->float('debt_salary')->default(0)->comment('余欠款');
            $table->float('court_salary')->default(0)->comment('法院转提');
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
