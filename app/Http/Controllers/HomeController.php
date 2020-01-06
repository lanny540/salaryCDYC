<?php

namespace App\Http\Controllers;

use App\Models\Salary\SalaryLog;
use App\Services\SalaryData;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    protected $salaryData;

    public function __construct(SalaryData $services)
    {
        $this->salaryData = $services;
    }

    /**
     * 仪表盘视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $year = Carbon::now()->year;
        $periods = $this->salaryData->getPeriodIds($year);
        if (0 == count($periods)) {
            $year = $year - 1;
        }

        // 获取今年的薪酬汇总数据
        $salary = $this->salaryData->getDashboardSalary(Auth::id(), $year);

        // 日志
        $logs = SalaryLog::where('user_id', Auth::id())
            ->leftJoin('roles', 'roles.id', '=', 'salary_log.upload_type')
            ->select(['salary_log.*', 'roles.description'])
            ->orderByDesc('id')->limit(4)->get();

        return view('home')
            ->with('logs', $logs)
            ->with('year', $year)
            ->with('salary', json_encode($salary));
    }
}
