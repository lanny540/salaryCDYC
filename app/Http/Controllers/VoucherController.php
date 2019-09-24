<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Voucher\VoucherStatistic;
use App\Services\VoucherService;
use DB;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    protected $vs;

    public function __construct(VoucherService $services)
    {
        $this->vs = $services;
    }

    /**
     * 汇总表查看页面.
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
     * 根据周期生成汇总表.
     *
     * @param Request $request
     * @param int $period_id 会计期
     *
     * @return mixed
     */
    public function vsheetShow(Request $request, $period_id)
    {
        // 是否重新计算. 0 否 1 是 .
        $status = $request->get('calculate', 1);
        if (0 === $status) {
            $data = VoucherStatistic::where('period_id', $period_id)->get();
        } else {
            // 先删除再计算
            $this->vs->deleteSheet($period_id);
            $data = $this->vs->generateSheet($period_id);
        }

        return response()->json([
            'status' => $status,
            'sheet' => $data,
        ]);
    }

    /**
     * 提交汇总表数据存入数据库.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function vsheetSubmit(Request $request)
    {
        $data = $request->only('sheet');
        $result = DB::table('voucher_statistic')->insert($data);

        return response()->json([
            'status' => $result,
            'msg' => '保存成功!',
        ]);
    }
}
