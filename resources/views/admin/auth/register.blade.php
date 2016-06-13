@extends('admin.common.frame')
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
    </style>
@endsection
@section('lang','zh-CN')
@section('content')
    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div id="signup-form" data-animation="shake">
            <div>
                <h1 class="logo-name">
                    <img class="img-circle circle-border" src="/assets/img/logo.png" alt="image">
                </h1>
            </div>
            {!! Form::open([
                    'id'        =>'signupForm',
                    'novalidate'=>'novalidate',
                    'class'     =>'m-t',
                    'url'       =>url('adm/register')
                ]) !!}
            <div class="form-group">
                <div class="input-group bt-style">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    {!! Form::text(
                        'username',
                        null,
                        ['class'        =>'form-control',
                        'required'      => '',
                        'placeholder'   =>'请输入您的昵称']
                    ) !!}
                </div>
                <div class="input-group error-display"></div>
                <div class="input-group bt-style">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    {!! Form::text(
                        'email',
                        null,
                        ['class'        =>'form-control',
                        'required'      => '',
                        'placeholder'   =>'请输入您的邮箱地址']
                    ) !!}
                </div>
                <div class="input-group error-display"></div>
                <div class="input-group bt-style">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    {!! Form::password(
                        'password',
                        ['class'        =>'form-control',
                        'required'      => '',
                        'id'            => 'password',
                        'placeholder'   =>'请输入您的帐号密码']
                    ) !!}
                </div>
                <div class="input-group error-display"></div>
                <div class="input-group bt-style">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    {!! Form::password(
                        'password_confirmation',
                        ['class'        =>'form-control',
                        'required'      => '',
                        'placeholder'   =>'请再次输入您的帐号密码']
                    ) !!}
                </div>


                <div class="input-group error-display"></div>
                {!! Form::submit(
                    '注 册',
                    ['class'=>'btn btn-success block full-width m-b',]
                ) !!}
                <p class="text-muted text-center">
                    <a href="{!! url('/adm/login') !!}">
                        <small>已经有账户了？</small>
                        <i class="fa fa-user"></i></a>
                </p>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('footer')
    <script src="/assets/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="/assets/js/plugins/validate/messages_zh.min.js"></script>
    <script>
        $.validator.setDefaults({
            highlight: function (e) {
                $(e).closest(".input-group").removeClass("has-success").addClass("has-error")
            },
            success: function (e) {
                $("#signup-form").removeAttr("class").attr("class", "");
                e.parent().prev().removeClass("has-error").addClass("has-success");
                e.closest(".input-group").removeClass("has-error").addClass("has-success")
            },
            errorElement: "div",
            errorPlacement: function (error, element) {
                error.appendTo(element.parent().next())
            },
            errorClass: "error-color",
            validClass: "valid-color"
        });
        $().ready(function () {
            var e = "<i class='fa fa-times-circle'></i> ";
            $("#signupForm").validate({
                onsubmit: true,
                rules: {
                    username: {required: !0, minlength: 6},
                    email: {required: !0, email: !0},
                    password: {required: !0, minlength: 6},
                    password_confirmation: {required: !0, minlength: 6, equalTo: "#password"}
                },
                messages: {
                    username: {required: e + "用户昵称不能为空"},
                    email: {required: e + "邮箱地址不能为空", email: e + "请输入有效的邮箱地址"},
                    password: {required: e + "账户密码不能为空", minlength: e + "账户密码必须6个字符以上"},
                    password_confirmation: {
                        required: e + "请再次输入账户密码",
                        minlength: e + "账户密码必须6个字符以上",
                        equalTo: e + "两次输入的账户密码不一致"
                    }
                },
                submitHandler: function (form) {  //通过之后回调
                    var param = $("#signupForm").serialize();
                    $.ajax({
                        url: "{{url('adm/register')}}",
                        type: "post",
                        dataType: "json",
                        data: param,
                        error: function (data) { // the data parameter here is a jqXHR instance
                            var errors = data.responseJSON;
                            switch (data.status) {
                                case 200:
                                    top.location.href = "{{url('adm/home')}}";
                                    break;
                                case 422:
                                    shakeForm();
                                    if (errors.username) {
                                        $('#username-error').html(e + errors.username);
                                    } else if (errors.email) {
                                        $('#email-error').html(e + errors.email);
                                    } else if (errors.password) {
                                        $('#password_confirmation-error').html(e + errors.password);
                                    } else {
                                        alert('验证失败请重试。');
                                    }
                                    break;
                                default:
                                        console.log(data);
                                    alert('注册失败请重试。');
                            }
                        }
                    });
                },
                invalidHandler: function (form, validator) {  //不通过回调
                    shakeForm();
                    return false;
                }
            });

            function shakeForm() {
                var obj = $("#signup-form");
                obj.removeAttr("class").attr("class", "");
                obj.addClass("animated");
                obj.addClass(obj.attr("data-animation"));
            }
        });
    </script>
@endsection