<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticsTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('period_id')->default(0)->comment('会计期ID');
            $table->string('username', 10)->index()->comment('人员姓名');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->string('publish', 24)->comment('发放时间');

            // 工资部分
            $table->float('annual')->default(0)->comment('年薪工资');
            $table->float('post_wage')->default(0)->comment('岗位工资');
            $table->float('retained_wage')->default(0)->comment('保留工资');
            $table->float('compensation')->default(0)->comment('套级补差');
            $table->float('night_shift')->default(0)->comment('中夜班费');
            $table->float('overtime_wage')->default(0)->comment('加班工资');
            $table->float('seniority_wage')->default(0)->comment('年功工资');
            $table->float('total_wage')->default(0)->comment('应发工资');   // 工资合计
            // 奖金部分bonus
            $table->float('bonus')->default(0)->comment('月奖');
            $table->float('special_bonus')->default(0)->comment('专项奖');
            $table->float('labor_bonus')->default(0)->comment('劳动竞赛');
            $table->float('course_bonus')->default(0)->comment('课酬');
            $table->float('festival_bonus')->default(0)->comment('节日慰问费');
            $table->float('party_bonus')->default(0)->comment('党员奖励');
            $table->float('union_bonus')->default(0)->comment('工会发放');
            $table->float('other_bonus')->default(0)->comment('其他奖励');
            $table->float('total_bonus')->default(0)->comment('奖金合计');   // 奖金合计
            // 社保部分
            $table->float('gjj_deduction')->default(0)->comment('公积金补扣');
            $table->float('gjj_person')->default(0)->comment('公积金个人');
            $table->float('gjj_enterprise')->default(0)->comment('公积企业缴');
            $table->float('annuity_deduction')->default(0)->comment('年金补扣');
            $table->float('annuity_person')->default(0)->comment('年金个人');
            $table->float('annuity_enterprise')->default(0)->comment('年金企业缴');
            $table->float('retire_deduction')->default(0)->comment('退养金补扣');
            $table->float('retire_person')->default(0)->comment('退养金个人');
            $table->float('retire_enterprise')->default(0)->comment('退养企业缴');
            $table->float('medical_deduction')->default(0)->comment('医保金补扣');
            $table->float('medical_person')->default(0)->comment('医保金个人');
            $table->float('medical_enterprise')->default(0)->comment('医疗企业缴');
            $table->float('unemployment_deduction')->default(0)->comment('失业金补扣');
            $table->float('unemployment_person')->default(0)->comment('失业金个人');
            $table->float('unemployment_enterprise')->default(0)->comment('失业企业缴');
            $table->float('injury_enterprise')->default(0)->comment('工伤企业缴');
            $table->float('birth_enterprise')->default(0)->comment('生育企业缴');
            // 补贴部分
            $table->float('communication')->default(0)->comment('通讯补贴');
            $table->float('traffic')->default(0)->comment('交通费');
            $table->float('housing')->default(0)->comment('住房补贴');
            $table->float('single')->default(0)->comment('独子费');
            $table->float('subsidy')->default(0)->comment('补贴合计');  // 补贴合计
            // 扣除部分
            $table->float('property')->default(0)->comment('扣水电物管');
            $table->float('deduction')->default(0)->comment('扣欠款');
            $table->float('union_deduction')->default(0)->comment('扣工会会费');
            $table->float('total_deduction')->default(0)->comment('扣款合计');  // 扣款合计
            // 其他费用部分
            $table->float('remuneration')->default(0)->comment('稿酬');
            $table->float('labor')->default(0)->comment('劳务报酬');
            $table->float('franchise')->default(0)->comment('特许权费用');
            // 专项税务部分
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
            // 收入合计
            $table->float('total_income')->default(0)->comment('收入合计');  // 收入合计
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('statistics');
    }
}
