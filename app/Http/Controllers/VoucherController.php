<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Voucher\VoucherStatistic;
use App\Services\VoucherService;
use DB;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VoucherController extends Controller
{
    protected $vs;

    /**
     * VoucherController constructor.
     *
     * @param VoucherService $services 凭证相关数据处理服务
     */
    public function __construct(VoucherService $services)
    {
        $this->vs = $services;
    }

    /**
     * 凭证基础表查看页面.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function vsheetIndex()
    {
        $periods = Period::select(['id', 'published_at'])->get()->sortByDesc('id');
        $sheets = VoucherStatistic::select(['id', 'period_id'])->get();

        return view('voucher.vsheet')
            ->with('periods', $periods)
            ->with('sheets', json_encode($sheets));
    }

    /**
     * 根据周期生成凭证基础表.
     *
     * @param Request $request
     * @param $periodId
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function vsheetShow(Request $request, $periodId)
    {
        // 是否重新计算. 0 否 1 是 .
        $status = $request->get('calculate', 1);
        if (0 == $status) {
            $data = VoucherStatistic::where('period_id', $periodId)->get();
        } else {
            $data = $this->vs->generateSheet($periodId);
        }

        return DataTables::of($data)->make(true);
    }

    /**
     * 提交凭证基础表数据存入数据库.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function vsheetSubmit(Request $request)
    {
        $data = json_decode($request->get('sheet'), true);
        $periodId = $request->get('periodId');

        // 先删除再保存
        $this->vs->deleteSheet($periodId);

        $result = DB::table('voucher_statistic')->insert($data);

        if ($result) {
            return redirect()->route('vsheet.index')->with('success', '数据保存成功!');
        }

        return redirect()->route('vsheet.index')->with('error', '数据保存失败!请重新尝试或联系管理员!');
    }
}
