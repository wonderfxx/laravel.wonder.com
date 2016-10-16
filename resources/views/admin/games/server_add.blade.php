@extends('admin.common.frame')
@section('header')
    <link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">
    <style>
        .custom_submit {
            padding: 0;
            margin: 0;
            text-align: center
        }
    </style>
@endsection
@section('content')
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="col-xs-12 m-t">
            {!! Form::open([
                'class'=>'form-horizontal form-box',
                'method'=>'post',
            ]) !!}
            <div class="form-group">
                <div class="col-xs-6">
                    {!! Form::select('game_code',$games,'loapk',[
                       'class' => 'form-control chosen-select'
                    ]) !!}
                </div>
                <div class="col-xs-6">
                    {!! Form::input('text','server_id','',[
                       'placeholder' =>  "请输入".$headers['server_id']['title'],
                        "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['server_id']['title'],
                        'required'      => '',
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-6">
                    {!! Form::input('text','server_type','',[
                       'placeholder' =>  "请输入".$headers['server_type']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['server_type']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
                <div class="col-xs-6">
                    {!! Form::input('text','server_name','',[
                       'placeholder' =>  "请输入".$headers['server_name']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['server_name']['title'],
                        'required'      => '',
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-6">
                    {!! Form::input('text','server_open_at','',[
                       'placeholder' =>  "请输入".$headers['server_open_at']['title'],
                        "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['server_open_at']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
                <div class="col-xs-6">
                    {!! Form::input('text','server_close_at','',[
                       'placeholder' =>  "请输入".$headers['server_close_at']['title'],
                        "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['server_close_at']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-6">
                    {!! Form::input('text','server_lang','',[
                       'placeholder' =>  "请输入".$headers['server_lang']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['server_lang']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
                <div class="col-xs-6">
                    {!! Form::input('text','server_region','',[
                       'placeholder' =>  "请输入".$headers['server_region']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['server_region']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-6">
                    {!! Form::input('text','server_address','',[
                       'placeholder' =>  "请输入".$headers['server_address']['title'],
                        "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['server_address']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <label>
                        {!! Form::radio('status','Y','',[]) !!}
                        <span class="label label-primary">已启用</span> </label> <label>
                        {!! Form::radio('status','T','checked',['style'=>'margin-left:10px']) !!}
                        <span class="label label-info">测试中</span> </label>
                        {!! Form::radio('status','N','',['style'=>'margin-left:10px']) !!}
                        <span class="label label-danger">未启用</span> </label>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="clearfix hidden-xs"></div>
    </div>
@endsection
@section('footer')
    <script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
    <script src="/assets/js/plugins/validate/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            // 选择插件
            $('.chosen-select').chosen();

            var contentBox = $(".wrapper");
            contentBox.tooltip({
                selector: "[data-toggle=tooltip]",
                container: "body"
            });

        });
        // add
        function saveButton() {

            $('form.form-box').validate({
                onsubmit: true,
                errorPlacement: function (error, element) {
                    $(element).attr('data-original-title', $(error).text());
                },
                success: function (label, element) {
                    $(element).attr('data-original-title', $(element).attr('placeholder'));
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: "{{url('adm/gameServer/')}}",
                        type: "post",
                        dataType: "json",
                        data: $(form).serialize(),
                        success: function () {
                            alert('恭喜您添加成功!');
                        },
                        error: function (data) { // the data parameter here is a jqXHR instance
                            var errors = data.responseJSON;
                            switch (data.status) {
                                case 422:
                                    alert(errors.msg);
                                    break;
                                default:
                                    alert('操作失败,请重试。');
                            }
                        }
                    });
                }
            });
            $('form.form-box').submit();
        }
    </script>
@endsection()
