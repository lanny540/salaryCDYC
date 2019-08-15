<?php

namespace App\Http\Controllers;

use App\Models\BugReport;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * 个税计算视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function taxIndex()
    {
        return view('help.tax');
    }

    /**
     * 系统BUG报告视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reportIndex()
    {
        return view('help.report');
    }

    /**
     * 联系我们视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contactIndex()
    {
        return view('help.contact');
    }

    /**
     * 个税计算.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function taxCalculate(Request $request)
    {
//        TODO:个税计算方法
        $data = $request->get('money', 0);

        return response()->json($data);
    }

    /**
     * 报告提交.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function reportPost(Request $request)
    {
//        TODO:上传截图
        $imageUrl = asset('/images/bugs/');

        BugReport::create([
            'reportType' => $request->get('type'),
            'content' => $request->get('content'),
            'contact' => $request->get('contact', ''),
            'screenShot' => $imageUrl,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return redirect()->route('report')->withSuccess('感谢您的宝贵意见!');
    }
}
