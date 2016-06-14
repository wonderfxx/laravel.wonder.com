@extends('admin.common.frame')
@section('body_style_class','gray-bg mini-navbar  pace-done')
@section('header')
<style type="text/css">
    .bt-style {
        margin-bottom: 5px;
    }
    .error-display {
        height: 20px;
        display: block
    }
    .error-display div {
        text-align: left
    }
    .error-color {
        color: red
    }
    .valid-color {
        color: #999
    }
    .loginscreen.middle-box{width: 250px;}
</style>
@endsection
@section('content')
<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div class="m-b-md">
            <h1 class="logo-name">
                <img class="img-circle circle-border" src="/assets/img/logo.png" alt="image">
            </h1>
        </div>
        <form class="m-t" role="form" method="post" novalidate="novalidate">
            <div class="form-group">
                <div class="input-group bt-style m-t m-b">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="text" name="email" id="email"
                           class="form-control" placeholder="请输入您的邮箱" >
                </div>
                <div class="input-group error-display"></div>
                <button type="submit" class="btn btn-success block full-width m-b">找回密码</button>
                <p class="text-muted text-center">
                    <a href="/adm/login"><small>已经有账户了？</small><i class="fa fa-user"></i></a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection