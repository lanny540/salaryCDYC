<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * 权限管理视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function permissionIndex()
    {
        $data = [
            10 => '基础数据',
            11 => '工资',
            12 => '奖金',
            13 => '其他费用',
            14 => '社保',
            15 => '补贴',
            16 => '补发',
            17 => '扣款',
            18 => '专项税务',
            19 => '特殊字段',
            20 => '新增读取',
        ];
        $permissions = Permission::select('id', 'description', 'typeId')
            ->orderBy('typeId')->get();
        $counts[0] = Permission::where('typeId', 0)->get()->count();
        $counts[1] = Permission::where('typeId', 1)->get()->count();
        $counts[2] = Permission::where('typeId', '>=', 2)->get()->count();

        return view('settings.permissions')
            ->with(['permissions' => $permissions, 'counts' => $counts, 'datas' => $data]);
    }
}
