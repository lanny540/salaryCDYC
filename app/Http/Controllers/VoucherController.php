<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Subject;
use App\Models\Voucher\VoucherData;
use App\Models\Voucher\VoucherStatistic;
use App\Models\Voucher\VoucherType;
use App\Services\VoucherService;
use Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Validator;
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

        return view('voucher.vsheet')
            ->with('periods', $periods);
    }

    /**
     * 根据周期生成凭证基础表.
     *
     * @param int $periodId 会计期ID
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function vsheetShow($periodId)
    {
        // 是否重新计算. 0 否 1 是 .
        $status = request()->get('calculate', 0);

        $data = VoucherStatistic::where('period_id', $periodId)->get();
        // 如果无数据或者重新计算
        if ($status === 1 || count($data) === 0) {
            $res = $this->vs->generateSheet($periodId);
        } else {
            $res = $data;
        }

        return DataTables::of($res)->make(true);
    }

    /**
     * 提交凭证基础表数据存入数据库.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function vsheetSubmit()
    {
        $data = json_decode(request()->get('sheet'), true);
        $periodId = request()->get('periodId');

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function vdataHas()
    {
        $pid = request()->get('periodId');
        $vid = request()->get('vid');

        $count = VoucherData::where('vid', $vid)
                    ->where('period_id', $pid)
                    ->get()->count();

        if (0 === $count) {
            $msg = '数据库中没有凭证数据!';
            $status = '生成';
        } else {
            $msg = '数据库中已有凭证数据!';
            $status = '查看';
        }

        return response()->json([
            'msg' => $msg,
            'status' => $status,
        ]);
    }

    /**
     * 根据模板读取或生成数据.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function vdataShow(Request $request)
    {
        $pid = $request->get('periodId');
        $vid = $request->get('vid');
        $data = $request->all();
        $rules = [
            'periodId' => 'required',
            'vid' => 'required',
        ];
        $messages = [
            'periodId.required' => '会计期不能为空',
            'vid.required' => '凭证模板不能为空',
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        // 编码分类
        $subjects = [];
        for ($i =0; $i <= 5; ++$i) {
            $subjects['segment'.$i] = Subject::where('subject_type', $i)->get();
        }

        $vdata = [];

        $data = VoucherData::where('vid', $vid)
            ->where('period_id', $pid)
            ->get()->toArray();
        // 如果没有数据，则重新计算；否则直接读取数据库数据
        if (0 === count($data)) {
            $vdata['vid'] = $vid;
            $vdata['period_id'] = $pid;
            $vdata['vname'] = 'XXX';
            $vdata['vcategory'] = '银行凭证';
            $vdata['vuser'] = Auth::user()->profile->userName;
            $vdata['cdate'] = Carbon::now();
            $vdata['period'] = Carbon::now()->month.'-'.Carbon::now()->day;
            $vdata['cgroup'] = '临时批组';
            $vdata['vdescription'] = '临时描述';
            $vdata['vdata'] = $this->vs->transformData($vid, $pid);
            $vdata['temp'] = [];
        } else {
            $vdata['vid'] = $data[0]['vid'];
            $vdata['period_id'] = $data[0]['period_id'];
            $vdata['vname'] = $data[0]['vname'];
            $vdata['vcategory'] = $data[0]['vcategory'];
            $vdata['vuser'] = $data[0]['vuser'];
            $vdata['cdate'] = $data[0]['cdate'];
            $vdata['period'] = $data[0]['period'];
            $vdata['cgroup'] = $data[0]['cgroup'];
            $vdata['vdescription'] = $data[0]['vdescription'];
            $vdata['vdata'] = $data[0]['vdata']['vdata'];
            $vdata['temp'] = $data[0]['vdata']['temp'];
        }

        return view('voucher.vdata')
            ->with('vdata', $vdata)
            ->with('subjects', $subjects)
            ->with('tempdata', json_encode($vdata));
    }

    /**
     * 将凭数据写入数据库.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function vdataStore(Request $request)
    {
        $vdata = json_decode($request->get('vdata'), true);
        $vtemp = json_decode($request->get('vtemp'), true);

        foreach ($vdata as $k => $v) {
            $vdata[$k]['debit'] = round($v['debit'], 2);
            $vdata[$k]['credit'] = round($v['credit'], 2);
        }
        foreach ($vtemp as $k => $v) {
            $vtemp[$k]['debit'] = round($v['debit'], 2);
            $vtemp[$k]['credit'] = round($v['credit'], 2);
        }
        $data['vdata'] = $vdata;
        $data['vtemp'] = $vtemp;


        $r = VoucherData::create([
            'vid' => $request->get('vid'),
            'period_id' => $request->get('period_id'),
            'vname' => $request->get('vname'),
            'vcategory' => $request->get('vcategory'),
            'vuser' => $request->get('vuser'),
            'cdate' => $request->get('cdate'),
            'period' => $request->get('period'),
            'cgroup' => $request->get('cgroup'),
            'vdescription' => $request->get('vdescription'),
            'vdata' => $data,
            'isUpload' => 0,
        ]);

        $msg = '数据保存成功！';
        $code = 201;
        if (!$r) {
            $msg = '数据保存失败！请联系系统管理员.';
            $code = 500;
        }

        return response()->json([
            'msg' => $msg,
            'status' => $code,
        ]);
    }
}
