<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Message;
use App\Models\Users\User;
use App\Repository\MessageRepository;
use Auth;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Storage;

class MessageController extends Controller
{
    protected $messages;

    public function __construct(MessageRepository $msg)
    {
        $this->messages = $msg;
    }

    /**
     * 我的消息视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $msg = Message::where('receiver', Auth::id())->orderByDesc('created_at')->get();

        return view('messages.index')
            ->with('msg', $msg);
    }

    /**
     * 详细消息.
     *
     * @param $msgId
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function show($msgId)
    {
        $msg = Message::select(['messages.*', 'userProfile.userName'])
            ->where('id', $msgId)
            ->where('receiver', Auth::id())
            ->leftJoin('userProfile', 'userProfile.user_id', '=', 'messages.sender')
            ->first();

        $msg->isread = 1;
        $msg->save();

        return $msg;
    }

    /**
     * 删除消息.
     *
     * @param $msgId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($msgId)
    {
        $msg = Message::where('id', $msgId)->where('receiver', Auth::id())
            ->get();

        if (0 === count($msg)) {
            return response()->json([
                'code' => 417,
                'msg' => '请求参数错误!',
            ]);
        } else {
            Message::where('id', $msgId)->where('receiver', Auth::id())->delete();

            return response()->json([
                'code' => 201,
                'msg' => '删除成功!',
            ]);
        }
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
//        Storage::disk('attachment')->put($fileName, $content);
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

    /**
     * 群发自定义消息.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function sendCustomMessage(Request $request)
    {
        $import = json_decode($request->get('importData'), true);

        if (isset($import[0]) && array_key_exists('保险编号', $import[0]) && array_key_exists('发送内容', $import[0])) {
            $data = $this->messages->transMsg(Auth::id(), $import);

            Message::insert($data);

            // 保存文件至本地
            if ($request->hasFile('excel') && $request->file('excel')->isValid()) {
                $file = $_FILES['excel'];
                $arr = explode('.', $file['name']);
                $fileName = uniqid('customMsg', false).'.'.end($arr);
                $content = File::get($file['tmp_name']);
                Storage::disk('customMsg')->put($fileName, $content);
            }

            return redirect()->route('messages.send')->with('success', '消息发送成功！');
        } else {
            return redirect()->back()->withErrors('传入字段不正确！必须存在 保险编号 和 发送内容 两个字段.');
        }
    }
}
