@extends('layouts.app')

@section('css')
<link href="{{ asset('css/plugins/jsTree/style.min.css') }}" rel="stylesheet">
@stop

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>部门列表</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    系统设置
                </li>
                <li class="breadcrumb-item active">
                    <strong>部门管理</strong>
                </li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-md-7">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>组织机构列表</h5>
                        <div class="ibox-tools">
                            <a class="btn btn-sm btn-outline-primary depCreate"><b>新增组织机构</b></a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="depList">
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-1">列表显示</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-2">树形显示</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active">
                                    <div class="panel-body" style="min-height: 450px;overflow-y: auto;max-height: 550px;">
                                        <table class="table table-hover" >
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>名称</th>
                                                    <th>DWDM</th>
                                                    <th width="5%">操作</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($departments as $dep)
                                                <tr>
                                                    <td>{{ $dep->weight }}</td>
                                                    <td>{{ $dep->name }}</td>
                                                    <td>{{ $dep->dwdm }}</td>
                                                    <td>
                                                        <button id="{{ $dep->id }}" class="btn btn-xs btn-primary depEdit">Edit</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <div id="departmentsList" style="min-height: 450px;overflow-y: auto;max-height: 550px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="ibox-title">组织基础信息</div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">
                            {{ Form::open(['route' => 'department.store', 'method' => 'POST', 'role' => 'form']) }}
                                {{ Form::hidden('dep_id', 0) }}
                                <div class="form-group">
                                    <label>部门名称</label>
                                    <input type="text" name="dep_name" placeholder="请输入部门名称" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>DWDM</label>
                                    <input type="text" name="dep_dwdm" placeholder="请输入DWDM" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>排序</label>
                                    <input type="text" name="dep_weight" placeholder="" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>父节点</label>
                                    <select class="form-control" name="dep_pid" disabled>
                                        <option value="0"></option>
                                        @foreach($departments as $dep)
                                            <option value="{{ $dep->id }}">{{ $dep->name }}___{{ $dep->dwdm }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-sm btn-primary float-right m-t-n-xs dep_submit" disabled>确定</button>
                                    <button type="button" class="btn btn-sm btn-primary float-left m-t-n-xs dep_cancle">取消</button>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<!-- jstree -->
<script src="{{ asset('js/plugins/jsTree/jstree.min.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
    });

    let departmentsTree = $("#departmentsList").jstree({
        'core' : {
            "multiple" : false,
            "themes" : {
                "stripes" : true,
                "variant" : "large"
            },
            'data' : {
                "url" : "{{ url('getDepartments') }}",
                "dataType" : "json"
            },
            "check_callback" : function(operation){
                if (operation === 'delete_node') {
                    // $('#userid').val(0);
                    // $('#username').val('');
                    // $('#userphone').val('');
                    // $('#department').val('');
                }
                return true;
            }
        },
        "types" : {
            "default" : {
                "icon" : "glyphicon glyphicon-tasks"
            },
            "child" : {
                "icon" : "glyphicon glyphicon-user"
            }
        },
        "plugins" : [
            "types", "wholerow"
        ]
    });

    $(document).ready(function () {
        $('.depCreate').click(function () {
            departmentInput(null);
        });
        $('.depEdit').click(function () {
            $.get({
                url: '/departments/' + this.id,
                success: function (data) {
                    departmentInput(data);
                }
            });
        });
        $('.dep_cancle').click(function () {
            $("input[name='dep_name']").val('').attr('disabled', 'disabled');
            $("input[name='dep_dwdm']").val('').attr('disabled', 'disabled');
            $("input[name='dep_weight']").val('').attr('disabled', 'disabled');
            $("select[name='dep_pid']").val('').attr('disabled', 'disabled');
            $(".dep_submit").attr('disabled', 'disabled');
        });
    });

    // 输入框的初始化
    function departmentInput(data) {
        if (data === null) {
            $("input[name='dep_id']").val(0);
            $("input[name='dep_name']").removeAttr('disabled').val('');
            $("input[name='dep_dwdm']").removeAttr('disabled').val('');
            $("input[name='dep_weight']").removeAttr('disabled').val('');
            $("select[name='dep_pid']").removeAttr('disabled').val('');
            $(".dep_submit").removeAttr('disabled');
        } else {
            $("input[name='dep_id']").val(data.id);
            $("input[name='dep_name']").removeAttr('disabled').val(data.name);
            $("input[name='dep_dwdm']").removeAttr('disabled').val(data.dwdm);
            $("input[name='dep_weight']").removeAttr('disabled').val(data.weight);
            $("select[name='dep_pid']").removeAttr('disabled').val(data.pid);
            $(".dep_submit").removeAttr('disabled');
        }
    }
</script>
@stop
