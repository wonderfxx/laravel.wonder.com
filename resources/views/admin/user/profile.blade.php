@extends('admin.common.frame')
@section('header')
<link href="/assets/css/plugins/flags/flag-icon.min.css" rel="stylesheet">
<link href="/assets/css/plugins/steps/jquery.steps.css" rel="stylesheet">
<link href="/assets/css/plugins/cropper/cropper.min.css" rel="stylesheet">
<link href="/assets/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<style type="text/css">
    .wizard > .content > .body input {
        margin-top: 0
    }
    .wizard > .content > .body .has-error input {
        border-color: #ed5565;
    }
    .fixed-height {
        height: 58px;
    }
    .reset_alert{
        padding: 5px;margin-top: 5px;
    }
    .btn i.flag-icon{width:40px;height:30px;}
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
                            <li class="">
                                <a data-toggle="tab" href="#tab-5" aria-expanded="true"><i class="fa fa-user-secret"></i>安全设置</a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#tab-3" aria-expanded="true"><i class="fa fa-photo"></i>编辑头像</a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#tab-4" aria-expanded="true"><i class="fa fa-history"></i>登陆日志</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <form class="form-horizontal m-t" id="signupForm">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">账户名称：</label>

                                            <div class="col-sm-4">
                                                <p class="form-control-static"><b>email@example.com</b></p>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">账户昵称：</label>
                                            <div class="col-sm-4">
                                                <input id="nickname" name="nickname" style='margin-top:5px' class="form-control input-sm"
                                                       type="text"
                                                       aria-required="true" aria-invalid="true" value="email@example.com">
                                            </div>
                                            <div class="col-sm-4">
                          <span class="help-block m-b-none alert alert-info reset_alert">
                            <i class="fa fa-info-circle"></i> 后台显示名称，默认显示账户名称
                          </span>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">收起菜单：</label>
                                            <div class="col-sm-4">
                                                <div class="radio radio-info radio-inline">
                                                    <input type="radio" checked="checked" name="close-menu" value="N" id="close-menu-n">
                                                    <label for="close-menu-n"> 关闭 </label>
                                                </div>
                                                <div class="radio radio-info radio-inline">
                                                    <input type="radio" checked="" name="close-menu" value="Y" id="close-menu-y">
                                                    <label for="close-menu-y"> 开启 </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                          <span class="help-block m-b-none  alert alert-info reset_alert">
                            <i class="fa fa-info-circle"></i> 登陆后台后，是否默认收起左侧菜单
                          </span>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">固定宽度：</label>
                                            <div class="col-sm-4">
                                                <div class="radio radio-info radio-inline">
                                                    <input type="radio" checked="checked" name="fix-height" value="N" id="fix-height-n">
                                                    <label for="fix-height-n"> 关闭 </label>
                                                </div>
                                                <div class="radio radio-info radio-inline">
                                                    <input type="radio" checked="" name="fix-height" value="Y" id="fix-height-y">
                                                    <label for="fix-height-y"> 开启 </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                          <span class="help-block m-b-none alert alert-info reset_alert">
                            <i class="fa fa-info-circle"></i> 登陆后台后，是否默认固定页面宽度
                          </span>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">主题选择：</label>

                                            <div class="col-sm-4">
                                                <a class="btn btn-primary btn-circle btn-lg default-skin " href="javascript:"><i class="fa fa-check"></i></a>
                                                <a class="btn btn-primary btn-circle btn-lg blue-skin" href="javascript:" ></a>
                                                <a class="btn btn-primary btn-circle btn-lg yellow-skin " href="javascript:"></a>
                                            </div>
                                            <div class="col-sm-4">
                          <span class="help-block m-b-none alert alert-info reset_alert">
                            <i class="fa fa-info-circle"></i> 登陆后台后，设置页面使用的模版
                          </span>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">语言选择：</label>

                                            <div class="col-sm-4">
                                                <a class="btn btn-white btn-bitbucket">
                                                    <i class="flag flag-icon flag-icon-cn"></i>
                                                </a>
                                                <a class="btn btn-white btn-bitbucket">
                                                    <i class="flag flag-icon flag-icon-us"></i>
                                                </a>
                                            </div>
                                            <div class="col-sm-4">
                          <span class="help-block m-b-none alert alert-info reset_alert">
                            <i class="fa fa-info-circle"></i> 登陆后台后，页面语言切换
                          </span>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <div class="col-sm-2 col-sm-offset-2">
                                                <button class="btn btn-primary" type="submit">保存更改</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane ">
                                <div class="panel-body">
                                    <form id="form" action="form_wizard.html#" class="wizard-big form-horizontal">
                                        <h1>安全验证</h1>
                                        <fieldset>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">账户名称：</label>
                                                <div class="col-sm-4 fixed-height">
                                                    <p class="form-control-static"><b>email@example.com</b></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">当前密码：</label>

                                                <div class="col-sm-6 fixed-height">
                                                    <input type="password" class="form-control" name="password" id="password">
                                                </div>
                                            </div>
                                        </fieldset>
                                        <h1>设置密码</h1>
                                        <fieldset>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">重置密码：</label>

                                                <div class="col-sm-6 fixed-height">
                                                    <input type="password" class="form-control" name="new_password" id="new_password">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">确认密码：</label>

                                                <div class="col-sm-6 fixed-height">
                                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                            <div id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="image-crop">
                                                <img src="/upload/section_14_300x300.jpg">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>图片预览：</h4>

                                            <div class="img-preview img-preview-sm"></div>
                                            <div class="btn-group">
                                                <label title="上传图片" for="inputImage" class="btn btn-primary"> <input type="file"
                                                                                                                     accept="image/*"
                                                                                                                     name="file" id="inputImage"
                                                                                                                     class="hide"> 上传新图片
                                                </label> <label title="下载图片" id="download" class="btn btn-primary">下载</label>
                                            </div>
                                            <div class="btn-group">
                                                <button class="btn btn-white" id="zoomIn" type="button">放大</button>
                                                <button class="btn btn-white" id="zoomOut" type="button">缩小</button>
                                                <button class="btn btn-white" id="rotateLeft" type="button">左旋转</button>
                                                <button class="btn btn-white" id="rotateRight" type="button">右旋转</button>
                                                <button class="btn btn-warning" id="setDrag" type="button">裁剪</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-4" class="tab-pane">
                                <div class="panel-body">
                                    asdadadad
                                </div>
                            </div>
                            <div id="tab-5" class="tab-pane">
                                <div class="panel-body">
                                    <form class="form-horizontal m-t" id="secret">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" >同时在线：</label>
                                            <div class="col-sm-8">
                                                <div class="radio radio-info radio-inline">
                                                    <input type="radio" checked="checked" name="multi-login" value="N" id="multi-login-n">
                                                    <label for="multi-login-n"> 关闭 </label>
                                                </div>
                                                <div class="radio radio-info radio-inline">
                                                    <input type="radio" checked="" name="multi-login" value="Y" id="multi-login-y">
                                                    <label for="multi-login-y"> 开启 </label>
                                                </div>
                        <span class="help-block m-b-none alert alert-info">
                          <i class="fa fa-info-circle"></i>
                          限制多设备同时登陆：<br>
                          1. 关闭，支持不同设备同时在线<br>
                          2. 开启，支持一个设备在线，其他设备将会强制退出<br>
                        </span>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" >登陆次数：</label>
                                            <div class="col-sm-8">
                                                <div class="radio radio-info radio-inline">
                                                    <input type="radio" checked="checked" name="login-nums" value="N" id="login-nums-n">
                                                    <label for="login-nums-n"> 关闭 </label>
                                                </div>
                                                <div class="radio radio-info radio-inline">
                                                    <input type="radio" checked="" name="login-nums" value="Y" id="login-nums-y">
                                                    <label for="login-nums-y"> 开启 </label>
                                                </div>
                                                <!--<input id="login_nums" name="login_nums" class="form-control input-sm" data-mask="99"-->
                                                <!--type="text"-->
                                                <!--aria-required="true" aria-invalid="true" required="number" value="">-->
                        <span class="help-block m-b-none alert alert-info">
                          <i class="fa fa-info-circle"></i>
                          限制用户访问次数：<br>
                          1. 关闭，登陆尝试次数不做限制<br>
                          2. 开启，按照用户设定的次数进行限制，超过指定次数后，账户会被临时冻结<br>
                        </span>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <div class="col-sm-2 col-sm-offset-2">
                                                <button class="btn btn-primary" type="submit">保存更改</button>
                                            </div>
                                        </div>
                                    </form>
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
<script src="/assets/js/plugins/steps/jquery.steps.min.js"></script>
<script src="/assets/js/plugins/validate/jquery.validate.min.js"></script>
<script src="/assets/js/plugins/validate/messages_zh.min.js"></script>
<script src="/assets/js/content.min.js"></script>
<script src="/assets/js/plugins/cropper/cropper.min.js"></script>
<script>
    $(document).ready(function () {

        /*step-1 basic info*/

        /*step-2 reset password*/
        var form = $('#form'), e = "<i class='fa fa-times-circle'></i> ";
        $.validator.setDefaults({
            highlight: function (e) {
                $(e).closest(".form-group").removeClass("has-success").addClass("has-error")
            }, success: function (e) {
                e.closest(".form-group").removeClass("has-error").addClass("has-success")
            }, errorElement: "span", errorPlacement: function (e, r) {
                e.appendTo(r.parent())
            }, errorClass: "help-block m-b-none", validClass: "help-block m-b-none"
        });
        form.steps({
            transitionEffect: "slideLeft",
            enableCancelButton: false,
            bodyTag: "fieldset", onStepChanging: function (event, currentIndex, newIndex) {
                if (currentIndex > newIndex) {
                    return true
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                if (form.valid()) {

                    console.log(form.serialize());
//          return false;
                    return form.valid();
                }
                else {
                    return false;
                }
            }, onStepChanged: function (event, currentIndex, priorIndex) {
                if (currentIndex === 2) {
                    $(this).steps("previous")
                }
            }, onFinishing: function (event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid()
            }, onFinished: function (event, currentIndex) {
                form.submit()
            }
        }).validate({
            rules: {
                password: {required: !0, minlength: 6},
                new_password: {required: !0, minlength: 6},
                confirm_password: {required: !0, minlength: 6, equalTo: "#new_password"}
            },
            messages: {
                password: {required: e + "请输入您的密码", minlength: e + "密码必须6个字符以上"},
                new_password: {required: e + "请输入您的密码", minlength: e + "密码必须6个字符以上"},
                confirm_password: {required: e + "请再次输入密码", minlength: e + "密码必须6个字符以上", equalTo: e + "两次输入的密码不一致"}
            }
        });

        /*step-3 edit profie img*/
        var o = $(".image-crop > img");
        $(o).cropper({
            aspectRatio: 1.618, preview: ".img-preview", done: function () {
            }
        });
        var r = $("#inputImage");
        window.FileReader ? r.change(function () {
            var e, i = new FileReader, t = this.files;
            t.length && (e = t[0], /^image\/\w+$/.test(e.type) ? (i.readAsDataURL(e), i.onload = function () {
                r.val(""), o.cropper("reset", !0).cropper("replace", this.result)
            }) : showMessage("请选择图片文件"))
        }) : r.addClass("hide"), $("#download").click(function () {
            window.open(o.cropper("getDataURL"))
        }), $("#zoomIn").click(function () {
            o.cropper("zoom", .1)
        }), $("#zoomOut").click(function () {
            o.cropper("zoom", -.1)
        }), $("#rotateLeft").click(function () {
            o.cropper("rotate", 90)
        }), $("#rotateRight").click(function () {
            o.cropper("rotate", -90)
        }), $("#setDrag").click(function () {
            o.cropper("setDragMode", "crop")
        });

    });
</script>
@endsection