@extends('layouts.app')

@section('css')
<!-- Select2 -->
<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">

<style>
    .voucherTable {
        overflow: scroll;
        width: 100%;
        height: 800px;
    }
</style>
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
                <div class="ibox-title">
                    <button class="btn btn-sm btn-outline-danger create"><b>新增临时会计科目数据</b></button>
                    <button class="btn btn-sm btn-info store pull-right"><b>保存此凭证数据</b></button>
                </div>
                <div class="ibox-content voucherTable">
                    <table class="table table-hover">
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
                            <th>会计科目描述</th>
                            <th>凭证单项描述</th>
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
                                <td class="text-success text-center">{{ $vd['debit'] }}</td>
                                <td class="text-info text-center">{{ $vd['credit'] }}</td>
                                <td>{{ $vd['seg_des'] }}</td>
                                <td>{{ $vd['detail_des'] }}</td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <button class="btn-info btn btn-sm edit" value="{{ $vd['id'] }}"><span class="fa fa-edit"></span> Edit</button>
                                        <input type="hidden" value="{{ $k }}">
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @foreach($vdata['temp'] as $k => $vd)
                            <tr id="vdata{{ $vd['id'] }}_temp" style="background-color: #FFF8DC">
                                <td></td>
                                <td>{{ $vd['seg0'] }}</td>
                                <td>{{ $vd['seg1'] }}</td>
                                <td>{{ $vd['seg2'] }}</td>
                                <td>{{ $vd['seg3'] }}</td>
                                <td>{{ $vd['seg4'] }}</td>
                                <td>{{ $vd['seg5'] }}</td>
                                <td class="text-success text-center">{{ $vd['debit'] }}</td>
                                <td class="text-info text-center">{{ $vd['credit'] }}</td>
                                <td>{{ $vd['seg_des'] }}</td>
                                <td>{{ $vd['detail_des'] }}</td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <button class="btn-info btn btn-sm edit" value="{{ $vd['id'] }}_temp"><span class="fa fa-edit"></span> Edit</button>
                                        <button class="btn-danger btn btn-sm delete" value="{{ $vd['id'] }}_temp"><span class="fa fa-trash"></span> Delete</button>
                                        <input type="hidden" value="{{ $k }}">
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

    <input type="hidden" value="{{ $vdata['vid'] }}" name="vid" id="vid">
    <input type="hidden" value="{{ $vdata['period_id'] }}" name="period_id" id="period_id">

    @include('voucher._modals')
</div>
@endsection

@section('js')
<!-- Select2 -->
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('js/plugins/sweetalert2/sweetalert.min.js') }}"></script>

<script src="{{ asset('js/helper.js') }}"></script>

<script>
    $(".select2_category").select2();
    $(".select2_segment").select2({
        dropdownParent: $('#tempVoucherSubjectModal')
    });

    let vdata = <?php echo $tempdata;?>;

    $(document).ready(function() {
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

        const body = $('body');

        // 解决select2在modal中无法正确显示的错误
        body.on('shown.bs.modal', '.modal', function() {
            $(this).find('select').each(function() {
                let dropdownParent = $(document.body);
                if ($(this).parents('.modal.in:first').length !== 0)
                    dropdownParent = $(this).parents('.modal.in:first');
                $(this).select2({
                    dropdownParent: dropdownParent
                });
            });
            $(".select2-selection__rendered").on("click",function(){
                setTimeout("$('.select2-container.select2-container--default.select2-container--open').addClass('modal');",100);
            });
        });

        // 新增按钮
        body.on('click', 'button.create', function() {
            // console.log('新增临时会计科目数据', vdata.temp);
            $('#modal_title').text('新增数据');

            // 数据初始化
            $('#seg1').prop('selectedIndex', 0);
            $('#seg2').prop('selectedIndex', 0);
            $('#seg3').prop('selectedIndex', 0);
            $('#seg4').prop('selectedIndex', 0);
            $('#seg5').prop('selectedIndex', 0);
            $('#id').val(-1);
            $('#type').val('temp');
            $('#debit').val(0);
            $('#credit').val(0);
            $('#seg_des').val('');
            $('#detail_des').val('');
            $('#hiddenId').val(0);

            $('#tempVoucherSubjectModal').modal('show');
        });

        // 编辑按钮
        body.on('click', 'button.edit', function() {
            let modalData = {};
            let hiddenInput = $(this).siblings('input');

            $('#modal_title').text('编辑数据');

            let temp = $(this).val();
            let modalType = $('#type');
            // 是临时科目数据还是模板数据
            if (temp.search("_temp") === -1 ) {
                modalType.val('fixed');
                modalData = vdata.vdata[hiddenInput.val()];
            } else {
                modalType.val('temp');
                modalData = vdata.temp[hiddenInput.val()];
            }
            // 数据初始化
            $('#id').val(modalData.id);
            $('#seg0').val(modalData.seg0);
            $('#seg1').val(modalData.seg1);
            $('#seg2').val(modalData.seg2);
            $('#seg3').val(modalData.seg3);
            $('#seg4').val(modalData.seg4);
            $('#seg5').val(modalData.seg5);
            $('#debit').val(parseFloat(modalData.debit).toFixed(2));
            $('#credit').val(parseFloat(modalData.credit).toFixed(2));
            $('#seg_des').val(modalData.seg_des);
            $('#detail_des').val(modalData.detail_des);
            $('#hiddenId').val(hiddenInput.val());

            $('#tempVoucherSubjectModal').modal('show');
        });

        // 删除按钮
        body.on('click', 'button.delete', function() {
            let temp = $(this).val();
            let id = transformButtonValue(temp);

            swal({
                title: "是否确定删除?",
                text: "删除数据前，请将此行数据收拢，否则会出现显示错误!数据不受影响！",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    if (temp.search("_temp") === -1 ) {
                        for(let i=0; i < vdata.vdata.length; ++i) {
                            if (vdata.vdata[i].id === id) {
                                // 不能删除，只能将 该下标的数据 置为 0
                                vdata.vdata[i].debit = 0;
                                vdata.vdata[i].credit = 0;
                                $('#vdata' + temp).remove();    // 删除表格对应行
                                break;
                            }
                        }
                        console.log('更改后:', vdata.vdata);
                    } else {
                        for(let i=0; i < vdata.temp.length; ++i) {
                            if (vdata.temp[i].id === id) {
                                vdata.temp.splice(i, 1);       // 删除数组对应下标
                                $('#vdata' + temp).remove();    // 删除表格对应行
                                break;
                            }
                        }
                        console.log('更改后:', vdata.temp);
                    }
                } else {
                    swal("取消操作!");
                }
            });
        });

        // modal 保存按钮
        $('#save').on('click', function() {
            let id = $('#id').val();
            let temp = {
                id: id,
                seg0: $('#seg0').val(),
                seg1: $('#seg1').val(),
                seg2: $('#seg2').val(),
                seg3: $('#seg3').val(),
                seg4: $('#seg4').val(),
                seg5: $('#seg5').val(),
                debit: $('#debit').val(),
                credit: $('#credit').val(),
                seg_des: $('#seg_des').val(),
                detail_des: $('#detail_des').val(),
                hiddenId: $('#hiddenId').val()
            };
            let error_messages = $('#error_messages');
            let data = validationModalData(temp);

            // console.log(data);

            error_messages.html('');
            if (!data.validate) {
                // 验证失败
                for (let i=0; i < data.messages.length; ++i) {
                    error_messages.append(`<li class="text-danger">${data.messages[i]}</li>`);
                }
            } else {
                // 验证成功
                let modalType = $('#type').val();

                if (modalType === 'temp') {
                    // 临时科目
                    if (id === '-1') {
                        // 新增：临时科目的ID 等于 temp 数组的长度 + 1
                        data.modalData.id = vdata.temp.length + 1;
                        vdata.temp.push(data.modalData);

                        let voucher =`
                            <tr id="vdata${data.modalData.id}_temp" style="background-color: #FFF8DC">
                                <td></td>
                                <td>${data.modalData.seg0}</td>
                                <td>${data.modalData.seg1}</td>
                                <td>${data.modalData.seg2}</td>
                                <td>${data.modalData.seg3}</td>
                                <td>${data.modalData.seg4}</td>
                                <td>${data.modalData.seg5}</td>
                                <td class="text-success text-center">${data.modalData.debit}</td>
                                <td class="text-info text-center">${data.modalData.credit}</td>
                                <td>${data.modalData.seg_des}</td>
                                <td>${data.modalData.detail_des}</td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <button class="btn-info btn btn-sm edit" value="${data.modalData.id}_temp"><span class="fa fa-edit"></span> Edit</button>
                                        <button class="btn-danger btn btn-sm delete" value="${data.modalData.id}_temp"><span class="fa fa-trash"></span> Delete</button>
                                        <input type="hidden" value="${data.modalData.hiddenId}">
                                    </div>
                                </td>
                            </tr>
                        `;

                        $('#vdata-list').append(voucher);
                    } else {
                        vdata.temp[id] = data.modalData;
                        $('#vdata'+data.modalData.id+'_temp').replaceWith(voucher);
                    }
                    console.log('更改后:', vdata.temp);
                } else {
                    // 模板科目
                    data.modalData.id = parseInt(id);
                    for(let i=0; i < vdata.vdata.length; ++i) {
                        if (vdata.vdata[i].id === parseInt(id)) {
                            vdata.vdata[i] = data.modalData;
                            break;
                        }
                    }
                    // console.log('计算前:', vdata.vdata);

                    swal({
                        title: "是否需要重新计算?",
                        text: "凭证模板数据已修改。重新计算可能导致其他相关数据变化，请谨慎选择！",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willReCal) => {
                        if (willReCal) {
                            // 模板数据变更后需要重新进行计算,再将计算后的数据重新渲染一次
                            $.ajax({
                                url: '/vdataReCal',
                                type: 'POST',
                                data: {
                                    vid: $('#vid').val(),
                                    period_id: $('#period_id').val(),
                                    vdata: vdata.vdata
                                },
                                dataType: 'json',
                                success: function (data) {
                                    // console.log('重新计算后:',data);
                                    let vlist = $('#vdata-list');
                                    vdata.vdata = data;

                                    vlist.html('');

                                    let lists = '';
                                    // 模板数据
                                    for (let i=0; i < data.length; ++i) {
                                        lists += `
                                        <tr id="vdata${data[i].id}">
                                            <td></td>
                                            <td>${data[i].seg0}</td>
                                            <td>${data[i].seg1}</td>
                                            <td>${data[i].seg2}</td>
                                            <td>${data[i].seg3}</td>
                                            <td>${data[i].seg4}</td>
                                            <td>${data[i].seg5}</td>
                                            <td class="text-success text-center">${parseFloat(data[i].debit).toFixed(2)}</td>
                                            <td class="text-info text-center">${parseFloat(data[i].credit).toFixed(2)}</td>
                                            <td>${data[i].seg_des}</td>
                                            <td>${data[i].detail_des}</td>
                                            <td class="text-right">
                                                <div class="btn-group">
                                                    <button class="btn-info btn btn-sm edit" value="${data[i].id}"><span class="fa fa-edit"></span> Edit</button>
                                                    <input type="hidden" value=${i}>
                                                </div>
                                            </td>
                                        </tr>
                                        `;
                                    }
                                    // 临时数据
                                    for (let i=0; i<vdata.temp.length; ++i) {
                                        lists += `
                                            <tr id="vdata${vdata.temp[i].id}_temp" style="background-color: #FFF8DC">
                                                <td></td>
                                                <td>${vdata.temp[i].seg0}</td>
                                                <td>${vdata.temp[i].seg1}</td>
                                                <td>${vdata.temp[i].seg2}</td>
                                                <td>${vdata.temp[i].seg3}</td>
                                                <td>${vdata.temp[i].seg4}</td>
                                                <td>${vdata.temp[i].seg5}</td>
                                                <td class="text-success text-center">${vdata.temp[i].debit}</td>
                                                <td class="text-info text-center">${vdata.temp[i].credit}</td>
                                                <td>${vdata.temp[i].seg_des}</td>
                                                <td>${vdata.temp[i].detail_des}</td>
                                                <td class="text-right">
                                                    <div class="btn-group">
                                                        <button class="btn-info btn btn-sm edit" value="${vdata.temp[i].id}_temp"><span class="fa fa-edit"></span> Edit</button>
                                                        <button class="btn-danger btn btn-sm delete" value="${vdata.temp[i].id}_temp"><span class="fa fa-trash"></span> Delete</button>
                                                        <input type="hidden" value="${i}">
                                                    </div>
                                                </td>
                                            </tr>
                                        `;
                                    }

                                    vlist.html(lists);
                                }
                            });
                        } else {
                            swal("未重新计算!");
                            let voucher = `
                                <tr id="vdata${data.modalData.id}">
                                    <td></td>
                                    <td>${data.modalData.seg0}</td>
                                    <td>${data.modalData.seg1}</td>
                                    <td>${data.modalData.seg2}</td>
                                    <td>${data.modalData.seg3}</td>
                                    <td>${data.modalData.seg4}</td>
                                    <td>${data.modalData.seg5}</td>
                                    <td class="text-success text-center">${parseFloat(data.modalData.debit).toFixed(2)}</td>
                                    <td class="text-info text-center">${parseFloat(data.modalData.credit).toFixed(2)}</td>
                                    <td>${data.modalData.seg_des}</td>
                                    <td>${data.modalData.detail_des}</td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <button class="btn-info btn btn-sm edit" value="${data.modalData.id}"><span class="fa fa-edit"></span> Edit</button>
                                            <input type="hidden" value="${data.modalData.hiddenId}">
                                        </div>
                                    </td>
                                </tr>
                            `;

                            $('#vdata'+data.modalData.id).replaceWith(voucher);
                        }
                    });
                }

                $('#tempVoucherSubjectModal').modal('hide');
            }
        });

        body.on('click', 'button.store', function() {
            let data = {
                vid: $('#vid').val(),               // 凭证类别ID
                period_id: $('#period_id').val(),   // 会计周期ID
                cdate: $('#cdate').val(),           // 凭证日期
                vuser: $('#vuser').val(),           // 制单人名称
                period: $('#period').val(),         // 会计周期
                vname: $('#vname').val(),           // 凭证名称
                cgroup: $('#cgroup').val(),         // 凭证批组
                vcategory: $('#vcategory').val(),   // 凭证类别
                vdescription: $('#vdescription').val(), // 凭证描述
                vdata: JSON.stringify(vdata.vdata),
                vtemp: JSON.stringify(vdata.temp),
                _token: '{{ csrf_token() }}'
            };

            console.log(data);

            $.ajax({
                type: 'POST',
                url: '/vdatastore',
                data: data,
                dataType: 'json',
                success: function (data) {
                    swal(data.msg, {icon: "success"});
                },
                error: function (data, json, errorThrown) {
                    console.log(data);
                    let errors = data.responseJSON.errors;
                    let errorsHtml= '';
                    $.each( errors, function( key, value ) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    toastr.error( errorsHtml , "Error " + data.status +': '+ errorThrown);
                }
            });
        });
    });

    // 将按钮的value转化成ID
    function transformButtonValue(temp)
    {
        let id;
        if (temp.search("_temp") !== -1 ) {
            id = parseInt(temp.substr(0, temp.search("_temp")));
        } else {
            id = parseInt(temp);
        }

        return id;
    }

    // 验证数据
    function validationModalData(data)
    {
        let { seg0, seg1, seg2, seg3, seg4, seg5, debit, credit, seg_des, detail_des } = data;
        let res = true;
        let message = [];

        if ( seg0 === '') {
            res = false;
            message.push('公司段 不能为空');
        }
        if ( seg1 === '') {
            res = false;
            message.push('责任中心段 不能为空');
        }
        if ( seg2 === '') {
            res = false;
            message.push('科目段 不能为空');
        }
        if ( seg3 === '') {
            res = false;
            message.push('子母段 不能为空');
        }
        if ( seg4 === '') {
            res = false;
            message.push('产品段 不能为空');
        }
        if ( seg5 === '') {
            res = false;
            message.push('参考段 不能为空');
        }

        if (!isNumber(debit)) {
            res = false;
            message.push('借方金额 格式不正确');
        } else {
            data.debit = parseFloat(debit);
        }

        if (!isNumber(credit)) {
            res = false;
            message.push('贷方金额 格式不正确');
        }else {
            data.credit = parseFloat(credit);
        }

        if ( seg_des === '') {
            res = false;
            message.push('会计科目描述 不能为空');
        }
        if ( detail_des === '') {
            res = false;
            message.push('凭证单项描述 不能为空');
        }

        return {
            validate: res,
            messages: message,
            modalData: data,
        };
    }

    //验证是否为数字
    function isNumber(value)
    {

        let patrn = /^\d+(\.\d+)?$/;

        return !(patrn.exec(value) == null || value === "");
    }
</script>
@endsection
