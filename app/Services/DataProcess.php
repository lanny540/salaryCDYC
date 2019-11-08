<?php

namespace App\Services;

use App\Models\Period;
use App\Models\Salary\Wage;
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
     * @param array  $info   表单提交数据
     * @param string $period 发放日期
     *
     * @return bool|\Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function dataToDb(array $info)
    {
        DB::beginTransaction();

        try {
            $this->salary->saveToTable($info['period'], $info['uploadType'], $info['importData'], $info['isReset']);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

//            return false;
            // 调试用代码
            return redirect()->back()->withErrors($e->getMessage());
        }

        return true;
    }

    /**
     * 根据日期返回会计周期ID.
     *
     * @return int
     */
    public function getPeriodId(): int
    {
        $period = Period::max('id');

        if (empty($period)) {
            return $this->newPeriod();
        }

        return $period;
    }

    /**
     * 关闭当前会计周期
     *
     * @param string $publishedAt
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function closePeriod(string $publishedAt = '')
    {
        $period = Period::latest('id')->first();

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
     * @param int $period
     *
     * @return bool
     * @throws \Exception
     */
    public function calSummary(int $period): bool
    {
        //避免数据部分更新，采用事务处理
        DB::beginTransaction();

        try {
            // 工资
            $this->calWage($period);
            // 奖金
            $this->calBonus($period);
            // 补贴
            $this->calSubsidy($period);
            // 社保
            $this->calInsurances($period);
            // 补发
            $this->calReissue($period);
            // 其他费用——稿费
            $this->calOther($period);
            // 扣款
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

//            return false;
            // 调试用代码
            return redirect()->back()->withErrors($e->getMessage());
        }

        return true;
    }

    /**
     * 计算工资合计字段.
     *
     * @param int $period 会计期ID
     */
    private function calWage(int $period)
    {
        $wage = Wage::where('period_id', $period)->get();
        foreach ($wage as $w) {
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
                    //d
                    'wage_total' => 0,
                    'yfct' => 0,
                    'yfnt' => 0,
                ]
            );
        }
    }

    /**
     * 计算奖金合计字段.
     *
     * @param int $period
     */
    private function calBonus(int $period)
    {
        $sqlstring = 'UPDATE bonus SET bonus_total = month_bonus + special + competition + class_reward + holiday';
        $sqlstring .= ' + party_reward + union_paying + other_reward WHERE period_id = ?';
        DB::update($sqlstring, [$period]);
    }

    /**
     * 计算补贴合计字段.
     *
     * @param int $period
     */
    private function calSubsidy(int $period)
    {
        $sqlstring = 'UPDATE subsidy SET subsidy_total= traffic + single + housing + communication WHERE period_id = ?';
        DB::update($sqlstring, [$period]);
    }

    /**
     * 计算社保合计字段.
     *
     * @param int $period
     */
    private function calInsurances(int $period)
    {
        $sqlstring = 'UPDATE insurances SET enterprise_out_total = gjj_out_range + annuity_out_range + retire_out_range + medical_out_range + unemployment_out_range,';
        $sqlstring .= ' specail_deduction = gjj_deduction + retire_deduction + medical_deduction + unemployment_deduction WHERE period_id = ?';
        DB::update($sqlstring, [$period]);
    }

    /**
     * 计算补发合计字段.
     *
     * @param int $period
     */
    private function calReissue(int $period)
    {
        $sqlstring = 'UPDATE reissue SET reissue_total=reissue_wage+reissue_subsidy+reissue_other WHERE period_id = ?';
        DB::update($sqlstring, [$period]);
    }

    /**
     * 计算其他费用——稿费合计字段.
     *
     * @param int $period
     */
    private function calOther(int $period)
    {
        $sqlstring = 'UPDATE other SET article_fee = finance_article + union_article WHERE period_id = ?';
        DB::update($sqlstring, [$period]);
    }
}
