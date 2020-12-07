<?php

namespace App\Services;

use App\Models\Period;
use App\Models\Salary\Bonus;
use App\Models\Salary\Insurances;
use App\Models\Salary\SalarySummary;
use App\Models\Salary\TaxImport;
use App\Models\Users\UserProfile;
use Carbon\Carbon;
use DB;

class SalaryData
{
    /**
     * 输出首页图表所需数据.
     *
     * @param int    $userId 用户ID
     * @param string $year   年份
     *
     * @return mixed
     */
    public function getDashboardSalary($userId, $year)
    {
        $policyNumber = $this->getPolicyNumber($userId);
        $periods = $this->getPeriodIds($year);

        $res['salary'] = SalarySummary::where('policyNumber', $policyNumber)
            ->whereIn('period_id', $periods)
            ->leftJoin('periods', 'periods.id', '=', 'summary.period_id')
            ->select(['salary_total', 'periods.published_at'])
            ->orderBy('period_id')->get();
        $res['total'] = SalarySummary::where('policyNumber', $policyNumber)
            ->whereIn('period_id', $periods)
            ->sum('salary_total');
        $res['tax'] = TaxImport::where('policyNumber', $policyNumber)
            ->whereIn('period_id', $periods)
            ->sum('personal_tax');

        return $res;
    }

    /**
     * 根据年份获取年收入概况.
     *
     * @param int    $userId 用户ID
     * @param string $year   年份
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function getYearSalary($userId, $year)
    {
        $period = $this->getPeriodIds($year);
        $policyNumber = $this->getPolicyNumber($userId);

        return SalarySummary::where('summary.policyNumber', $policyNumber)
            ->whereIn('summary.period_id', $period)
            ->leftJoin('periods', 'periods.id', '=', 'summary.period_id')
            ->select(['should_total', 'bonus_total', 'salary_total', 'summary.period_id', 'periods.published_at'])
            ->orderBy('summary.period_id', 'desc')->get();
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

        return Period::where('published_at', 'like', $y.'%')
            ->get()->pluck('id');
    }

    /**
     * 根据UID查询保险编号.
     *
     * @param int $userId 用户ID
     *
     * @return mixed|string
     */
    public function getPolicyNumber($userId)
    {
        return 1 === $userId ? '0500038' : UserProfile::where('user_id', $userId)->first()->policyNumber;
//        return UserProfile::where('user_id', $userId)->first()->policyNumber;
    }

    /**
     * 获取明细数据.
     *
     * @param int $periodId 会计期ID
     * @param int $userId   用户ID
     *
     * @return array
     */
    public function getDetailSalary($periodId, $userId = 0)
    {
        $data = [];
        if (0 === $userId) {
            $wage = $this->getWage($periodId);
            $bonus = $this->getBonus($periodId);
            $subsidy = $this->getSubsidy($periodId);
            $reissue = $this->getReissue($periodId);
            $outRange = $this->getOutRange($periodId);
            $insurance = $this->getInsurance($periodId);
            $deduction = $this->getDeduction($periodId);
            $tax = $this->getTax($periodId);
        } else {
            $policy = $this->getPolicyNumber($userId);
            $wage = $this->getWage($periodId, $policy);
            $bonus = $this->getBonus($periodId, $policy);
            $subsidy = $this->getSubsidy($periodId, $policy);
            $reissue = $this->getReissue($periodId, $policy);
            $outRange = $this->getInsurance($periodId, $policy);
            $insurance = $this->getInsurance($periodId, $policy);
            $deduction = $this->getDeduction($periodId, $policy);
            $tax = $this->getTax($periodId, $policy);
        }

        $data['应发工资'] = $wage;
        $data['奖金合计'] = $bonus;
        $data['补贴合计'] = $subsidy;
        $data['补发合计'] = $reissue;
        $data['企业超合计'] = $outRange;
        $data['扣款合计'] = $deduction;
        $data['社保相关'] = $insurance;
        $data['专项相关'] = $tax;

        return $data;
    }

    /**
     * 查询应发工资.
     *
     * @param int    $periodId 会计期ID
     * @param string $policy   保险编号
     *
     * @return array
     */
    public function getWage($periodId, $policy = '')
    {
        $sqlstring = 'policyNumber AS 保险编号, wage_total AS 应发工资, annual AS 年薪工资, wage AS 岗位工资, retained_wage AS 保留工资, ';
        $sqlstring .= 'compensation AS 套级补差, night_shift AS 中夜班费, overtime_wage AS 加班工资, seniority_wage AS 年功工资';

        if ('' !== $policy) {
            return DB::select(
                'select '.$sqlstring.' from wage where period_id = ? AND policyNumber = ?',
                [$periodId, $policy]
            );
        }

        return DB::select('select '.$sqlstring.' from wage where period_id = ?', [$periodId]);
    }

    /**
     * 查询奖金合计
     *
     * @param int    $periodId 会计期ID
     * @param string $policy   保险编号
     *
     * @return array
     */
    public function getBonus($periodId, $policy = '')
    {
        $sqlstring = 'policyNumber AS 保险编号, month_bonus AS 月奖, special AS 专项奖, competition AS 劳动竞赛, ';
        $sqlstring .= 'class_reward AS 课酬, holiday AS 节日慰问费, party_reward AS 党员奖励, union_paying AS 工会发放, ';
        $sqlstring .= 'other_reward AS 其他奖励, bonus_total AS 奖金合计';

        if ('' !== $policy) {
            return DB::select(
                'select '.$sqlstring.' from bonus where period_id = ? AND policyNumber = ?',
                [$periodId, $policy]
            );
        }

        return DB::select('select '.$sqlstring.' from bonus where period_id = ?', [$periodId]);
    }

    /**
     * 查询补贴.
     *
     * @param int    $periodId 会计期ID
     * @param string $policy   保险编号
     *
     * @return array
     */
    public function getSubsidy($periodId, $policy = '')
    {
        $sqlstring = 'policyNumber AS 保险编号, communication AS 通讯补贴, traffic AS 交通补贴, ';
        $sqlstring .= 'housing AS 住房补贴, single AS 独子费, subsidy_total AS 补贴合计';
        if ('' !== $policy) {
            return DB::select(
                'select '.$sqlstring.' from subsidy where period_id = ? AND policyNumber = ?',
                [$periodId, $policy]
            );
        }

        return DB::select('select '.$sqlstring.' from subsidy where period_id = ?', [$periodId]);
    }

    /**
     * 查询补发.
     *
     * @param int    $periodId 会计期ID
     * @param string $policy   保险编号
     *
     * @return array
     */
    public function getReissue($periodId, $policy = '')
    {
        $sqlstring = 'policyNumber AS 保险编号, reissue_wage AS 补发工资, reissue_subsidy AS 补发补贴, ';
        $sqlstring .= 'reissue_other AS 补发其他, reissue_total AS 补发合计';
        if ('' !== $policy) {
            return DB::select(
                'select '.$sqlstring.' from reissue where period_id = ? AND policyNumber = ?',
                [$periodId, $policy]
            );
        }

        return DB::select('select '.$sqlstring.' from reissue where period_id = ?', [$periodId]);
    }

    /**
     * 查询企业超合计.
     *
     * @param int    $periodId 会计期ID
     * @param string $policy   保险编号
     *
     * @return array
     */
    public function getOutRange($periodId, $policy = '')
    {
        $sqlstring = 'policyNumber AS 保险编号, gjj_out_range AS 公积企超标, annuity_out_range AS 年金企超标, ';
        $sqlstring .= 'retire_out_range AS 退养企超标, medical_out_range AS 医疗企超标, ';
        $sqlstring .= 'unemployment_out_range AS 失业企超标, enterprise_out_total AS 企业超合计';
        if ('' !== $policy) {
            return DB::select(
                'select '.$sqlstring.' from insurances where period_id = ? AND policyNumber = ?',
                [$periodId, $policy]
            );
        }

        return DB::select('select '.$sqlstring.' from insurances where period_id = ?', [$periodId]);
    }

    /**
     * 查询社保相关.
     *
     * @param int    $periodId 会计期ID
     * @param string $policy
     *
     * @return array
     */
    public function getInsurance($periodId, $policy = '')
    {
        $sqlstring = 'policyNumber AS 保险编号, gjj_person AS 公积金, annuity_person AS 年金个人, ';
        $sqlstring .= 'retire_person AS 养老保险, medical_person AS 医疗保险, unemployment_person AS 失业保险 ';
        if ('' !== $policy) {
            return DB::select(
                'select '.$sqlstring.' from insurances where period_id = ? AND policyNumber = ?',
                [$periodId, $policy]
            );
        }

        return DB::select('select '.$sqlstring.' from insurances where period_id = ?', [$periodId]);
    }

    /**
     * 查询扣款相关.
     *
     * @param int    $periodId 会计期ID
     * @param string $policy
     *
     * @return array
     */
    public function getDeduction($periodId, $policy = '')
    {
        $sqlstring = 'SELECT d.policyNumber AS 保险编号, (d.water_electric + d.property_fee) AS 扣水电物管, ';
        $sqlstring .= '(d.debt + d.donate) AS 扣欠款及捐赠, d.union_deduction AS 扣工会会费, ';
        $sqlstring .= 't.tax_diff AS 税差, t.personal_tax AS 个人所得税, ';
        $sqlstring .= '(d.water_electric + d.property_fee + d.debt + d.donate + d.union_deduction + t.tax_diff + t.personal_tax) AS 扣款合计 ';
        $sqlstring .= 'FROM deduction d ';
        $sqlstring .= 'LEFT JOIN taxImport t ON d.policyNumber = t.policyNumber AND t.period_id = ? ';

        if ('' !== $policy) {
            $sqlstring .= 'WHERE d.period_id = ? AND d.policyNumber = ? AND t.period_id = ? AND t.policyNumber = ?';

            return DB::select($sqlstring, [$periodId, $periodId, $policy, $periodId, $policy]);
        }

        $sqlstring .= 'WHERE d.period_id = ? AND t.period_id = ? ';

        return DB::select($sqlstring, [$periodId, $periodId, $periodId]);
    }

    /**
     * 查询专项税务相关.
     *
     * @param int    $periodId 会计期ID
     * @param string $policy
     *
     * @return array
     */
    public function getTax($periodId, $policy = '')
    {
        $sqlstring = 'policyNumber AS 保险编号, income AS 累计收入额, deduct_expenses AS 累减除费用, special_deduction AS 累计专项扣, ';
        $sqlstring .= 'tax_child AS 累专附子女, tax_old AS 累专附老人, tax_edu AS 累专附继教, tax_loan AS 累专附房利, tax_rent AS 累专附房租, ';
        $sqlstring .= 'tax_other_deduct AS 累其他扣除, deduct_donate AS 累计扣捐赠, tax_income AS 累计应纳税所得额, taxrate AS 税率, ';
        $sqlstring .= 'quick_deduction AS 速算扣除数, taxable AS 累计应纳税, tax_reliefs AS 累计减免税,should_deducted_tax AS 累计应扣税, ';
        $sqlstring .= 'have_deducted_tax AS 累计申扣税, should_be_tax AS 累计应补税, prior_had_deducted_tax AS 上月已扣税';
        if ('' !== $policy) {
            return DB::select(
                'select '.$sqlstring.' from taxImport where period_id = ? AND policyNumber = ?',
                [$periodId, $policy]
            );
        }

        return DB::select('select '.$sqlstring.' from taxImport where period_id = ?', [$periodId]);
    }

    /**
     * 获取图表数据.
     *
     * @param int $periodId 会计期ID
     * @param int $userId   用户ID
     *
     * @return array
     */
    public function getChartSalary($periodId, $userId)
    {
        $policy = $this->getPolicyNumber($userId);
        $inner = $this->getInnerRingSalary($periodId, $policy);
        $outer = $this->getOuterRingSalary($periodId, $policy);

        return array_merge($inner, $outer);
    }

    /**
     * 返回内环所需要的数据.
     *
     * @param int    $periodId 会计期ID
     * @param string $policy   保险编号
     *
     * @return array
     */
    private function getInnerRingSalary($periodId, $policy)
    {
        return SalarySummary::where('period_id', $periodId)
            ->where('policyNumber', $policy)
            ->selectRaw('salary_total AS 工资薪金, should_total AS 应发合计, bonus_total AS 奖金合计,enterprise_out_total AS 企业超合计')
            ->firstOrFail()->toArray();
    }

    /**
     * 返回外环所需要的数据.
     *
     * @param int    $periodId 会计期ID
     * @param string $policy   保险编号
     *
     * @return array
     */
    private function getOuterRingSalary($periodId, $policy)
    {
        $wage = SalarySummary::selectRaw('wage_total AS 应发工资, subsidy_total AS 补贴合计, reissue_total AS 补发合计')
            ->where('period_id', $periodId)
            ->where('policyNumber', $policy)
            ->firstOrFail()->toArray();

        $sqlstring1 = 'month_bonus AS 月奖, special AS 专项奖, competition AS 劳动竞赛, class_reward AS 课酬, ';
        $sqlstring1 .= 'holiday AS 节日慰问费, party_reward AS 党员奖励, union_paying AS 工会发放, other_reward AS 其他奖励';
        $bonus = Bonus::selectRaw($sqlstring1)
            ->where('period_id', $periodId)
            ->where('policyNumber', $policy)
            ->firstOrFail()->toArray();

        $sqlstring2 = 'gjj_out_range AS 公积企超标, annuity_out_range AS 年金企超标, retire_out_range AS 退养企超标, ';
        $sqlstring2 .= 'medical_out_range AS 医疗企超标, unemployment_out_range AS 失业企超标';
        $insurances = Insurances::selectRaw($sqlstring2)
            ->where('period_id', $periodId)
            ->where('policyNumber', $policy)
            ->firstOrFail()->toArray();

        return array_merge($wage, $bonus, $insurances);
    }

    /**
     * 薪酬查询.
     *
     * @param $types
     * @param $periods
     *
     * @return array
     */
    public function search($types, $periods)
    {
        $columns = $this->getSearchColumn($types);
        $periods = Period::whereIn('id', $periods)
            ->pluck('id')->toArray();

        $policy = $this->getPolicyNumber(\Auth::id());
        $sqlstring = $this->getSearchSql($columns, $periods, $policy);

        return DB::select($sqlstring);
    }

    /**
     * 返回查询的表名及字段名称.
     *
     * @param $types
     *
     * @return array
     */
    private function getSearchColumn($types)
    {
        switch ($types) {
            case 's1':
                $columns = [
                    'table' => 'wage',
                    'columns' => [
                        'wage_total' => '应发工资',
                    ],
                ];
                break;
            case 's2':
                $columns = [
                    'table' => 'bonus',
                    'columns' => [
                        'month_bonus' => '月奖',
                    ],
                ];
                break;
            case 's3':
                $columns = [
                    'table' => 'bonus',
                    'columns' => [
                        'competition' => '劳动竞赛',
                    ],
                ];
                break;
            case 's4':
                $columns = [
                    'table' => 'bonus',
                    'columns' => [
                        'other_reward' => '其他奖励',
                    ],
                ];
                break;
            case 's5':
                $columns = [
                    'table' => 'subsidy',
                    'columns' => [
                        'communication' => '通讯补贴',
                        'housing' => '住房补贴',
                        'traffic' => '交通补贴',
                        'single' => '独子费',
                    ],
                ];
                break;
            case 's6':
                $columns = [
                    'table' => 'insurances',
                    'columns' => [
                        'gjj_person' => '公积金',
                        'annuity_person' => '年金个人',
                        'retire_person' => '养老保险',
                        'medical_person' => '医疗保险',
                        'unemployment_person' => '失业保险',
                    ],
                ];
                break;
            case 's7':
                $columns = [
                    'table' => 'taxImport',
                    'columns' => [
                        'personal_tax' => '个人所得税',
                    ],
                ];
                break;
            default:
                $columns = [];
        }

        return $columns;
    }

    /**
     * 返回查询的sql字符串（将竖表转成横表）.
     *
     * @param $columns
     * @param $periods
     * @param $policyNumber
     *
     * @return string
     */
    private function getSearchSql($columns, $periods, $policyNumber)
    {
        $pstring = implode(',', $periods);
        $sqlstring = 'SELECT ';
        foreach ($columns['columns'] as $k => $v) {
            $sqlstring .= $k.' AS '.$v.', ';
        }
        $sqlstring .= ' p.published_at';
        $sqlstring .= ' FROM '.$columns['table'];
        $sqlstring .= ' LEFT JOIN periods p ON p.id = '.$columns['table'].'.period_id';
        $sqlstring .= ' WHERE policyNumber = '.$policyNumber;
        $sqlstring .= ' AND p.id IN ('.$pstring.') ';

        return $sqlstring;
    }
}
