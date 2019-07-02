<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * 薪酬分类视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cats = Category::select('id', 'name AS text', 'pid')->get();
        return view('settings.category')->with(['categories' => $cats]);
    }

    /**
     * 薪酬分类新增或变更
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $id = $request->get('categoryId');
        if ($id == 0) {
            Category::create([
                'name' => $request->get('categoryName'),
                'pid'  => $request->get('pid')
            ]);

            return redirect()->back()->withSuccess('分类新增成功!');
        } else {
            $category = Category::findOrFail($id);
            $category->name = $request->get('categoryName');
            $category->pid = $request->get('pid');
            $category->save();

            return redirect()->back()->withSuccess('分类变更成功!');
        }
    }

    /**
     * 树形输出
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategoryData()
    {
        $items = Category::select('id', 'name AS text', 'pid')->get()->toArray();

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
                if (!isset($array[$item['pid']]['state']['opened']))
                    $array[$item['pid']]['state']['opened'] = 'true';
            }
            else {
                $tree[] = &$array[$item['id']];
            }
        }
        return $tree;
    }
}
