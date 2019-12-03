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

        return redirect()->route('salary.calculate')->withErrors($res);
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

    public function getPersonPrintData(Request $request)
    {
        $data = [
            ['period' => 10, 'wage' => 555, 'bonus' => 666],
            ['period' => 11, 'wage' => 666, 'bonus' => 777],
        ];
        // return $request->all();

        return $data;
    }

    public function print(Request $request)
    {
//        return $request->all();
        return view('print.person');
    }

    public function departmentPrint()
    {
        return view('salary.department_print');
    }
}
