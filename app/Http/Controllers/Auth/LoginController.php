<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    protected $redirectAfterlogout = '/login';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'name';
    }

    // TODO: 重写密码重置方法
    public function showResetForm()
    {
        return view('auth.passwords.reset');
    }

    // TODO::输入员工信息验证
    public function resetPassword()
    {
        return 'resetpassword';
    }
}
