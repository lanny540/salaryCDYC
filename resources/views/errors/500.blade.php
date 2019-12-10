@extends('layouts.app')

@section('content')
    <div class="middle-box text-center animated fadeInDown">
        <h1>500</h1>
        <h3 class="font-bold">内部服务错误</h3>

        <div class="error-desc">
            The server encountered something unexpected that didn't allow it to complete the request. We apologize.<br/>
            You can go back to main page: <br/><a href="{{ route('home') }}" class="btn btn-primary m-t"> 首页 </a>
        </div>
    </div>
@endsection
