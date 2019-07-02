<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * 仪表盘视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('home');
    }
}
