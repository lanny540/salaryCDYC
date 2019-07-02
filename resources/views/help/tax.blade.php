@extends('layouts.app')

@section('css')
<!-- Toastr style -->
<link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
@stop

@section('title', '个税计算器')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox" id="taxForm">
                <div class="ibox-content">
                    <div class="sk-spinner sk-spinner-double-bounce">
                        <div class="sk-double-bounce1"></div>
                        <div class="sk-double-bounce2"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7 b-r">
                            <div class="form-group row">
                                <div class="col-sm-8">
                                    <input type="text" name="money" id="money" class="form-control input-lg" style="font-size: 20px" placeholder="请输入需要计算的金额">
                                </div>
                                <button id="taxCal" class="btn btn-primary col-sm-3" style="font-size: 22px">计算</button>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <h2 class="text-center" id="tax"> 应缴纳个税: ￥ 0.00</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr/>
    <div class="ibox-content m-b-sm">
        <div class="text-center">
            <h2>如果您对个税计算有任何疑问，请咨询 <strong>计划财务部</strong> ！</h2>
        </div>
    </div>
    {{--TODO: FAQ列表--}}
    <div class="faq-item">
        <div class="row">
            <div class="col-md-12">
                <a data-toggle="collapse" href="#faq1" class="faq-question">2019年个人所得税是如何计算的 ?</a>
                <small>Added by <strong>Alex Smith</strong> <i class="fa fa-clock-o"></i> Today 2:40 pm - 24.06.2014</small>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="faq1" class="panel-collapse collapse ">
                    <div class="faq-answer">
                        <p>
                            It is a long established fact that a reader will be distracted by the
                            readable content of a page when looking at its layout. The point of
                            using Lorem Ipsum is that it has a more-or-less normal distribution of
                            letters, as opposed to using 'Content here, content here', making it
                            look like readable English.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="faq-item">
        <div class="row">
            <div class="col-md-12">
                <a data-toggle="collapse" href="#faq2" class="faq-question">Many desktop publishing packages ?</a>
                <small>Added by <strong>Mark Nowak</strong> <i class="fa fa-clock-o"></i> Today 3:30 pm - 11.06.2014</small>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="faq2" class="panel-collapse collapse">
                    <div class="faq-answer">
                        <p>
                            Many desktop publishing packages and web page editors now use Lorem
                            Ipsum as their default model text, and a search for 'lorem ipsum' will
                            uncover many web sites still in their infancy. Various versions have
                            evolved over the years, sometimes by accident, sometimes on purpose
                            (injected humour and the like).
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="faq-item">
        <div class="row">
            <div class="col-md-12">
                <a data-toggle="collapse" href="#faq4" class="faq-question">What Finibus Bonorum et Malorum mean ?</a>
                <small>Added by <strong>Janet North</strong> <i class="fa fa-clock-o"></i> Today 2:43 pm - 22.06.2014</small>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="faq4" class="panel-collapse collapse">
                    <div class="faq-answer">
                        <p>
                            Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus
                            Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written
                            in 45 BC. This book is a treatise on the theory of ethics, very popular
                            during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum
                            dolor sit amet..", comes from a line in section 1.10.32.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="faq-item">
        <div class="row">
            <div class="col-md-12">
                <a data-toggle="collapse" href="#faq5" class="faq-question">The standard chunk of Lorem Ipsum used since ?</a>
                <small>Added by <strong>Robert Task</strong> <i class="fa fa-clock-o"></i> Today 1:23 pm - 12.06.2014</small>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="faq5" class="panel-collapse collapse">
                    <div class="faq-answer">
                        <p>
                            The standard chunk of Lorem Ipsum used since the 1500s is reproduced
                            below for those interested. Sections 1.10.32 and 1.10.33 from "de
                            Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact
                            original form, accompanied by English versions from the 1914 translation
                            by H. Rackham.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<!-- Toastr -->
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>

<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

    $('#taxCal').click(function () {
        var salary = $('#money').val();
        if (salary > 0) {
            $('#taxForm').children('.ibox-content').toggleClass('sk-loading');
            $.ajax({
                type: "POST",
                url: "/tax",
                data: {
                    money: salary
                },
                success: function (data) {
                    $('#tax').html('应缴纳个税: ￥ ' + data);
                    $('#taxForm').children('.ibox-content').toggleClass('sk-loading');
                }
            });
        } else {
            toastr.options = {
                progressBar: true,
                positionClass: 'toast-top-center',
                showMethod: 'slideDown',
                timeOut: 3000
            };
            toastr.error('请输入大于0的金额！');
            $('#money').focus().val('');
        }

    });
</script>
@stop
