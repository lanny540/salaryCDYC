@extends('layouts.app')

@section('css')
@endsection

@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-3">
        <h2>部门薪酬打印</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">首页</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>部门薪酬打印</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox-content m-b-sm border-bottom">
            <div class="text-center p-lg">
                <h2>系统暂时不提供部门工资条打印功能。部门打印由计划财务部提供PDF文件自行打印。</h2>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
