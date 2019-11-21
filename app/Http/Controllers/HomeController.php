<?php

namespace App\Http\Controllers;

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

        // 获取 今年的薪酬汇总数据
        $salary = $this->salaryData->getDashboardSalary(Auth::id(), $year);

        return view('home')
            ->with('salary', json_encode($salary));
    }
}
