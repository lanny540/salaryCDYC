<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'name';
    }

    /**
     * 重置密码视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm()
    {
        return view('auth.passwords.reset');
    }

    /**
     * 重置密码.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'uid' => 'required | size:18',
            'password' => 'required | confirmed | min: 6',
        ],[
            'name.required' => '登录名 必填',
            'uid.required' => '身份证号码 必填',
            'uid.size' => '身份证长度不正确',
            'password.required' => '密码 必填',
            'password.confirmed' => '密码与确认密码不匹配',
            'password.min' => '密码 长度不得低于6位',
        ]);

        $user = User::select(['users.id', 'users.name'])
            ->leftJoin('userProfile', 'users.id', '=', 'userProfile.user_id')
            ->where('users.name', $request->get('name'))
            ->where('userProfile.uid', $request->get('uid'))
            ->first();

        if (null === $user) {
            return redirect()->back()->withErrors('没有找到该用户！请确认信息或者联系管理员!');
        }

        $user->password = bcrypt($request->get('password'));
        $user->save();

        return redirect()->route('password.request')->with('success', '重置密码成功!');
    }
}
