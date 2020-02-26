<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name')->comment('名称');
            $table->string('subject_no', 64)->comment('科目编码');
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
            $table->decimal('wage', 14, 2)->default(0)->comment('岗位工资');
            $table->decimal('retained_wage', 14, 2)->default(0)->comment('保留工资');
            $table->decimal('compensation', 14, 2)->default(0)->comment('套级补差');
            $table->decimal('night_shift', 14, 2)->default(0)->comment('中夜班费');
            $table->decimal('overtime_wage', 14, 2)->default(0)->comment('加班工资');
            $table->decimal('seniority_wage', 14, 2)->default(0)->comment('年功工资');
            $table->decimal('jbylj', 14, 2)->default(0)->comment('基本养老金');
            $table->decimal('zj', 14, 2)->default(0)->comment('增机');
            $table->decimal('gjxj', 14, 2)->default(0)->comment('国家小计');
            $table->decimal('dfxj', 14, 2)->default(0)->comment('地方小计');
            $table->decimal('hyxj', 14, 2)->default(0)->comment('行业小计');
            $table->decimal('qydzf', 14, 2)->default(0)->comment('企业独子费');
            $table->decimal('qyxj', 14, 2)->default(0)->comment('企业小计');
            $table->decimal('ltxbc', 14, 2)->default(0)->comment('离退休补充');
            $table->decimal('wage_total', 14, 2)->default(0)->comment('应发工资');
            $table->decimal('month_bonus', 14, 2)->default(0)->comment('月奖');
            $table->decimal('communication', 14, 2)->default(0)->comment('通讯补贴');
            $table->decimal('traffic', 14, 2)->default(0)->comment('交通费');
            $table->decimal('housing', 14, 2)->default(0)->comment('住房补贴');
            $table->decimal('single', 14, 2)->default(0)->comment('独子费');
            $table->decimal('reissue_wage', 14, 2)->default(0)->comment('补发工资');
            $table->decimal('reissue_subsidy', 14, 2)->default(0)->comment('补发补贴');
            $table->decimal('reissue_other', 14, 2)->default(0)->comment('补发其他');
            $table->decimal('reissue_total', 14, 2)->default(0)->comment('补发合计');
            $table->decimal('gjj_person', 14, 2)->default(0)->comment('公积金个人');
            $table->decimal('gjj_enterprise', 14, 2)->default(0)->comment('公积企业缴');
            $table->decimal('annuity_person', 14, 2)->default(0)->comment('年金个人');
            $table->decimal('annuity_enterprise', 14, 2)->default(0)->comment('年金企业缴');
            $table->decimal('retire_person', 14, 2)->default(0)->comment('退养金个人');
            $table->decimal('retire_enterprise', 14, 2)->default(0)->comment('退养企业缴');
            $table->decimal('medical_person', 14, 2)->default(0)->comment('医保金个人');
            $table->decimal('medical_enterprise', 14, 2)->default(0)->comment('医疗企业缴');
            $table->decimal('unemployment_person', 14, 2)->default(0)->comment('失业金个人');
            $table->decimal('unemployment_enterprise', 14, 2)->default(0)->comment('失业企业缴');
            $table->decimal('injury_enterprise', 14, 2)->default(0)->comment('工伤企业缴');
            $table->decimal('birth_enterprise', 14, 2)->default(0)->comment('生育企业缴');
            $table->decimal('cc_water', 14, 2)->default(0)->comment('成钞水费');
            $table->decimal('cc_electric', 14, 2)->default(0)->comment('成钞电费');
            $table->decimal('xy_water', 14, 2)->default(0)->comment('鑫源水费');
            $table->decimal('xy_electric', 14, 2)->default(0)->comment('鑫源电费');
            $table->decimal('garage_water', 14, 2)->default(0)->comment('车库水费');
            $table->decimal('garage_electric', 14, 2)->default(0)->comment('车库电费');
            $table->decimal('back_water', 14, 2)->default(0)->comment('退补水费');
            $table->decimal('back_electric', 14, 2)->default(0)->comment('退补电费');
            $table->decimal('water_electric', 14, 2)->default(0)->comment('水电');
            $table->decimal('property_fee', 14, 2)->default(0)->comment('物管费');
            $table->decimal('union_deduction', 14, 2)->default(0)->comment('扣工会会费');
            $table->decimal('car_fee', 14, 2)->default(0)->comment('公车费用');
            $table->decimal('fixed_deduction', 14, 2)->default(0)->comment('固定扣款');
            $table->decimal('temp_deduction', 14, 2)->default(0)->comment('临时扣款');
            $table->decimal('other_deduction', 14, 2)->default(0)->comment('其他扣款');
            $table->decimal('prior_deduction', 14, 2)->default(0)->comment('上期余欠款');
            $table->decimal('had_debt', 14, 2)->default(0)->comment('已销欠款');
            $table->decimal('debt', 14, 2)->default(0)->comment('扣欠款');
            $table->decimal('tax_diff', 14, 2)->default(0)->comment('税差');
            $table->decimal('personal_tax', 14, 2)->default(0)->comment('个人所得税');
            $table->decimal('instead_salary', 14, 2)->default(0)->comment('代汇');
            $table->decimal('bank_salary', 14, 2)->default(0)->comment('银行发放');
            $table->decimal('debt_salary', 14, 2)->default(0)->comment('余欠款');
            $table->decimal('court_salary', 14, 2)->default(0)->comment('法院转提');
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
