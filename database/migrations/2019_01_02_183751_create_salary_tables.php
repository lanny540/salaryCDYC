<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // 上传日志表.记录上传人员ID，文件地址，以及上传的类型（是根据角色来确定的，故等于角色ID）
        Schema::create('salary_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->integer('user_id')->comment('上传人员ID');
            $table->integer('upload_type')->default(0)->comment('上传数据的类型， 等于角色ID');
            $table->string('upload_file')->default('')->comment('上传文件路径');
            $table->timestamps();
        });
        // 合计表
        Schema::create('summary', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->decimal('wage_total', 14, 2)->default(0)->comment('应发工资');
            $table->decimal('bonus_total', 14, 2)->default(0)->comment('奖金合计');
            $table->decimal('subsidy_total', 14, 2)->default(0)->comment('补贴合计');
            $table->decimal('reissue_total', 14, 2)->default(0)->comment('补发合计');
            $table->decimal('enterprise_out_total', 14, 2)->default(0)->comment('企业超合计');
            $table->decimal('should_total', 14, 2)->default(0)->comment('应发合计=应发工资+应发辞退+应发内退+补贴合计+补发合计');
            $table->decimal('salary_total', 14, 2)->default(0)->comment('工资薪金=应发合计+奖金合计+企业超合计');
        });
        // 工资表
        Schema::create('wage', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->decimal('annual_standard', 14, 2)->default(0.00)->comment('年薪工资标');
            $table->decimal('wage_standard', 14, 2)->default(0.00)->comment('岗位工资标');
            $table->decimal('wage_daily', 14, 2)->default(0.00)->comment('岗位工资日');
            $table->decimal('sick_sub', 14, 2)->default(0.00)->comment('扣岗位工病');
            $table->decimal('leave_sub', 14, 2)->default(0.00)->comment('扣岗位工事');
            $table->decimal('baby_sub', 14, 2)->default(0.00)->comment('扣岗位工婴');
            $table->decimal('annual', 14, 2)->default(0.00)->comment('年薪工资=年薪工资标-扣岗位工病-扣岗位工事-扣岗位工婴');
            $table->decimal('wage', 14, 2)->default(0.00)->comment('岗位工资=岗位工资标-扣岗位工病-扣岗位工事-扣岗位工婴');
            $table->decimal('retained_wage', 14, 2)->default(0.00)->comment('保留工资');
            $table->decimal('compensation', 14, 2)->default(0.00)->comment('套级补差');
            $table->decimal('night_shift', 14, 2)->default(0.00)->comment('中夜班费');
            $table->decimal('overtime_wage', 14, 2)->default(0.00)->comment('加班工资');
            $table->decimal('seniority_wage', 14, 2)->default(0.00)->comment('年功工资');
            $table->decimal('lggw', 14, 2)->default(0.00)->comment('离岗岗位');
            $table->decimal('lgbl', 14, 2)->default(0.00)->comment('离岗保留');
            $table->decimal('lgzj', 14, 2)->default(0.00)->comment('离岗增加');
            $table->decimal('lgng', 14, 2)->default(0.00)->comment('离岗年功');
            $table->decimal('jbylj', 14, 2)->default(0.00)->comment('基本养老金.1、离岗休养人员，基本养老金=离岗岗位+离岗保留+离岗增加+离岗年功;2、其他退休人员，基本养老金直接取数');
            $table->decimal('zj', 14, 2)->default(0.00)->comment('增机');
            $table->decimal('gjbt', 14, 2)->default(0.00)->comment('国家补贴');
            $table->decimal('gjsh', 14, 2)->default(0.00)->comment('国家生活');
            $table->decimal('gjxj', 14, 2)->default(0.00)->comment('国家小计=国家补贴+国家生活');
            $table->decimal('dflc', 14, 2)->default(0.00)->comment('地方粮差');
            $table->decimal('dfqt', 14, 2)->default(0.00)->comment('地方其他');
            $table->decimal('dfwb', 14, 2)->default(0.00)->comment('地方物补');
            $table->decimal('dfsh', 14, 2)->default(0.00)->comment('地方生活');
            $table->decimal('dfxj', 14, 2)->default(0.00)->comment('地方小计=地方粮差+地方其他+地方物补+地方生活');
            $table->decimal('hygl', 14, 2)->default(0.00)->comment('行业工龄');
            $table->decimal('hytb', 14, 2)->default(0.00)->comment('行业退补');
            $table->decimal('hyqt', 14, 2)->default(0.00)->comment('行业其他');
            $table->decimal('hyxj', 14, 2)->default(0.00)->comment('行业小计=行业工龄+行业退补+行业其他');
            $table->decimal('tcxj', 14, 2)->default(0.00)->comment('统筹小计=基本养老金+增机+国家小计+地方小计+行业小计');
            $table->decimal('qylc', 14, 2)->default(0.00)->comment('企业粮差');
            $table->decimal('qygl', 14, 2)->default(0.00)->comment('企业工龄');
            $table->decimal('qysb', 14, 2)->default(0.00)->comment('企业书报');
            $table->decimal('qysd', 14, 2)->default(0.00)->comment('企业水电');
            $table->decimal('qysh', 14, 2)->default(0.00)->comment('企业生活');
            $table->decimal('qydzf', 14, 2)->default(0.00)->comment('企业独子费');
            $table->decimal('qyhlf', 14, 2)->default(0.00)->comment('企业护理费');
            $table->decimal('qytxf', 14, 2)->default(0.00)->comment('企业通讯费');
            $table->decimal('qygfz', 14, 2)->default(0.00)->comment('企业规范增');
            $table->decimal('qygl2', 14, 2)->default(0.00)->comment('企业工龄02');
            $table->decimal('qyntb', 14, 2)->default(0.00)->comment('企业内退补');
            $table->decimal('qybf', 14, 2)->default(0.00)->comment('企业补发');
            $table->decimal('qyxj', 14, 2)->default(0.00)->comment('企业小计=企业粮差+企业工龄+企业书报+企业水电+企业生活+企业独子费+企业护理费+企业工龄02+企业通讯费+企业内退补+企业规范增+企业补发');
            $table->decimal('ltxbc', 14, 2)->default(0.00)->comment('离退休补充');
            $table->decimal('bc', 14, 2)->default(0.00)->comment('补偿');
            $table->decimal('wage_total', 14, 2)->default(0.00)->comment('应发工资=年薪工资+岗位工资+保留工资+套级补差+中夜班费+加班工资+年功工资+基本养老金+增机+国家小计+地方小计+行业小计+企业小计+离退休补充+补偿');
            $table->decimal('yfct', 14, 2)->default(0.00)->comment('应发辞退.如果dwdm="01020201",应发辞退=应发工资,应发工资=0');
            $table->decimal('yfnt', 14, 2)->default(0.00)->comment('应发内退.如果dwdm="01020202",应发辞退=应发工资,应发工资=0');
        });
        // 奖金表
        Schema::create('bonus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->decimal('month_bonus', 14, 2)->default(0.00)->comment('月奖');
            $table->decimal('special', 14, 2)->default(0.00)->comment('专项奖');
            $table->decimal('competition', 14, 2)->default(0.00)->comment('劳动竞赛');
            $table->decimal('class_reward', 14, 2)->default(0.00)->comment('课酬');
            $table->decimal('holiday', 14, 2)->default(0.00)->comment('节日慰问费');
            $table->decimal('party_reward', 14, 2)->default(0.00)->comment('党员奖励');
            $table->decimal('union_paying', 14, 2)->default(0.00)->comment('工会发放');
            $table->decimal('other_reward', 14, 2)->default(0.00)->comment('其他奖励');
            $table->decimal('bonus_total', 14, 2)->default(0.00)->comment('奖金合计=月奖+工会发放+专项奖+课酬+劳动竞赛+节日慰问费+党员奖励+其他奖励');
        });
        // 其他费用表（稿酬、特许使用权、劳务报酬）
        Schema::create('other', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->decimal('finance_article', 14, 2)->default(0.00)->comment('财务发稿酬');
            $table->decimal('union_article', 14, 2)->default(0.00)->comment('工会发稿酬');
            $table->decimal('article_fee', 14, 2)->default(0.00)->comment('稿酬=财务发稿酬+工会发稿酬');
            $table->decimal('article_add_tax', 14, 2)->default(0.00)->comment('稿酬应补税');
            $table->decimal('article_sub_tax', 14, 2)->default(0.00)->comment('稿酬减免税');
            $table->decimal('franchise', 14, 2)->default(0.00)->comment('特许使用权');
            $table->decimal('franchise_add_tax', 14, 2)->default(0.00)->comment('特权应补税');
            $table->decimal('franchise_sub_tax', 14, 2)->default(0.00)->comment('特权减免税');
        });
        // 社保表
        Schema::create('insurances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->decimal('gjj_classic', 14, 2)->default(0.00)->comment('公积金标准');
            $table->decimal('gjj_add', 14, 2)->default(0.00)->comment('公积金补扣');
            $table->decimal('gjj_person', 14, 2)->default(0.00)->comment('公积金个人=标准+补扣');
            $table->decimal('gjj_deduction', 14, 2)->default(0.00)->comment('公积金扣除');
            $table->decimal('gjj_enterprise', 14, 2)->default(0.00)->comment('公积企业缴');
            $table->decimal('gjj_out_range', 14, 2)->default(0.00)->comment('公积企超标');

            $table->decimal('annuity_classic', 14, 2)->default(0.00)->comment('年金标准');
            $table->decimal('annuity_add', 14, 2)->default(0.00)->comment('年金补扣');
            $table->decimal('annuity_person', 14, 2)->default(0.00)->comment('年金个人');
            $table->decimal('annuity_deduction', 14, 2)->default(0.00)->comment('年金扣除');
            $table->decimal('annuity_enterprise', 14, 2)->default(0.00)->comment('年金企业缴');
            $table->decimal('annuity_out_range', 14, 2)->default(0.00)->comment('年金企超标');

            $table->decimal('retire_classic', 14, 2)->default(0.00)->comment('退养金标准');
            $table->decimal('retire_add', 14, 2)->default(0.00)->comment('退养金补扣');
            $table->decimal('retire_person', 14, 2)->default(0.00)->comment('退养金个人');
            $table->decimal('retire_deduction', 14, 2)->default(0.00)->comment('退养金扣除');
            $table->decimal('retire_enterprise', 14, 2)->default(0.00)->comment('退养企业缴');
            $table->decimal('retire_out_range', 14, 2)->default(0.00)->comment('退养企超标');

            $table->decimal('medical_classic', 14, 2)->default(0.00)->comment('医保金标准');
            $table->decimal('medical_add', 14, 2)->default(0.00)->comment('医保金补扣');
            $table->decimal('medical_person', 14, 2)->default(0.00)->comment('医保金个人');
            $table->decimal('medical_deduction', 14, 2)->default(0.00)->comment('医保金扣除');
            $table->decimal('medical_enterprise', 14, 2)->default(0.00)->comment('医保企业缴');
            $table->decimal('medical_out_range', 14, 2)->default(0.00)->comment('医保企超标');

            $table->decimal('unemployment_classic', 14, 2)->default(0.00)->comment('失业金标准');
            $table->decimal('unemployment_add', 14, 2)->default(0.00)->comment('失业金补扣');
            $table->decimal('unemployment_person', 14, 2)->default(0.00)->comment('失业金个人');
            $table->decimal('unemployment_deduction', 14, 2)->default(0.00)->comment('失业金扣除');
            $table->decimal('unemployment_enterprise', 14, 2)->default(0.00)->comment('失业企业缴');
            $table->decimal('unemployment_out_range', 14, 2)->default(0.00)->comment('失业企超标');

            $table->decimal('injury_enterprise', 14, 2)->default(0.00)->comment('工伤企业缴');
            $table->decimal('birth_enterprise', 14, 2)->default(0.00)->comment('生育企业缴');

            $table->decimal('enterprise_out_total', 14, 2)->default(0.00)->comment('企业超合计=公积企超标+失业企超标+医保企超标+年金企超标+退养企超标');
            $table->decimal('specail_deduction', 14, 2)->default(0.00)->comment('专项扣除=退养金扣除+医保金扣除+失业金扣除+公积金扣除');
        });
        // 补贴表
        Schema::create('subsidy', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->decimal('communication', 14, 2)->default(0.00)->comment('通讯补贴');
            $table->decimal('housing', 14, 2)->default(0.00)->comment('住房补贴');
            $table->decimal('traffic_standard', 14, 2)->default(0.00)->comment('交通补贴标');
            $table->decimal('traffic_add', 14, 2)->default(0.00)->comment('交通补贴考');
            $table->decimal('traffic', 14, 2)->default(0.00)->comment('交通费=交通补贴标+交通补贴考');
            $table->decimal('single_standard', 14, 2)->default(0.00)->comment('独子费标准');
            $table->decimal('single_add', 14, 2)->default(0.00)->comment('独子费补发');
            $table->decimal('single', 14, 2)->default(0.00)->comment('独子费=独子费标准+独子费补发');
            $table->decimal('subsidy_total', 14, 2)->default(0.00)->comment('补贴合计=交通费+住房补贴+独子费');
        });
        // 补发表
        Schema::create('reissue', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->decimal('reissue_wage', 14, 2)->default(0.00)->comment('补发工资');
            $table->decimal('reissue_subsidy', 14, 2)->default(0.00)->comment('补发补贴');
            $table->decimal('reissue_other', 14, 2)->default(0.00)->comment('补发其他');
            $table->decimal('reissue_total', 14, 2)->default(0.00)->comment('补发合计=补发工资+补发补贴+补发其他');
        });
        // 扣款表
        Schema::create('deduction', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->decimal('garage_water', 14, 2)->default(0.00)->comment('车库水费');
            $table->decimal('garage_electric', 14, 2)->default(0.00)->comment('车库电费');
            $table->decimal('garage_property', 14, 2)->default(0.00)->comment('车库物管');
            $table->decimal('cc_water', 14, 2)->default(0.00)->comment('成钞水费');
            $table->decimal('cc_electric', 14, 2)->default(0.00)->comment('成钞电费');
            $table->decimal('cc_property', 14, 2)->default(0.00)->comment('成钞物管');
            $table->decimal('xy_water', 14, 2)->default(0.00)->comment('鑫源水费');
            $table->decimal('xy_electric', 14, 2)->default(0.00)->comment('鑫源电费');
            $table->decimal('xy_property', 14, 2)->default(0.00)->comment('鑫源物管');
            $table->decimal('back_water', 14, 2)->default(0.00)->comment('退补水费');
            $table->decimal('back_electric', 14, 2)->default(0.00)->comment('退补电费');
            $table->decimal('back_property', 14, 2)->default(0.00)->comment('退补物管费');
            $table->decimal('water_electric', 14, 2)->default(0.00)->comment('水电');
            $table->decimal('property_fee', 14, 2)->default(0.00)->comment('物管费');

            $table->decimal('car_fee', 14, 2)->default(0.00)->comment('公车费用');
            $table->decimal('car_deduction', 14, 2)->default(0.00)->comment('公车补扣除');
            $table->string('car_deduction_comment')->default('')->comment('公车扣备注');
            $table->decimal('rest_deduction', 14, 2)->default(0.00)->comment('它项扣除');
            $table->string('rest_deduction_comment')->default('')->comment('它项扣备注');
            $table->decimal('sum_deduction', 14, 2)->default(0.00)->comment('其他扣除=公车补扣除+它项扣除');
            $table->decimal('fixed_deduction', 14, 2)->default(0.00)->comment('固定扣款');
            $table->decimal('other_deduction', 14, 2)->default(0.00)->comment('其他扣款');
            $table->decimal('temp_deduction', 14, 2)->default(0.00)->comment('临时扣款');
            $table->decimal('union_deduction', 14, 2)->default(0.00)->comment('扣工会会费');
            $table->decimal('prior_deduction', 14, 2)->default(0.00)->comment('上期余欠款');
            $table->decimal('had_debt', 14, 2)->default(0.00)->comment('已销欠款');
            $table->decimal('debt', 14, 2)->default(0.00)->comment('扣欠款');
            $table->decimal('donate', 14, 2)->default(0.00)->comment('捐赠');
        });
        // 专项税务表
        Schema::create('taxImport', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->decimal('income', 14, 2)->default(0.00)->comment('累计收入额');
            $table->decimal('deduct_expenses', 14, 2)->default(0.00)->comment('累减除费用');
            $table->decimal('special_deduction', 14, 2)->default(0.00)->comment('累计专项扣');
            $table->decimal('tax_child', 14, 2)->default(0.00)->comment('累专附子女');
            $table->decimal('tax_old', 14, 2)->default(0.00)->comment('累专附老人');
            $table->decimal('tax_edu', 14, 2)->default(0.00)->comment('累专附继教');
            $table->decimal('tax_loan', 14, 2)->default(0.00)->comment('累专附房利');
            $table->decimal('tax_rent', 14, 2)->default(0.00)->comment('累专附房租');
            $table->decimal('tax_other_deduct', 14, 2)->default(0.00)->comment('累其他扣除');
            $table->decimal('deduct_donate', 14, 2)->default(0.00)->comment('累计扣捐赠');
            $table->decimal('tax_income', 14, 2)->default(0.00)->comment('累税所得额');
            $table->decimal('taxrate', 14, 2)->default(0.00)->comment('税率');
            $table->decimal('quick_deduction', 14, 2)->default(0.00)->comment('速算扣除数');
            $table->decimal('taxable', 14, 2)->default(0.00)->comment('累计应纳税');
            $table->decimal('tax_reliefs', 14, 2)->default(0.00)->comment('累计减免税');
            $table->decimal('should_deducted_tax', 14, 2)->default(0.00)->comment('累计应扣税');
            $table->decimal('have_deducted_tax', 14, 2)->default(0.00)->comment('累计申扣税');
            $table->decimal('should_be_tax', 14, 2)->default(0.00)->comment('累计应补税');
            $table->decimal('reduce_tax', 14, 2)->default(0.00)->comment('减免个税');
            $table->decimal('personal_tax', 14, 2)->default(0.00)->comment('个人所得税');
            $table->decimal('prior_had_deducted_tax', 14, 2)->default(0.00)->comment('上月已扣税');
            $table->decimal('declare_tax_salary', 14, 2)->default(0.00)->comment('薪金申报个税');
            $table->decimal('declare_tax_article', 14, 2)->default(0.00)->comment('稿酬申报个税');
            $table->decimal('declare_tax_franchise', 14, 2)->default(0.00)->comment('特权申报个税');
            $table->decimal('declare_tax', 14, 2)->default(0.00)->comment('申报个税');
            $table->decimal('tax_diff', 14, 2)->default(0.00)->comment('税差');
        });
        // 特殊薪酬表
        Schema::create('special', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->decimal('actual_salary', 14, 2)->default(0)->comment('实发工资');
            $table->decimal('debt_salary', 14, 2)->default(0)->comment('余欠款');
            $table->decimal('instead_salary', 14, 2)->default(0)->comment('代汇');
            $table->decimal('bank_salary', 14, 2)->default(0)->comment('银行发放');
            $table->decimal('court_salary', 14, 2)->default(0)->comment('法院转提');
        });
        // 新增表.如果以后需要读取更多的列，则从此表读取
        Schema::create('extra', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->decimal('extra_column1', 14, 2)->default(0);
            $table->decimal('extra_column2', 14, 2)->default(0);
            $table->decimal('extra_column3', 14, 2)->default(0);
            $table->decimal('extra_column4', 14, 2)->default(0);
            $table->decimal('extra_column5', 14, 2)->default(0);
            $table->decimal('extra_column6', 14, 2)->default(0);
            $table->decimal('extra_column7', 14, 2)->default(0);
            $table->decimal('extra_column8', 14, 2)->default(0);
            $table->decimal('extra_column9', 14, 2)->default(0);
            $table->decimal('extra_column10', 14, 2)->default(0);
            $table->decimal('extra_column11', 14, 2)->default(0);
            $table->decimal('extra_column12', 14, 2)->default(0);
            $table->decimal('extra_column13', 14, 2)->default(0);
            $table->decimal('extra_column14', 14, 2)->default(0);
            $table->decimal('extra_column15', 14, 2)->default(0);
            $table->decimal('extra_column16', 14, 2)->default(0);
            $table->decimal('extra_column17', 14, 2)->default(0);
            $table->decimal('extra_column18', 14, 2)->default(0);
            $table->decimal('extra_column19', 14, 2)->default(0);
            $table->decimal('extra_column20', 14, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::dropIfExists('salary_log');
        Schema::dropIfExists('summary');
        Schema::dropIfExists('wage');
        Schema::dropIfExists('bonus');
        Schema::dropIfExists('other');
        Schema::dropIfExists('insurances');
        Schema::dropIfExists('subsidy');
        Schema::dropIfExists('reissue');
        Schema::dropIfExists('deduction');
        Schema::dropIfExists('taxImport');
        Schema::dropIfExists('special');
        Schema::dropIfExists('extra');
    }
}
