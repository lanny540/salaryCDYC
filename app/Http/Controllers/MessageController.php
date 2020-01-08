<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Message;
use App\Models\Users\User;
use Auth;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return view('messages.index');
    }

    /**
     * 发送消息视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendIndex()
    {
        $res = Auth::user()->hasRole('administrator|financial_manager');
        // 如果是管理员，可看到所有部门
        if ($res) {
            $departments = Department::select(['id', 'name'])
                ->where('level', 2)
                ->orderBy('weight')->get();
        } else {
            $departments = Department::select(['id', 'name'])
                ->where('level', 2)
                ->where('id', Auth::user()->profile->department_id)
                ->orderBy('weight')->get();
        }

        return view('messages.send')
            ->with('departments', $departments);
    }

    /**
     * 固定消息群发.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendMessage(Request $request)
    {
        // 验证
        $this->validate($request, [
            'type_id' => 'required',
            'content' => 'required | max: 10',
        ], [
            'type_id.required' => '发送对象不能为空',
            'content.required' => '发送内容不能为空',
            'content.max' => '发送内容不能超过:max 字符',
        ]);

        // 发送人ID
        $sender = Auth::id();
        $type = $request->get('type_id');
        // 如果 选择的是全站用户
        if (0 == $type) {
            $receiver = User::where('id', '<>', 1)->pluck('id');
        } else {
            if (null !== $request->get('department')) {
                $departments = $request->get('department');
            } else {
                $departments = [Auth::user()->profile->department_id];
            }
            $receiver = User::whereIn('userProfile.department_id', $departments)
                ->leftJoin('userProfile', 'users.id', '=', 'userProfile.user_id')
                ->pluck('id');
        }

        // 保存文件至本地
        if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
            $file = $_FILES['attachment'];
            $arr = explode('.', $file['name']);
            $fileName = uniqid('attachment_', false).'.'.end($arr);
            $content = File::get($file['tmp_name']);
//        Storage::disk('excelFiles')->put($fileName, $content);
            $attachment = asset('/storage/attachment/'.$fileName);
        } else {
            $attachment = '';
        }

        $data = [];
        $date = Carbon::now();
        foreach ($receiver as $k => $r) {
            $data[$k]['sender'] = $sender;
            $data[$k]['receiver'] = $r;
            $data[$k]['type_id'] = $type;
            $data[$k]['content'] = $request->get('content');
            $data[$k]['attachment'] = $attachment;
            $data[$k]['created_at'] = $date;
            $data[$k]['updated_at'] = $date;
        }

        Message::insert($data);

        return redirect()->route('messages.send')->with('success', '消息发送成功！');
    }

    public function sendCustomMessage(Request $request)
    {
        return $request->all();
//        return redirect()->route()->with('success', '消息发送成功！');
    }
}
