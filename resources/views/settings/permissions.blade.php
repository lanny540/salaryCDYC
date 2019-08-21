@extends('layouts.app')

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>权限列表</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    系统设置
                </li>
                <li class="breadcrumb-item active">
                    <strong>权限管理</strong>
                </li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>权限列表</h5>
                        <div class="ibox-tools">
                            Total : {{ $permissions->count() }}
                        </div>
                    </div>
                    <div class="ibox-content forum-container">
                        <div class="forum-title">
                            <div class="float-right forum-desc">
                                <samll>Total : {{ $counts[0] }}</samll>
                            </div>
                            <h3><i class="fa fa-gear"></i> 系统权限</h3>
                        </div>
                        <div class="forum-item active">
                            <div class="row">
                                @foreach($permissions as $p)
                                    @if($p->typeId === 0)
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <span class="badge badge-primary" style="font-size: 12px;">{{ $p->description }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="forum-title">
                            <div class="float-right forum-desc">
                                <samll>Total : {{ $counts[1] }}</samll>
                            </div>
                            <h3><i class="fa fa-user"></i> 用户设置权限</h3>
                        </div>
                        <div class="forum-item active">
                            <div class="row">
                                @foreach($permissions as $p)
                                    @if($p->typeId === 1)
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <span class="badge badge-info" style="font-size: 12px;">{{ $p->description }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="forum-title">
                            <div class="float-right forum-desc">
                                <samll>Total : {{ $counts[2] }}</samll>
                            </div>
                            <h3><i class="fa fa-shield"></i> 业务权限</h3>
                        </div>
                        <div class="forum-item active">
                            @foreach($datas as $k => $data)
                            <h3><i class="fa fa-cube"></i> {{ $data }}</h3>
                            <div class="row">
                                @foreach($permissions as $p)
                                    @if($p->typeId === $k)
                                        <div class="col-sm-3 col-md-2">
                                            <div class="form-group">
                                                <span class="badge badge-success" style="font-size: 12px;">{{ $p->description }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
