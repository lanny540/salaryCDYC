@extends('layouts.app')

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>个人薪酬</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>个人薪酬信息</strong>
                </li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row p-w-md m-t-sm">
        <div class="col-md-4">
            <div class="profile-info">
                <div>
                    <h2>{{ Auth::user()->profile->userName }}</h2>
                    <br/>
                    <h4>{{ Auth::user()->profile->departmentName }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <table class="table m-b-xs">
                <tbody>
                <tr>
                    <td>
                        <strong>工号</strong>
                    </td>
                    <td>
                        <strong>{{ Auth::user()->name }}</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>身份证号</strong>
                    </td>
                    <td>
                        <strong>{{ Auth::user()->profile->uid }}</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>保险编号</strong>
                    </td>
                    <td>
                        <strong>{{ Auth::user()->profile->policyNumber }}</strong>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 offset-2">
            <a href="{{ route('user.edit', auth::id()) }}" class="btn btn-primary btn-block">查看或修改详细个人信息</a>
        </div>
    </div>
    <hr/>
    <div class="p-w-md m-t-sm">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <canvas id="profile-chart" height="100"></canvas>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>会计期</th>
                        <th>工资</th>
                        <th>奖金</th>
                        <th>个税</th>
                        <th width="5%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 1; $i <= 12; $i ++)
                        <tr>
                            <td> 2018-{{ $i }}</td>
                            <td> {{ rand(4500, 5000) }}</td>
                            <td> {{ rand(2000, 4500) }}</td>
                            <td> {{ rand(100, 300) }}</td>
                            {{--<td class="client-status"><a href="{{ route('salary.show', $i) }}" target="_blank"> <span class="label label-primary">查看明细</span></a></td>--}}
                            <td class="client-status"><a href="{{ route('salary.show', $i) }}"> <span class="label label-primary">查看明细</span></a></td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<!-- ChartJS-->
<script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>
<script src="{{ asset('js/plugins/chartJs/Chart.demo.js') }}"></script>
@stop
