@extends('layouts.app')

@section('css')
<!-- Select2 -->
<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<!-- FooTable -->
<link href="{{ asset('css/plugins/footable3/footable.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>生成凭证</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">首页</a>
            </li>
            <li class="breadcrumb-item">
                凭证相关
            </li>
            <li class="breadcrumb-item active">
                <strong>凭证数据</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    {{ Form::open(['route' => 'vdata.store', 'method' => 'post']) }}
    <div class="ibox-content m-b-sm border-bottom" style="padding: 0 10px 0 10px">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-form-label" for="cdate">凭证日期</label>
                    <input type="text" id="cdate" name="cdate" value="{{ $vdata['cdate'] }}" placeholder="凭证日期" class="form-control form-control-sm">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-form-label" for="vuser">制单人名称</label>
                    <input type="text" id="vuser" name="vuser" value="{{ $vdata['vuser'] }}" placeholder="制单人名称" class="form-control form-control-sm" disabled>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-form-label" for="period">会计周期</label>
                    <input type="text" id="period" name="period" value="{{ $vdata['period'] }}" placeholder="Customer" class="form-control form-control-sm">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-form-label" for="vname">凭证名称</label>
                    <input type="text" id="vname" name="vname" value="{{ $vdata['vname'] }}" placeholder="凭证名称" class="form-control form-control-sm">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-form-label" for="cgroup">凭证批组</label>
                    <div class="input-group">
                        <input type="text" id="cgroup" name="cgroup" value="{{ $vdata['cgroup'] }}" placeholder="凭证批组" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-form-label" for="vcategory">凭证类别</label>
                    <div class="input-group">
                        <select id="vcategory" name="vcategory" class="form-control">
                            <option value="手工转账" {{ ($vdata['vcategory'] === '手工转账') ? 'selected' : '' }}>手工转账</option>
                            <option value="现金凭证" {{ ($vdata['vcategory'] === '现金凭证') ? 'selected' : '' }}>现金凭证</option>
                            <option value="银行凭证" {{ ($vdata['vcategory'] === '银行凭证') ? 'selected' : '' }}>银行凭证</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="col-form-label" for="vdescription">凭证描述</label>
                    <input type="text" id="vdescription" name="vdescription" value="{{ $vdata['vdescription'] }}" placeholder="凭证描述" class="form-control form-control-sm">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <table class="footable table table-hover toggle-arrow-tiny" data-paging="true" data-sorting="false">
                        <thead>
                        <tr>
                            <th></th>
                            <th>公司</th>
                            <th>责任中心段</th>
                            <th>科目段</th>
                            <th>子母段</th>
                            <th>产品段</th>
                            <th>参考段</th>
                            <th>借方金额</th>
                            <th>贷方金额</th>
                            <th data-breakpoints="all">会计科目描述</th>
                            <th data-breakpoints="all">凭证单项描述</th>
                            <th class="text-right">操作</th>
                        </tr>
                        </thead>
                        <tbody id="vdata-list">
                        @foreach($vdata['vdata'] as $k => $vd)
                            <tr id="vdata{{ $vd['id'] }}">
                                <td></td>
                                <td>{{ $vd['seg0'] }}</td>
                                <td>{{ $vd['seg1'] }}</td>
                                <td>{{ $vd['seg2'] }}</td>
                                <td>{{ $vd['seg3'] }}</td>
                                <td>{{ $vd['seg4'] }}</td>
                                <td>{{ $vd['seg5'] }}</td>
                                <td>{{ $vd['debit'] }}</td>
                                <td>{{ $vd['credit'] }}</td>
                                <td>{{ $vd['seg_des'] }}</td>
                                <td>{{ $vd['detail_des'] }}</td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <button class="btn-info btn btn-sm edit" value="{{ $vd['id'] }}">Edit</button>
                                        <button class="btn-danger btn btn-sm delete" value="{{ $vd['id'] }}">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" value="{{ $vdata['vid'] }}" name="vid">
    <input type="hidden" value="{{ $vdata['period_id'] }}" name="period_id">
    {{ Form::submit() }}
    {{ Form::close() }}

    @include('voucher._modals')
</div>
@endsection

@section('js')
<!-- Select2 -->
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<!-- FooTable -->
<script src="{{ asset('js/plugins/footable3/footable.min.js') }}"></script>

<script>
    $(".select2_category").select2();
    $('.footable').footable({
        "expandFirst": false,
        "useParentWidth": true,
        "show-toggle": true,
        "paging": {
            "size": 20,
            "position": "center",
        }
    });

    let vdata = <?php echo $tempdata;?>;

    $(document).ready(function() {
        console.log(vdata);
    });
</script>
@endsection
