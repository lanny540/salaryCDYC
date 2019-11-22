<?php

namespace App\Http\Controllers;

use App\Exports\SpecailExport;
use App\Models\Salary\SalaryLog;
use App\Repository\SpecialRepository;
use App\Services\DataProcess;
use Auth;
use Excel;
use File;
use Illuminate\Http\Request;

class SpecialController extends Controller
{
    protected $taxExport;
    protected $dataProcess;

    public function __construct(SpecialRepository $specialRepository, DataProcess $dataProcess)
    {
        $this->taxExport = $specialRepository;
        $this->dataProcess = $dataProcess;
    }

    /**
     * 专项数据导入导出视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('special.index');
    }

    /**
     * 专项数据导出.
     *
     * @return \Maatwebsite\Excel\BinaryFileResponse
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function taxExport(Request $request)
    {
        $exportType = $request->get('exportType');

        $res = $this->taxExport->exportSpecialData($exportType);

        if (0 == count($res['data'])) {
            return redirect()->route('special.index')->withErrors('导出错误或者无导出数据!');
        } else {
            return Excel::download(new SpecailExport($res['data'], $res['headings']), $res['filename']);
        }
    }

    /**
     * 专项税务计算数据导入.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function taxImport(Request $request)
    {
        // 获取最新的会计期ID
        $info['period'] = $this->dataProcess->getPeriodId();
        // 上传数据分类
        $info['uploadType'] = $request->get('uploadType');
        // 格式化待插入的数据
        $info['importData'] = json_decode($request->get('importData'), true);
        // 重置当前的数据
        $info['isReset'] = 1;

        // 保存文件至本地
        $file = $_FILES['excel'];
        $arr = explode('.', $file['name']);
        $fileName = uniqid('excel_', false).'.'.end($arr);
        $content = File::get($file['tmp_name']);
//        Storage::disk('excelFiles')->put($fileName, $content);
        $info['file'] = asset('/storage/excelFiles/'.$fileName);

        // 将数据写入DB
        $result = $this->dataProcess->dataToDb($info);

        // 写入salary_log
        SalaryLog::create([
            'period_id' => $info['period'],
            'user_id' => Auth::id(),
            'upload_type' => $info['uploadType'],
            'upload_file' => $info['file'],
        ]);

        // 写入失败
        if (!$result) {
            return redirect()->route('special.index')->withErrors('数据上传错误!');
        }

        return redirect()->route('special.index')->with('success', '数据上传成功!');
    }
}
