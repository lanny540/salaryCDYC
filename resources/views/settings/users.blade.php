@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/plugins/dataTables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>人员列表</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    系统设置
                </li>
                <li class="breadcrumb-item active">
                    <strong>人员管理</strong>
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
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover users-dataTables">
                                <thead>
                                    <tr>
                                        <th>姓名</th>
                                        <th>部门</th>
                                        <th>工号</th>
                                        <th style="width: 20%;">操作</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>姓名</th>
                                        <th>部门</th>
                                        <th>工号</th>
                                        <th>操作</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<!--  datatables  -->
<script src="{{ asset('js/plugins/dataTables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/datatables.config.js') }}"></script>

<script>
    let table =$('.users-dataTables').DataTable({
        ajax: '/getUsersData',
        columns: [
            { data: 'profile.userName', name: 'profile.userName'},
            { data: 'profile.department.name', name: 'profile.department.name'},
            { data: 'name', name: 'name'},
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    $(document).ready(function () {
        $('.users-dataTables tfoot th').each(function (colIdx) {
            if (colIdx < 3) {
                let title = $('.users-dataTables thead th').eq($(this).index()).text();
                $(this).html('<input type="text" placeholder="Search '+title+'" />');
            }
        });

        table.columns().eq(0).each(function (colIdx) {
            $('input', table.column(colIdx).footer()).on('keyup change', function () {
                table.column(colIdx).search(this.value).draw();
            });
        });

        table.on('click', '.edit', function () {
            let tr = $(this).closest('tr');
            let data = table.row(tr).data();
            $(location).attr('href', '/users/' + data.id + '/edit');
            //$(open('/profile/' + data.id + '/edit'))
        });
    })
</script>
@endsection
