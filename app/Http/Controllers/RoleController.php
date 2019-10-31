<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * 角色管理视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
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
        // 查询列
        $columns = ['id', 'description', 'typeId'];

        $roles = Role::with('permissions')
            ->select($columns)
            ->where('typeId', '=', 9)
            ->where('id', '<>', 8)
            ->get();
        $permissions = Permission::select($columns)
            ->where('typeId', '>=', 10)
            ->get();

        return view('settings.roles')->with(['roles' => $roles, 'permissions' => $permissions, 'datas' => $data]);
    }

    /**
     * 创建角色.
     *
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'role_name' => 'required | max:40',
            'role_description' => 'required | max:50',
            'role_type' => 'required',
        ]);

        $role = new Role();
        $role->name = $request->get('name');
        $role->description = $request->get('description');
        $role->typeId = $request->get('type_id');
        $role->target_table = $request->get('tablename');
        $role->save();

        return response()->json([
            'code' => 201,
            'message' => '新角色已创建成功',
        ]);
    }

    /**
     * Ajax 返回具体角色信息.
     *
     * @param $roleId
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|Role|Role[]
     */
    public function show($roleId)
    {
        $role = Role::with(['permissions' => function ($query) {
            $query->select('id', 'description');
        }])->findOrFail($roleId);

        return $role;
    }

    /**
     * 变更角色权限.
     *
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required',
        ]);

        $roleId = $request->get('role_id');

        if (0 === $roleId) {
            return redirect()->back()->withErrors('错误请求角色参数');
        }

        $role = Role::findById($roleId);

        $p_all = Permission::all();
        foreach ($p_all as $p) {
            $role->revokePermissionTo($p);  // 移除与角色关联的所有权限
        }

        if (!empty($request['permissions'])) {
            $permissions = $request['permissions'];
            foreach ($permissions as $p) {
                $p = Permission::where('id', $p)->firstOrFail();    // 从数据库中获取相应权限
                $role->givePermissionTo($p);    // 分配权限到角色
            }
        }

        return redirect()->route('role.index')->withSuccess('角色权限更新成功!');
    }
}
