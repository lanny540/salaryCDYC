@extends('layouts.app')

@section('css')
<link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>我的消息</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>站内信</strong>
                </li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-4">
                <div class="ibox">
                    <div class="ibox-title"><h5>消息列表</h5></div>
                    <div class="ibox-content" style="padding: 10px 0 10px 0;">
                        <div class="panel-body">
                            <div class="panel-group" id="messagesList">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#messagesList" href="#sysMsgList">
                                                系统消息 <span class="label label-danger float-right">{{ $messages['sysMsg']->msgcount }} 条未读</span>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="sysMsgList" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <ul class="folder-list m-b-md" style="padding: 0">
                                                @foreach($msg as $m)
                                                    @if($m->type_id === 0)
                                                    <li id="msg{{ $m->id }}" value="{{ $m->id }}" class="msg" style="margin-bottom: 15px;">
                                                        <i class="fa fa-envelope-o"></i>
                                                        {{ Illuminate\Support\Str::limit($m->content, 20, '... ...') }}
                                                        @if($m->isread === 0)
                                                            <span class="fa fa-circle text-danger float-right"></span>
                                                        @endif
                                                        <span class="label label-info float-right" style="margin-right: 5px;">{{ $m->created_at->diffForHumans() }}</span>
                                                    </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#messagesList" href="#depMsgList">
                                                部门消息 <span class="label label-warning float-right">{{ $messages['depMsg']->msgcount }} 条未读</span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="depMsgList" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <ul class="folder-list m-b-md" style="padding: 0">
                                                @foreach($msg as $m)
                                                    @if($m->type_id === 1)
                                                        <li id="msg{{ $m->id }}" value="{{ $m->id }}" class="msg" style="margin-bottom: 15px;">
                                                            <i class="fa fa-file-text-o"></i>
                                                            {{ Illuminate\Support\Str::limit($m->content, 20, '... ...') }}
                                                            @if($m->isread === 0)
                                                                <span class="fa fa-circle text-danger float-right"></span>
                                                            @endif
                                                            <span class="label label-info float-right" style="margin-right: 5px;">{{ $m->created_at->diffForHumans() }}</span>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 animated fadeInRight" id="msgContent">

            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

        $('.msg').on('click', function(){
            let url = 'mymsg/' + $(this).val();
            let id = '#msg' + $(this).val() + ' span';
            $.get({
                url: url,
                success: function (data) {
                    // console.log(data);
                    let spans = $(id);
                    spans.removeClass('fa-circle').eq(0);
                    document.getElementById("msgContent").innerHTML = tranformHtml(data);
                }
            });
        });

        $('body').on('click', 'button.delete', function() {
            let id = $(this).val();
            $.ajax({
                type: 'DELETE',
                url: 'mymsg/' + id,
                success: function (data) {
                    if (data.code === 201) {
                        toastr.success(data.msg);
                    } else {
                        toastr.error(data.msg);
                    }
                    $('#msg' + id).remove();
                    document.getElementById("msgContent").innerHTML = '';
                }
            });
        });
    });

    function tranformHtml(data)
    {
        let html = `
            <div class="mail-box-header">
                <h2>消息内容</h2>
                    <div class="mail-tools tooltip-demo m-t-md">
                        <h4>
                            <span class="float-right font-normal">${data.created_at}</span>
                            <span class="font-normal">发送人: </span>${data.userName}
                        </h4>
                    </div>
                </div>
                <div class="mail-box">
                    <div class="mail-body">
                        <p>${data.content}</p>
                    </div>
        `;


        if (data.attachment && typeof(data.attachment) != "undefined" && data.attachment !== '') {
            let originFileName = data.attachment.substr(data.attachment.lastIndexOf('/')+1);

            html += `
                <div class="mail-attachment">
                    <p><span><i class="fa fa-paperclip"></i>附件:</span></p>
                    <div class="attachment">
                        <div class="file-box">
                            <div class="file">
                                <a href="#">
                                    <span class="corner"></span>
                                    <div class="icon"><i class="fa fa-file"></i></div>
                                    <div class="file-name">
                                            ${originFileName}
                                        <br/>
                                        <small>${data.updated_at}</small>
                                    </div>
                                </a>
                                </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            `;
        }

        html += `
            <div class="mail-body text-right tooltip-demo">
                <button class="btn btn-sm btn-white delete" value="${data.id}"><i class="fa fa-trash-o"></i> 删除</button>
            </div>
        </div>
        `;
        return html;
    }
</script>
@endsection
