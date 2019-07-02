<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * 部门列表视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $departments = Department::select(['id', 'name', 'dwdm', 'weight'])->orderBy('weight')->get();
        return view('settings.departments')->with(['departments' => $departments]);
    }

    /**
     * 部门信息
     *
     * @param $id
     *
     * @return Department|Department[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function show($id)
    {
        return Department::findOrFail($id);
    }

    /**
     * 新建或更新部门
     *
     * @param Request $request
     *
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'dep_id' => 'required | integer',
            'dep_name' => 'required | max: 50',
            'dep_dwdm' => 'required | max: 32',
            'dep_weight' => 'required | integer',
            'dep_pid' => 'required'
        ],
        [
            'dep_id.required' => '部门ID 必须传入',
            'dep_name.required' => '部门名称 必填',
            'dep_name.max' => '部门名称 不能超过 :max',
            'dep_dwdm.required' => '部门编号 必填',
            'dep_dwdm.max' => '部门编号 不能超过 :max',
            'dep_weight.required' => '排序 必填',
            'dep_weight.integer' => '排序 必须为整形',
            'dep_pid.required' => '父节点 必选'
        ]);

        $dep = Department::updateOrCreate(
            ['id' => $request->get('dep_id')],
            [
                'name' => $request->get('dep_name'),
                'dwdm' => $request->get('dep_dwdm'),
                'pid' => $request->get('dep_pid'),
                'weight' => $request->get('dep_weight'),
                'level' => $this->getDepartmentLevel($request->get('dep_pid'))
            ]
        );
        return redirect()->route('department.index')
            ->withSuccess($dep->name.'____'.$dep->dwdm.' 已变更!');
    }

    /**
     * 树形输出
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepartments()
    {
        $items = Department::select(['id', 'name AS text', 'pid'])->get()->toArray();

        $data = [];
        $length = count($items);
        for ($i = 0; $i < $length; $i++){
            $data[$i + 1] = $items[$i];
        }
        return response()->json($this->getTree($data));
    }

    /**
     * 按照 jstree 格式输出
     *
     * @param $array
     *
     * @return array
     */
    private function getTree($array):array
    {
        $tree = array();
        foreach ($array as $item)
        {
            if (isset($array[$item['pid']])) {
                $array[$item['pid']]['children'][] = &$array[$item['id']];
//                if (!isset($array[$item['pid']]['state']['opened']))
//                    $array[$item['pid']]['state']['opened'] = 'true';
            }
            else {
                $tree[] = &$array[$item['id']];
            }
        }
        return $tree;
    }

    /**
     * 根据父节点获取层级
     *
     * @param $pid
     *
     * @return int|mixed
     */
    private function getDepartmentLevel($pid)
    {
        return $pid > 0 ? Department::find($pid)->level + 1 : 1;
    }
}
