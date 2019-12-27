<?php

namespace App\Http\Controllers;

use App\Exports\SalaryExport;
use App\Models\Config\SystemConfig;
use App\Models\Period;
use App\Models\Salary\SalarySummary;
use App\Services\DataProcess;
use App\Services\SalaryData;
use Auth;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Validator;

class SalaryController extends Controller
{
    protected $salaryData;
    protected $dataProcess;

    /**
     * SalaryController constructor.
     *
     * @param SalaryData $services
     * @param DataProcess $dataProcess
     */
    public function __construct(SalaryData $services, DataProcess $dataProcess)
    {
        $this->salaryData = $services;
        $this->dataProcess = $dataProcess;
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
            ->with('chartdata', json_encode($chartData, JSON_NUMERIC_CHECK))
        ;
    }

    /**
     * 个人薪酬明细视图.
     *
     * @param int $period_id 会计期ID
     *
     * @return mixed
     */
    public function show($period_id)
    {
        $periods = Period::select(['id', 'published_at'])
            ->where('published_at', '<>', '')->orderByDesc('id')->get();
        $period = Period::find($period_id);

        $policy = $this->salaryData->getPolicyNumber(Auth::id());
        $summary = SalarySummary::where('period_id', $period_id)
            ->where('policyNumber', $policy)->firstOrFail();
        $detail = $this->salaryData->getDetailSalary($period_id, Auth::id());
        $chartData = $this->salaryData->getChartSalary($period_id, Auth::id());

        return view('salary.show')
            ->with('curPeriod', $period)
            ->with('periods', $periods)
            ->with('summary', $summary)
            ->with('detail', $detail)
            ->with('chartdata', json_encode($chartData, JSON_NUMERIC_CHECK))
        ;
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
     * 求和所有字段.
     *
     * @throws \Exception
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function calSalary()
    {
        $period = $this->dataProcess->getPeriodId();
        // 计算合计字段
        $res = $this->dataProcess->calTotal($period);
        if ('success' === $res) {
            // 对所有字段进行求和，并输出
            return $this->dataProcess->getTotal($period);
        }

        return [];
    }

    /**
     * 导出所有人员当期薪酬明细.
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     *
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function salaryExport()
    {
        $period = $this->dataProcess->getPeriodId();
        $res = $this->dataProcess->getSalaryDetail($period);

        if (0 === \count($res['data'])) {
            return redirect()->route('special.index')->withErrors('导出错误或者无导出数据!');
        }

        return Excel::download(new SalaryExport($res['data'], $res['headings']), $res['filename']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function settleAccount(Request $request)
    {
        $rules = [
            'published_at' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $published_at = $request->get('published_at');
        // 关闭周期
        $period = $this->dataProcess->closePeriod($published_at);
        // 中断1秒，防止上期结束和本期开始为相同时间.
        sleep(1);
        // 新开周期
        $this->dataProcess->newPeriod();

        return response()->json([
            'statuscode' => '201',
            'message' => '当期结束于'.$period->enddate.'.',
        ]);
    }

    /**
     * 薪酬查询视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function salarySearch()
    {
        $periods = Period::where('published_at', '<>', '')
            ->orderByDesc('id')->get();

        $dataTypes = SystemConfig::where('type', 'search')
            ->select(['config_key', 'config_value'])->get();

        return view('salary.search')
            ->with('periods', $periods)
            ->with('dataTypes', $dataTypes)
        ;
    }

    /**
     * 薪酬查询.
     *
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function search(Request $request)
    {
        $rules = [
            'types' => 'required',
            'periods' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $types = $request->get('types');
        $periods = $request->get('periods');

        $res = [];
        foreach ($types as $t) {
            $res[] = $this->salaryData->search($t, $periods);
        }

        return $res;
    }

    /**
     * 个人薪酬打印视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function personPrint()
    {
        $periods = Period::where('published_at', '<>', '')
            ->orderByDesc('id')->limit(18)->get();

        return view('salary.person_print')
            ->with('periods', $periods)
        ;
    }

    /**
     * 输出个人打印数据.
     *
     * @param Request $request
     * @return array
     */
    public function getPersonPrintData(Request $request)
    {
        $periods = $request->get('periods');
        $policy = $this->salaryData->getPolicyNumber(Auth::id());
        $data = $this->dataProcess->getPersonPrintData($periods, $policy);

        return $data;
    }

    /**
     * 个人打印数据导出.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function personPrintExport(Request $request)
    {
        $periods = explode(',', $request->get('periods'));

        $policy = $this->salaryData->getPolicyNumber(Auth::id());
        $data = $this->dataProcess->getPersonPrintData($periods, $policy);
        $headings = [
            '发布日期', '年薪工资', '岗位工资', '保留工资', '套级补差', '中夜班费', '年功工资', '加班工资',
            '月奖', '专项奖', '劳动竞赛', '课酬', '节日慰问费', '党员奖励', '其他奖励', '工会发放',
            '通讯补贴', '住房补贴', '独子费', '交通补贴', '补发工资', '补发补贴', '补发其他',
            '养老保险个人', '医疗保险个人', '失业保险个人', '公积金个人', '年金个人', '扣水电物管', '扣欠款及捐赠', '扣工会会费',
            '累专附子女', '累专附老人', '累专附继教', '累专附房租', '累专附房利', '累其他扣除', '累计扣捐赠', '个人所得税',
            '累计应纳税所得额', '累计应纳税', '累计减免税', '累计应扣税', '累计申报已扣税', '累计应补税', '上期已扣税',
            '累计收入', '累计减除费用', '累计专项扣除', '扣款合计', '应发工资', '奖金合计', '补贴合计', '补发合计', '工资薪金',
        ];
        $filename = '打印数据导出.xlsx';

        return Excel::download(new SalaryExport($data, $headings), $filename);
    }

    /**
     * 个人薪酬打印.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function print(Request $request)
    {
        $periods = explode(',', $request->get('periods'));
        $policy = $this->salaryData->getPolicyNumber(Auth::id());
        $data = $this->dataProcess->getPersonPrintData($periods, $policy);

        return view('print.person')
            ->with('data', $data);
    }

    /**
     * 部门薪酬打印.
     */
    public function departmentPrint()
    {
        return view('salary.department_print');
    }
}
