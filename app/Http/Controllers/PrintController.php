<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function sheetIndex()
    {
        return view('print.sheet');
    }

    public function sheetPrint(Request $request)
    {
        // TODO: 根据传入的IDS，获取人员薪酬信息
        $count = $request->get('ids');

        return view('print.sheetPrint')->with(['counts' => $count]);
    }

    public function incomeIndex()
    {
        return view('print.income');
    }
}
