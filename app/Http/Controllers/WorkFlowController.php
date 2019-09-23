<?php

namespace App\Http\Controllers;

use App\Services\DataProcess;
use Auth;
use File;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Storage;

class WorkFlowController extends Controller
{
    protected $dataProcess;

    public function __construct(DataProcess $services)
    {
        $this->dataProcess = $services;
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
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|Role|null
     */
    public function getColumns($roleId)
    {
        // 如果 0，则选择所有字段
        if (0 == $roleId) {
            $permissionAll = Permission::where('typeId', '>=', 2)
                ->where('description', '<>', '')->get();

            return response()->json([
                'permissions' => $permissionAll,
            ]);
        }
        // 非 0，则选择该角色下的所有字段
        return Role::with('permissions')
            ->select(['id', 'target_table'])->where('id', $roleId)->first();
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
        // 发放日期
        $published_at = $request->get('published_at');
        // 获取最新的会计期ID
        $info['period'] = $this->dataProcess->getPeriodId();
        // 角色ID
        $info['roleId'] = $request->get('roleType');
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
        $result = $this->dataProcess->dataToDb($info, $published_at);

        // 写入失败
        if (!$result) {
            return redirect()->route('upload.index')->withErrors('数据上传错误!');
        }

        return redirect()->route('upload.index')->with('success', '数据上传成功!');
    }
}
