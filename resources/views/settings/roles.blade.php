@extends('layouts.app')

@section('css')
    <!-- Toastr style -->
    <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <style>
        .notclick {
            pointer-events: none;
        }
    </style>
@stop

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>角色列表</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    系统设置
                </li>
                <li class="breadcrumb-item active">
                    <strong>角色管理</strong>
                </li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row" id="roleForm">
            <div class="col-sm-3">
                <div class="ibox ">
                    <div class="ibox-content mailbox-content">
                        <div class="file-manager">
                            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createRoleModal">新增角色</button>
                            <div class="space-25"></div>
                            <h5>系统角色</h5>
                            <ul class="folder-list m-b-md" style="padding: 0">
                                @foreach($roles as $role)
                                    @if($role->typeId === 0)
                                        <li><a href="javascript:;" id="{{ $role->id }}" class="roleList"><i class="fa fa-circle text-navy"></i> {{ $role->description }} <span class="label label-danger float-right">{{ $role->permissions->count() }}</span></a></li>
                                    @endif
                                @endforeach
                            </ul>
                            <h5>流程角色</h5>
                            <ul class="folder-list m-b-md" style="padding: 0">
                                @foreach($roles as $role)
                                    @if($role->typeId === 1)
                                        <li><a href="javascript:;" id="{{ $role->id }}" class="roleList"><i class="fa fa-circle text-warning"></i> {{ $role->description }} <span class="label label-danger float-right">{{ $role->permissions->count() }}</span></a></li>
                                    @endif
                                @endforeach
                            </ul>
                            <h5>业务角色</h5>
                            <ul class="folder-list m-b-md" style="padding: 0">
                                @foreach($roles as $role)
                                    @if($role->typeId === 2)
                                        <li><a href="javascript:;" id="{{ $role->id }}" class="roleList"><i class="fa fa-circle text-info"></i> {{ $role->description }} <span class="label label-danger float-right">{{ $role->permissions->count() }}</span></a></li>
                                    @endif
                                @endforeach
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9 animated fadeInRight ibox-content">
                <div class="sk-spinner sk-spinner-wave">
                    <div class="sk-rect1"></div>
                    <div class="sk-rect2"></div>
                    <div class="sk-rect3"></div>
                    <div class="sk-rect4"></div>
                    <div class="sk-rect5"></div>
                </div>

                {{ Form::open(['route' => 'role.update', 'method' => 'POST']) }}
                <div class="mail-box-header">
                    <h2>权限列表</h2>
                    <div class="mail-tools tooltip-demo m-t-md">
                        <button id="roleUpdate" class="btn btn-success" type="button" disabled><i class="fa fa-pencil"></i> 变 更</button>
                        <button id="roleStore" class="btn btn-primary float-right" type="submit" disabled><i class="fa fa-download"></i> 保 存</button>
                    </div>
                </div>

                <div class="mail-box">
                    <div class="mail-body notclick" id="permissionsList">
                        <input type="hidden" id="role_id" name="role_id" value="0">
                        <h3><i class="fa fa-gear"></i> 系统权限</h3>
                        <div class="forum-item">
                            <div class="row">
                                @foreach($permissions as $p)
                                    @if($p->typeId === 0)
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="role{{ $p->id }}" name="permissions[]" type="checkbox" value="{{ $p->id }}">
                                                    <label for="role{{ $p->id }}">{{ $p->description }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <h3><i class="fa fa-user"></i> 用户权限</h3>
                        <div class="forum-item">
                            <div class="row">
                                @foreach($permissions as $p)
                                    @if($p->typeId === 1)
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="role{{ $p->id }}" name="permissions[]" type="checkbox" value="{{ $p->id }}">
                                                    <label for="role{{ $p->id }}">{{ $p->description }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <h3><i class="fa fa-shield"></i> 业务权限</h3>
                        <div class="forum-item">
                            @foreach($datas as $k => $data)
                            <h4><i class="fa fa-cube"></i> {{ $data }}</h4>
                            <div class="row">
                                @foreach($permissions as $p)
                                    @if($p->typeId === $k)
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="role{{ $p->id }}" name="permissions[]" type="checkbox" value="{{ $p->id }}">
                                                    <label for="role{{ $p->id }}">{{ $p->description }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>

        {{-- modal --}}
        <div class="modal inmodal" id="createRoleModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <i class="fa fa-cloud modal-icon"></i>
                        <h4 class="modal-title">新 增 角 色</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>角色名称</label>
                            <input type="text" name="role_name" placeholder="后台名称.不要使用中文!" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>角色描述</label>
                            <input type="text" name="role_description" placeholder="展示给用户的描述." class="form-control">
                        </div>
                        <div class="form-group">
                            <label>角色分类</label>
                            <select class="role_type form-control" name="role_type">
                                <option value="0">系统角色</option>
                                <option value="1">流程角色</option>
                                <option value="2">业务角色</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>期望目标表</label>
                            <select class="role_table_name form-control" name="role_table_name">
                                <option value="0">无</option>
                                <option value="wage">工资</option>
                                <option value="bonus">奖金</option>
                                <option value="other">其他费用</option>
                                <option value="insurances">社保</option>
                                <option value="subsidy">补贴</option>
                                <option value="reissue">补发</option>
                                <option value="deduction">扣款</option>
                                <option value="taxImport">专项税务</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="roleCreate">保存</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<!-- Toastr -->
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});
    $(document).ready(function() {
        $('a.roleList').click(function(){
            $('#roleForm').children('.ibox-content').toggleClass('sk-loading');
            $("input:checkbox").removeAttr('checked');
            $('#role_id').val(this.id);
            $.ajax({
                url: '/roles/' + this.id,
                success: function (data) {
                    $('#roleForm').children('.ibox-content').toggleClass('sk-loading');
                    $('#roleUpdate').removeAttr('disabled');

                    data.permissions.forEach(function(value) {
                        $('#role' + value.id).attr('checked', true);
                    });
                }
            });
        });

        $('#roleUpdate').click(function() {
            $('#permissionsList').removeClass('notclick');
            $('#roleStore').removeAttr('disabled');
        });

        $('#roleCreate').click(function() {
            $.post({
                url: '/roles',
                data: {
                    role_name: $("input[name='role_name']").val(),
                    role_description: $("input[name='role_description']").val(),
                    role_type: $("select[name='role_type']").val(),
                    role_table_name: $("select[name='role_table_name']").val()
                },
                success: function (data) {
                    setTimeout(function () {
                        toastr.options = {
                            progressBar: true,
                            positionClass: 'toast-top-right',
                            showMethod: 'slideDown',
                            timeOut: 3000
                        };
                        toastr.info(data.message);
                    }, 500);
                },
                error: function () {
                    setTimeout(function () {
                        toastr.options = {
                            progressBar: true,
                            positionClass: 'toast-top-right',
                            showMethod: 'slideDown',
                            timeOut: 3000
                        };
                        toastr.error('未知错误！请联系管理员！');
                    }, 500);
                }
            });
        });
    });
</script>
@stop
