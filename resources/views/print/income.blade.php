@extends('layouts.app')

@section('title', '年收入打印')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-sm-6">
                        <p>
                            <span><strong>计算日期起:</strong> Marh 18, 2018</span><br/>
                            <span><strong>计算日期止:</strong> March 24, 2018</span>
                        </p>
                    </div>

                    <div class="col-sm-6 text-right">
                        <address>
                            <strong>{{ Auth::user()->profile->userName }}</strong><br>
                        </address>
                        <h4>保险编号</h4>
                        <h4 class="text-navy">{{ Auth::user()->profile->policyNumber }}</h4>
                    </div>
                </div>

                <div class="table-responsive m-t">
                    <table class="table invoice-table">
                        <thead>
                        <tr>
                            <th>日期</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>个税</th>
                            <th>实发工资</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><div><strong>2018-12</strong></div>
                            </td>
                            <td>1</td>
                            <td>$26.00</td>
                            <td>$5.98</td>
                            <td>$31,98</td>
                        </tr>
                        <tr>
                            <td><div><strong>2018-11</strong></div>
                            <td>2</td>
                            <td>$80.00</td>
                            <td>$36.80</td>
                            <td>$196.80</td>
                        </tr>
                        <tr>
                            <td><div><strong>2018-10</strong></div>
                            <td>3</td>
                            <td>$420.00</td>
                            <td>$193.20</td>
                            <td>$1033.20</td>
                        </tr>
                        <tr>
                            <td><div><strong>2018-09</strong></div>
                            <td>3</td>
                            <td>$420.00</td>
                            <td>$193.20</td>
                            <td>$1033.20</td>
                        </tr>
                        <tr>
                            <td><div><strong>2018-08</strong></div>
                            <td>3</td>
                            <td>$420.00</td>
                            <td>$193.20</td>
                            <td>$1033.20</td>
                        </tr>
                        <tr>
                            <td><div><strong>2018-07</strong></div>
                            <td>3</td>
                            <td>$420.00</td>
                            <td>$193.20</td>
                            <td>$1033.20</td>
                        </tr>
                        <tr>
                            <td><div><strong>2018-06</strong></div>
                            <td>3</td>
                            <td>$420.00</td>
                            <td>$193.20</td>
                            <td>$1033.20</td>
                        </tr>
                        <tr>
                            <td><div><strong>2018-05</strong></div>
                            <td>3</td>
                            <td>$420.00</td>
                            <td>$193.20</td>
                            <td>$1033.20</td>
                        </tr>
                        <tr>
                            <td><div><strong>2018-04</strong></div>
                            <td>3</td>
                            <td>$420.00</td>
                            <td>$193.20</td>
                            <td>$1033.20</td>
                        </tr>
                        <tr>
                            <td><div><strong>2018-03</strong></div>
                            <td>3</td>
                            <td>$420.00</td>
                            <td>$193.20</td>
                            <td>$1033.20</td>
                        </tr>
                        <tr>
                            <td><div><strong>2018-02</strong></div>
                            <td>3</td>
                            <td>$420.00</td>
                            <td>$193.20</td>
                            <td>$1033.20</td>
                        </tr>
                        <tr>
                            <td><div><strong>2018-01</strong></div>
                            <td>3</td>
                            <td>$420.00</td>
                            <td>$193.20</td>
                            <td>$1033.20</td>
                        </tr>
                        </tbody>
                    </table>
                </div><!-- /table-responsive -->

                <table class="table invoice-total">
                    <tbody>
                    <tr>
                        <td><strong>年度个税缴纳 :</strong></td>
                        <td>$235.98</td>
                    </tr>
                    <tr>
                        <td><strong>年度总收入 :</strong></td>
                        <td>$1261.98</td>
                    </tr>
                    </tbody>
                </table>

                <div class="text-right">
                    <a href="#" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> 打印收入单 </a>
                </div>

                <div class="well m-t"><strong>说明：</strong>
                    收入清单属于个人隐私，请妥善保管！！ 如果数据有任何疑问，请通过系统相关功能查询或者点击 <a href="{{ route('contact') }}">联系我们</a>  页面 联系财务部。
                </div>
            </div>
        </div>
    </div>
</div>
@stop
