<?php

namespace App\Http\Controllers;

use App\Services\DataProcess;
use Auth;
use File;
use Illuminate\Http\Request;
use Storage;
use App\Services\ImportColumn;

class WorkFlowController extends Controller
{
    protected $dataProcess;
    protected $importColumns;

    public function __construct(DataProcess $services, ImportColumn $importColumn)
    {
        $this->dataProcess = $services;
        $this->importColumns = $importColumn;
    }

    /**
     * 上传数据视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploadIndex()
    {
        $roles = Auth::user()->roles()
            ->where('typeId', 9)
            ->pluck('description', 'id');

        return view('workflow.upload')
                ->with(['roles' => $roles]);
    }

    /**
     * 根据角色获取对应表名以及字段名.
     *
     * @param int $roleId
     *
     * @return \Illuminate\Support\Collection
     */
    public function getColumns($roleId)
    {
        return $this->importColumns->getImportConfig($roleId);
    }

    /**
     * 流程向导提交请求
     *
     * @param Request $request
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function wizardSubmit(Request $request)
    {
        // 获取最新的会计期ID
        $info['period'] = $this->dataProcess->getPeriodId();
        // 上传数据分类
        $info['uploadType'] = $request->get('uploadType');
        // TODO:更新或重传数据
        $info['isReset'] = $request->get('isReset', 1);
        // 格式化待插入的数据
        $info['importData'] = json_decode($request->get('importData'), true);

        // 保存文件至本地
        $file = $_FILES['excel'];
        $arr = explode('.', $file['name']);
        $fileName = uniqid('excel_', false).'.'.end($arr);
        $content = File::get($file['tmp_name']);
//        Storage::disk('excelFiles')->put($fileName, $content);
        $info['file'] = asset('/storage/excelFiles/'.$fileName);

        // 将数据写入DB
        $result = $this->dataProcess->dataToDb($info);

        // 写入失败
        if (!$result) {
            return redirect()->route('upload.index')->withErrors('数据上传错误!');
        }

        return redirect()->route('upload.index')->with('success', '数据上传成功!');
    }
}
