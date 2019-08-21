<?php

namespace App\Http\Controllers;

use App\Models\Salary\BonusType;
use App\Models\Salary\DeductionType;
use App\Models\Salary\OtherType;
use App\Models\Users\UserProfile;
use App\Models\WorkFlow\WorkFlow;
use App\Services\DataProcess;
use App\Services\WorkFlowProcess;
use Auth;
use File;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Storage;

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
     * 上传数据视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploadIndex()
    {
        $roles = Auth::user()->roles()->where('typeId', 2)->pluck('description', 'id');

        return view('workflow.upload')->with(['roles' => $roles]);
    }

    /**
     * 根据角色获取对应表名以及字段名.
     *
     * @param $roleId
     *
     * @return null|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|Role
     */
    public function getColumns($roleId)
    {
        return Role::with('permissions')
            ->select(['id', 'target_table'])->where('id', $roleId)->first();
    }

    /**
     * 从数据库获取人员信息用于校验.
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
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
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
        $arr = explode('.', $file['name']);
        $fileName = uniqid('excel_', false).'.'.end($arr);
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
        if (99 !== $info['roleId']) {
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
}
