<?php

namespace App\Http\Controllers;

use App\Services\DataProcess;
use Auth;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    protected $dataProcess;

    public function __construct(DataProcess $services)
    {
        $this->dataProcess = $services;
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

    /**
     * 当前会计期薪酬汇总计算.
     *
     * @return mixed
     */
    public function calSalary()
    {
        $res = '';
        if (Auth::user()->hasRole('financial_manager')) {
            $period_id = $this->dataProcess->getPeriodId();
            $res = $this->dataProcess->statmonthlyIncome($period_id);
        }

        return $res;
    }

    /**
     * 会计期结算.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function settleAccount(Request $request)
    {
        if (Auth::user()->hasRole('financial_manager')) {
            // 将汇总数据写入到数据库
            $salaries = $request->get('salary');
            $period = $this->dataProcess->getPeriodId();

            // 关闭当前会计期
            $old_period = $this->dataProcess->closePeriod();
            // 新开会计期
            // TODO
//            $new_period = $this->dataProcess->newPeriod();
            // 返回消息
            $text = '会计期已关闭,时间是'.$old_period->startdate.'到'.$old_period->enddate.' ! ';
            $text .= '新会计期自动将于明天开启.';
            $type = 'success';
            $title = '已结算!';
        } else {
            $type = 'error';
            $title = '错误!';
            $text = '无权限结算会计期!请联系管理员.';
        }

        return response()->json([
            'text' => $text,
            'type' => $type,
            'title' => $title,
        ]);
    }

    /**
     * 个人薪酬信息视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('salary.index');
    }

    /**
     * 个人薪酬明细视图.
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
