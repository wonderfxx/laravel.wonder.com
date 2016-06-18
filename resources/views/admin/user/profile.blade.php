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

        .removeMargin {
            margin: 0
        }

        .form-horizontal .control-label {
            min-height: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-bookmark" style="color: #1ab394"></i> 个人资料 </h5>
                    </div>
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a data-toggle="tab" href="#tab-1" aria-expanded="false"><i class="fa fa-bars"></i>基础设置</a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#tab-2" aria-expanded="true"><i class="fa fa-lock"></i>重置密码</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        {!! Form::open([
                                            'id'        =>'profile',
                                            'class'     =>'form-horizontal m-t',
                                        ]) !!}
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">用户邮箱：</label>
                                            <div class="col-sm-4">
                                                <p class="form-control-static">
                                                    <b>{!! Auth::guard('admin')->user()->email !!}</b></p>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">用户昵称：</label>
                                            <div class="col-sm-4">
                                                <p class="form-control-static">
                                                    <b>{!! Auth::guard('admin')->user()->username !!}</b></p>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">注册时间：</label>
                                            <div class="col-sm-4">
                                                <p class="form-control-static"><b>
                                                        {!! date('Y-m-d H:i:s',Auth::guard('admin')->user()->created_at) !!}
                                                    </b></p>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">最近登陆：</label>
                                            <div class="col-sm-4">
                                                <p class="form-control-static"><b>
                                                        {!! date('Y-m-d H:i:s',Auth::guard('admin')->user()->updated_at) !!}
                                                    </b></p>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">最近登陆IP：</label>
                                            <div class="col-sm-4">
                                                <p class="form-control-static"><b>
                                                        {!! Auth::guard('admin')->user()->login_ip !!}
                                                    </b></p>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">用户状态：</label>
                                            <div class="col-sm-4">
                                                <p class="form-control-static"><b>
                                                        @if(Auth::guard('admin')->user()->status == 'Y')
                                                            <span class="label label-primary">审核通过</span>
                                                        @endif
                                                    </b></p>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                <div id="tab-2" class="tab-pane ">
                                    <div class="panel-body">
                                        {!! Form::open([
                                            'id'        =>'resetPwd',
                                            'class'     =>'wizard-big form-horizontal',
                                            'url'       =>url('adm/user')
                                        ]) !!}
                                        <h3>安全验证</h3>
                                        <fieldset>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">账户名称：</label>
                                                <div class="col-sm-6 fixed-height">
                                                    <p class="form-control-static">
                                                        <b>{!! Auth::guard('admin')->user()->email !!}</b></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">当前密码：</label>
                                                <div class="col-sm-6 fixed-height">
                                                    {!! Form::password(
                                                        'old_password',
                                                        ['class'        =>'form-control',
                                                        'required'      => '',
                                                        'id'            => 'old_password',
                                                        'placeholder'   =>'请输入您的当前密码']
                                                    ) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label"></label>
                                                <div class="col-sm-6 error-display"></div>
                                            </div>
                                        </fieldset>
                                        <div class="hr-line-dashed removeMargin"></div>
                                        <h3>设置密码</h3>
                                        <fieldset>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">重置密码：</label>
                                                <div class="col-sm-6 fixed-height">
                                                    {!! Form::password(
                                                        'new_password',
                                                        ['class'        =>'form-control',
                                                        'required'      => '',
                                                        'id'            => 'new_password',
                                                        'placeholder'   =>'请再次输入您的新密码']
                                                    ) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label"></label>
                                                <div class="col-sm-6 error-display"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">确认密码：</label>
                                                <div class="col-sm-6 fixed-height">
                                                    {!! Form::password(
                                                        'confirm_password',
                                                        ['class'        =>'form-control',
                                                        'required'      => '',
                                                        'id'            => 'confirm_password',
                                                        'placeholder'   =>'请输入您的帐号密码']
                                                    ) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label"></label>
                                                <div class="col-sm-6 error-display"></div>
                                            </div>
                                        </fieldset>
                                        <div class="hr-line-dashed removeMargin"></div>
                                        <div class="form-group" style="margin: 15px;">
                                            <label class="col-sm-2 control-label"> </label>
                                            <div class="col-sm-6 fixed-height">
                                                {!! Form::submit(
                                                    '重置密码',
                                                    ['class'=>'btn btn-success block ',]
                                                ) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="/assets/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="/assets/js/plugins/validate/messages_zh.min.js"></script>
    <script>
        $(document).ready(function () {
            /*step-2 reset password*/
            var form = $('#resetPwd'), e = "<i class='fa fa-times-circle'></i> ";
            $.validator.setDefaults({
                highlight: function (e) {
                    $(e).parent().removeClass("has-success").addClass("has-error")
                },
                success: function (e) {
                    $("#login-form").removeAttr("class").attr("class", "");
                    e.parent().prev().removeClass("has-error").addClass("has-success");
                    e.closest(".input-group").removeClass("has-error").addClass("has-success")
                },
                errorElement: "div",
                errorPlacement: function (error, element) {
                    element.parent().parent().next().find('.error-display').html(error);
                },
                errorClass: "error-color",
                validClass: "valid-color"
            });
            form.validate({
                onsubmit: true,
                rules: {
                    old_password: {required: !0, minlength: 6},
                    new_password: {required: !0, minlength: 6},
                    confirm_password: {required: !0, minlength: 6, equalTo: "#new_password"}
                },
                messages: {
                    old_password: {required: e + "请输入您的当前密码", minlength: e + "密码必须6个字符以上"},
                    new_password: {required: e + "请输入您的新密码", minlength: e + "密码必须6个字符以上"},
                    confirm_password: {
                        required: e + "请再次输入您的新密码",
                        minlength: e + "密码必须6个字符以上",
                        equalTo: e + "两次输入的密码不一致"
                    }
                },
                submitHandler: function () {
                    $.ajax({
                        url: "{{url('adm/password/resetUser')}}",
                        type: "post",
                        dataType: "json",
                        data: form.serialize(),
                        success: function () {
                            if (confirm('恭喜!重置密码成功,是否需要重新登陆?')) {
                                top.location.href = "{{url('adm/logout')}}";
                            }
                        },
                        error: function (data) { // the data parameter here is a jqXHR instance
                            var errors = data.responseJSON;
                            switch (data.status) {
                                case 422:
                                    if (errors.old_password) {
                                        $('#old_password').parent().removeClass('has-success').addClass('has-error');
                                        $('#old_password-error').html(e + errors.old_password);
                                    } else if (errors.new_password) {
                                        $('#new_password').parent().removeClass('has-success').addClass('has-error');
                                        $('#new_password-error').html(e + errors.new_password);
                                    } else {
                                        toastr.error(errors.error);
                                    }
                                    break;
                                case 302:
                                case 200:
                                    if (confirm('恭喜!重置密码成功,是否需要重新登陆?')) {
                                        top.location.href = "{{url('adm/logout')}}";
                                    }
                                    break;
                                default:
                                    alert('验证超时,请重试!');
                            }
                        }
                    });
                },
                invalidHandler: function (form, validator) {
                    return false;
                }
            });
        });
    </script>
@endsection