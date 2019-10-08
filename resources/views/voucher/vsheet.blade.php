@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <!-- dataTables -->
    <link href="{{ asset('css/plugins/dataTables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/dataTables/fixedColumns.bootstrap4.min.css') }}" rel="stylesheet">
@stop

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>凭证基础表</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    凭证相关
                </li>
                <li class="breadcrumb-item active">
                    <strong>凭证基础表</strong>
                </li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox" id="ibox">
                    <div class="ibox-content">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="period">发放日期 </label>
                            <div class="col-sm-4">
                                <select class="form-control select2_types" id="period" size="12" style="width: 200px;">
                                    <option></option>
                                    @foreach($periods as $p)
                                        <option value="{{ $p->id }}">{{ $p->published_at }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-block btn-primary" id="vsheetGenerate">生成汇总表</button>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-block btn-success" id="vsheetSubmit" disabled>提交保存</button>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-block btn-info" id="vsheetExport" disabled>导出Excel</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table id="sheets-dataTables"
                                       class="table table-striped table-bordered table-hover"
                                       style="white-space: nowrap;"
                                >
                                    <thead>
                                    <tr>
                                        <th>dwdm</th>
                                        <th>部门名称</th>
                                        <th>人数</th>

                                        <th>岗位工资</th>
                                        <th>保留工资</th>
                                        <th>套级补差</th>
                                        <th>中夜班费</th>
                                        <th>加班工资</th>
                                        <th>年功工资</th>
                                        <th>基本养老金</th>
                                        <th>增机</th>
                                        <th>国家小计</th>
                                        <th>地方小计</th>
                                        <th>行业小计</th>
                                        <th>企业独子费</th>
                                        <th>企业小计</th>
                                        <th>离退休补充</th>
                                        <th>应发工资</th>

                                        <th>月奖</th>

                                        <th>通讯补贴</th>
                                        <th>交通费</th>
                                        <th>住房补贴</th>
                                        <th>独子费</th>

                                        <th>补发工资</th>
                                        <th>补发补贴</th>
                                        <th>补发其他</th>
                                        <th>补发合计</th>

                                        <th>公积金个人</th>
                                        <th>公积企业缴</th>
                                        <th>年金个人</th>
                                        <th>年金企业缴</th>
                                        <th>退养金个人</th>
                                        <th>退养企业缴</th>
                                        <th>医保金个人</th>
                                        <th>医疗企业缴</th>
                                        <th>失业金个人</th>
                                        <th>失业企业缴</th>
                                        <th>工伤企业缴</th>
                                        <th>生育企业缴</th>

                                        <th>成钞水费</th>
                                        <th>成钞电费</th>
                                        <th>鑫源水费</th>
                                        <th>鑫源电费</th>
                                        <th>车库水费</th>
                                        <th>车库电费</th>
                                        <th>退补水费</th>
                                        <th>退补电费</th>
                                        <th>水电</th>
                                        <th>物管费</th>
                                        <th>扣工会会费</th>
                                        <th>公车费用</th>
                                        <th>固定扣款</th>
                                        <th>临时扣款</th>
                                        <th>其他扣款</th>
                                        <th>上期余欠款</th>
                                        <th>已销欠款</th>
                                        <th>扣欠款</th>
                                        <th>税差</th>
                                        <th>个人所得税</th>

                                        <th>代汇</th>
                                        <th>银行发放</th>
                                        <th>余欠款</th>
                                        <th>法院转提</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <!-- ramda -->
    <script src="{{ asset('js/plugins/ramda/ramda.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- Sweet alert -->
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <!-- dataTables -->
    <script src="{{ asset('js/plugins/dataTables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.fixedColumns.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/fixedColumns.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.config.js') }}"></script>

    <script src="{{ asset('js/helper.js') }}"></script>

    <script>
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

        $(".select2_types").select2({
            placeholder: "请选择发放日期...",
            allowClear: true
        });

        $(document).ready(function () {
            let sheets = <?php echo $sheets; ?>;
            let sheetData;

            $('#vsheetGenerate').on('click', function () {
                $('#ibox').children('.ibox-content').toggleClass('sk-loading');
                let pid = $('#period').val();

                if (pid > 0) {
                    if (sheets[pid - 1] && sheets[pid - 1].id === parseInt(pid)) {
                        swal({
                            title: "你确定重新生成汇总表吗?",
                            text: "该会计期已存在汇总表!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "是的, 重新生成!",
                            cancelButtonText: "不, 立即查看!",
                            closeOnConfirm: true,
                            closeOnCancel: true,
                        }, function (isConfirm) {
                            if (isConfirm) {
                                calulateSheet(pid, 1);
                            } else {
                                calulateSheet(pid, 0);
                            }
                        });
                    } else {
                        calulateSheet(pid, 1);
                    }

                    setTimeout(function () {
                        $('#ibox').children('.ibox-content').toggleClass('sk-loading');
                        sheetData = $('#sheets-dataTables').DataTable().data();
                    }, 5000);
                } else {
                    swal({
                        title: "出错了!",
                        text: "没有选择会计期!",
                        type: "error"
                    });
                    $('#ibox').children('.ibox-content').toggleClass('sk-loading');
                }
            });

            $('#vsheetSubmit').on('click', function () {
                let temp = getTableDatas();
                let periodId = $('#period').val();
                let data = [];

                temp.forEach((item, i) => {
                    data[i] = R.assoc('period_id', periodId, item);
                });

                let params = {
                    sheet: JSON.stringify(data),
                    periodId: periodId,
                    _token: '{{ csrf_token() }}',
                };

                Post("vsheet", params);
            });
        });

        // 生成凭证汇总数据
        function calulateSheet(pid, calculate) {
            if (calculate === 1) {
                $('#vsheetSubmit').removeAttr('disabled');
            }
            let url = '/vsheet/' + pid + '?calculate=' + calculate;
            // console.log(url);
            let tabledom = $('#sheets-dataTables');
            let sheetsTable = tabledom.dataTable();
            if (tabledom.hasClass('dataTable')) {
                sheetsTable.fnClearTable(); //清空table
                sheetsTable.fnDestroy(); //还原初始化的datatable
            }
            sheetsTable.show();

            tabledom.DataTable({
                scrollY: "500px",
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                searching: false,
                autoWidth: true,
                ajax: url,
                columns: [
                    {data: 'dwdm', name: 'dwdm'},
                    {data: 'name', name: 'name', orderable: false},
                    {data: 'sum_number', name: 'sum_number', orderable: false},
                    {data: 'wage', name: 'wage', orderable: false},
                    {data: 'retained_wage', name: 'retained_wage', orderable: false},
                    {data: 'compensation', name: 'compensation', orderable: false},
                    {data: 'night_shift', name: 'night_shift', orderable: false},
                    {data: 'overtime_wage', name: 'overtime_wage', orderable: false},
                    {data: 'seniority_wage', name: 'seniority_wage', orderable: false},
                    {data: 'jbylj', name: 'jbylj', orderable: false},
                    {data: 'zj', name: 'zj', orderable: false},
                    {data: 'gjxj', name: 'gjxj', orderable: false},
                    {data: 'dfxj', name: 'dfxj', orderable: false},
                    {data: 'hyxj', name: 'hyxj', orderable: false},
                    {data: 'qydzf', name: 'qydzf', orderable: false},
                    {data: 'qyxj', name: 'qyxj', orderable: false},
                    {data: 'ltxbc', name: 'ltxbc', orderable: false},
                    {data: 'wage_total', name: 'wage_total', orderable: false},

                    {data: 'month_bonus', name: 'month_bonus', orderable: false},

                    {data: 'communication', name: 'communication', orderable: false},
                    {data: 'traffic', name: 'traffic', orderable: false},
                    {data: 'housing', name: 'housing', orderable: false},
                    {data: 'single', name: 'single', orderable: false},

                    {data: 'reissue_wage', name: 'reissue_wage', orderable: false},
                    {data: 'reissue_subsidy', name: 'reissue_subsidy', orderable: false},
                    {data: 'reissue_other', name: 'reissue_other', orderable: false},
                    {data: 'reissue_total', name: 'reissue_total', orderable: false},

                    {data: 'gjj_person', name: 'gjj_person', orderable: false},
                    {data: 'gjj_enterprise', name: 'gjj_enterprise', orderable: false},
                    {data: 'annuity_person', name: 'annuity_person', orderable: false},
                    {data: 'annuity_enterprise', name: 'annuity_enterprise', orderable: false},
                    {data: 'retire_person', name: 'retire_person', orderable: false},
                    {data: 'retire_enterprise', name: 'retire_enterprise', orderable: false},
                    {data: 'medical_person', name: 'medical_person', orderable: false},
                    {data: 'medical_enterprise', name: 'medical_enterprise', orderable: false},
                    {data: 'unemployment_person', name: 'unemployment_person', orderable: false},
                    {data: 'unemployment_enterprise', name: 'unemployment_enterprise', orderable: false},
                    {data: 'injury_enterprise', name: 'injury_enterprise', orderable: false},
                    {data: 'birth_enterprise', name: 'birth_enterprise', orderable: false},

                    {data: 'cc_water', name: 'cc_water', orderable: false},
                    {data: 'cc_electric', name: 'cc_electric', orderable: false},
                    {data: 'xy_water', name: 'xy_water', orderable: false},
                    {data: 'xy_electric', name: 'xy_electric', orderable: false},
                    {data: 'garage_water', name: 'garage_water', orderable: false},
                    {data: 'garage_electric', name: 'garage_electric', orderable: false},
                    {data: 'back_water', name: 'back_water', orderable: false},
                    {data: 'back_electric', name: 'back_electric', orderable: false},
                    {data: 'water_electric', name: 'water_electric', orderable: false},
                    {data: 'property_fee', name: 'property_fee', orderable: false},
                    {data: 'union_deduction', name: 'union_deduction', orderable: false},
                    {data: 'car_fee', name: 'car_fee', orderable: false},
                    {data: 'fixed_deduction', name: 'fixed_deduction', orderable: false},
                    {data: 'temp_deduction', name: 'temp_deduction', orderable: false},
                    {data: 'other_deduction', name: 'other_deduction', orderable: false},
                    {data: 'prior_deduction', name: 'prior_deduction', orderable: false},
                    {data: 'had_debt', name: 'had_debt', orderable: false},
                    {data: 'debt', name: 'debt', orderable: false},
                    {data: 'tax_diff', name: 'tax_diff', orderable: false},
                    {data: 'personal_tax', name: 'personal_tax', orderable: false},

                    {data: 'instead_salary', name: 'instead_salary', orderable: false},
                    {data: 'bank_salary', name: 'bank_salary', orderable: false},
                    {data: 'debt_salary', name: 'debt_salary', orderable: false},
                    {data: 'court_salary', name: 'court_salary', orderable: false},
                ],
                fixedColumns: {
                    leftColumns: 2
                }
            });
        }

    </script>
@stop
