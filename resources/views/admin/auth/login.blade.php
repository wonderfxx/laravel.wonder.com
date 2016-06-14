@extends('admin.common.frame')
@section('lang','zh-CN')
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
    </style>
@endsection
@section('content')
    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div id="login-form" data-animation="shake">
            <div>
                <h1 class="logo-name">
                    <img class="img-circle circle-border" src="/assets/img/logo.png" alt="image">
                </h1>
            </div>
            {!! Form::open([
                'id'        =>'loginForm',
                'novalidate'=>'novalidate',
                'class'     =>'m-t',
                'url'       =>url('adm/login')
            ]) !!}
            <div class="form-group">
                <div class="input-group bt-style">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    {!! Form::text(
                        'email',
                        null,
                        ['class'        =>'form-control animation_select',
                        'required'      => '',
                        'id'            => 'email',
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
                {!! Form::submit(
                    '登 录',
                    ['class'=>'btn btn-success block full-width m-b',]
                ) !!}
                <p class="text-muted text-center">
                    <a href="{!! url('/adm/register') !!}">
                        <small>创建一个新账户？</small>
                        <i class="fa fa-user-plus"></i>
                    </a>
                </p>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div id="error">

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
                $("#login-form").removeAttr("class").attr("class", "");
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
        $(document).ready(function () {
            var e = "<i class='fa fa-times-circle'></i> ";
            $("#loginForm").validate({
                onsubmit: true,
                rules: {
                    email: {required: !0, email: !0},
                    password: {required: !0, minlength: 5}
                },
                messages: {
                    email: {required: e + "邮箱地址不能为空", email: e + "请输入有效的邮箱地址"},
                    password: {required: e + "账户密码不能为空", minlength: e + "账户密码必须5个字符以上"}
                },
                submitHandler: function (form) {  //通过之后回调
                    var param = $("#loginForm").serialize();
                    $.ajax({
                        url: "{{url('adm/login')}}",
                        type: "post",
                        dataType: "json",
                        data: param,
                        success:function (data) {
                            location.href = '{!! url('adm/') !!}';
                        },
                        error: function (data) { // the data parameter here is a jqXHR instance
                            var errors = data.responseJSON;
                            console.log(data);
                            switch (data.status) {
                                case 422:
                                    shakeForm();
                                    if (errors.email) {
                                        $('#email').parent().removeClass('has-success').addClass('has-error');
                                        $('#email-error').html(e + errors.email);
                                    } else if (errors.password) {
                                        $('#password').parent().removeClass('has-success').addClass('has-error');
                                        $('#password-error').html(e + errors.password);
                                    } else {
                                        alert(errors.error);
                                    }
                                    break;
                                case 302:
                                    location.href = '{!! url('adm/verify') !!}';
                                    break;
                                case 200:
                                    //location.href = '{!! url('adm/') !!}';
                                    break;
                                default:
                                    alert('登陆超时,请重试。');
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
                var obj = $("#login-form");
                obj.removeAttr("class").attr('class', '');
                obj.addClass("animated");
                obj.addClass(obj.attr("data-animation"));
            }
        });
    </script>
@endsection