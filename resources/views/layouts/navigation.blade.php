<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
{{--                <div class="dropdown profile-element">--}}
{{--                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">--}}
{{--                        <span class="clear">--}}
{{--                            <span class="block m-t-xs text-center">--}}
{{--                                <strong class="font-bold">{{ Auth::user()->profile->userName }}</strong>--}}
{{--                            </span>--}}
{{--                            <span class="text-muted m-t-xs text-center block">--}}
{{--                                {{ Auth::user()->profile->department->name }}--}}
{{--                            </span>--}}
{{--                        </span>--}}
{{--                    </a>--}}
{{--                </div>--}}
                <div class="logo-element"> 薪酬核算</div>
            </li>

            {{--SideBar--}}
            <li class="{{ Request::is('/') ? 'active' : '' }}">
                <a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> <span class="nav-label">仪表盘 </span></a>
            </li>
            <li class="{{ Request::is('salary*') ? 'active' : '' }}">
                <a href="{{ route('salary.index') }}"><i class="fa fa-address-book"></i> <span class="nav-label">个人薪酬信息 </span></a>
            </li>

            @hasanyrole('administrator|financial_manager')
            <li class="nav nav-link">业务办理 </li>
            <li class="{{ Request::is('uploadData*') ? 'active' : '' }}">
                <a href="{{ route('upload.index') }}"><i class="fa fa-gears"></i> <span class="nav-label">上传数据 </span></a>
            </li>
            <li class="{{ Request::is('workflow*') ? 'active' : '' }}">
                <a href="{{ route('workflow.index') }}"><i class="fa fa-rebel"></i> <span class="nav-label">数据审核 </span></a>
            </li>
            <li class="{{ Request::is('special*') ? 'active' : '' }}">
                <a href="{{ route('special.index') }}"><i class="fa fa-plug"></i> <span class="nav-label">专项数据 </span></a>
            </li>
            <li class="{{ Request::is('calculation*') ? 'active' : '' }}">
                <a href="{{ route('salary.calculate') }}"><i class="fa fa-calculator"></i> <span class="nav-label">计算数据 </span></a>
            </li>
            <li class="{{ Request::is('vsheet*') ? 'active' : '' }}">
                <a href="{{ route('vsheet.index') }}"><i class="fa fa-table"></i> <span class="nav-label">凭证基础表 </span></a>
            </li>
            <li class="{{ Request::is('vdata*') ? 'active' : '' }}">
                <a href="{{ route('vdata.index') }}"><i class="fa fa-retweet"></i> <span class="nav-label">生成凭证 </span></a>
            </li>
            <li class="{{ Request::is('vsynclists*') ? 'active' : '' }}">
                <a href="{{ route('vsync.list') }}"><i class="fa fa-etsy"></i><span class="nav-label"> 上传ERP </span> </a>
            </li>
            @endhasanyrole

            <li class="nav nav-link">自助服务 </li>
            <li class="{{ Request::is('search*') ? 'active' : '' }}">
                <a href="{{ route('salary.search') }}"><i class="fa fa-search"></i> <span class="nav-label">薪酬查询 </span></a>
            </li>
            <li class="{{ Request::is('personprint*') ? 'active' : '' }}">
                <a href="{{ route('person.print') }}"><i class="fa fa-trophy"></i> <span class="nav-label">个人薪酬打印 </span> </a>
            </li>
            @hasanyrole('administrator|financial_manager')
            <li class="{{ Request::is('departmentprint*') ? 'active' : '' }}">
                <a href="{{ route('department.print') }}"><i class="fa fa-print"></i> <span class="nav-label">部门薪酬打印 </span> </a>
            </li>
            <li class="{{ Request::is('mymsg*') ? 'active' : '' }}">
                <a href="{{ route('mymsg.index') }}"><i class="fa fa-envelope"></i> <span class="nav-label">我的消息 </span> </a>
            </li>

            <li class="nav nav-link">系统设置 </li>
            <li class="{{ Request::is('messages*') ? 'active' : '' }}">
                <a href="{{ route('messages.send') }}"><i class="fa fa-envelope"></i> <span class="nav-label">消息发送 </span> </a>
            </li>
            <li class="{{ Request::is('users*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}"><i class="fa fa-users"></i> <span class="nav-label">人员管理 </span></a>
            </li>
            <li class="{{ Request::is('role*') ? 'active' : '' }}">
                <a href="{{ route('role.index') }}"><i class="fa fa-cloud"></i> <span class="nav-label">角色管理 </span></a>
            </li>
            <li class="{{ Request::is('permission*') ? 'active' : '' }}">
                <a href="{{ route('permission.index') }}"><i class="fa fa-cube"></i> <span class="nav-label">权限管理 </span></a>
            </li>
            <li class="{{ Request::is('department*') ? 'active' : '' }}">
                <a href="{{ route('department.index') }}"><i class="fa fa-sitemap"></i> <span class="nav-label">部门管理 </span></a>
            </li>
            <li class="{{ Request::is('systemconfig*') ? 'active' : '' }}">
                <a href="{{ route('systemconfig.index') }}"><i class="fa fa-cogs"></i> <span class="nav-label">基础数据管理</span></a>
            </li>
            <li class="{{ Request::is('importconfig*') ? 'active' : '' }}">
                <a href="{{ route('importconfig.index') }}"><i class="fa fa-codepen"></i> <span class="nav-label">导入管理</span></a>
            </li>
            @endhasanyrole

            <li class="nav nav-link">其他工具</li>
            <li class="{{ Request::is('tax') ? 'active' : '' }}">
                <a href="{{ route('tax') }}"><i class="fa fa-calculator"></i> <span class="nav-label">个税计算器 </span> </a>
            </li>
            <li class="{{ Request::is('report') ? 'active' : '' }}">
                <a href="{{ route('report') }}"><i class="fa fa-bug"></i> <span class="nav-label">系统BUG报告 </span> </a>
            </li>
            <li class="{{ Request::is('contact') ? 'active' : '' }}">
                <a href="{{ route('contact') }}"><i class="fa fa-qq"></i> <span class="nav-label">联系我们 </span> </a>
            </li>
        </ul>
    </div>
</nav>
