<?php

namespace App\Http\Controllers;

use App\Models\Salary\BonusType;
use App\Models\Salary\DeductionType;
use App\Models\Salary\OtherType;
use App\Models\Users\UserProfile;
use App\Models\WorkFlow\WorkFlow;
use App\Models\WorkFlow\WorkFlowLog;
use App\Services\DataProcess;
use App\Services\WorkFlowProcess;
use Auth;
use File;
use Spatie\Permission\Models\Role;
use Storage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WorkFlowController extends Controller
{
    protected $dataProcess;
    protected $wfProcess;

    public function __construct(DataProcess $services, WorkFlowProcess $workFlowProcess)
    {
        $this->dataProcess = $services;
        $this->wfProcess = $workFlowProcess;
    }

    /**
     * 上传数据视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploadIndex()
    {
        $roles = Auth::user()->roles()->where('typeId', 2)->pluck('description', 'id');
        return view('workflow.upload')->with(['roles' => $roles]);
    }

    /**
     * 根据角色获取对应表名以及字段名
     *
     * @param $roleId
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|Role|null
     */
    public function getColumns($roleId)
    {
        $role = Role::with('permissions')
            ->select(['id', 'target_table'])->where('id', $roleId)->first();
        return $role;
    }

    /**
     * 获取二级分类信息
     *
     * @param $roleId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCatesName($roleId)
    {
        // 其他奖金分类
        if ($roleId >= 10 && $roleId <= 12) {
            $columns = BonusType::select('id', 'name')->where('role_id', $roleId)->get();
        }
        // 扣款分类
        elseif ($roleId >= 20 && $roleId <= 22) {
            $columns = DeductionType::select('id', 'name')->where('role_id', $roleId)->get();
        }
        // 其他费用分类
        elseif ($roleId >= 13 && $roleId <= 16) {
            $columns = OtherType::select('id', 'name')->where('role_id', $roleId)->get();
        } else {
            // 报错
            $columns = [];
        }

        return response()->json($columns);
    }

    /**
     * 从数据库获取人员信息用于校验
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfiles()
    {
        $infos = UserProfile::select('userName', 'policyNumber', 'wageCard', 'bonusCard')->get();
        return response()->json($infos);
    }

    /**
     * 流程向导提交请求
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function wizardSubmit(Request $request)
    {
        $temp = $request->get('statusCode');
        $code = isset($temp) ? 1 : 0;

        $info['roleId'] = $request->get('roleType');
        $temp1 = $request->get('level2Name');
        $info['roleLevel'] = $temp1 ?? 0;
        $info['targetTable'] = $request->get('targetTable');
        $importData = json_decode($request->get('importData'), true);

        // 保存文件至本地
        $file = $_FILES['excel'];
        $arr=explode('.', $file['name']);
        $fileName = uniqid('excel_', false). '.' . end($arr);
        $content = File::get($file['tmp_name']);
        Storage::disk('excelFiles')->put($fileName, $content);
        $info['file'] = asset('/storage/excelFiles/'.$fileName);
        // 根据选择的日期得到会计周期ID
        $info['period'] = $this->dataProcess->getPeriodId();

        // 将数据写入DB
        $res = $this->dataProcess->convertData($info, $importData);
        // 写数据表
        $result = $this->dataProcess->dataToDb($info['targetTable'], $res);

        // 写入失败
        if (!$result) {
            return redirect()->route('upload.index')->withErrors('数据保存错误!');
        }
        // 写入成功

        // 判断是否是需要走流程的角色，不是则修改$code，直接上传已审核数据
        if ($info['roleId'] !== 99) {
            $code = 9;
        }
        // 写流程表
        $workflow = WorkFlow::create([
            'title' => $request->get('title'),
            'category_id' => $request->get('roleType'),
            'statusCode' => $code,
            'createdUser' => Auth::id(),
            'fileUrl' => $info['file'],
        ]);

        // 创建流程日志
        $this->dataProcess->initializeWorkFlowLog($workflow->id, $code);

        return redirect()->route('upload.index')->withSuccess('数据保存成功!');
    }


    /**
     * 流程列表视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (Auth::id() === 1) {
            $role = 1;
        } else {
            $role = Role::whereHas('users', function ($q){
                $q->where('id', 1);
            })->where('typeId', 1)->max('id');
        }

        return view('workflow.index')->with(['roleId' => $role]);
    }

    /**
     * 根据角色获取流程列表
     *
     * @param Request $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function getWorkFlows(Request $request)
    {
        $workFlows = WorkFlow::select([
            'workflows.id',
            'workflows.title',
            'userprofile.userName',
            'workflowstatus.description'
        ])
            ->leftJoin('workflowstatus', 'workflowstatus.statusCode', '=', 'workflows.statuscode')
            ->leftJoin('userprofile', 'workflows.createdUser', '=', 'userprofile.user_id');

        if ($request->has('status')) {
            if ($request->get('status') == 1) {
                $workFlows = $workFlows->get();
            } else {
                $temp = $request->get('status') - 5;
                $workFlows = $workFlows->where('workflows.statusCode', $temp)->get();
            }
        } else {
            return redirect()->route('check.index')->withErrors('错误参数@');
        }

        return DataTables::of($workFlows)
            ->editColumn('title', '{!! str_limit($title, 40) !!}')
            ->addColumn('action', function ($workflow) {
                return '<a href="'.route('workflow.show', $workflow->id).'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit"></i> 浏览</a>';
            })
            ->make(true);
    }

    /**
     * 根据流程ID查询流程数据
     *
     * @param $workflowId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Show($workflowId)
    {
        $workflow = WorkFlow::where('id', $workflowId)
            ->select(['id', 'title', 'fileUrl', 'statusCode'])
            ->first();
        $logs = WorkFlowLog::select(['workflowlogs.*', 'userprofile.userName'])
            ->leftJoin('userprofile', 'userprofile.user_id', '=', 'workflowlogs.user_id')
            ->where('wf_id', $workflowId)
            ->orderByDesc('id')->get();
        return view('workflow.show')->with(['workflow' => $workflow, 'logs' => $logs]);
    }

    /**
     * 流程办理
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function post(Request $request)
    {
        $this->validate($request, [
            'wfId' => 'required',
            'action' => 'required'
        ]);

        $id = $request->get('wfId');
        $action = $request->get('action');
        $content = $request->get('content', '');

        $res = $this->wfProcess->workflowProcess($id, $action, $content);

        if ($res['code'] === 500) {
            return redirect()->route('workflow.show', $id)->withErrors($res['message']);
        }
        return redirect()->route('check.index')->withSuccess($res['message']);
    }

}
