<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * 汇总表查看页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function vsheetIndex()
    {
        return view('voucher.vsheet');
    }

    /**
     * 根据周期生成汇总表
     *
     * @param $period_id
     * @return mixed
     */
    public function vsheetShow($period_id)
    {
        return $period_id;
    }

    /**
     * 提交汇总表数据存入数据库
     *
     * @return string
     */
    public function vsheetSubmit()
    {
        return 'vsheetSubmit';
    }
}
