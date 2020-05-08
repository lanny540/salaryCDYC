<?php

namespace App\Http\Controllers;

use App\Models\Salary\SalaryLog;
use App\Models\WorkFlow\WorkFlow;
use App\Services\DataProcess;
use App\Services\ImportColumn;
use Auth;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Storage;

class WorkFlowController extends Controller
{
    protected $dataProcess;
    protected $importColumns;

    private $types = [
        '专项奖',
        '劳动竞赛',
        '课酬',
        '节日慰问费',
        '党员奖励',
        '工会发放',
        '其他奖励',
        '财务发稿酬',
        '工会发稿酬',
    ];

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
            ->pluck('description', 'id')
        ;

        return view('workflow.upload')
            ->with(['roles' => $roles])
        ;
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
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Exception
     */
    public function wizardSubmit(Request $request)
    {
        // 获取最新的会计期ID
        $info['period'] = $this->dataProcess->getPeriodId();
        // 上传数据分类
        $info['uploadType'] = $request->get('uploadType');
        $info['isReset'] = $request->get('isReset', 1);
        // 格式化待插入的数据
        $info['importData'] = json_decode($request->get('importData'), true);

        // 保存文件至本地
        $file = $_FILES['excel'];
        $arr = explode('.', $file['name']);
        $fileName = uniqid('excel_', false).'.'.end($arr);
        $content = File::get($file['tmp_name']);
        Storage::disk('excelFiles')->put($fileName, $content);
        $info['file'] = asset('/storage/excelFiles/'.$fileName);

        // 写入salary_log
        SalaryLog::create([
            'period_id' => $info['period'],
            'user_id' => Auth::id(),
            'upload_type' => $info['uploadType'],
            'upload_file' => $info['file'],
        ]);

        // 将数据写入DB
        $result = $this->dataProcess->dataToDb($info);

        // 写入失败
        if (!$result) {
            return redirect()->route('upload.index')->withErrors('数据上传错误!');
        }

        return redirect()->route('upload.index')->with('success', '数据上传成功!');
    }

    /**
     * 数据流程审核列表视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $end = Carbon::now()->addHours(8);
        $start = Carbon::now()->modify('-3 months');
        $workflows = WorkFlow::select([
            'id', 'name', 'userProfile.userName as uploader','upload_file', 'isconfirm', 'workflows.created_at', 'workflows.updated_at', 'record', 'money'
        ])
            ->leftJoin('userProfile', 'workflows.uploader', '=', 'userProfile.user_id')
            ->whereRaw("UNIX_TIMESTAMP(workflows.created_at)  BETWEEN UNIX_TIMESTAMP('".$start."') AND UNIX_TIMESTAMP('".$end."')")
            ->orderByDesc('id')->get();

        $result = $workflows->mapToDictionary(function ($item) {
            return [$item['isconfirm'] => $item];
        });

        return view('workflow.index')->with('workflows', $result)->with('viewTypes', $this->types);
    }

    /**
     * 数据流程审核.
     *
     * @param $workflowId
     * @return WorkFlow|WorkFlow[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function dataConfirm($workflowId)
    {
        $workflow = WorkFlow::with('userprofile')->findOrFail($workflowId);
        $workflow->isconfirm = 1;
        $workflow->save();

        return $workflow;
    }

    /**
     * 数据删除.
     *
     * @param $workflowId
     * @return WorkFlow|WorkFlow[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function dataDelete($workflowId)
    {
        $wf = WorkFlow::findOrFail($workflowId);
        try {
            $wf->delete();
        } catch (\Exception $e) {
        }
        $wf->save();

        return $wf;
    }

    /**
     * 根据流程ID查看上传数据明细.
     *
     * @param $workflowId
     * @return \Illuminate\Support\Collection
     */
    public function dataShow($workflowId)
    {
        return WorkFlow::with(['details' => function($query) {
            $query->select(['wf_id', 'userProfile.userName as username', 'bonus_detail.policynumber as policy', 'departments.name as department', 'money', 'remarks'])
                ->leftJoin('userProfile', 'bonus_detail.policynumber', '=', 'userProfile.policyNumber')
                ->leftJoin('departments', 'departments.id', '=', 'userProfile.department_id');
        }])->findOrFail($workflowId);
    }
}
