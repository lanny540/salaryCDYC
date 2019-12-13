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

        return view('settings.system.index')->with('systems', $data);
    }

    public function systemShow($id)
    {
        $config = SystemConfig::findOrFail($id);

        return $config;
    }

    public function systemUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'description' => 'required',
            'config_value' => 'required | numeric',
            'type' => 'required',
        ]);

        $config = SystemConfig::findOrFail($id);
        $config->description = $request->input('description');
        $config->config_value = $request->input('config_value');
        $config->type = $request->input('type');
        $config->save();

        return response()->json([
            'config' => $config,
            'msg' => $config->human_column.' 已修改!',
        ]);
    }

    /**
     * 删除.
     *
     * @param $id
     *
     * @return string
     */
    public function systemDelete($id)
    {
        $config = SystemConfig::findOrFail($id);
//        $config->delete();

        return $config->config_key.'信息已删除!';
    }

    /**
     * 导入读取字段设置视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function importIndex()
    {
        $data = ImportConfig::all();

        return view('settings.import.index')->with('imports', $data);
    }

    /**
     * 查看.
     *
     * @param $id
     *
     * @return ImportConfig|ImportConfig[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function importShow($id)
    {
        $data = ImportConfig::find($id);

        return $data;
    }

    /**
     * 编辑.
     *
     * @param Request $request
     * @param $id
     *
     * @return string
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function importUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'human_column' => 'required',
            'excel_column' => 'required | max:100',
        ]);

        $import = ImportConfig::findOrFail($id);
        $import->human_column = $request->input('human_column');
        $import->excel_column = $request->input('excel_column');
        $import->save();

        return response()->json([
            'config' => $import,
            'msg' => $import->human_column.' 已修改!',
        ]);
    }

    /**
     * 删除.
     *
     * @param $id
     *
     * @return string
     */
    public function importDelete($id)
    {
        $config = ImportConfig::findOrFail($id);
//        $import->delete();

        return $config->human_column.'信息已删除!';
    }
}
