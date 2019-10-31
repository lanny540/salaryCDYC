<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Salary\SalarySummary;
use App\Models\Salary\Special;
use App\Services\DataProcess;
use App\Services\SalaryData;
use Auth;
use Carbon\Carbon;
use DB;

class SalaryController extends Controller
{
    protected $salaryData;
    protected $dataProcess;

    public function __construct(SalaryData $services, DataProcess $dataProcess)
    {
        $this->salaryData = $services;
        $this->dataProcess = $dataProcess;
    }

    /**
     * 个人薪酬信息视图.此处只允许个人查看.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $year = Carbon::now()->year;
        // 获取 去年的薪酬汇总数据
        $preYearSalary = $this->salaryData->getYearSalary(Auth::id(), $year - 1);
        // 获取 今年的薪酬汇总数据
        $curSalary = $this->salaryData->getYearSalary(Auth::id(), $year);
        // 转换成图标需要的数据
        $chartData = $this->salaryData->chartData($preYearSalary, $curSalary, $year);

        return view('salary.index')
            ->with('cursalary', $curSalary)
            ->with('chartdata', json_encode($chartData, JSON_NUMERIC_CHECK));
    }

    /**
     * 个人薪酬明细视图.
     *
     * @param int $period_id 会计期ID
     *
     * @return mixed
     */
    public function show($period_id)
    {
        $periods = Period::select(['id', 'published_at'])
            ->where('enddate', '<>', '')->orderByDesc('id')->get();
        $period = Period::find($period_id);

        $policy = $this->salaryData->getPolicyNumber(Auth::id());
        $summary = SalarySummary::where('period_id', $period_id)
            ->where('policyNumber', $policy)->firstOrFail();
        $detail = $this->salaryData->getDetailSalary($period_id, Auth::id());
        $chartData = $this->salaryData->getChartSalary($period_id, Auth::id());

        return view('salary.show')
            ->with('curPeriod', $period)
            ->with('periods', $periods)
            ->with('summary', $summary)
            ->with('detail', $detail)
            ->with('chartdata', json_encode($chartData, JSON_NUMERIC_CHECK));
    }

    /**
     * 薪酬计算视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function calculate()
    {
        return view('salary.calculate');
    }

    public function calSalary()
    {
        $date = Carbon::now();
        $period = $this->dataProcess->getPeriodId();

        // 扣款
//        // 查询上期是否有余欠款的数据
//        $deductions = Special::where('period_id', $period - 1)->where('debt_salary', '>', 0)->get();
//        // 如果上期存在余欠款数据，则插入到当期的 上期余欠款 中。
//        if (count($deductions) > 0) {
//            $deductions = Special::where('period_id', $period - 1)->where('debt_salary', '>', 0)
//                        ->select(['policyNumber', 'debt_salary'])->get();
//            foreach ($deductions as $d) {
//                Deduction::updateOrCreate(
//                    ['policyNumber' => $d->policyNumber, 'period_id' => $period],
//                    ['prior_deduction' => $d->debt_salary],
//                );
//            }
//        }
//        $sqlstring = 'UPDATE deduction SET property_fee = garage_property + cc_property + xy_property + back_property, ';
//        $sqlstring .= 'water_electric = garage_water + garage_electric + cc_water + cc_electric + xy_water + xy_electric + back_water + back_electric, ';
//        $sqlstring .= 'sum_deduction = car_deduction + rest_deduction, ';
//        $sqlstring .= 'debt = fixed_deduction + other_deduction + temp_deduction + union_deduction + car_fee + prior_deduction - had_debt ';
//        $sqlstring .= ' WHERE period_id = '.$period;
//        DB::update($sqlstring);

        // 合计表
//        $sqlstring = 'SELECT u.policyNumber, wage.period_id, ';
//        $sqlstring .= '(wage.wage_total + wage.yfct + wage.yfnt) as wage_total, ';
//        $sqlstring .= 'bonus.bonus_total,subsidy.subsidy_total,reissue.reissue_total,insurances.enterprise_out_total, ';
//        $sqlstring .= '(wage_total + subsidy.subsidy_total + reissue.reissue_total) as should_total, ';
//        $sqlstring .= '(wage_total + bonus.bonus_total + insurances.enterprise_out_total) as salary_total ';
//        $sqlstring .= 'FROM userprofile u ';
//        $sqlstring .= 'LEFT JOIN wage ON u.policyNumber = wage.policyNumber ';
//        $sqlstring .= 'LEFT JOIN bonus ON u.policyNumber = bonus.policyNumber ';
//        $sqlstring .= 'LEFT JOIN subsidy ON u.policyNumber = subsidy.policyNumber ';
//        $sqlstring .= 'LEFT JOIN reissue ON u.policyNumber = reissue.policyNumber  ';
//        $sqlstring .= 'LEFT JOIN insurances ON u.policyNumber = insurances.policyNumber ';
//        $sqlstring .= 'WHERE wage.period_id = ?';
//        $summary = DB::select($sqlstring, [$period]);
//
//        SalarySummary::where('period_id', $period)->delete();
//        foreach ($summary as $s) {
//            $data[] = [
//                'policyNumber' => $s->policyNumber,
//                'period_id' => $s->period_id,
//                'wage_total' => $s->wage_total,
//                'bonus_total' => $s->bonus_total,
//                'subsidy_total' => $s->subsidy_total,
//                'reissue_total' => $s->reissue_total,
//                'enterprise_out_total' => $s->enterprise_out_total,
//                'should_total' => $s->should_total,
//                'salary_total' => $s->salary_total,
//                'created_at' => $date,
//                'updated_at' => $date,
//            ];
//        }
//        SalarySummary::insert($data);

        // 特殊
        // 获取 需要 代汇的 人员保险编号
        $sqlstring = 'SELECT up.policyNumber FROM card_info c LEFT JOIN userprofile up ON c.user_id = up.user_id';
        $policies = DB::select($sqlstring);
        foreach ($policies as $p) {
            $temp[] = $p->policyNumber;
        }

        $sqlstring = 'SELECT d.dwdm, u.policyNumber, summary.period_id, ';
        $sqlstring .= '(summary.should_total * 100 ';
        $sqlstring .= '- ifnull(insurances.gjj_person, 0) * 100 - ifnull(insurances.annuity_person,0) * 100 ';
        $sqlstring .= '- ifnull(insurances.retire_person, 0) * 100 - ifnull(insurances.medical_person, 0) * 100 ';
        $sqlstring .= '- ifnull(insurances.unemployment_person, 0) * 100 - ifnull(deduction.water_electric, 0) * 100 ';
        $sqlstring .= '- ifnull(deduction.property_fee, 0) * 100 - ifnull(deduction.debt, 0) * 100 ';
        $sqlstring .= '- ifnull(deduction.donate, 0) * 100 - ifnull(taxImport.personal_tax, 0) * 100';
        $sqlstring .= '- ifnull(taxImport.tax_diff, 0) * 100 ) / 100 as actual_salary ';
        $sqlstring .= 'FROM userprofile u ';
        $sqlstring .= 'LEFT JOIN departments d ON u.department_id = d.id ';
        $sqlstring .= 'LEFT JOIN summary ON u.policyNumber = summary.policyNumber ';
        $sqlstring .= 'LEFT JOIN insurances ON u.policyNumber = insurances.policyNumber ';
        $sqlstring .= 'LEFT JOIN deduction ON u.policyNumber = deduction.policyNumber ';
        $sqlstring .= 'LEFT JOIN taxImport ON u.policyNumber = taxImport.policyNumber ';
        $sqlstring .= 'WHERE summary.period_id = ?';

        $special = DB::select($sqlstring, [$period]);
        Special::where('period_id', $period)->delete();
        foreach ($special as $k => $s) {
            // dwdm like 010101, 0102
            if ('010101' == substr($s->dwdm, 0, 6) || '0102' == substr($s->dwdm, 0, 4)) {
                // 实发工资 < 0，余欠款 = 1 - 实发工资
                if ($s->actual_salary < 0) {
                    $actual_salary = 0;
                    $debt_salary = 1 - $s->actual_salary;
                } else {
                    $actual_salary = $s->actual_salary;
                    $debt_salary = 0;
                }
            } else {
                $actual_salary = 0;
                $debt_salary = 0;
            }
            // 是否是 代汇
            if (in_array($s->policyNumber, $temp)) {
                $instead_salary = $actual_salary + $debt_salary;
                $bank_salary = 0;
            } else {
                $instead_salary = 0;
                $bank_salary = $actual_salary + $debt_salary;
            }
            $data[$k] = [
                'policyNumber' => $s->policyNumber,
                'period_id' => $s->period_id,
                'created_at' => $date,
                'updated_at' => $date,
                'actual_salary' => $actual_salary,
                'debt_salary' => $debt_salary,
                'instead_salary' => $instead_salary,
                'bank_salary' => $bank_salary,
                // 法院转提 暂时为 0
                'court_salary' => 0,
            ];
        }
        Special::insert($data);

        return $data;
    }
}
