@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@stop

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>流程列表</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>流程列表</strong>
                </li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-content">
            @role('administrator')
                <h2>全部流程</h2>
            @elserole('merchandiser')
                <h2>待发起</h2>
            @elserole('department_audit')
                <h2>部门审核</h2>
            @elserole('accountant')
                <h2>财务会计</h2>
            @elserole('financial_affairs')
                <h2>财务审核</h2>
            @endrole
            <div class="row m-t-sm">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover workflow-dataTables w-100">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>标题</th>
                            <th>发起人</th>
                            <th>状态</th>
                            <th style="width: 10%;">操作</th>
                        </tr>
                        </thead>
                    </table>
                    <input type="hidden" id="roleId" value="{{ $roleId }}">
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
{{--  datatables  --}}
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/datatables.config.js') }}"></script>

<script src="{{ asset('js/helper.js') }}"></script>

<script>
    let url = '/getWorkFlows?status=' + $('#roleId').val();

    $('.workflow-dataTables').DataTable({
        ajax: url,
        columns: [
            { data: 'id', name: 'id'},
            { data: 'title', name: 'title', orderable: false},
            { data: 'userName', name: 'userName', orderable: false},
            { data: 'description', name: 'description'},
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
</script>
@stop
