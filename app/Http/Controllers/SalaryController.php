<?php

namespace App\Http\Controllers;

use App\Services\DataProcess;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    protected $dataProcess;
    public function __construct(DataProcess $services)
    {
        $this->dataProcess = $services;
    }

    /**
     * 薪酬计算视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function calculate()
    {
        return view('salary.calculate');
    }

    public function temp()
    {
        $period_id = $this->dataProcess->getPeriodId();
        $res = $this->dataProcess->statmonthlyIncome($period_id);
        return $res;
    }

    /**
     * 个人薪酬信息视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('salary.index');
    }

    /**
     * 个人薪酬明细视图
     *
     * @param $salaryId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($salaryId)
    {
        return view('salary.show')->with(['salaryId' => $salaryId]);
//        $id = $this->dataProcess->getPeriodId('2019-12');
//        return $id;
    }
}
