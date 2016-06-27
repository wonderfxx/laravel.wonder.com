@extends('admin.common.frame')@section('body_style_class','gray-bg mini-navbar pace-done')
@section('header')
    <link href="/assets/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
    <link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="/assets/css/reset.css" rel="stylesheet">
    <style>
        .custom_submit {
            padding: 0;
            margin: 0;
            text-align: center
        }
    </style>
@endsection
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>新增套餐</h5>
            </div>
            <div class="ibox-content">
                <div class="row row-lg add_new_tab_box">
                    <div class="col-sm-4 add_new_tab">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title custom_ibox_title">
                                <h5><i class="fa fa-plus"></i></h5>
                                <div class="ibox-tools">
                                    <button class="btn btn-xs btn-success addButton" data-placement="top"
                                            data-toggle="tooltip" data-original-title="复制当前信息副本" type="button">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                    <button class="btn btn-xs btn-danger delButton" style="margin-left: 5px;"
                                            title="删除当前信息" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="ibox-content custom_ibox_content">
                                <div class="row">
                                    {!! Form::open([
                                        'class'=>'form-horizontal form-box',
                                        'method'=>'post',
                                    ]) !!}
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            {!! Form::select('game_code',$games,'loapk',[
                                               'class' => 'form-control chosen-select'
                                            ]) !!}
                                        </div>
                                        <div class="col-sm-6">
                                            {!! Form::select('country',$countries,'US',[
                                               'class' => 'form-control chosen-select',
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            {!! Form::select('channel_code',$channels,'kongregate',[
                                               'class' => 'form-control chosen-select',
                                            ]) !!}
                                        </div>
                                        <div class="col-sm-6">
                                            {!! Form::input('text','channel_sub_code','',[
                                               'placeholder' =>  "请输入".$headers['channel_sub_code']['title'],
                                               "data-placement"    =>"top",
                                                "data-toggle"       =>"tooltip" ,
                                                "data-original-title"=>"请输入".$headers['channel_sub_code']['title'],
                                               'class' => 'form-control'
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            {!! Form::input('text','amount','',[
                                               'placeholder' =>  "请输入".$headers['amount']['title'],
                                                "data-placement"    =>"top",
                                                "data-toggle"       =>"tooltip" ,
                                                "data-original-title"=>"请输入".$headers['amount']['title'],
                                                'required'      => '',
                                               'class' => 'form-control'
                                            ]) !!}
                                        </div>
                                        <div class="col-sm-6">
                                            {!! Form::select('currency',$currencies,'KRD',[
                                               'class' => 'form-control chosen-select'
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            {!! Form::input('text','amount_usd','',[
                                               'placeholder' =>  "请输入".$headers['amount_usd']['title'],
                                               "data-placement"    =>"top",
                                                "data-toggle"       =>"tooltip" ,
                                                "data-original-title"=>"请输入".$headers['amount_usd']['title'],
                                               'class' => 'form-control'
                                            ]) !!}
                                        </div>
                                        <div class="col-sm-6">
                                            {!! Form::input('text','game_coins','',[
                                               'placeholder' =>  "请输入".$headers['game_coins']['title'],
                                               "data-placement"    =>"top",
                                                "data-toggle"       =>"tooltip" ,
                                                "data-original-title"=>"请输入".$headers['game_coins']['title'],
                                                'required'      => '',
                                               'class' => 'form-control'
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            {!! Form::input('text','game_coins_rewards','',[
                                               'placeholder' =>  "请输入".$headers['game_coins_rewards']['title'],
                                                "data-placement"    =>"top",
                                                "data-toggle"       =>"tooltip" ,
                                                "data-original-title"=>"请输入".$headers['game_coins_rewards']['title'],
                                               'class' => 'form-control'
                                            ]) !!}
                                        </div>
                                        <div class="col-sm-6">
                                            {!! Form::input('text','product_id','',[
                                               'placeholder' =>  "请输入".$headers['product_id']['title'],
                                               "data-placement"    =>"top",
                                                "data-toggle"       =>"tooltip" ,
                                                "data-original-title"=>"请输入".$headers['product_id']['title'],
                                                'required'      => '',
                                               'class' => 'form-control'
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            {!! Form::input('text','product_type','',[
                                               'placeholder' =>  "请输入".$headers['product_type']['title'],
                                               "data-placement"    =>"top",
                                                "data-toggle"       =>"tooltip" ,
                                                "data-original-title"=>"请输入".$headers['product_type']['title'],
                                               'class' => 'form-control'
                                            ]) !!}
                                        </div>
                                        <div class="col-sm-6">
                                            {!! Form::input('text','product_logo','',[
                                               'placeholder' =>  "请输入".$headers['product_logo']['title'],
                                               "data-placement"    =>"top",
                                                "data-toggle"       =>"tooltip" ,
                                                "data-original-title"=>"请输入".$headers['product_logo']['title'],
                                               'class' => 'form-control'
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            {!! Form::textarea('product_name','',[
                                               'placeholder' =>  "请输入".$headers['product_name']['title'],
                                               "data-placement"    =>"top",
                                                "data-toggle"       =>"tooltip" ,
                                                "data-original-title"=>"请输入".$headers['product_name']['title'],
                                               'rows' =>'2',
                                               'class' => 'form-control',
                                            ]) !!}
                                        </div>
                                        <div class="col-sm-6">
                                            {!! Form::textarea('product_description','',[
                                               'placeholder' =>  "请输入".$headers['product_description']['title'],
                                               "data-placement"    =>"top",
                                                "data-toggle"       =>"tooltip" ,
                                                "data-original-title"=>"请输入".$headers['product_description']['title'],
                                               'rows' =>'2',
                                               'class' => 'form-control'
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                {!! Form::radio('status','Y','',[]) !!}
                                                <span class="label label-primary">已启用</span> </label> <label>
                                                {!! Form::radio('status','N','checked',['style'=>'margin-left:10px']) !!}
                                                <span class="label label-danger">未启用</span> </label>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed" style="margin: 15px 0;padding: 0"></div>
                                    <div class="form-group" style="margin: 0;padding: 0">
                                        <div class="col-sm-12 custom_submit">
                                            {!! Form::submit('确认保存',[
                                                'class' => 'btn btn-sm btn-success saveButton',
                                                'style' => ' margin-right: 50px'
                                            ]) !!}
                                            {!!Form::input('reset','reset',
                                                '清空数据',
                                                [
                                                    'class' => 'btn btn-sm btn-warning resetButton',
                                                    "data-placement"    =>"top",
                                                    "data-toggle"       =>"tooltip" ,
                                                    "data-original-title"=>"重置所有数据",
                                                ])
                                            !!}
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix hidden-xs"></div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
    <script src="/assets/js/plugins/validate/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            // 选择插件
            $('.chosen-select').chosen();

            var contentBox = $(".add_new_tab_box");
            contentBox.tooltip({
                selector: "[data-toggle=tooltip]",
                container: "body"
            });
            // 添加设备点击事件
            contentBox.on('click', '.addButton', function () {
                var demo = $(this).parent().parent().parent().parent();
                var divs = demo.clone();
                demo.find('select').each(function () {
                    name = $(this).attr('name');
                    val = $(this).find("option:selected").val();
                    divs.find(".chosen-select[name='" + name + "'] option[value='" + val + "']").attr('selected', true);
                });
                demo.after(divs);
                divs.find('.chosen-container').remove();
                divs.find('.chosen-select').show().chosen();
            });
            // 删除设备点击事件
            contentBox.on('click', '.delButton', function () {
                if ($('.add_new_tab').length > 1) {
                    $(this).parent().parent().parent().parent().remove();
                }
            });
            //新增
            contentBox.on('click', '.saveButton', function () {
                var formHandler = $(this).closest("form");
                formHandler.validate({
                    debug: true,
                    onsubmit: true,
                    errorPlacement: function (error, element) {
                        $(element).attr('data-original-title', $(error).text());
                    },
                    success: function (label, element) {
                        $(element).attr('data-original-title', $(element).attr('placeholder'));
                    },
                    submitHandler: function (form) {
                        $.ajax({
                            url: "{{url('adm/gamePackage')}}",
                            type: "post",
                            dataType: "json",
                            data: $(form).serialize(),
                            success: function () {
                                alert('恭喜您添加成功');
                                if ($('.add_new_tab').length > 1) {
                                    formHandler.parent().parent().parent().parent().remove();
                                }
                                else {
                                    formHandler.find('.resetButton').trigger('click');
                                }
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
            });
        });
    </script>
@endsection()