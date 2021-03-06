<?php

namespace App\Services;

use App\Models\Period;
use App\Models\Salary\Bonus;
use App\Models\Salary\Deduction;
use App\Models\Salary\Other;
use App\Models\Salary\SalarySummary;
use App\Models\Salary\Special;
use App\Models\Salary\TaxImport;
use App\Models\Salary\Wage;
use App\Models\Users\UserProfile;
use App\Repository\SalaryRepository;
use Carbon\Carbon;
use DB;

class DataProcess
{
    protected $salary;

    public function __construct(SalaryRepository $salaryRepository)
    {
        $this->salary = $salaryRepository;
    }

    /**
     * 数据写入DB.
     *
     * @param array $info 表单提交数据
     *
     * @throws \Exception
     *
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function dataToDb(array $info)
    {
        DB::beginTransaction();

        try {
            $this->salary->saveToTable($info['period'], $info['uploadType'], $info['importData'], $info['file'], $info['isReset']);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->withErrors($e->getMessage());
        }

        return true;
    }

    /**
     * 根据日期返回会计周期ID.
     */
    public function getPeriodId(): int
    {
        // 需要返回还没有关闭的会计期ID
        $period = Period::where('published_at', '')->max('id');

        if (empty($period)) {
            return $this->newPeriod();
        }

        return $period;
    }

    /**
     * 关闭当前会计周期
     *
     * @param string $publishedAt 发布日期
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function closePeriod(string $publishedAt = '')
    {
        $period = Period::latest('id')->firstOrFail();

        $period->published_at = $publishedAt;
        $period->enddate = Carbon::now();
        $period->save();

        return $period;
    }

    /**
     * 新开会计周期
     *
     * @return int 会计周期ID
     */
    public function newPeriod(): int
    {
        $period = Period::create([
            'published_at' => '',
            'startdate' => Carbon::now(),
        ]);

        return $period->id;
    }

    /**
     * 计算合计字段.
     *
     * @param int $period 会计期间ID
     *
     * @return string
     * @throws \Exception
     */
    public function calTotal(int $period): string
    {
        //避免数据部分更新，采用事务处理
        DB::beginTransaction();

        try {
            // 工资——应发工资、应发辞退、应发内退
            $this->calWage($period);
            // 奖金——奖金合计
            $this->calBonus($period);
            // 补贴——补贴合计
            $this->calSubsidy($period);
            // 社保——企业超合计、专项扣除
            $this->calInsurances($period);
            // 补发——补发合计
            $this->calReissue($period);
            // 其他费用——稿费
            $this->calOther($period);
            // 扣款——水电、物管、其他扣除、扣欠款
            $this->calDeduction($period);
            // 专项税务——个人所得税、税差
            $this->calTax($period);
            // 合计表
            $this->calSummary($period);
            // 需要代汇的人员
            $this->calInstead($period);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return $e;
        }

        return 'success';
    }

    /**
     * 分别求和每个字段.
     *
     * @param int $period 会计期间ID
     *
     * @return array
     */
    public function getTotal(int $period): array
    {
        //region SQL 查询语句
        $sqlstring = 'SELECT ';
        // 工资
        $sqlstring .= 'ROUND(SUM(IFNULL(w.annual_standard,0)),2) AS 年薪工资标,ROUND(SUM(IFNULL(w.wage_standard,0)),2) AS 岗位工资标,ROUND(SUM(IFNULL(w.wage_daily,0)),2) AS 岗位工资日,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.sick_sub,0)),2) AS 扣岗位工病,ROUND(SUM(IFNULL(w.leave_sub,0)),2) AS 扣岗位工事,ROUND(SUM(IFNULL(w.baby_sub,0)),2) AS 扣岗位工婴,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.annual,0)),2) AS 年薪工资,ROUND(SUM(IFNULL(w.wage,0)),2) AS 岗位工资,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.retained_wage,0)),2) AS 保留工资,ROUND(SUM(IFNULL(w.compensation,0)),2) AS 套级补差,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.night_shift,0)),2) AS 中夜班费,ROUND(SUM(IFNULL(w.overtime_wage,0)),2) AS 加班工资,ROUND(SUM(IFNULL(w.seniority_wage,0)),2) AS 年功工资,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.lggw,0)),2) AS 离岗岗位,ROUND(SUM(IFNULL(w.lgbl,0)),2) AS 离岗保留,ROUND(SUM(IFNULL(w.lgzj,0)),2) AS 离岗增加,ROUND(SUM(IFNULL(w.lgng,0)),2) AS 离岗年功,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.jbylj,0)),2) AS 基本养老金,ROUND(SUM(IFNULL(w.zj,0)),2) AS 增机,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.gjbt,0)),2) AS 国家补贴,ROUND(SUM(IFNULL(w.gjsh,0)),2) AS 国家生活,ROUND(SUM(IFNULL(w.gjxj,0)),2) AS 国家小计,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.dflc,0)),2) AS 地方粮差,ROUND(SUM(IFNULL(w.dfqt,0)),2) AS 地方其他,ROUND(SUM(IFNULL(w.dfwb,0)),2) AS 地方物补,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.dfsh,0)),2) AS 地方生活,ROUND(SUM(IFNULL(w.dfxj,0)),2) AS 地方小计,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.hygl,0)),2) AS 行业工龄,ROUND(SUM(IFNULL(w.hytb,0)),2) AS 行业退补,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.hyqt,0)),2) AS 行业其他,ROUND(SUM(IFNULL(w.hyxj,0)),2) AS 行业小计,ROUND(SUM(IFNULL(w.tcxj,0)),2) AS 统筹小计,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.qylc,0)),2) AS 企业粮差,ROUND(SUM(IFNULL(w.qygl,0)),2) AS 企业工龄,ROUND(SUM(IFNULL(w.qysb,0)),2) AS 企业书报,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.qysd,0)),2) AS 企业水电,ROUND(SUM(IFNULL(w.qysh,0)),2) AS 企业生活,ROUND(SUM(IFNULL(w.qydzf,0)),2) AS 企业独子费,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.qyhlf,0)),2) AS 企业护理费,ROUND(SUM(IFNULL(w.qytxf,0)),2) AS 企业通讯费,ROUND(SUM(IFNULL(w.qygfz,0)),2) AS 企业规范增,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.qygl2,0)),2) AS 企业工龄02,ROUND(SUM(IFNULL(w.qyntb,0)),2) AS 企业内退补,ROUND(SUM(IFNULL(w.qybf,0)),2) AS 企业补发,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.qyxj,0)),2) AS 企业小计,ROUND(SUM(IFNULL(w.ltxbc,0)),2) AS 离退休补充,ROUND(SUM(IFNULL(w.bc,0)),2) AS 补偿,';
        $sqlstring .= 'ROUND(SUM(IFNULL(w.wage_total,0)),2) AS 应发工资,ROUND(SUM(IFNULL(w.yfct,0)),2) AS 应发辞退,ROUND(SUM(IFNULL(w.yfnt,0)),2) AS 应发内退,';
        // 奖金
        $sqlstring .= 'ROUND(SUM(IFNULL(b.month_bonus,0)),2) AS 月奖,ROUND(SUM(IFNULL(b.special,0)),2) AS 专项奖,ROUND(SUM(IFNULL(b.competition,0)),2) AS 劳动竞赛,';
        $sqlstring .= 'ROUND(SUM(IFNULL(b.class_reward,0)),2) AS 课酬,ROUND(SUM(IFNULL(b.holiday,0)),2) AS 节日慰问费,ROUND(SUM(IFNULL(b.party_reward,0)),2) AS 党员奖励,';
        $sqlstring .= 'ROUND(SUM(IFNULL(b.union_paying,0)),2) AS 工会发放,ROUND(SUM(IFNULL(b.other_reward,0)),2) AS 其他奖励,ROUND(SUM(IFNULL(b.bonus_total,0)),2) AS 奖金合计,';
        // 其他费用
        $sqlstring .= 'ROUND(SUM(IFNULL(o.finance_article,0)),2) AS 财务发稿酬,ROUND(SUM(IFNULL(o.union_article,0)),2) AS 工会发稿酬,ROUND(SUM(IFNULL(o.article_fee,0)),2) AS 稿酬,';
        $sqlstring .= 'ROUND(SUM(IFNULL(o.article_add_tax,0)),2) AS 稿酬应补税,ROUND(SUM(IFNULL(o.article_sub_tax,0)),2) AS 稿酬减免税,';
        $sqlstring .= 'ROUND(SUM(IFNULL(o.franchise,0)),2) AS 特许使用权,ROUND(SUM(IFNULL(o.franchise_add_tax,0)),2) AS 特权应补税,ROUND(SUM(IFNULL(o.franchise_sub_tax,0)),2) AS 特权减免税,';
        // 社保
        $sqlstring .= 'ROUND(SUM(IFNULL(i.gjj_classic,0)),2) AS 公积金标准,ROUND(SUM(IFNULL(i.gjj_add,0)),2) AS 公积金补扣,ROUND(SUM(IFNULL(i.gjj_person,0)),2) AS 公积金个人,';
        $sqlstring .= 'ROUND(SUM(IFNULL(i.gjj_deduction,0)),2) AS 公积金扣除,ROUND(SUM(IFNULL(i.gjj_enterprise,0)),2) AS 公积企业缴,ROUND(SUM(IFNULL(i.gjj_out_range,0)),2) AS 公积企超标,';
        $sqlstring .= 'ROUND(SUM(IFNULL(i.annuity_classic,0)),2) AS 年金标准,ROUND(SUM(IFNULL(i.annuity_add,0)),2) AS 年金补扣,ROUND(SUM(IFNULL(i.annuity_person,0)),2) AS 年金个人,';
        $sqlstring .= 'ROUND(SUM(IFNULL(i.annuity_deduction,0)),2) AS 年金扣除,ROUND(SUM(IFNULL(i.annuity_enterprise,0)),2) AS 年金企业缴,ROUND(SUM(IFNULL(i.annuity_out_range,0)),2) AS 年金企超标,';
        $sqlstring .= 'ROUND(SUM(IFNULL(i.retire_classic,0)),2) AS 退养金标准,ROUND(SUM(IFNULL(i.retire_add,0)),2) AS 退养金补扣,ROUND(SUM(IFNULL(i.retire_person,0)),2) AS 退养金个人,';
        $sqlstring .= 'ROUND(SUM(IFNULL(i.retire_deduction,0)),2) AS 退养金扣除,ROUND(SUM(IFNULL(i.retire_enterprise,0)),2) AS 退养企业缴,ROUND(SUM(IFNULL(i.retire_out_range,0)),2) AS 退养企超标,';
        $sqlstring .= 'ROUND(SUM(IFNULL(i.medical_classic,0)),2) AS 医保金标准,ROUND(SUM(IFNULL(i.medical_add,0)),2) AS 医保金补扣,ROUND(SUM(IFNULL(i.medical_person,0)),2) AS 医保金个人,';
        $sqlstring .= 'ROUND(SUM(IFNULL(i.medical_deduction,0)),2) AS 医保金扣除,ROUND(SUM(IFNULL(i.medical_enterprise,0)),2) AS 医保企业缴,ROUND(SUM(IFNULL(i.medical_out_range,0)),2) AS 医保企超标,';
        $sqlstring .= 'ROUND(SUM(IFNULL(i.unemployment_classic,0)),2) AS 失业金标准,ROUND(SUM(IFNULL(i.unemployment_add,0)),2) AS 失业金补扣,ROUND(SUM(IFNULL(i.unemployment_person,0)),2) AS 失业金个人,';
        $sqlstring .= 'ROUND(SUM(IFNULL(i.unemployment_deduction,0)),2) AS 失业金扣除,ROUND(SUM(IFNULL(i.unemployment_enterprise,0)),2) AS 失业企业缴,ROUND(SUM(IFNULL(i.unemployment_out_range,0)),2) AS 失业企超标,';
        $sqlstring .= 'ROUND(SUM(IFNULL(i.injury_enterprise,0)),2) AS 工伤企业缴,ROUND(SUM(IFNULL(i.birth_enterprise,0)),2) AS 生育企业缴,';
        $sqlstring .= 'ROUND(SUM(IFNULL(i.enterprise_out_total,0)),2) AS 企业超合计,ROUND(SUM(IFNULL(i.specail_deduction,0)),2) AS 专项扣除,';
        // 补贴
        $sqlstring .= 'ROUND(SUM(IFNULL(s.communication,0)),2) AS 通讯补贴,ROUND(SUM(IFNULL(s.housing,0)),2) AS 住房补贴,';
        $sqlstring .= 'ROUND(SUM(IFNULL(s.traffic_standard,0)),2) AS 交通补贴标,ROUND(SUM(IFNULL(s.traffic_add,0)),2) AS 交通补贴考,ROUND(SUM(IFNULL(s.traffic,0)),2) AS 交通费,';
        $sqlstring .= 'ROUND(SUM(IFNULL(s.single_standard,0)),2) AS 独子费标准,ROUND(SUM(IFNULL(s.single_add,0)),2) AS 独子费补发,ROUND(SUM(IFNULL(s.single,0)),2) AS 独子费,';
        $sqlstring .= 'ROUND(SUM(IFNULL(s.subsidy_total,0)),2) AS 补贴合计,';
        // 补发
        $sqlstring .= 'ROUND(SUM(IFNULL(r.reissue_wage,0)),2) AS 补发工资,ROUND(SUM(IFNULL(r.reissue_subsidy,0)),2) AS 补发补贴,ROUND(SUM(IFNULL(r.reissue_other,0)),2) AS 补发其他,';
        $sqlstring .= 'ROUND(SUM(IFNULL(r.reissue_total,0)),2) AS 补发合计,';
        // 扣款
        $sqlstring .= 'ROUND(SUM(IFNULL(d.garage_water,0)),2) AS 车库水费,ROUND(SUM(IFNULL(d.garage_electric,0)),2) AS 车库电费,ROUND(SUM(IFNULL(d.garage_property,0)),2) AS 车库物管,';
        $sqlstring .= 'ROUND(SUM(IFNULL(d.cc_water,0)),2) AS 成钞水费,ROUND(SUM(IFNULL(d.cc_electric,0)),2) AS 成钞电费,ROUND(SUM(IFNULL(d.cc_property,0)),2) AS 成钞物管,';
        $sqlstring .= 'ROUND(SUM(IFNULL(d.xy_water,0)),2) AS 鑫源水费,ROUND(SUM(IFNULL(d.xy_electric,0)),2) AS 鑫源电费,ROUND(SUM(IFNULL(d.xy_property,0)),2) AS 鑫源物管,';
        $sqlstring .= 'ROUND(SUM(IFNULL(d.back_water,0)),2) AS 退补水费,ROUND(SUM(IFNULL(d.back_electric,0)),2) AS 退补电费,ROUND(SUM(IFNULL(d.back_property,0)),2) AS 退补物管费,';
        $sqlstring .= 'ROUND(SUM(IFNULL(d.water_electric,0)),2) AS 水电,ROUND(SUM(IFNULL(d.property_fee,0)),2) AS 物管费,';
        $sqlstring .= 'ROUND(SUM(IFNULL(d.car_fee,0)),2) AS 公车费用,ROUND(SUM(IFNULL(d.car_deduction,0)),2) AS 公车补扣除,ROUND(SUM(IFNULL(d.rest_deduction,0)),2) AS 它项扣除,';
        $sqlstring .= 'ROUND(SUM(IFNULL(d.sum_deduction,0)),2) AS 其他扣除,';
        $sqlstring .= 'ROUND(SUM(IFNULL(d.fixed_deduction,0)),2) AS 固定扣款,ROUND(SUM(IFNULL(d.other_deduction,0)),2) AS 其他扣款,ROUND(SUM(IFNULL(d.temp_deduction,0)),2) AS 临时扣款,';
        $sqlstring .= 'ROUND(SUM(IFNULL(d.union_deduction,0)),2) AS 扣工会会费,ROUND(SUM(IFNULL(d.prior_deduction,0)),2) AS 上期余欠款,ROUND(SUM(IFNULL(d.had_debt,0)),2) AS 已销欠款,';
        $sqlstring .= 'ROUND(SUM(IFNULL(d.debt,0)),2) AS 扣欠款,ROUND(SUM(IFNULL(d.donate,0)),2) AS 捐赠,';
        // 专项
        $sqlstring .= 'ROUND(SUM(IFNULL(t.income,0)),2) AS 累计收入额,ROUND(SUM(IFNULL(t.deduct_expenses,0)),2) AS 累减除费用,ROUND(SUM(IFNULL(t.special_deduction,0)),2) AS 累计专项扣,';
        $sqlstring .= 'ROUND(SUM(IFNULL(t.tax_child,0)),2) AS 累专附子女,ROUND(SUM(IFNULL(t.tax_old,0)),2) AS 累专附老人,ROUND(SUM(IFNULL(t.tax_edu,0)),2) AS 累专附继教,';
        $sqlstring .= 'ROUND(SUM(IFNULL(t.tax_loan,0)),2) AS 累专附房利,ROUND(SUM(IFNULL(t.tax_rent,0)),2) AS 累专附房租,ROUND(SUM(IFNULL(t.tax_other_deduct,0)),2) AS 累其他扣除,';
        $sqlstring .= 'ROUND(SUM(IFNULL(t.deduct_donate,0)),2) AS 累计扣捐赠,ROUND(SUM(IFNULL(t.tax_income,0)),2) AS 累税所得额,';
        $sqlstring .= 'ROUND(SUM(IFNULL(t.taxable,0)),2) AS 累计应纳税,ROUND(SUM(IFNULL(t.tax_reliefs,0)),2) AS 累计减免税,ROUND(SUM(IFNULL(t.should_deducted_tax,0)),2) AS 累计应扣税,';
        $sqlstring .= 'ROUND(SUM(IFNULL(t.have_deducted_tax,0)),2) AS 累计申扣税,ROUND(SUM(IFNULL(t.should_be_tax,0)),2) AS 累计应补税,ROUND(SUM(IFNULL(t.reduce_tax,0)),2) AS 减免个税,';
        $sqlstring .= 'ROUND(SUM(IFNULL(t.personal_tax,0)),2) AS 个人所得税,ROUND(SUM(IFNULL(t.prior_had_deducted_tax,0)),2) AS 上月已扣税,';
        $sqlstring .= 'ROUND(SUM(IFNULL(t.declare_tax,0)),2) AS 申报个税,ROUND(SUM(IFNULL(t.tax_diff,0)),2) AS 税差,';
        // 特殊
        $sqlstring .= 'ROUND(SUM(IFNULL(sp.actual_salary,0)),2) AS 实发工资,ROUND(SUM(IFNULL(sp.debt_salary,0)),2) AS 余欠款,';
        $sqlstring .= 'ROUND(SUM(IFNULL(sp.instead_salary,0)),2) AS 代汇,ROUND(SUM(IFNULL(sp.bank_salary,0)),2) AS 银行发放,';
        $sqlstring .= 'ROUND(SUM(IFNULL(sp.court_salary,0)),2) AS 法院转提, ';
        // 合计
        $sqlstring .= 'ROUND(SUM(IFNULL(su.should_total,0)),2) AS 应发合计, ROUND(SUM(IFNULL(su.salary_total,0)),2) AS 工资薪金 ';

        $sqlstring .= 'FROM userProfile up ';
        $sqlstring .= 'LEFT JOIN wage w ON up.policyNumber = w.policyNumber AND w.period_id = ? ';
        $sqlstring .= 'LEFT JOIN bonus b ON up.policyNumber = b.policyNumber AND b.period_id = ? ';
        $sqlstring .= 'LEFT JOIN other o ON up.policyNumber = o.policyNumber AND o.period_id = ? ';
        $sqlstring .= 'LEFT JOIN insurances i ON up.policyNumber = i.policyNumber AND i.period_id = ? ';
        $sqlstring .= 'LEFT JOIN subsidy s ON up.policyNumber = s.policyNumber AND s.period_id = ? ';
        $sqlstring .= 'LEFT JOIN reissue r ON up.policyNumber = r.policyNumber AND r.period_id = ? ';
        $sqlstring .= 'LEFT JOIN deduction d ON up.policyNumber = d.policyNumber AND d.period_id = ? ';
        $sqlstring .= 'LEFT JOIN taxImport t ON up.policyNumber = t.policyNumber AND t.period_id = ? ';
        $sqlstring .= 'LEFT JOIN special sp ON up.policyNumber = sp.policyNumber AND sp.period_id = ? ';
        $sqlstring .= 'LEFT JOIN summary su ON up.policyNumber = su.policyNumber AND su.period_id = ? ';
        // endregion

        return DB::select($sqlstring, [
            $period, $period, $period, $period, $period, $period, $period, $period, $period, $period,
        ]);
    }

    /**
     * 输出所有人员当期明细.
     *
     * @param int $period 会计期间ID
     *
     * @return array
     */
    public function getSalaryDetail(int $period): array
    {
        $res['headings'] = [
            'dwdm', '部门', '工序', '人数', '姓名', '转储姓名', '保险编号', '人员编码', '手机号码',
            '证照类型', '证照号码', '工资工行卡', '奖金工行卡', '入职时间', '离职时间', '是否残疾人', '减免税率',
            // region 工资
            '年薪工资', '年薪工资标', '岗位工资标', '岗位工资日', '扣岗位工病', '扣岗位工事', '扣岗位工婴', '岗位工资',
            '保留工资', '套级补差', '中夜班费', '加班工资', '年功工资', '离岗岗位', '离岗保留', '离岗增加', '离岗年功',
            '基本养老金', '增机', '国家补贴', '国家生活', '国家小计', '地方粮差', '地方其他', '地方物补', '地方生活', '地方小计',
            '行业工龄', '行业退补', '行业其他', '行业小计', '统筹小计',
            '企业粮差', '企业工龄', '企业书报', '企业水电', '企业生活', '企业独子费', '企业护理费', '企业通讯费', '企业规范增',
            '企业工龄02', '企业内退补', '企业补发', '企业小计', '离退休补充', '补偿', '应发工资', '应发辞退', '应发内退',
            // endregion
            // region 奖金
            '月奖', '专项奖', '劳动竞赛', '课酬', '节日慰问费', '党员奖励', '工会发放', '其他奖励', '奖金合计',
            // endregion
            // region 其他费用
            '财务发稿酬', '工会发稿酬', '稿酬', '稿酬应补税', '稿酬减免税', '特许使用权', '特权应补税', '特权减免税',
            // endregion
            // region 社保
            '公积金标准', '公积金补扣', '公积金个人', '公积金扣除', '公积企业缴', '公积企超标',
            '年金标准', '年金补扣', '年金个人', '年金扣除', '年金企业缴', '年金企超标',
            '退养金标准', '退养金补扣', '退养金个人', '退养金扣除', '退养企业缴', '退养企超标',
            '医保金标准', '医保金补扣', '医保金个人', '医保金扣除', '医保企业缴', '医保企超标',
            '失业金标准', '失业金补扣', '失业金个人', '失业金扣除', '失业企业缴', '失业企超标',
            '工伤企业缴', '生育企业缴', '企业超合计', '专项扣除',
            // endregion
            // region 补贴
            '通讯补贴', '住房补贴', '交通补贴标', '交通补贴考', '交通费',
            '独子费标准', '独子费补发', '独子费', '补贴合计',
            // endregion
            // region 补发
            '补发工资', '补发补贴', '补发其他', '补发合计',
            // endregion
            // region 扣款
            '车库水费', '车库电费', '车库物管', '成钞水费', '成钞电费', '成钞物管', '鑫源水费', '鑫源电费', '鑫源物管',
            '退补水费', '退补电费', '退补物管费', '水电', '物管费',
            '公车费用', '公车补扣除', '公车扣备注', '它项扣除', '它项扣备注', '其他扣除',
            '固定扣款', '其他扣款', '临时扣款', '扣工会会费', '上期余欠款', '已销欠款', '扣欠款', '捐赠',
            // endregion
            // region 专项
            '累计收入额', '累减除费用', '累计专项扣', '累专附子女', '累专附老人', '累专附继教', '累专附房利', '累专附房租', '累其他扣除',
            '累计扣捐赠', '累税所得额', '税率', '速算扣除数', '累计应纳税', '累计减免税', '累计应扣税', '累计申扣税', '累计应补税',
            '减免个税', '个人所得税', '上月已扣税', '申报个税', '税差',
            // endregion
            // region 特殊
            '汇', '代汇', '银行发放', '实发工资', '余欠款', '法院转提',
            // endregion
            // region 合计信息
            '应发合计', '工资薪金',
            // endregion
            // region 发放日期
            '发放日期',
            // endregion
            // region card
            '代汇开户行', '代汇省', '代汇市', '代汇地区码', '代汇姓名', '代汇账号',
            // endregion
        ];

        $res['filename'] = date('Ym').'_所有字段明细数据导出.xlsx';
        // region SQL 查询语句
        $sqlstring = "SELECT d1.dwdm, d1.name AS '部门', d2.name AS '工序', 1 AS '人数', ";
        $sqlstring .= 'up.userName, up.userName as name1, up.policyNumber, users.name as uname, ';
        $sqlstring .= "up.mobile, '身份证' as '证照类型', up.uid, up.wageCard, up.bonusCard, up.hiredate, up.departure, ";
        $sqlstring .= "IF(handicapped = 0, 'F', 'T') as handicapped, up.tax_rebates, ";
        // region 工资
        $sqlstring .= 'IFNULL(w.annual,0) AS 年薪工资, IFNULL(w.annual_standard,0) AS 年薪工资标,';
        $sqlstring .= 'IFNULL(w.wage_standard,0) AS 岗位工资标,IFNULL(w.wage_daily,0) AS 岗位工资日,';
        $sqlstring .= 'IFNULL(w.sick_sub,0) AS 扣岗位工病,IFNULL(w.leave_sub,0) AS 扣岗位工事,IFNULL(w.baby_sub,0) AS 扣岗位工婴,';
        $sqlstring .= 'IFNULL(w.wage,0) AS 岗位工资,';
        $sqlstring .= 'IFNULL(w.retained_wage,0) AS 保留工资,IFNULL(w.compensation,0) AS 套级补差,';
        $sqlstring .= 'IFNULL(w.night_shift,0) AS 中夜班费,IFNULL(w.overtime_wage,0) AS 加班工资,IFNULL(w.seniority_wage,0) AS 年功工资,';
        $sqlstring .= 'IFNULL(w.lggw,0) AS 离岗岗位,IFNULL(w.lgbl,0) AS 离岗保留,IFNULL(w.lgzj,0) AS 离岗增加,IFNULL(w.lgng,0) AS 离岗年功,';
        $sqlstring .= 'IFNULL(w.jbylj,0) AS 基本养老金,IFNULL(w.zj,0) AS 增机,';
        $sqlstring .= 'IFNULL(w.gjbt,0) AS 国家补贴,IFNULL(w.gjsh,0) AS 国家生活,IFNULL(w.gjxj,0) AS 国家小计,';
        $sqlstring .= 'IFNULL(w.dflc,0) AS 地方粮差,IFNULL(w.dfqt,0) AS 地方其他,IFNULL(w.dfwb,0) AS 地方物补,';
        $sqlstring .= 'IFNULL(w.dfsh,0) AS 地方生活,IFNULL(w.dfxj,0) AS 地方小计,';
        $sqlstring .= 'IFNULL(w.hygl,0) AS 行业工龄,IFNULL(w.hytb,0) AS 行业退补,';
        $sqlstring .= 'IFNULL(w.hyqt,0) AS 行业其他,IFNULL(w.hyxj,0) AS 行业小计,IFNULL(w.tcxj,0) AS 统筹小计,';
        $sqlstring .= 'IFNULL(w.qylc,0) AS 企业粮差,IFNULL(w.qygl,0) AS 企业工龄,IFNULL(w.qysb,0) AS 企业书报,';
        $sqlstring .= 'IFNULL(w.qysd,0) AS 企业水电,IFNULL(w.qysh,0) AS 企业生活,IFNULL(w.qydzf,0) AS 企业独子费,';
        $sqlstring .= 'IFNULL(w.qyhlf,0) AS 企业护理费,IFNULL(w.qytxf,0) AS 企业通讯费,IFNULL(w.qygfz,0) AS 企业规范增,';
        $sqlstring .= 'IFNULL(w.qygl2,0) AS 企业工龄02,IFNULL(w.qyntb,0) AS 企业内退补,IFNULL(w.qybf,0) AS 企业补发,';
        $sqlstring .= 'IFNULL(w.qyxj,0) AS 企业小计,IFNULL(w.ltxbc,0) AS 离退休补充,IFNULL(w.bc,0) AS 补偿,';
        $sqlstring .= 'IFNULL(w.wage_total,0) AS 应发工资,IFNULL(w.yfct,0) AS 应发辞退,IFNULL(w.yfnt,0) AS 应发内退,';
        // endregion
        // region 奖金
        $sqlstring .= 'IFNULL(b.month_bonus,0) AS 月奖,IFNULL(b.special,0) AS 专项奖,IFNULL(b.competition,0) AS 劳动竞赛,';
        $sqlstring .= 'IFNULL(b.class_reward,0) AS 课酬,IFNULL(b.holiday,0) AS 节日慰问费,IFNULL(b.party_reward,0) AS 党员奖励,';
        $sqlstring .= 'IFNULL(b.union_paying,0) AS 工会发放,IFNULL(b.other_reward,0) AS 其他奖励,IFNULL(b.bonus_total,0) AS 奖金合计,';
        // endregion
        // region 其他费用
        $sqlstring .= 'IFNULL(o.finance_article,0) AS 财务发稿酬,IFNULL(o.union_article,0) AS 工会发稿酬,IFNULL(o.article_fee,0) AS 稿酬,';
        $sqlstring .= 'IFNULL(o.article_add_tax,0) AS 稿酬应补税,IFNULL(o.article_sub_tax,0) AS 稿酬减免税,';
        $sqlstring .= 'IFNULL(o.franchise,0) AS 特许使用权,IFNULL(o.franchise_add_tax,0) AS 特权应补税,IFNULL(o.franchise_sub_tax,0) AS 特权减免税,';
        // endregion
        // region 社保
        $sqlstring .= 'IFNULL(i.gjj_classic,0) AS 公积金标准,IFNULL(i.gjj_add,0) AS 公积金补扣,IFNULL(i.gjj_person,0) AS 公积金个人,';
        $sqlstring .= 'IFNULL(i.gjj_deduction,0) AS 公积金扣除,IFNULL(i.gjj_enterprise,0) AS 公积企业缴,IFNULL(i.gjj_out_range,0) AS 公积企超标,';
        $sqlstring .= 'IFNULL(i.annuity_classic,0) AS 年金标准,IFNULL(i.annuity_add,0) AS 年金补扣,IFNULL(i.annuity_person,0) AS 年金个人,';
        $sqlstring .= 'IFNULL(i.annuity_deduction,0) AS 年金扣除,IFNULL(i.annuity_enterprise,0) AS 年金企业缴,IFNULL(i.annuity_out_range,0) AS 年金企超标,';
        $sqlstring .= 'IFNULL(i.retire_classic,0) AS 退养金标准,IFNULL(i.retire_add,0) AS 退养金补扣,IFNULL(i.retire_person,0) AS 退养金个人,';
        $sqlstring .= 'IFNULL(i.retire_deduction,0) AS 退养金扣除,IFNULL(i.retire_enterprise,0) AS 退养企业缴,IFNULL(i.retire_out_range,0) AS 退养企超标,';
        $sqlstring .= 'IFNULL(i.medical_classic,0) AS 医保金标准,IFNULL(i.medical_add,0) AS 医保金补扣,IFNULL(i.medical_person,0) AS 医保金个人,';
        $sqlstring .= 'IFNULL(i.medical_deduction,0) AS 医保金扣除,IFNULL(i.medical_enterprise,0) AS 医保企业缴,IFNULL(i.medical_out_range,0) AS 医保企超标,';
        $sqlstring .= 'IFNULL(i.unemployment_classic,0) AS 失业金标准,IFNULL(i.unemployment_add,0) AS 失业金补扣,IFNULL(i.unemployment_person,0) AS 失业金个人,';
        $sqlstring .= 'IFNULL(i.unemployment_deduction,0) AS 失业金扣除,IFNULL(i.unemployment_enterprise,0) AS 失业企业缴,IFNULL(i.unemployment_out_range,0) AS 失业企超标,';
        $sqlstring .= 'IFNULL(i.injury_enterprise,0) AS 工伤企业缴,IFNULL(i.birth_enterprise,0) AS 生育企业缴,';
        $sqlstring .= 'IFNULL(i.enterprise_out_total,0) AS 企业超合计,IFNULL(i.specail_deduction,0) AS 专项扣除,';
        // endregion
        // region 补贴
        $sqlstring .= 'IFNULL(s.communication,0) AS 通讯补贴,IFNULL(s.housing,0) AS 住房补贴,';
        $sqlstring .= 'IFNULL(s.traffic_standard,0) AS 交通补贴标,IFNULL(s.traffic_add,0) AS 交通补贴考,IFNULL(s.traffic,0) AS 交通费,';
        $sqlstring .= 'IFNULL(s.single_standard,0) AS 独子费标准,IFNULL(s.single_add,0) AS 独子费补发,IFNULL(s.single,0) AS 独子费,';
        $sqlstring .= 'IFNULL(s.subsidy_total,0) AS 补贴合计,';
        // endregion
        // region 补发
        $sqlstring .= 'IFNULL(r.reissue_wage,0) AS 补发工资,IFNULL(r.reissue_subsidy,0) AS 补发补贴,IFNULL(r.reissue_other,0) AS 补发其他,';
        $sqlstring .= 'IFNULL(r.reissue_total,0) AS 补发合计,';
        // endregion
        // region 扣款
        $sqlstring .= 'IFNULL(d.garage_water,0) AS 车库水费,IFNULL(d.garage_electric,0) AS 车库电费,IFNULL(d.garage_property,0) AS 车库物管,';
        $sqlstring .= 'IFNULL(d.cc_water,0) AS 成钞水费,IFNULL(d.cc_electric,0) AS 成钞电费,IFNULL(d.cc_property,0) AS 成钞物管,';
        $sqlstring .= 'IFNULL(d.xy_water,0) AS 鑫源水费,IFNULL(d.xy_electric,0) AS 鑫源电费,IFNULL(d.xy_property,0) AS 鑫源物管,';
        $sqlstring .= 'IFNULL(d.back_water,0) AS 退补水费,IFNULL(d.back_electric,0) AS 退补电费,IFNULL(d.back_property,0) AS 退补物管费,';
        $sqlstring .= 'IFNULL(d.water_electric,0) AS 水电,IFNULL(d.property_fee,0) AS 物管费,';
        $sqlstring .= "IFNULL(d.car_fee,0) AS 公车费用,IFNULL(d.car_deduction,0) AS 公车补扣除,IFNULL(d.car_deduction_comment,'') AS '公车扣备注',";
        $sqlstring .= "IFNULL(d.rest_deduction,0) AS 它项扣除, IFNULL(d.rest_deduction_comment, '') AS '它项扣备注',";
        $sqlstring .= 'IFNULL(d.sum_deduction,0) AS 其他扣除,';
        $sqlstring .= 'IFNULL(d.fixed_deduction,0) AS 固定扣款,IFNULL(d.other_deduction,0) AS 其他扣款,IFNULL(d.temp_deduction,0) AS 临时扣款,';
        $sqlstring .= 'IFNULL(d.union_deduction,0) AS 扣工会会费,IFNULL(d.prior_deduction,0) AS 上期余欠款,IFNULL(d.had_debt,0) AS 已销欠款,';
        $sqlstring .= 'IFNULL(d.debt,0) AS 扣欠款,IFNULL(d.donate,0) AS 捐赠,';
        // endregion
        // region 专项
        $sqlstring .= 'IFNULL(t.income,0) AS 累计收入额,IFNULL(t.deduct_expenses,0) AS 累减除费用,IFNULL(t.special_deduction,0) AS 累计专项扣,';
        $sqlstring .= 'IFNULL(t.tax_child,0) AS 累专附子女,IFNULL(t.tax_old,0) AS 累专附老人,IFNULL(t.tax_edu,0) AS 累专附继教,';
        $sqlstring .= 'IFNULL(t.tax_loan,0) AS 累专附房利,IFNULL(t.tax_rent,0) AS 累专附房租,IFNULL(t.tax_other_deduct,0) AS 累其他扣除,';
        $sqlstring .= 'IFNULL(t.deduct_donate,0) AS 累计扣捐赠,IFNULL(t.tax_income,0) AS 累税所得额,IFNULL(t.taxrate,0) AS 税率,IFNULL(t.quick_deduction,0) AS 速算扣除数,';
        $sqlstring .= 'IFNULL(t.taxable,0) AS 累计应纳税,IFNULL(t.tax_reliefs,0) AS 累计减免税,IFNULL(t.should_deducted_tax,0) AS 累计应扣税,';
        $sqlstring .= 'IFNULL(t.have_deducted_tax,0) AS 累计申扣税,IFNULL(t.should_be_tax,0) AS 累计应补税,IFNULL(t.reduce_tax,0) AS 减免个税,';
        $sqlstring .= 'IFNULL(t.personal_tax,0) AS 个人所得税,IFNULL(t.prior_had_deducted_tax,0) AS 上月已扣税,';
        $sqlstring .= 'IFNULL(t.declare_tax,0) AS 申报个税,IFNULL(t.tax_diff,0) AS 税差,';
        // endregion
        // region 特殊
        $sqlstring .= "IF(sp.instead_salary > 0, 'T', 'F') AS 汇, IFNULL(sp.instead_salary,0) AS 代汇,";
        $sqlstring .= 'IFNULL(sp.bank_salary,0) AS 银行发放,IFNULL(sp.actual_salary,0) AS 实发工资,';
        $sqlstring .= 'IFNULL(sp.debt_salary,0) AS 余欠款,IFNULL(sp.court_salary,0) AS 法院转提, ';
        // endregion
        // region 合计
        $sqlstring .= 'IFNULL(ss.should_total,0), IFNULL(ss.salary_total,0),';
        // endregion
        // region 发放日期
        $sqlstring .= "IFNULL(p.published_at, ''),";
        // endregion
        // region card
        $sqlstring .= 'c.remit_bank, c.remit_province, c.remit_city,';
        $sqlstring .= 'c.remit_address_no, c.remit_name, c.remit_card_no ';
        // endregion

        $sqlstring .= 'FROM userProfile up ';
        $sqlstring .= 'LEFT JOIN users ON up.user_id = users.id ';
        $sqlstring .= 'LEFT JOIN departments d1 ON up.department_id = d1.id ';
        $sqlstring .= 'LEFT JOIN departments d2 ON up.organization_id = d2.id ';
        $sqlstring .= 'LEFT JOIN wage w ON up.policyNumber = w.policyNumber AND w.period_id = ? ';
        $sqlstring .= 'LEFT JOIN bonus b ON up.policyNumber = b.policyNumber AND b.period_id = ? ';
        $sqlstring .= 'LEFT JOIN other o ON up.policyNumber = o.policyNumber AND o.period_id = ? ';
        $sqlstring .= 'LEFT JOIN insurances i ON up.policyNumber = i.policyNumber AND i.period_id = ? ';
        $sqlstring .= 'LEFT JOIN subsidy s ON up.policyNumber = s.policyNumber AND s.period_id = ? ';
        $sqlstring .= 'LEFT JOIN reissue r ON up.policyNumber = r.policyNumber AND r.period_id = ? ';
        $sqlstring .= 'LEFT JOIN deduction d ON up.policyNumber = d.policyNumber AND d.period_id = ? ';
        $sqlstring .= 'LEFT JOIN taxImport t ON up.policyNumber = t.policyNumber AND t.period_id = ? ';
        $sqlstring .= 'LEFT JOIN special sp ON up.policyNumber = sp.policyNumber AND sp.period_id = ? ';
        $sqlstring .= 'LEFT JOIN summary ss ON up.policyNumber = ss.policyNumber AND ss.period_id = ? ';
        $sqlstring .= 'LEFT JOIN card_info c ON up.user_id = c.user_id ';
        $sqlstring .= 'LEFT JOIN periods p ON p.id = ss.period_id AND p.id = ? ';
        $sqlstring .= 'WHERE up.user_id <> 1 ';
        $sqlstring .= 'ORDER BY d1.dwdm, up.user_id';
        //endregion

        $res['data'] = DB::select($sqlstring, [
            $period, $period, $period, $period, $period, $period, $period, $period, $period, $period, $period,
        ]);

        return $res;
    }

    /**
     * 计算工资合计字段.
     *
     * @param int $period 会计期ID
     */
    private function calWage(int $period): void
    {
        $wage = Wage::where('period_id', $period)->get();
        $yfct = UserProfile::leftJoin('departments', 'departments.id', '=', 'userProfile.department_id')
            ->where('departments.dwdm', 'like', '01020201%')
            ->pluck('policyNumber')->toArray();
        $yfnt = UserProfile::leftJoin('departments', 'departments.id', '=', 'userProfile.department_id')
            ->where('departments.dwdm', 'like', '01020202%')
            ->pluck('policyNumber')->toArray();
        foreach ($wage as $w) {
            $cal = $this->calWageDetail($w, $yfct, $yfnt);

            Wage::updateOrCreate(
                ['period_id' => $period, 'policyNumber' => $w->policyNumber],
                [
                    'annual' => $w->annual,
                    'wage' => $w->wage,
                    'retained_wage' => $w->retained_wage,
                    'compensation' => $w->compensation,
                    'night_shift' => $w->night_shift,
                    'overtime_wage' => $w->overtime_wage,
                    'seniority_wage' => $w->seniority_wage,
                    'tcxj' => $w->tcxj,
                    'qyxj' => $w->qyxj,
                    'ltxbc' => $w->ltxbc,
                    'bc' => $w->bc,

                    'wage_total' => $cal['wage_total'],
                    'yfct' => $cal['yfct'],
                    'yfnt' => $cal['yfnt'],
                ]
            );
        }
    }

    /**
     * 计算工资的 应发工资、应发辞退、应发内退.
     *
     * @param $data
     *
     * @param $yfct
     * @param $yfnt
     * @return mixed
     */
    private function calWageDetail($data, $yfct, $yfnt)
    {
        // 应发工资
        $annual = $data->annual;
        $wage = $data->wage;
        $retained_wage = $data->retained_wage;
        $compensation = $data->compensation;
        $night_shift = $data->night_shift;
        $overtime_wage = $data->overtime_wage;
        $seniority_wage = $data->seniority_wage;
        $tcxj = $data->tcxj;
        $qyxj = $data->qyxj;
        $ltxbc = $data->ltxbc;
        $bc = $data->bc;

        $wage_total = $annual * 100 + $wage * 100 + $retained_wage * 100 + $compensation * 100 + $night_shift * 100;
        $wage_total += $overtime_wage * 100 + $seniority_wage * 100 + $tcxj * 100 + $qyxj * 100;
        $wage_total += $ltxbc * 100 + $bc * 100;
        $wage_total = $wage_total / 100;

        $res['wage_total'] = $wage_total;

        if (in_array($data->policyNumber, $yfct)) {
            $res['wage_total'] = 0;
            $res['yfnt'] = 0;
            $res['yfct'] = $wage_total;
        } elseif (in_array($data->policyNumber, $yfnt)) {
            $res['wage_total'] = 0;
            $res['yfnt'] = $wage_total;
            $res['yfct'] = 0;
        } else {
            $res['wage_total'] = $wage_total;
            $res['yfnt'] = 0;
            $res['yfct'] = 0;
        }

        return $res;
    }

    /**
     * 计算奖金合计字段.
     *
     * @param int $period 会计期间ID
     */
    private function calBonus(int $period): void
    {
        // 先计算明细数据,再update数据
        $datas = $this->calBonusDetail($period);
        foreach ($datas as $d)
        {
            Bonus::updateOrCreate(
                ['period_id' => $period, 'policyNumber' => $d->policynumber],
                [
                    'special' => $d->special,
                    'competition' => $d->competition,
                    'class_reward' => $d->class_reward,
                    'holiday' => $d->holiday,
                    'party_reward' => $d->party_reward,
                    'union_paying' => $d->union_paying,
                    'other_reward' => $d->other_reward,
                ]
            );

            Other::updateOrCreate(
                ['period_id' => $period, 'policyNumber' => $d->policynumber],
                [
                    'finance_article' => $d->finance_article,
                    'union_article' => $d->union_article,
                ]
            );
        }

        $sqlstring = 'UPDATE bonus SET bonus_total = month_bonus + special + competition + class_reward + holiday';
        $sqlstring .= ' + party_reward + union_paying + other_reward WHERE period_id = ?';
        DB::update($sqlstring, [$period]);
    }

    /**
     * 计算补贴合计字段.
     *
     * @param int $period 会计期间ID
     */
    private function calSubsidy(int $period): void
    {
        $sqlstring = 'UPDATE subsidy SET subsidy_total= traffic + single + housing + communication WHERE period_id = ?';
        DB::update($sqlstring, [$period]);
    }

    /**
     * 计算社保合计字段.
     *
     * @param int $period 会计期间ID
     */
    private function calInsurances(int $period): void
    {
        $sqlstring = 'UPDATE insurances SET enterprise_out_total = gjj_out_range + annuity_out_range';
        $sqlstring .= ' + retire_out_range + medical_out_range + unemployment_out_range,';
        $sqlstring .= ' specail_deduction = gjj_deduction+retire_deduction+medical_deduction+unemployment_deduction';
        $sqlstring .= ' WHERE period_id = ?';
        DB::update($sqlstring, [$period]);
    }

    /**
     * 计算补发合计字段.
     *
     * @param int $period 会计期间ID
     */
    private function calReissue(int $period): void
    {
        $sqlstring = 'UPDATE reissue SET reissue_total=reissue_wage+reissue_subsidy+reissue_other WHERE period_id = ?';
        DB::update($sqlstring, [$period]);
    }

    /**
     * 计算其他费用——稿费合计字段.
     *
     * @param int $period 会计期间ID
     */
    private function calOther(int $period): void
    {
        // 稿酬合计
        $sqlstring = 'UPDATE other SET article_fee = finance_article + union_article WHERE period_id = ?';
        DB::update($sqlstring, [$period]);
    }

    /**
     * 计算扣款合计字段.
     *
     * @param int $period 会计期间ID
     */
    private function calDeduction(int $period): void
    {
        // 获取上期余欠款
        // 查询上期是否有余欠款的数据
        $deductions = Special::where('period_id', $period - 1)->where('debt_salary', '>', 0)
            ->select(['policyNumber', 'debt_salary'])->get();
        // 如果上期存在余欠款数据，则插入到当期的 上期余欠款 字段。
        if (count($deductions) > 0) {
            foreach ($deductions as $d) {
                Deduction::updateOrCreate(
                    ['policyNumber' => $d->policyNumber, 'period_id' => $period],
                    ['prior_deduction' => $d->debt_salary],
                );
            }
        }

        // 计算 水电、物管、其他扣除、扣欠款
        $sqlstring = 'UPDATE deduction d ';
        $sqlstring .= 'SET ';
        // 物管
        $sqlstring .= 'd.property_fee = d.garage_property + d.cc_property + d.xy_property + d.back_property, ';
        // 水电
        $sqlstring .= 'd.water_electric = d.garage_water + d.garage_electric + d.cc_water + d.cc_electric + ';
        $sqlstring .= 'd.xy_water + d.xy_electric + d.back_water + d.back_electric, ';
        // 其他扣除
        $sqlstring .= 'd.sum_deduction = d.car_deduction + d.rest_deduction, ';
        // 扣欠款
        $sqlstring .= 'd.debt = d.fixed_deduction + d.other_deduction + d.temp_deduction + d.union_deduction + ';
        $sqlstring .= 'd.car_fee + d.prior_deduction - d.had_debt ';
        $sqlstring .= 'WHERE d.period_id = ?';

        DB::update($sqlstring, [$period]);
    }

    /**
     * 计算专项合计字段.
     *
     * @param int $period 会计期间ID
     */
    private function calTax(int $period): void
    {
        // 获取上期个人所得税
        $taxs = TaxImport::where('period_id', $period - 1)
            ->select(['policyNumber', 'personal_tax'])->get();
        // 将数据写入当期的 上期已扣税 字段
        if (count($taxs) > 0) {
            foreach ($taxs as $t) {
                TaxImport::updateOrCreate(
                    ['policyNumber' => $t->policyNumber, 'period_id' => $period],
                    ['prior_had_deducted_tax' => $t->personal_tax],
                );
            }
        }
        TaxImport::where('period_id', $period)->update(['personal_tax' => 0]);

        $sqlstring = 'UPDATE taxImport t ';
        $sqlstring .= 'LEFT JOIN ( ';
        // 子查询
        $sqlstring .= 'SELECT a.policyNumber, a.aa, IFNULL(b.article_add_tax, 0) as bb, IFNULL(b.franchise_add_tax, 0) as cc ';
        $sqlstring .= 'FROM ';
        $sqlstring .= '(SELECT period_id, policyNumber, should_be_tax as aa FROM taxImport ';
        $sqlstring .= 'WHERE period_id = ? ) a ';
        $sqlstring .= 'LEFT JOIN ';
        $sqlstring .= '(SELECT o.period_id, policyNumber, o.article_add_tax, o.franchise_add_tax FROM other o ';
        $sqlstring .= 'WHERE o.period_id = ? ) b ';
        $sqlstring .= 'ON a.policyNumber = b.policyNumber AND a.period_id = b.period_id ';
        $sqlstring .= ') tt ';
        $sqlstring .= 'ON t.policyNumber = tt.policyNumber ';
        $sqlstring .= 'SET ';
        // 个人所得税
        $sqlstring .= 't.personal_tax = tt.aa + tt.bb + tt.cc, ';
        // 申报个税
        $sqlstring .= 't.declare_tax = t.declare_tax_salary + t.declare_tax_article + t.declare_tax_franchise, ';
        // 税差
        $sqlstring .= 't.tax_diff = (t.declare_tax * 100 - prior_had_deducted_tax * 100) / 100 ';
        $sqlstring .= 'WHERE t.period_id = ? ';

        DB::update($sqlstring, [$period, $period, $period]);
    }

    /**
     * 更新合计表数据.
     *
     * @param int $period 会计期间ID
     */
    private function calSummary(int $period): void
    {
        $data = [];

        // 先清空当期合计表数据
        SalarySummary::where('period_id', $period)->update([
            'wage_total' => 0,
            'bonus_total' => 0,
            'subsidy_total' => 0,
            'reissue_total' => 0,
            'enterprise_out_total' => 0,
            'should_total' => 0,
            'salary_total' => 0,
        ]);
        // 再更新
        $sqlstring = 'SELECT up.policyNumber, ';
        $sqlstring .= '(IFNULL(w.wage_total, 0) + IFNULL(w.yfct, 0) + IFNULL(w.yfnt, 0)) as wage_total, ';
        $sqlstring .= 'IFNULL(b.bonus_total, 0) as bonus_total, IFNULL(s.subsidy_total, 0) as subsidy_total,';
        $sqlstring .= 'IFNULL(r.reissue_total , 0) as reissue_total, IFNULL(i.enterprise_out_total, 0) as enterprise_out_total,';
        $sqlstring .= '(IFNULL(w.wage_total, 0) + IFNULL(w.yfct, 0) + IFNULL(w.yfnt, 0) + IFNULL(s.subsidy_total, 0) + IFNULL(r.reissue_total , 0)) as should_total, ';
        $sqlstring .= '(IFNULL(w.wage_total, 0) + IFNULL(w.yfct, 0) + IFNULL(w.yfnt, 0) + IFNULL(s.subsidy_total, 0) + IFNULL(r.reissue_total , 0) + IFNULL(b.bonus_total, 0) + IFNULL(i.enterprise_out_total, 0)) as salary_total ';
        $sqlstring .= 'FROM userProfile up ';
        $sqlstring .= 'LEFT JOIN wage w ON up.policyNumber = w.policyNumber AND w.period_id = ? ';
        $sqlstring .= 'LEFT JOIN bonus b ON up.policyNumber = b.policyNumber AND b.period_id = ? ';
        $sqlstring .= 'LEFT JOIN subsidy s ON up.policyNumber = s.policyNumber AND s.period_id = ? ';
        $sqlstring .= 'LEFT JOIN reissue r ON up.policyNumber = r.policyNumber AND r.period_id = ? ';
        $sqlstring .= 'LEFT JOIN insurances i ON up.policyNumber = i.policyNumber AND i.period_id = ? ';
        $summary = DB::select($sqlstring, [
            $period, $period, $period, $period, $period,
        ]);

        foreach ($summary as $s) {
            SalarySummary::updateOrCreate(['period_id' => $period, 'policyNumber' => $s->policyNumber], [
                'wage_total' => $s->wage_total ?? 0,
                'bonus_total' => $s->bonus_total ?? 0,
                'subsidy_total' => $s->subsidy_total ?? 0,
                'reissue_total' => $s->reissue_total ?? 0,
                'enterprise_out_total' => $s->enterprise_out_total ?? 0,
                'should_total' => $s->should_total ?? 0,
                'salary_total' => $s->salary_total ?? 0,
            ]);
        }
    }

    /**
     * 更新代汇数据.
     *
     * @param int $period 会计期间ID
     */
    private function calInstead(int $period): void
    {
        // 获取 需要代汇 的人员保险编号
        $temp = [];
        $sqlstring = 'SELECT up.policyNumber FROM card_info c LEFT JOIN userProfile up ON c.user_id = up.user_id';
        $policies = DB::select($sqlstring);
        foreach ($policies as $p) {
            $temp[] = $p->policyNumber;
        }
        // 计算实发工资
        $sqlstring = 'SELECT d.dwdm, u.policyNumber, s.period_id, ';
        $sqlstring .= '(s.should_total * 100 ';
        $sqlstring .= '- ifnull(i.gjj_person, 0) * 100 - ifnull(i.annuity_person,0) * 100 ';
        $sqlstring .= '- ifnull(i.retire_person, 0) * 100 - ifnull(i.medical_person, 0) * 100 ';
        $sqlstring .= '- ifnull(i.unemployment_person, 0) * 100 - ifnull(de.water_electric, 0) * 100 ';
        $sqlstring .= '- ifnull(de.property_fee, 0) * 100 - ifnull(de.debt, 0) * 100 ';
        $sqlstring .= '- ifnull(de.donate, 0) * 100 - ifnull(t.personal_tax, 0) * 100';
        $sqlstring .= '- ifnull(t.tax_diff, 0) * 100 ) / 100 as actual_salary ';
        $sqlstring .= 'FROM userProfile u ';
        $sqlstring .= 'LEFT JOIN departments d ON u.department_id = d.id ';
        $sqlstring .= 'LEFT JOIN summary s ON u.policyNumber = s.policyNumber AND s.period_id = ? ';
        $sqlstring .= 'LEFT JOIN insurances i ON u.policyNumber = i.policyNumber AND i.period_id = ? ';
        $sqlstring .= 'LEFT JOIN deduction de ON u.policyNumber = de.policyNumber AND de.period_id = ? ';
        $sqlstring .= 'LEFT JOIN taxImport t ON u.policyNumber = t.policyNumber AND t.period_id = ? ';

        $insteads = DB::select($sqlstring, [$period, $period, $period, $period]);
        // 重置当期的代汇数据
        Special::where('period_id', $period)->update([
            'actual_salary' => 0,
            'debt_salary' => 0,
            'instead_salary' => 0,
            'bank_salary' => 0,
            'court_salary' => 0,
        ]);

        $data = [];
        foreach ($insteads as $k => $i) {
            // dwdm like 010101, 0102
            if ('010101' === substr($i->dwdm, 0, 6) || '0102' === substr($i->dwdm, 0, 4)) {
                // 实发工资 < 0，余欠款 = 1 - 实发工资
                if ($i->actual_salary < 0) {
                    $actual_salary = $i->actual_salary;
                    $debt_salary = 1 - $i->actual_salary;
                } else {
                    $actual_salary = $i->actual_salary;
                    $debt_salary = 0;
                }
            } else {
                $actual_salary = 0;
                $debt_salary = 0;
            }
            // 是否是 代汇
            if (in_array($i->policyNumber, $temp, true)) {
                $instead_salary = $actual_salary + $debt_salary;
                $bank_salary = 0;
            } else {
                $instead_salary = 0;
                $bank_salary = $actual_salary + $debt_salary;
            }
            $data[$k] = [
                'policyNumber' => $i->policyNumber,
                'actual_salary' => $actual_salary,
                'debt_salary' => $debt_salary,
                'instead_salary' => $instead_salary,
                'bank_salary' => $bank_salary,
                'court_salary' => 0,
            ];
        }

        foreach ($data as $d) {
            Special::updateOrCreate(['period_id' => $period, 'policyNumber' => $d['policyNumber']], [
                'actual_salary' => $d['actual_salary'],
                'debt_salary' => $d['debt_salary'],
                'instead_salary' => $d['instead_salary'],
                'bank_salary' => $d['bank_salary'],
                // 法院转提 暂时为 0
                'court_salary' => 0,
            ]);
        }
    }

    /**
     * 查询个人打印数据.
     *
     * @param array  $periods 会计期
     * @param string $policy  保险编号
     *
     * @return array
     */
    public function getPersonPrintData($periods, $policy): array
    {
        $pstring = implode(',', $periods);

        //region 查询SQL
        $sqlstring = 'SELECT p.published_at, ';
        $sqlstring .= ' w.annual, w.wage, w.retained_wage, w.compensation, w.night_shift, w.seniority_wage, w.overtime_wage,';
        $sqlstring .= ' b.month_bonus, b.special, b.competition, b.class_reward, b.holiday, b.party_reward, b.other_reward, b.union_paying,';
        $sqlstring .= ' s.communication, s.housing, s.single, s.traffic, r.reissue_wage, r.reissue_subsidy, r.reissue_other,';
        $sqlstring .= ' i.retire_person, i.medical_person, i.unemployment_person, i.gjj_person, i.annuity_person,';
        $sqlstring .= ' Round((d.water_electric + d.property_fee), 2) as property, Round((d.debt + d.donate), 2) as debt, d.union_deduction,';
        $sqlstring .= ' t.tax_child, t.tax_old, t.tax_edu, t.tax_loan, t.tax_rent, t.tax_other_deduct, t.deduct_donate, t.personal_tax,';
        $sqlstring .= ' t.tax_income, t.taxable, t.tax_reliefs, t.should_deducted_tax, t.have_deducted_tax, t.should_be_tax, t.prior_had_deducted_tax,';
        $sqlstring .= ' t.income, t.deduct_expenses, t.special_deduction,';
        $sqlstring .= ' Round((d.water_electric + d.property_fee + d.debt + d.donate + d.union_deduction + t.personal_tax + t.tax_diff), 2) as deduction_total,';
        $sqlstring .= ' summary.wage_total, summary.bonus_total, summary.subsidy_total, summary.reissue_total, summary.salary_total';
        $sqlstring .= ' FROM periods p';
        $sqlstring .= ' LEFT JOIN summary ON p.id = summary.period_id AND summary.policyNumber = ? ';
        $sqlstring .= ' LEFT JOIN wage w ON p.id = w.period_id AND w.policyNumber = ? ';
        $sqlstring .= ' LEFT JOIN bonus b ON p.id = b.period_id AND b.policyNumber = ? ';
        $sqlstring .= ' LEFT JOIN subsidy s ON p.id = s.period_id AND s.policyNumber = ? ';
        $sqlstring .= ' LEFT JOIN reissue r ON p.id = r.period_id AND r.policyNumber = ? ';
        $sqlstring .= ' LEFT JOIN insurances i ON p.id = i.period_id AND i.policyNumber = ? ';
        $sqlstring .= ' LEFT JOIN taxImport t ON p.id = t.period_id AND t.policyNumber = ? ';
        $sqlstring .= ' LEFT JOIN deduction d ON p.id = d.period_id AND d.policyNumber = ? ';
        $sqlstring .= ' WHERE summary.period_id IN ('.$pstring.')';
        $sqlstring .= ' AND w.period_id IN ('.$pstring.')';
        $sqlstring .= ' AND b.period_id IN ('.$pstring.')';
        $sqlstring .= ' AND s.period_id IN ('.$pstring.')';
        $sqlstring .= ' AND r.period_id IN ('.$pstring.')';
        $sqlstring .= ' AND i.period_id IN ('.$pstring.')';
        $sqlstring .= ' AND t.period_id IN ('.$pstring.')';
        $sqlstring .= ' AND d.period_id IN ('.$pstring.')';
        $sqlstring .= ' ORDER BY p.id DESC';
        //endregion

        return DB::select($sqlstring, [$policy, $policy, $policy, $policy, $policy, $policy, $policy, $policy]);
    }

    /**
     * 计算明细数据，转横表
     *
     * @param int $period
     * @return array
     */
    public function calBonusDetail(int $period): array
    {
        $sqlstring = 'SELECT b.policynumber, b.period_id,';
        $sqlstring .= "SUM(IF(type_id = 13, b.money, 0)) AS 'special',";
        $sqlstring .= "SUM(IF(type_id = 14, b.money, 0)) AS 'competition',";
        $sqlstring .= "SUM(IF(type_id = 15, b.money, 0)) AS 'class_reward',";
        $sqlstring .= "SUM(IF(type_id = 16, b.money, 0)) AS 'holiday',";
        $sqlstring .= "SUM(IF(type_id = 17, b.money, 0)) AS 'party_reward',";
        $sqlstring .= "SUM(IF(type_id = 18, b.money, 0)) AS 'union_paying',";
        $sqlstring .= "SUM(IF(type_id = 19, b.money, 0)) AS 'other_reward',";
        $sqlstring .= "SUM(IF(type_id = 37, b.money, 0)) AS 'finance_article',";
        $sqlstring .= "SUM(IF(type_id = 38, b.money, 0)) AS 'union_article' ";
        $sqlstring .= 'FROM bonus_detail b ';
        $sqlstring .= 'left join workflows w on b.wf_id = w.id ';
        $sqlstring .= 'where b.period_id = ?  ';
        $sqlstring .= 'and w.isconfirm = 1 ';
        $sqlstring .= 'GROUP BY b.policynumber, b.period_id';

        return DB::select($sqlstring, [$period]);
    }
}
