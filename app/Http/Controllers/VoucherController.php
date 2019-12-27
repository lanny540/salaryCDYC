<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Subject;
use App\Models\Voucher\VoucherData;
use App\Models\Voucher\VoucherStatistic;
use App\Models\Voucher\VoucherTemplate;
use App\Models\Voucher\VoucherType;
use App\Services\VoucherService;
use Auth;
use Carbon\Carbon;
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
        /**
         * 下拉选择后，判断下拉的ID 是否存在于 ￥sheets 中，如果存在，直接读取，如果不存在，则生成。
         */
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
     * @param int     $periodId 会计期ID
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

    /**
     * 生成凭证列表.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function vdataIndex()
    {
        $periods = Period::select(['id', 'published_at'])->get()->sortByDesc('id');
        $vouchers = VoucherType::with('vouchers')->get();

        return view('voucher.vlist')
            ->with('periods', $periods)
            ->with('types', $vouchers);
    }

    /**
     * 查询凭证数据是否存在.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function vdataHas(Request $request)
    {
        $pid = $request->get('periodId');
        $vid = $request->get('vid');

        $count = VoucherData::where('vid', $vid)
                    ->where('period_id', $pid)
                    ->get()->count();

        if (0 === $count) {
            $msg = '数据库中无该凭证数据!';
            $status = '生成';
        } else {
            $msg = '数据库中有该凭证数据!';
            $status = '查看';
        }

        return response()->json([
            'msg' => $msg,
            'status' => $status,
        ]);
    }

    public function vdataShow(Request $request)
    {
        $pid = $request->get('periodId');
        $vid = $request->get('vid');

        // 编码分类
        $subjects['segment2'] = Subject::where('subject_type', 2)->get();
        $subjects['segment3'] = Subject::where('subject_type', 3)->get();
        $subjects['segment4'] = Subject::where('subject_type', 4)->get();
        $subjects['segment5'] = Subject::where('subject_type', 5)->get();
        $subjects['segment6'] = Subject::where('subject_type', 6)->get();

        // 分解编码
        $code = [];
        $templates = VoucherTemplate::where('vid', $vid)->get();
        foreach ($templates as $k => $t) {
            $code[$k] = explode('.', $t->subject_no);
        }

        $vdata = [];
        $data = VoucherData::where('vid', $vid)
            ->where('period_id', $pid)
            ->get()->toArray();
        // 如果没有数据，则重新计算；否则直接读取数据库数据
        if (0 == sizeof($data)) {
            $vdata['vid'] = $vid;
            $vdata['period_id'] = $pid;
            $vdata['vname'] = 'XXX';
            $vdata['vcategory'] = '银行凭证';
            $vdata['vuser'] = Auth::user()->profile->userName;
            $vdata['cdate'] = Carbon::now();
            $vdata['period'] = Carbon::now()->month.'-'.Carbon::now()->day;
            $vdata['cgroup'] = '临时批组';
            $vdata['vdescription'] = '临时描述';
            // TODO: 将模板数据读出，结合凭证基础数据表，形成凭证数据
            $vdata['vdata'] = $this->vs->transformData($templates, $pid);
        } else {
            $vdata = $data;
        }

        return view('voucher.vdata')
                ->with('code', $code)
                ->with('templates', $templates)
                ->with('vdata', $vdata)
                ->with('subjects', $subjects);

//        return $code;
    }

    public function vdataStore(Request $request)
    {
        return $request->all();
    }
}
