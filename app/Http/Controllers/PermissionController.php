<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * 权限管理视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function permissionIndex()
    {
        $permissions = Permission::select('id', 'description', 'typeId')
            ->orderBy('typeId')->get();
        $counts[0] = Permission::where('typeId', 0)->get()->count();
        $counts[1] = Permission::where('typeId', 1)->get()->count();
        $counts[2] = Permission::where('typeId', 2)->get()->count();
        return view('settings.permissions')->with(['permissions' => $permissions, 'counts' => $counts]);
    }

}
