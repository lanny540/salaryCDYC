@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <style>
        .systemTable {
            overflow: scroll;
            width: 100%;
            height: 800px;
        }
    </style>
@endsection

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>基础数据列表</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    系统设置
                </li>
                <li class="breadcrumb-item active">
                    <strong>基础数据</strong>
                </li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="table-responsive systemTable">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr class="text-center">
                                    <th>KEY</th>
                                    <th>VALUE</th>
                                    <th>TYPE</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($systems as $s)
                                    <tr id="system{{ $s->id }}" class="text-center">
                                        <td>{{ $s->description }}</td>
                                        <td>{{ $s->config_value }}</td>
                                        <td>{{ $s->type }}</td>
                                        <td class="client-status" style="width: 150px;margin-left: 10px;">
                                            <button class="btn btn-sm btn-primary edit" value="{{ $s->id }}">
                                                <i class="fa fa-edit"></i> 编辑
                                            </button>
                                            <button class="btn btn-sm btn-danger pull-right delete" value="{{ $s->id }}" style="margin-left: 10px;">
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
            </div>
        </div>
    </div>

    @include('settings.system._modals')
@endsection

@section('js')
    <!-- Toastr script -->
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('js/plugins/sweetalert2/sweetalert.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

            const url = '/systemconfig/';
            const body = $('body');

            body.on('click', 'button.delete', function() {
                swal({
                    title: "是否确定删除?",
                    text: "一旦删除数据将无法恢复，请谨慎操作!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        let id = $(this).val();
                        $.ajax({
                            type: 'DELETE',
                            url: url + id,
                            success: function (data) {
                                $('#system'+id).remove();
                                swal(data, {
                                    icon: "success",
                                });
                            },
                            error: function (data, json, errorThrow) {
                                console.log(data);
                                let errors = data.responseJSON.errors;
                                let errorsHTML = '';
                                $.each(errors, function(key, value) {
                                    errorsHTML += '<li>' + value[0] + '</li>';
                                });
                                toastr.error(errorsHTML, 'Error ' + data.status + ': ' + errorThrow);
                            }
                        });
                    } else {
                        swal("取消操作!");
                    }
                });
            });

            body.on('click', 'button.edit', function () {
                let id = $(this).val();
                $('#id').val(id);
                $.get(url + id, function (data) {
                    $('#description').val(data['description']);
                    $('#config_value').val(data['config_value']);
                    $('#type').val(data['type']);
                });

                $('#systemModal').modal('show');
            });

            $('#save').on('click', function() {
                let id = $('#id').val();
                let data = {
                    description: $('#description').val(),
                    config_value: $('#config_value').val(),
                    type: $('#type').val(),
                };

                $.ajax({
                    type: 'PUT',
                    url: url + id,
                    data: data,
                    dataType: 'json',
                    success: function (data) {
                        $('#systemModal').modal('hide');
                        $('#system').trigger('reset');

                        let temp = `
                            <tr id="system${data.config.id}" class="text-center">
                                <td>${data.config.description}</td>
                                <td>${data.config.config_value}</td>
                                <td>${data.config.type}</td>
                                <td class="client-status" style="width: 150px;margin-left: 10px;">
                                    <button class="btn btn-sm btn-primary edit" value="${data.config.id}">
                                        <i class="fa fa-edit"></i> 编辑
                                    </button>
                                    <button class="btn btn-sm btn-danger pull-right delete" value="${data.config.id}" style="margin-left: 10px;">
                                        <i class="fa fa-bug"></i> 删除
                                    </button>
                                </td>
                            </tr>
                        `;

                        $('#system'+data.config.id).replaceWith(temp);
                        swal(data.msg, {icon: "success"});
                    },
                    error: function (data, json, errorThrown) {
                        console.log(data);
                        let errors = data.responseJSON.errors;
                        let errorsHtml= '';
                        $.each(errors, function(key, value ) {
                            errorsHtml += '<li>' + value[0] + '</li>';
                        });
                        toastr.error( errorsHtml , "Error " + data.status +': '+ errorThrown);
                    }
                });
            });
        });
    </script>
@endsection
