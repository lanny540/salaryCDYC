<!DOCTYPE html>
<html lang="cn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta name="description" content="CDYC">
    <meta name="author" content="李凌">
    <title> {{ env('APP_NAME') }} </title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/print.css') }}" media="print">
</head>

<body class="white-bg">
<div class="wrapper wrapper-content p-xl">
    <div class="ibox-content">

        <table class="table table-bordered invoice-table table-responsive row mx-0">
            <tbody class="w-100">
            @for($i = 1; $i <= $counts; $i++)
                <tr class="row mx-0">
                    <td class="col-2 text-center"><strong>发放日期</strong></td>
                    <td class="col-3 text-center"><strong>保险编号</strong></td>
                    <td class="col-3 text-center"><strong>姓名</strong></td>
                    <td class="col-4 text-center"><strong>实发工资</strong></td>
                </tr>
                <tr class="row mx-0">
                    <td class="col-2 text-center">2018-01</td>
                    <td class="col-3 text-center">{{ 5400001 + $i }}</td>
                    <td class="col-3 text-center">李四</td>
                    <td class="col-4 text-center">6666.66</td>
                </tr>
                <tr class="row mx-0">
                    <td class="col-1 text-center"><strong>岗位工资</strong></td>
                    <td class="col-1 text-center"><strong>中夜班费加班工资</strong></td>
                    <td class="col-1 text-center"><strong>年功工资</strong></td>
                    <td class="col-1 text-center"><strong>交通费补贴</strong></td>
                    <td class="col-1 text-center"><strong>通讯费补贴</strong></td>
                    <td class="col-1 text-center"><strong>住房补贴</strong></td>
                    <td class="col-1 text-center"><strong>独子费</strong></td>
                    <td class="col-1 text-center"><strong>补发</strong></td>
                    <td class="col-4 text-center"><strong>应发小计</strong></td>
                </tr>
                <tr class="row mx-0">
                    <td class="col-1 text-center">5555.00</td>
                    <td class="col-1 text-center">0</td>
                    <td class="col-1 text-center">345.00</td>
                    <td class="col-1 text-center">380.00</td>
                    <td class="col-1 text-center">100.00</td>
                    <td class="col-1 text-center">800.00</td>
                    <td class="col-1 text-center">0</td>
                    <td class="col-1 text-center">0</td>
                    <td class="col-4 text-center">6666.00</td>
                </tr>
                <tr class="row mx-0">
                    <td class="col-1 text-center"><strong>扣病事婴假</strong></td>
                    <td class="col-1 text-center"><strong>扣养老保险</strong></td>
                    <td class="col-1 text-center"><strong>扣医疗保险</strong></td>
                    <td class="col-1 text-center"><strong>扣失业保险</strong></td>
                    <td class="col-1 text-center"><strong>扣住房公积金</strong></td>
                    <td class="col-1 text-center"><strong>扣企业年金</strong></td>
                    <td class="col-1 text-center"><strong>扣水电气扣物管费</strong></td>
                    <td class="col-1 text-center"><strong>扣欠款及工会会费</strong></td>
                    <td class="col-2 text-center"><strong>扣个人所得税</strong></td>
                    <td class="col-2 text-center"><strong>扣款小计</strong></td>
                </tr>
                <tr class="row mx-0">
                    <td class="col-1 text-center"></td>
                    <td class="col-1 text-center">1068.24</td>
                    <td class="col-1 text-center">250.66</td>
                    <td class="col-1 text-center">99.88</td>
                    <td class="col-1 text-center">1888.00</td>
                    <td class="col-1 text-center">432.11</td>
                    <td class="col-1 text-center">36.88</td>
                    <td class="col-1 text-center"></td>
                    <td class="col-2 text-center">25.00</td>
                    <td class="col-2 text-center">2981.67</td>
                </tr>
                <tr style="height: 10px;">
                </tr>
                @if($i % 5 == 0)
                    <tr>
                        <td><p></p></td>
                    </tr>
                @endif
            @endfor
            </tbody>
        </table>

    </div>
</div>
</body>

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<script type="text/javascript">
    window.print();
</script>
