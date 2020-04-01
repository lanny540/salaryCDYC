<div class="row border-bottom">
    <nav class="navbar navbar-static-top gray-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
        <ul class="nav navbar-top-links navbar-left">
            <li>
                <span class="m-r-sm text-muted welcome-message" style="font-size: medium"> {{ env('APP_NAME') }} </span>
            </li>
        </ul>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell"></i>  <span class="label label-primary">{{ $messages['count'] }}</span>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="#" class="dropdown-item">
                            <div>
                                <i class="fa fa-envelope fa-fw"></i> 有 {{ $messages['sysMsg']->msgcount }} 条未读系统消息
                                <span class="float-right text-muted small">
                                    @if($messages['sysMsg']->lastdate !== null)
                                    {{ \Carbon\Carbon::parse($messages['sysMsg']->lastdate)->diffForHumans() }}
                                    @endif
                                </span>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                        <a href="#" class="dropdown-item">
                            <div>
                                <i class="fa fa-twitter fa-fw"></i> 有 {{ $messages['depMsg']->msgcount }} 条未读部门消息
                                <span class="float-right text-muted small">
                                    @if($messages['depMsg']->lastdate !== null)
                                    {{ \Carbon\Carbon::parse($messages['depMsg']->lastdate)->diffForHumans() }}
                                    @endif
                                </span>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user"></i> {{ Auth::user()->profile->userName ?? '' }}
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/users/{{ Auth::id() }}/edit"><i class="fa fa-edit"></i> 个人资料</a></li>
                    <li class="dropdown-divider"></li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
                            <i class="fa fa-sign-out"></i> 用户注销
                        </a>
                        {{ Form::open(['id' => 'logout-form', 'style' => 'display: none;', 'method' => 'POST', 'route' => 'logout']) }}
                        {{ Form::close() }}
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
