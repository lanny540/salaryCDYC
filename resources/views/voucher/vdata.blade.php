@extends('layouts.app')

@section('css')

@stop

@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>凭证列表</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">首页</a>
            </li>
            <li class="breadcrumb-item">
                凭证相关
            </li>
            <li class="breadcrumb-item active">
                <strong>凭证数据</strong>
            </li>
        </ol>
    </div>
</div>
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">

        </div>
    </div>
</div>
@stop

@section('js')

@stop
