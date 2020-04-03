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
        $salary = $request->get('money', 0);

        $tax = $this->getPersonalIncomeTax($salary);

        return response()->json($tax);
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

    /**
     * 个税计算公式.
     *
     * @param float $salary 含税收入金额
     * @param int $deduction 保险等应当扣除的金额 默认值为0
     * @param int $threshold 起征金额 默认值为5000
     * @return float | false 返回值为应缴税金额 参数错误时返回false
     */
    private function getPersonalIncomeTax($salary, $deduction=0, $threshold=5000){

        if(!is_numeric($salary) || !is_numeric($deduction) || !is_numeric($threshold)){
            return false;
        }

        if($salary <= $threshold){
            return 0;
        }

        $levels = [3000, 12000, 25000, 35000, 55000, 80000, PHP_INT_MAX];
        $rates = [0.03, 0.1, 0.2, 0.25, 0.3, 0.35, 0.45];

        $taxableIncome = $salary - $threshold - $deduction;

        $tax = 0;

        foreach($levels as $k => $level){
            $previousLevel = $levels[$k - 1] ?? 0;
            if($taxableIncome <= $level){
                $tax += ($taxableIncome - $previousLevel) * $rates[$k];

                break;
            }

            $tax += ($level-$previousLevel) * $rates[$k];
        }

        $tax = round($tax, 2);

        return $tax;
    }

}
