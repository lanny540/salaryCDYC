<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Users\User;
use App\Models\Users\UserProfile;
use App\Models\Users\UserRemitting;
use Auth;
use Illuminate\Http\Request;
use Log;
use Spatie\Permission\Models\Role;
use Validator;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * 人员信息管理视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function usersIndex()
    {
        return view('settings.users');
    }

    /**
     * 编辑人员信息视图.
     *
     * @param $userId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($userId)
    {
        //TODO: 这里需要判断权限。本人只能查看自己，劳务员可以查看部门人员，管理员可以查看全部人员
        $user = User::with(['profile', 'remit'])
            ->where('id', $userId)
            ->select('users.id', 'users.name')
            ->firstOrFail()
        ;
        $departments = Department::select('id', 'name')
            ->where('level', 5)
            ->orderBy('weight')
            ->get()
        ;
        $roles = Role::select('id', 'description', 'typeId')->get();

        return view('user.edit')->with(['user' => $user, 'departments' => $departments, 'roles' => $roles]);
    }

    /**
     * 更新人员一般信息.
     *
     * @param Request $request
     * @param $userId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $userId)
    {
        $rules = [
            'department_id' => 'required',
            'status' => 'required',
            'uid' => 'required | max:50',
            'wageCard' => 'required | max:32',
            'bonusCard' => 'required | max:32',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //TODO: 这里需要判断权限。本人只能修改自己，劳务员可以修改部门人员，管理员可以修改全部人员

        //将修改操作写入profile日志
        Log::channel('profile')->info('用户'.Auth::user()->id.'修改了用户'.$userId.'的个人信息。');

        $userProfile = UserProfile::where('user_id', $userId)->first();

        $userProfile->department_id = $request->get('department_id');
        $userProfile->status = $request->get('status');
        $userProfile->uid = $request->get('uid');
        $userProfile->wageCard = $request->get('wageCard');
        $userProfile->bonusCard = $request->get('bonusCard');

        $userProfile->mobile = $request->get('mobile', '');
        $userProfile->phone = $request->get('phone', '');
        $userProfile->address = $request->get('address', '');

        $userProfile->save();

        return redirect()->back()->withSuccess('个人信息变更成功!');
    }

    /**
     * 更新人员特殊信息.
     *
     * @param Request $request
     * @param $userId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateS(Request $request, $userId)
    {
        $userProfile = UserProfile::where('user_id', $userId)->first();
        $userProfile->hiredate = $request->get('hiredate', '');
        $userProfile->departure = $request->get('departure', '');
        $userProfile->handicapped = $request->get('handicapped', 0);
        $userProfile->tax_rebates = $request->get('tax_rebates', 0);

        $userProfile->save();

        return redirect()->back()->withSuccess('个人信息变更成功!');
    }

    /**
     * 更新非工行卡信息.
     *
     * @param Request $request
     * @param $userId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remit(Request $request, $userId)
    {
        $rules = [
            'flag' => 'required',
            'remit_card_no' => 'required',
            'remit_name' => 'required',
            'remit_bank' => 'required',
            'remit_bank_no' => 'required',
            'remit_province' => 'required',
            'remit_city' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userProfile = UserProfile::where('user_id', $userId)->first();
        $userProfile->flag = $request->get('flag');
        $userProfile->save();
        UserRemitting::updateOrCreate(
            ['user_id' => $userId],
            [
                'user_id' => $userId,
                'remit_card_no' => $request->get('remit_card_no'),
                'remit_name' => $request->get('remit_name'),
                'remit_bank' => $request->get('remit_bank'),
                'remit_bank_no' => $request->get('remit_bank_no'),
                'remit_province' => $request->get('remit_province'),
                'remit_city' => $request->get('remit_city'),
            ]
        );

        return redirect()->back()->withSuccess('个人信息变更成功!');
    }

    /**
     * 更新用户所属角色.
     *
     * @param Request $request
     * @param $userId
     *
     * @return mixed
     */
    public function changeRole(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $roles = $request['roles'];
        if (isset($roles)) {
            $user->roles()->sync($roles);   // 如果有角色选中与用户关联则更新用户角色
        } else {
            $user->roles()->detach();   // 如果没有选择任何与用户关联的角色则将之前关联角色解除
        }
        if (1 === $userId) {
            $user->roles()->sync(1);
        }

        return redirect()->route('user.edit', $userId)->withSuccess('用户角色变更成功!');
    }

    /**
     * 人员列表输出至datatables.
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function getUsersData()
    {
        $users = User::with(['profile' => function ($query) {
            $query->select(['user_id', 'userName', 'department_id'])
                ->with(['department' => function ($q) {
                    $q->select(['id', 'name']);
                }])
            ;
        }])->select('users.id', 'users.name');

        return DataTables::of($users)
            ->addColumn('action', function ($user) {
                return '<a href="javascript:;" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit"></i> 修改人员信息</a>';
            })
            ->make(true)
        ;
    }
}
