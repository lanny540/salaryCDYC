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

            $table->float('wage_total')->default(0)->comment('应发工资');
            $table->float('bonus_total')->default(0)->comment('奖金合计');
            $table->float('subsidy_total')->default(0)->comment('补贴合计');
            $table->float('reissue_total')->default(0)->comment('补发合计');
            $table->float('enterprise_out_total')->default(0)->comment('企业超合计');
            $table->float('should_total')->default(0)->comment('应发合计=应发工资+应发辞退+应发内退+补贴合计+补发合计');
            $table->float('salary_total')->default(0)->comment('工资薪金=应发合计+奖金合计+企业超合计');
        });
        // 工资表
        Schema::create('wage', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->float('annual_standard')->default(0)->comment('年薪工资标');
            $table->float('wage_standard')->default(0)->comment('岗位工资标');
            $table->float('wage_daily')->default(0)->comment('岗位工资日');
            $table->float('sick_sub')->default(0)->comment('扣岗位工病');
            $table->float('leave_sub')->default(0)->comment('扣岗位工事');
            $table->float('baby_sub')->default(0)->comment('扣岗位工婴');
            $table->float('annual')->default(0)->comment('年薪工资=年薪工资标-扣岗位工病-扣岗位工事-扣岗位工婴');
            $table->float('wage')->default(0)->comment('岗位工资=岗位工资标-扣岗位工病-扣岗位工事-扣岗位工婴');
            $table->float('retained_wage')->default(0)->comment('保留工资');
            $table->float('compensation')->default(0)->comment('套级补差');
            $table->float('night_shift')->default(0)->comment('中夜班费');
            $table->float('overtime_wage')->default(0)->comment('加班工资');
            $table->float('seniority_wage')->default(0)->comment('年功工资');
            $table->float('lggw')->default(0)->comment('离岗岗位');
            $table->float('lgbl')->default(0)->comment('离岗保留');
            $table->float('lgzj')->default(0)->comment('离岗增加');
            $table->float('lgng')->default(0)->comment('离岗年功');
            $table->float('jbylj')->default(0)->comment('基本养老金.1、离岗休养人员，基本养老金=离岗岗位+离岗保留+离岗增加+离岗年功;2、其他退休人员，基本养老金直接取数');
            $table->float('zj')->default(0)->comment('增机');
            $table->float('gjbt')->default(0)->comment('国家补贴');
            $table->float('gjsh')->default(0)->comment('国家生活');
            $table->float('gjxj')->default(0)->comment('国家小计=国家补贴+国家生活');
            $table->float('dflc')->default(0)->comment('地方粮差');
            $table->float('dfqt')->default(0)->comment('地方其他');
            $table->float('dfwb')->default(0)->comment('地方物补');
            $table->float('dfsh')->default(0)->comment('地方生活');
            $table->float('dfxj')->default(0)->comment('地方小计=地方粮差+地方其他+地方物补+地方生活');
            $table->float('hygl')->default(0)->comment('行业工龄');
            $table->float('hytb')->default(0)->comment('行业退补');
            $table->float('hyqt')->default(0)->comment('行业其他');
            $table->float('hyxj')->default(0)->comment('行业小计=行业工龄+行业退补+行业其他');
            $table->float('tcxj')->default(0)->comment('统筹小计=基本养老金+增机+国家小计+地方小计+行业小计');
            $table->float('qylc')->default(0)->comment('企业粮差');
            $table->float('qygl')->default(0)->comment('企业工龄');
            $table->float('qysb')->default(0)->comment('企业书报');
            $table->float('qysd')->default(0)->comment('企业水电');
            $table->float('qysh')->default(0)->comment('企业生活');
            $table->float('qydzf')->default(0)->comment('企业独子费');
            $table->float('qyhlf')->default(0)->comment('企业护理费');
            $table->float('qytxf')->default(0)->comment('企业通讯费');
            $table->float('qygfz')->default(0)->comment('企业规范增');
            $table->float('qygl2')->default(0)->comment('企业工龄02');
            $table->float('qyntb')->default(0)->comment('企业内退补');
            $table->float('qybf')->default(0)->comment('企业补发');
            $table->float('qyxj')->default(0)->comment('企业小计=企业粮差+企业工龄+企业书报+企业水电+企业生活+企业独子费+企业护理费+企业工龄02+企业通讯费+企业内退补+企业规范增+企业补发');
            $table->float('ltxbc')->default(0)->comment('离退休补充');
            $table->float('bc')->default(0)->comment('补偿');
            $table->float('wage_total')->default(0)->comment('应发工资=年薪工资+岗位工资+保留工资+套级补差+中夜班费+加班工资+年功工资+基本养老金+增机+国家小计+地方小计+行业小计+企业小计+离退休补充+补偿');
            $table->float('yfct')->default(0)->comment('应发辞退.如果dwdm="01020201",应发辞退=应发工资,应发工资=0');
            $table->float('yfnt')->default(0)->comment('应发内退.如果dwdm="01020202",应发辞退=应发工资,应发工资=0');
        });
        // 奖金表
        Schema::create('bonus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->float('month_bonus')->default(0)->comment('月奖');
            $table->float('special')->default(0)->comment('专项奖');
            $table->float('competition')->default(0)->comment('劳动竞赛');
            $table->float('class_reward')->default(0)->comment('课酬');
            $table->float('holiday')->default(0)->comment('节日慰问费');
            $table->float('party_reward')->default(0)->comment('党员奖励');
            $table->float('union_paying')->default(0)->comment('工会发放');
            $table->float('other_reward')->default(0)->comment('其他奖励');
            $table->float('bonus_total')->default(0)->comment('奖金合计=月奖+工会发放+专项奖+课酬+劳动竞赛+节日慰问费+党员奖励+其他奖励');
        });
        // 其他费用表（稿酬、特许使用权、劳务报酬）
        Schema::create('other', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->float('finance_article')->default(0)->comment('财务发稿酬');
            $table->float('union_article')->default(0)->comment('工会发稿酬');
            $table->float('article_fee')->default(0)->comment('稿酬=财务发稿酬+工会发稿酬');
            $table->float('article_add_tax')->default(0)->comment('稿酬应补税');
            $table->float('article_sub_tax')->default(0)->comment('稿酬减免税');
            $table->float('franchise')->default(0)->comment('特许使用权');
            $table->float('franchise_add_tax')->default(0)->comment('特权应补税');
            $table->float('franchise_sub_tax')->default(0)->comment('特权减免税');
        });
        // 社保表
        Schema::create('insurances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->float('gjj_classic')->default(0)->comment('公积金标准');
            $table->float('gjj_add')->default(0)->comment('公积金补扣');
            $table->float('gjj_person')->default(0)->comment('公积金个人=标准+补扣');
            $table->float('gjj_deduction')->default(0)->comment('公积金扣除');
            $table->float('gjj_enterprise')->default(0)->comment('公积企业缴');
            $table->float('gjj_out_range')->default(0)->comment('公积企超标');

            $table->float('annuity_classic')->default(0)->comment('年金标准');
            $table->float('annuity_add')->default(0)->comment('年金补扣');
            $table->float('annuity_person')->default(0)->comment('年金个人');
            $table->float('annuity_deduction')->default(0)->comment('年金扣除');
            $table->float('annuity_enterprise')->default(0)->comment('年金企业缴');
            $table->float('annuity_out_range')->default(0)->comment('年金企超标');

            $table->float('retire_classic')->default(0)->comment('退养金标准');
            $table->float('retire_add')->default(0)->comment('退养金补扣');
            $table->float('retire_person')->default(0)->comment('退养金个人');
            $table->float('retire_deduction')->default(0)->comment('退养金扣除');
            $table->float('retire_enterprise')->default(0)->comment('退养企业缴');
            $table->float('retire_out_range')->default(0)->comment('退养企超标');

            $table->float('medical_classic')->default(0)->comment('医保金标准');
            $table->float('medical_add')->default(0)->comment('医保金补扣');
            $table->float('medical_person')->default(0)->comment('医保金个人');
            $table->float('medical_deduction')->default(0)->comment('医保金扣除');
            $table->float('medical_enterprise')->default(0)->comment('医保企业缴');
            $table->float('medical_out_range')->default(0)->comment('医保企超标');

            $table->float('unemployment_classic')->default(0)->comment('失业金标准');
            $table->float('unemployment_add')->default(0)->comment('失业金补扣');
            $table->float('unemployment_person')->default(0)->comment('失业金个人');
            $table->float('unemployment_deduction')->default(0)->comment('失业金扣除');
            $table->float('unemployment_enterprise')->default(0)->comment('失业企业缴');
            $table->float('unemployment_out_range')->default(0)->comment('失业企超标');

            $table->float('injury_enterprise')->default(0)->comment('工伤企业缴');
            $table->float('birth_enterprise')->default(0)->comment('生育企业缴');

            $table->float('enterprise_out_total')->default(0)->comment('企业超合计=公积企超标+失业企超标+医保企超标+年金企超标+退养企超标');
            $table->float('specail_deduction')->default(0)->comment('专项扣除=退养金扣除+医保金扣除+失业金扣除+公积金扣除');
        });
        // 补贴表
        Schema::create('subsidy', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->float('communication')->default(0)->comment('通讯补贴');
            $table->float('housing')->default(0)->comment('住房补贴');
            $table->float('traffic_standard')->default(0)->comment('交通补贴标');
            $table->float('traffic_add')->default(0)->comment('交通补贴考');
            $table->float('traffic')->default(0)->comment('交通费=交通补贴标+交通补贴考');
            $table->float('single_standard')->default(0)->comment('独子费标准');
            $table->float('single_add')->default(0)->comment('独子费补发');
            $table->float('single')->default(0)->comment('独子费=独子费标准+独子费补发');
            $table->float('subsidy_total')->default(0)->comment('补贴合计=交通费+住房补贴+独子费');
        });
        // 补发表
        Schema::create('reissue', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->float('reissue_wage')->default(0)->comment('补发工资');
            $table->float('reissue_subsidy')->default(0)->comment('补发补贴');
            $table->float('reissue_other')->default(0)->comment('补发其他');
            $table->float('reissue_total')->default(0)->comment('补发合计=补发工资+补发补贴+补发其他');
        });
        // 扣款表
        Schema::create('deduction', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->float('garage_water')->default(0)->comment('车库水费');
            $table->float('garage_electric')->default(0)->comment('车库电费');
            $table->float('garage_property')->default(0)->comment('车库物管');
            $table->float('cc_water')->default(0)->comment('成钞水费');
            $table->float('cc_electric')->default(0)->comment('成钞电费');
            $table->float('cc_property')->default(0)->comment('成钞物管');
            $table->float('xy_water')->default(0)->comment('鑫源水费');
            $table->float('xy_electric')->default(0)->comment('鑫源电费');
            $table->float('xy_property')->default(0)->comment('鑫源物管');
            $table->float('back_water')->default(0)->comment('退补水费');
            $table->float('back_electric')->default(0)->comment('退补电费');
            $table->float('back_property')->default(0)->comment('退补物管费');
            $table->float('water_electric')->default(0)->comment('水电');
            $table->float('property_fee')->default(0)->comment('物管费');

            $table->float('car_fee')->default(0)->comment('公车费用');
            $table->float('car_deduction')->default(0)->comment('公车补扣除');
            $table->string('car_deduction_comment')->default('')->comment('公车扣备注');
            $table->float('rest_deduction')->default(0)->comment('它项扣除');
            $table->string('rest_deduction_comment')->default('')->comment('它项扣备注');
            $table->float('sum_deduction')->default(0)->comment('其他扣除=公车补扣除+它项扣除');
            $table->float('fixed_deduction')->default(0)->comment('固定扣款');
            $table->float('other_deduction')->default(0)->comment('其他扣款');
            $table->float('temp_deduction')->default(0)->comment('临时扣款');
            $table->float('union_deduction')->default(0)->comment('扣工会会费');
            $table->float('prior_deduction')->default(0)->comment('上期余欠款');
            $table->float('had_debt')->default(0)->comment('已销欠款');
            $table->float('debt')->default(0)->comment('扣欠款');
            $table->float('donate')->default(0)->comment('捐赠');
        });
        // 专项税务表
        Schema::create('taxImport', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

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
            $table->float('have_deducted_tax')->default(0)->comment('累计申扣税');
            $table->float('should_be_tax')->default(0)->comment('累计应补税');
            $table->float('reduce_tax')->default(0)->comment('减免个税');
            $table->float('personal_tax')->default(0)->comment('个人所得税');
            $table->float('prior_had_deducted_tax')->default(0)->comment('上月已扣税');
            $table->float('declare_tax_salary')->default(0)->comment('薪金申报个税');
            $table->float('declare_tax_article')->default(0)->comment('稿酬申报个税');
            $table->float('declare_tax_franchise')->default(0)->comment('特权申报个税');
            $table->float('declare_tax')->default(0)->comment('申报个税');
            $table->float('tax_diff')->default(0)->comment('税差');
        });
        // 特殊薪酬表
        Schema::create('special', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->float('actual_salary')->default(0)->comment('实发工资');
            $table->float('debt_salary')->default(0)->comment('余欠款');
            $table->float('instead_salary')->default(0)->comment('代汇');
            $table->float('bank_salary')->default(0)->comment('银行发放');
            $table->float('court_salary')->default(0)->comment('法院转提');
        });
        // 新增表.如果以后需要读取更多的列，则从此表读取
        Schema::create('extra', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(0)->index()->comment('会计期ID');
            $table->timestamps();

            $table->float('extra_column1')->default(0);
            $table->float('extra_column2')->default(0);
            $table->float('extra_column3')->default(0);
            $table->float('extra_column4')->default(0);
            $table->float('extra_column5')->default(0);
            $table->float('extra_column6')->default(0);
            $table->float('extra_column7')->default(0);
            $table->float('extra_column8')->default(0);
            $table->float('extra_column9')->default(0);
            $table->float('extra_column10')->default(0);
            $table->float('extra_column11')->default(0);
            $table->float('extra_column12')->default(0);
            $table->float('extra_column13')->default(0);
            $table->float('extra_column14')->default(0);
            $table->float('extra_column15')->default(0);
            $table->float('extra_column16')->default(0);
            $table->float('extra_column17')->default(0);
            $table->float('extra_column18')->default(0);
            $table->float('extra_column19')->default(0);
            $table->float('extra_column20')->default(0);
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
