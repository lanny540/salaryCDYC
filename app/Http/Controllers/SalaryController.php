<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Services\SalaryData;
use Auth;
use Carbon\Carbon;

class SalaryController extends Controller
{
    protected $salaryData;

    public function __construct(SalaryData $services)
    {
        $this->salaryData = $services;
    }

    /**
     * 薪酬计算视图.暂时隐藏.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function calculate()
    {
        return view('salary.calculate');
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($period_id)
    {
        $periods = Period::select(['id', 'published_at'])
                ->where('enddate', '<>', '')->orderByDesc('id')->get();
        $publish = Period::find($period_id)->published_at;
        return view('salary.show')
                ->with('published', $publish)
                ->with('periods', $periods);
    }
}
