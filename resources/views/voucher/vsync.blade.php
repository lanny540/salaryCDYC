@extends('layouts.app')

@section('css')
@endsection

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>凭证数据上传</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    凭证相关
                </li>
                <li class="breadcrumb-item active">
                    <strong>凭证任务列表</strong>
                </li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox" id="wizardForm">
                <div class="ibox-content">
                    <h2>上传任务列表</h2>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr class="text-center">
                                <th>状态</th>
                                <th>凭证名称</th>
                                <th>填表人</th>
                                <th>凭证日期</th>
                                <th>凭证描述</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lists as $t)
                                <tr id="task{{ $t->id }}" class="text-center">
                                    @if ($t->isUpload === 0)
                                        <td class="label-info">未同步</td>
                                    @elseif ($t->isUpload === 1)
                                        <td class="label-success">已同步</td>
                                    @endif
                                    <td>{{ $t->vname }}</td>
                                    <td>{{ $t->vuser }}</td>
                                    <td>{{ $t->cdate }}</td>
                                    <td>{{ Illuminate\Support\Str::limit($t->vdescription, 20, '...') }}</td>
                                    <td class="client-status text-right" style="width: 280px;">
                                        <button class="btn btn-primary view" value="{{ $t->id }}">
                                            <i class="fa fa-edit"></i> 查看
                                        </button>
                                        @if($t->isUpload === 0)
                                            <button class="btn btn-success upload" value="{{ $t->id }}">
                                                <i class="fa fa-cloud-upload"></i> 同步
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
@endsection

@section('js')
<!-- SweetAlert2 -->
<script src="{{ asset('js/plugins/sweetalert2/sweetalert.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

        const body = $('body');
        const url = 'erpsync/';

        body.on('click', 'button.upload', function () {
            let id = $(this).val();

            $.ajax({
                type: 'POST',
                url: url + id,
                success: function (data) {
                    let msg = data.vname + ' 已同步到ERP！';
                    let temp = `
                        <tr id="task${data.id}" class="text-center">
                            <td class="label-success">已同步</td>
                            <td>${data.vname}</td>
                            <td>${data.vuser}</td>
                            <td>${data.cdate}</td>
                            <td>${data.vdescription}</td>
                            <td class="client-status text-right" style="width: 280px;">
                                <button class="btn btn-primary view" value="${data.id}">
                                    <i class="fa fa-edit"></i> 查看
                                </button>
                            </td>
                        </tr>
                    `;

                    $('#task'+data.id).replaceWith(temp);

                    swal(msg, { icon: "success" });
                },
                error: function (data, json, errorThrow) {
                    console.log(data, errorThrow);
                }
            });
        });
    });
</script>
@endsection
