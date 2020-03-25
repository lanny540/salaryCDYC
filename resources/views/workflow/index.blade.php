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
                        <li><a class="nav-link active" data-toggle="tab" href="#unconfirmWorkflow"><i class="fa fa-desktop"></i> 未审核</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#confirmWorkflow"><i class="fa fa-database"></i> 已审核</a></li>
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
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($workflows as $w)
                                        @if($w->isconfirm === 0)
                                            <tr id="wf{{ $w->id }}" class="text-center">
                                                <td style="width: 100px;">
                                                    <span class="label label-danger">数据待审核</span>
                                                </td>
                                                <td>{{ $w->name }}</td>
                                                <td>{{ $w->uploader }}</td>
                                                <td class="client-status" style="width: 220px;margin-left: 30px;">
                                                    <button class="btn btn-sm btn-primary view" value="{{ $w->id }}">
                                                        <i class="fa fa-edit"></i> 查看数据
                                                    </button>
                                                    <button class="btn btn-sm btn-success pull-right confirm" value="{{ $w->id }}" style="margin-left: 10px;">
                                                        <i class="fa fa-bug"></i> 数据确认
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
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
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody id="confirmList">
                                    @foreach($workflows as $w)
                                        @if($w->isconfirm === 1)
                                            <tr id="wf{{ $w->id }}" class="text-center">
                                                <td style="width: 100px;">
                                                    <span class="label label-success">数据已审核</span>
                                                </td>
                                                <td>{{ $w->name }}</td>
                                                <td>{{ $w->uploader }}</td>
                                                <td class="client-status" style="width: 120px;">
                                                    <button class="btn btn-sm btn-primary view" value="{{ $w->id }}">
                                                        <i class="fa fa-edit"></i> 查看数据
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
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
                                    <td class="client-status" style="width: 120px;">
                                    <button class="btn btn-sm btn-primary view" value="${data.id}">
                                        <i class="fa fa-edit"></i> 查看数据
                                    </button>
                                    </td>
                                </tr>
                            `;

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
    });
</script>
@endsection
