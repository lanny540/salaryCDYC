@extends('layouts.app')

@section('title', '个人薪酬明细')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox product-detail">
                    <div class="ibox-title">
                        <h2 class="font-bold m-b-xs">
                            {{ $published }} 薪酬明细
                        </h2>
                        <div class="ibox-tools">
                            <label>
                                <select name="periodId" class="form-control">
                                    @foreach($periods as $p)
                                        <option value="{{ $p->id }}"> {{ $p->published_at }} </option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-5">
                                <div>
                                    <a href="{{ route('sheet.index') }}" class="btn btn-lg btn-primary float-right">打印工资条</a>
                                    <h1 class="product-main-price">$406,602</h1>
                                </div>
                                <hr>
                                <h4>月度明细</h4>
                                <dl class="row m-t-md small">
                                    <dt class="col-md-4 text-right">工资明细</dt>
                                    <dd class="col-md-8">
                                        AAAA工资： 3000.00<br/>
                                        BBBB工资： 500.00<br/>
                                        CCCC工资： 600.00<br/>
                                    </dd>

                                    <dt class="col-md-4 text-right">奖金明细</dt>
                                    <dd class="col-md-8">
                                        AAAA奖金： 2000.00<br/>
                                        BBBB奖金： 300.00<br/>
                                        CCCC奖金： 400.00<br/>
                                        DDDD奖金： 400.00<br/>
                                        EEEE奖金： 400.00<br/>
                                        FFFF奖金： 400.00<br/>
                                    </dd>

                                    <dt class="col-md-4 text-right">扣除明细</dt>
                                    <dd class="col-md-8">
                                        AAAA扣除： 2000.00<br/>
                                        BBBB扣除： 300.00<br/>
                                        CCCC扣除： 400.00<br/>
                                    </dd>
                                </dl>
                            </div>
                            <div class="col-md-7">
                                <h3>双环形图</h3>
                                <div id="salaryDetail" style="height: 500px"></div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-sm-4 offset-5">
                                <button class="btn btn-info"><i class="fa fa-cart-plus"></i> 关闭该窗口</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<!-- ECharts -->
<script src="{{ asset('js/plugins/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('js/plugins/echarts/echarts.demo.js') }}"></script>
@stop
