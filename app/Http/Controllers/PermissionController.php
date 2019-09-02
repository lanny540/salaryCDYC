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
            2 => '工资',
            3 => '奖金',
            4 => '其他费用',
            5 => '社保',
            6 => '补贴',
            7 => '补发',
            8 => '扣款',
            9 => '专项税务',
            10 => '新增读取',
        ];
        $permissions = Permission::select('id', 'description', 'typeId')
            ->orderBy('typeId')->get();
        $counts[0] = Permission::where('typeId', 0)->get()->count();
        $counts[1] = Permission::where('typeId', 1)->get()->count();
        $counts[2] = Permission::where('typeId', '>=', 2)->get()->count();

        return view('settings.permissions')->with(['permissions' => $permissions, 'counts' => $counts, 'datas' => $data]);
    }
}
