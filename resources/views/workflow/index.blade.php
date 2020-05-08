@extends('layouts.app')

@section('css')
@endsection

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>数据审核</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>数据审核</strong>
                </li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a class="nav-link active" data-toggle="tab" href="#unconfirmWorkflow"><i class="fa fa-desktop"></i> 未审核数据</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#confirmWorkflow"><i class="fa fa-database"></i> 当期已审核</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="unconfirmWorkflow" class="tab-pane active">
                            <div class="panel-body">
                                <div class="table-responsive unconfirmTable">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr class="text-center">
                                            <th>状态</th>
                                            <th>流程名称</th>
                                            <th>上传人</th>
                                            <th>记录数</th>
                                            <th>合计金额</th>
                                            <th>创建时间</th>
                                            <th>源文件</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($workflows[0] as $w)
                                            <tr id="wf{{ $w->id }}" class="text-center">
                                                <td style="width: 100px;">
                                                    @if($w->updated_at != $w->created_at)
                                                        <span class="label label-info">数据有变动</span>
                                                    @else
                                                        <span class="label label-danger">数据待审核</span>
                                                    @endif
                                                </td>
                                                <td>{{ $w->name }}</td>
                                                <td>{{ $w->uploader }}</td>
                                                <td>{{ $w->record }}</td>
                                                <td>{{ $w->money }}</td>
                                                <td>{{ $w->created_at }}</td>
                                                <td><a href="{{ $w->upload_file }}">下载</a></td>
                                                <td class="client-status text-right" style="width: 280px;">
                                                    @if(in_array($w->name, $viewTypes, true))
                                                    <button class="btn btn-xs btn-primary view" value="{{ $w->id }}">
                                                        <i class="fa fa-edit"></i> 查看
                                                    </button>
                                                    @endif
                                                    <button class="btn btn-xs btn-success confirm" value="{{ $w->id }}">
                                                        <i class="fa fa-bug"></i> 确认
                                                    </button>
                                                    <button class="btn btn-xs btn-danger delete" value="{{ $w->id }}">
                                                        <i class="fa fa-bug"></i> 删除
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" id="confirmWorkflow" class="tab-pane">
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <thead>
                                    <tr class="text-center">
                                        <th>状态</th>
                                        <th>流程名称</th>
                                        <th>上传人</th>
                                        <th>记录数</th>
                                        <th>合计金额</th>
                                        <th>审核时间</th>
                                        <th>源文件</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody id="confirmList">
                                    @foreach($workflows[1] as $w)
                                            <tr id="wf{{ $w->id }}" class="text-center">
                                                <td style="width: 100px;">
                                                    <span class="label label-success">数据已审核</span>
                                                </td>
                                                <td>{{ $w->name }}</td>
                                                <td>{{ $w->uploader }}</td>
                                                <td>{{ $w->record }}</td>
                                                <td>{{ $w->money }}</td>
                                                <td>{{ $w->updated_at }}</td>
                                                <td><a href="{{ $w->upload_file }}">下载</a></td>
                                                <td class="client-status" style="width: 120px;">
                                                    @if(in_array($w->name, $viewTypes, true))
                                                        <button class="btn btn-xs btn-primary view" value="{{ $w->id }}">
                                                            <i class="fa fa-edit"></i> 查看数据
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('workflow._modals')
@endsection

@section('js')
<!-- SweetAlert2 -->
<script src="{{ asset('js/plugins/sweetalert2/sweetalert.min.js') }}"></script>

<script>
    $(document).ready(function(){
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});
        const url = 'workflow/';
        const body = $('body');

        const viewTypes = ['专项奖', '劳动竞赛', '课酬', '节日慰问费', '党员奖励', '工会发放', '其他奖励', '财务发稿酬', '工会发稿酬'];

        body.on('click', 'button.view', function () {
            let id = $(this).val();
            let detailList = $('#detail');

            detailList.html('');
            $.get(url + id, function (data) {
                // console.log(data);
                $('#wf_name').text(data.name);
                let details = data.details;
                let res = details.map(function (item, index, details) {
                    return `
                        <tr>
                            <td>${item.username}</td>
                            <td>${item.policy}</td>
                            <td>${item.department}</td>
                            <td>${item.money}</td>
                            <td>${item.remarks}</td>
                        </tr>
                    `;
                });
                detailList.append(res);
            });

            $('#workflowModal').modal('show');
        });

        body.on('click', 'button.confirm', function () {
            swal({
                title: "数据是否确认?",
                text: "数据一旦确认，将计入当期收入，且无法编辑删除!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willConfirm) => {
                if (willConfirm) {
                    let id = $(this).val();
                    $.ajax({
                        type: 'PUT',
                        url: url + id,
                        success: function (data) {
                            let msg = data.name + '已审核！';
                            let temp = `
                                <tr id="wf${data.id}" class="text-center">
                                    <td style="width: 100px;">
                                        <span class="label label-success">数据已审核</span>
                                    </td>
                                    <td>${data.name}</td>
                                    <td>${data.userprofile.userName}</td>
                                    <td>${data.updated_at}</td>
                                    <td>${data.record}</td>
                                    <td>${data.money}</td>
                                    <td><a href="${data.upload_file}">下载</a></td>
                                    <td class="client-status" style="width: 120px;">
                            `;

                            if (viewTypes.includes(data.name)) {
                                temp += `
                                    <button class="btn btn-xs btn-primary view" value="${data.id}">
                                        <i class="fa fa-edit"></i> 查看数据
                                    </button>
                                `;
                            } else {
                                temp += `
                                        </td>
                                    </tr>
                                `;
                            }


                            $('#confirmList').append(temp);
                            $('#wf'+id).remove();

                            swal(msg, { icon: "success" });
                        },
                        error: function (data, json, errorThrow) {
                            console.log(data, errorThrow);
                        }
                    });
                } else {
                    swal("取消操作!");
                }
            });
        });

        body.on('click', 'button.delete', function () {
            swal({
                title: "数据是否删除?",
                text: "请联系业务人员重新上传数据!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willConfirm) => {
                if (willConfirm) {
                    let id = $(this).val();
                    $.ajax({
                        type: 'DELETE',
                        url: url + id,
                        success: function (data) {
                            let msg = data.name + '已删除！';
                            $('#wf'+id).remove();
                            swal(msg, { icon: "success" });
                        },
                        error: function (data, json, errorThrow) {
                            console.log(data, errorThrow);
                        }
                    });
                } else {
                    swal("取消操作!");
                }
            });
        })
    });
</script>
@endsection
