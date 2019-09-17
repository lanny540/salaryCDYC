<?php

namespace App\Services;

use App\Models\Period;
use App\Models\Salary\Bonus;
use App\Models\Salary\Insurances;
use App\Models\Salary\SalarySummary;
use App\Models\Users\UserProfile;
use Carbon\Carbon;
use DB;

class SalaryData
{
    /**
     * 根据年份获取年收入概况.
     *
     * @param int    $user_id 用户ID
     * @param string $year    年份
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function getYearSalary($user_id, $year)
    {
        $period = $this->getPeriodIds($year);
        $policy_number = $this->getPolicyNumber($user_id);

        return SalarySummary::where('summary.policyNumber', $policy_number)
            ->whereIn('summary.period_id', $period)
            ->leftJoin('periods', 'periods.id', '=', 'summary.period_id')
            ->select(['wage_total', 'bonus_total', 'salary_total', 'summary.period_id', 'periods.published_at'])
            ->orderByDesc('summary.period_id')->get();
    }

    /**
     * 将数据转化成图表需要的格式.
     *
     * @param array $prev 上一年薪酬汇总数据
     * @param array $curr 当前年薪酬汇总数据
     * @param int   $year 当前年
     *
     * @return array
     */
    public function chartData($prev, $curr, $year)
    {
        $data = [];
        $data['pyear'] = $year - 1;
        $data['cyear'] = $year;
        foreach ($prev as $k => $p) {
            $data[$year - 1][$k] = $p['salary_total'];
        }
        foreach ($curr as $k => $c) {
            $data[$year][$k] = $c['salary_total'];
        }

        return $data;
    }

    /**
     * 根据年份获取会计期间ID的数组.
     *
     * @param string $year 年
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPeriodIds($year = '')
    {
        $currentYear = Carbon::now()->year;
        $y = '' === $year ? $currentYear : $year;

        return $period = Period::where('published_at', 'like', $y.'%')
            ->get()->pluck('id');
    }

    /**
     * 根据UID查询保险编号.
     *
     * @param string $user_id 用户ID
     *
     * @return string
     */
    public function getPolicyNumber($user_id): string
    {
        return UserProfile::where('user_id', $user_id)->first()->policyNumber;
    }

    /**
     * 获取明细数据.
     *
     * @param int $user_id 用户ID
     * @param int $period_id 会计期ID
     *
     * @return array
     */
    public function getDetailSalary($period_id, $user_id = 0): array
    {
        $data = [];
        if (0 === $user_id) {
            $wage = $this->getWage($period_id);
            $bonus = $this->getBonus($period_id);
            $subsidy = $this->getSubsidy($period_id);
            $reissue = $this->getReissue($period_id);
            $out_range = $this->getOutRange($period_id);
            // TODO: 扣款
            $insurance = $this->getInsurance($period_id);
            $tax = $this->getTax($period_id);
        } else {
            $policy = $this->getPolicyNumber($user_id);
            $wage = $this->getWage($period_id, $policy);
            $bonus = $this->getBonus($period_id, $policy);
            $subsidy = $this->getSubsidy($period_id, $policy);
            $reissue = $this->getReissue($period_id, $policy);
            $out_range = $this->getInsurance($period_id, $policy);

            $insurance = $this->getInsurance($period_id, $policy);
            $tax = $this->getTax($period_id, $policy);
        }

        $data['应发工资'] = $wage;
        $data['奖金合计'] = $bonus;
        $data['补贴合计'] = $subsidy;
        $data['补发合计'] = $reissue;
        $data['企业超合计'] = $out_range;
        $data['扣款合计'] = [];
        $data['社保相关'] = $insurance;
        $data['专项相关'] = $tax;

        return $data;
    }

    /**
     * 查询应发工资.
     *
     * @param int $period_id 会计期ID
     * @param string $policy 保险编号
     *
     * @return array
     */
    public function getWage($period_id, $policy = ''): array
    {
        $sqlstring = 'policyNumber AS 保险编号, wage_total AS 应发工资, annual AS 年薪工资, wage AS 岗位工资, retained_wage AS 保留工资, ';
        $sqlstring .= 'compensation AS 套级补差, night_shift AS 中夜班费, overtime_wage AS 加班工资, seniority_wage AS 年功工资';

        if ('' !== $policy) {
            return DB::select('select ' . $sqlstring . ' from wage where period_id = ? AND policyNumber = ?', [$period_id, $policy]);
        }

        return DB::select('select ' . $sqlstring . ' from wage where period_id = ?', [$period_id]);
    }

    /**
     * 查询奖金合计
     *
     * @param int $period_id 会计期ID
     * @param string $policy 保险编号
     *
     * @return array
     */
    public function getBonus($period_id, $policy = ''): array
    {
        $sqlstring = 'policyNumber AS 保险编号, month_bonus AS 月奖, special AS 专项奖, competition AS 劳动竞赛, ';
        $sqlstring .= 'class_reward AS 课酬, holiday AS 节日慰问费, party_reward AS 党员奖励, union_paying AS 工会发放, ';
        $sqlstring .= 'other_reward AS 其他奖励, bonus_total AS 奖金合计';

        if ('' !== $policy) {
            return DB::select('select ' . $sqlstring . ' from bonus where period_id = ? AND policyNumber = ?', [$period_id, $policy]);
        }

        return DB::select('select ' . $sqlstring . ' from bonus where period_id = ?', [$period_id]);
    }

    /**
     * 查询补贴.
     *
     * @param int $period_id 会计期ID
     * @param string $policy 保险编号
     *
     * @return array
     */
    public function getSubsidy($period_id, $policy = ''): array
    {
        $sqlstring = 'policyNumber AS 保险编号, communication AS 通讯补贴, traffic AS 交通补贴, ';
        $sqlstring .= 'housing AS 住房补贴, single AS 独子费, subsidy_total AS 补贴合计';
        if ('' !== $policy) {
            return DB::select('select ' . $sqlstring . ' from subsidy where period_id = ? AND policyNumber = ?', [$period_id, $policy]);
        }

        return DB::select('select ' . $sqlstring . ' from subsidy where period_id = ?', [$policy]);
    }

    /**
     * 查询补发.
     *
     * @param int $period_id 会计期ID
     * @param string $policy 保险编号
     *
     * @return array
     */
    public function getReissue($period_id, $policy = ''): array
    {
        $sqlstring = 'policyNumber AS 保险编号, reissue_wage AS 补发工资, reissue_subsidy AS 补发补贴, ';
        $sqlstring .= 'reissue_other AS 补发其他, reissue_total AS 补发合计';
        if ('' !== $policy) {
            return DB::select('select ' . $sqlstring . ' from reissue where period_id = ? AND policyNumber = ?', [$period_id, $policy]);
        }

        return DB::select('select ' . $sqlstring . ' from reissue where period_id = ?', [$policy]);
    }

    /**
     * 查询企业超合计.
     *
     * @param int $period_id 会计期ID
     * @param string $policy 保险编号
     *
     * @return array
     */
    public function getOutRange($period_id, $policy = ''): array
    {
        $sqlstring = 'policyNumber AS 保险编号, gjj_out_range AS 公积企超标, annuity_out_range AS 年金企超标, ';
        $sqlstring .= 'retire_out_range AS 退养企超标, medical_out_range AS 医疗企超标, ';
        $sqlstring .= 'unemployment_out_range AS 失业企超标, enterprise_out_total AS 企业超合计';
        if ('' !== $policy) {
            return DB::select('select ' . $sqlstring . ' from insurances where period_id = ? AND policyNumber = ?', [$period_id, $policy]);
        }

        return DB::select('select ' . $sqlstring . ' from insurances where period_id = ?', [$policy]);
    }

    /**
     * 查询社保相关.
     *
     * @param $period_id
     * @param string $policy
     *
     * @return array
     */
    public function getInsurance($period_id, $policy = ''): array
    {
        $sqlstring = 'policyNumber AS 保险编号, gjj_person AS 公积金个人, gjj_enterprise AS 公积企业缴, gjj_deduction AS 公积金扣除, ';
        $sqlstring .= 'annuity_person AS 年金个人, annuity_enterprise AS 年金企业缴, annuity_deduction AS 年金扣除, ';
        $sqlstring .= 'retire_person AS 退养金个人, retire_enterprise AS 退养企业缴, retire_deduction AS 退养金扣除, ';
        $sqlstring .= 'medical_person AS 医保金个人, medical_enterprise AS 医疗企业缴, medical_deduction AS 医保金补扣, ';
        $sqlstring .= 'unemployment_person AS 失业金个人, unemployment_enterprise AS 失业企业缴, unemployment_deduction AS 失业金扣除, ';
        $sqlstring .= 'injury_enterprise AS 工伤企业缴, birth_enterprise AS 生育企业缴';
        if ('' !== $policy) {
            return DB::select('select ' . $sqlstring . ' from insurances where period_id = ? AND policyNumber = ?', [$period_id, $policy]);
        }

        return DB::select('select ' . $sqlstring . ' from insurances where period_id = ?', [$policy]);
    }

    /**
     * 查询专项税务相关.
     *
     * @param $period_id
     * @param string $policy
     *
     * @return array
     */
    public function getTax($period_id, $policy = ''): array
    {
        $sqlstring = 'policyNumber AS 保险编号, income AS 累计收入额, deduct_expenses AS 累减除费用, special_deduction AS 累计专项扣, ';
        $sqlstring .= 'tax_child AS 累专附子女, tax_old AS 累专附老人, tax_edu AS 累专附继教, tax_loan AS 累专附房利, tax_rent AS 累专附房租, ';
        $sqlstring .= 'tax_other_deduct AS 累其他扣除, deduct_donate AS 累计扣捐赠, tax_income AS 累计应纳税所得额, taxrate AS 税率, ';
        $sqlstring .= 'quick_deduction AS 速算扣除数, taxable AS 累计应纳税, tax_reliefs AS 累计减免税, should_deducted_tax AS 累计应扣税, ';
        $sqlstring .= 'have_deducted_tax AS 累计申扣税, should_be_tax AS 累计应补税, prior_had_deducted_tax AS 上月已扣税';
        if ('' !== $policy) {
            return DB::select('select ' . $sqlstring . ' from taximport where period_id = ? AND policyNumber = ?', [$period_id, $policy]);
        }

        return DB::select('select ' . $sqlstring . ' from taximport where period_id = ?', [$policy]);
    }

    /**
     * 获取图表数据.
     *
     * @param int $user_id 用户ID
     * @param int $period_id 会计期ID
     *
     * @return array
     */
    public function getChartSalary($period_id, $user_id): array
    {
        $policy = $this->getPolicyNumber($user_id);
        $inner = $this->getInnerRingSalary($period_id, $policy);
        $outer = $this->getOuterRingSalary($period_id, $policy);

        return array_merge($inner, $outer);
    }

    /**
     * 返回内环所需要的数据.
     *
     * @param string $policy 保险编号
     * @param int $period_id 会计期ID
     *
     * @return array
     */
    private function getInnerRingSalary($period_id, $policy): array
    {
        return SalarySummary::selectRaw('salary_total AS 工资薪金, should_total AS 应发合计, bonus_total AS 奖金合计, enterprise_out_total AS 企业超合计')
            ->where('period_id', $period_id)
            ->where('policyNumber', $policy)
            ->firstOrFail()->toArray();
    }

    /**
     * 返回外环所需要的数据.
     *
     * @param string $policy 保险编号
     * @param int $period_id 会计期ID
     *
     * @return array
     */
    private function getOuterRingSalary($period_id, $policy): array
    {
        $wage = SalarySummary::selectRaw('wage_total AS 应发工资, subsidy_total AS 补贴合计, reissue_total AS 补发合计')
            ->where('period_id', $period_id)
            ->where('policyNumber', $policy)
            ->firstOrFail()->toArray();

        $sqlstring1 = 'month_bonus AS 月奖, special AS 专项奖, competition AS 劳动竞赛, class_reward AS 课酬, ';
        $sqlstring1 .= 'holiday AS 节日慰问费, party_reward AS 党员奖励, union_paying AS 工会发放, other_reward AS 其他奖励';
        $bonus = Bonus::selectRaw($sqlstring1)
            ->where('period_id', $period_id)
            ->where('policyNumber', $policy)
            ->firstOrFail()->toArray();

        $sqlstring2 = 'gjj_out_range AS 公积企超标, annuity_out_range AS 年金企超标, retire_out_range AS 退养企超标, ';
        $sqlstring2 .= 'medical_out_range AS 医疗企超标, unemployment_out_range AS 失业企超标';
        $insurances = Insurances::selectRaw($sqlstring2)
            ->where('period_id', $period_id)
            ->where('policyNumber', $policy)
            ->firstOrFail()->toArray();

        return array_merge($wage, $bonus, $insurances);
    }
}
