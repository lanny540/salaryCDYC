<?php

namespace App\Services;

use App\Models\Period;
use App\Models\Salary\SalarySummary;
use App\Models\Users\UserProfile;
use Carbon\Carbon;

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
}
