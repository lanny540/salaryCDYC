<?php

namespace App\Http\Controllers;

use App\Models\Config\ImportConfig;
use App\Models\Config\SystemConfig;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * 系统基础数据设置视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function systemIndex()
    {
        $data = SystemConfig::all();

        return view('settings.system')->with('systems', $data);
    }

    /**
     * 导入读取字段设置视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function importIndex()
    {
        $data = ImportConfig::all();

        return view('settings.import')->with('imports', $data);
    }
}
