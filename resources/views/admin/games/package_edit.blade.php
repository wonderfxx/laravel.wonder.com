@extends('admin.common.frame')
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
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="col-xs-12">
            {!! Form::open([
                'class'=>'form-horizontal form-box',
                'method'    =>'PUT'
            ]) !!}
            <div class="form-group">
                {!! Form::label(
                    'game_code',
                    $headers['game_code']['title'],
                    ['class' => 'col-xs-3 control-label']
                ) !!}
                <div class="col-xs-9">
                    {!! Form::select('game_code',$games,$data->game_code,[
                       'class' => 'form-control chosen-select'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label(
                    'country',
                    $headers['country']['title'],
                    ['class' => 'col-xs-3 control-label']
                ) !!}
                <div class="col-xs-9">
                    {!! Form::select('country',$countries,$data->country,[
                       'class' => 'form-control chosen-select',
                    ]) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label(
                    'channel_code',
                    $headers['channel_code']['title'],
                    ['class' => 'col-xs-3 control-label']
                ) !!}
                <div class="col-xs-9">
                    {!! Form::select('channel_code',$channels,$data->channel,[
                       'class' => 'form-control chosen-select',
                    ]) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label(
                    'channel_sub_code',
                    $headers['channel_sub_code']['title'],
                    ['class' => 'col-xs-3 control-label']
                ) !!}
                <div class="col-xs-9">
                    {!! Form::input('text','channel_sub_code',$data->channel_sub_code,[
                       'placeholder' =>  "请输入".$headers['channel_sub_code']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['channel_sub_code']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label(
                    'amount',
                    $headers['amount']['title'],
                    ['class' => 'col-xs-3 control-label']
                ) !!}
                <div class="col-xs-9">
                    {!! Form::input('text','amount',$data->amount,[
                       'placeholder' =>  "请输入".$headers['amount']['title'],
                        "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['amount']['title'],
                        'required'      => '',
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label(
                    'currency',
                    $headers['currency']['title'],
                    ['class' => 'col-xs-3 control-label']
                ) !!}
                <div class="col-xs-9">
                    {!! Form::select('currency',$currencies,$data->currency,[
                       'class' => 'form-control chosen-select'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label(
                    'amount_usd',
                    $headers['amount_usd']['title'],
                    ['class' => 'col-xs-3 control-label']
                ) !!}
                <div class="col-xs-9">
                    {!! Form::input('text','amount_usd',$data->amount_usd,[
                       'placeholder' =>  "请输入".$headers['amount_usd']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['amount_usd']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label(
                    'game_coins',
                    $headers['game_coins']['title'],
                    ['class' => 'col-xs-3 control-label']
                ) !!}
                <div class="col-xs-9">
                    {!! Form::input('text','game_coins',$data->game_coins,[
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
                {!! Form::label(
                    'game_coins_rewards',
                    $headers['game_coins_rewards']['title'],
                    ['class' => 'col-xs-3 control-label']
                ) !!}
                <div class="col-xs-9">
                    {!! Form::input('text','game_coins_rewards',$data->game_coins_rewards,[
                       'placeholder' =>  "请输入".$headers['game_coins_rewards']['title'],
                        "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['game_coins_rewards']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label(
                    'product_id',
                    $headers['product_id']['title'],
                    ['class' => 'col-xs-3 control-label']
                ) !!}
                <div class="col-xs-9">
                    {!! Form::input('text','product_id',$data->product_id,[
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
                {!! Form::label(
                    'product_type',
                    $headers['product_type']['title'],
                    ['class' => 'col-xs-3 control-label']
                ) !!}
                <div class="col-xs-9">
                    {!! Form::input('text','product_type',$data->product_type,[
                       'placeholder' =>  "请输入".$headers['product_type']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['product_type']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label(
                    'product_logo',
                    $headers['product_logo']['title'],
                    ['class' => 'col-xs-3 control-label']
                ) !!}
                <div class="col-xs-9">
                    {!! Form::input('text','product_logo',$data->product_logo,[
                       'placeholder' =>  "请输入".$headers['product_logo']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['product_logo']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label(
                   'product_name',
                   $headers['product_name']['title'],
                   ['class' => 'col-xs-3 control-label']
               ) !!}
                <div class="col-xs-9">
                    {!! Form::textarea('product_name',$data->product_name,[
                       'placeholder' =>  "请输入".$headers['product_name']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['product_name']['title'],
                       'rows' =>'2',
                       'class' => 'form-control',
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label(
                   'product_description',
                   $headers['product_description']['title'],
                   ['class' => 'col-xs-3 control-label']
               ) !!}
                <div class="col-xs-9">
                    {!! Form::textarea('product_description',$data->product_description,[
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
                {!! Form::label(
                   'status',
                   $headers['status']['title'],
                   ['class' => 'col-xs-3 control-label']
               ) !!}
                <div class="col-xs-9">
                    @if($data->status =='Y')
                        <label> {!! Form::radio('status','Y','checked',[]) !!}
                            <span class="label label-primary">已启用</span> </label> <label>
                            {!! Form::radio('status','N','',['style'=>'margin-left:10px']) !!}
                            <span class="label label-danger">未启用</span> </label>
                    @else
                        <label>
                            {!! Form::radio('status','Y','',[]) !!}
                            <span class="label label-primary">已启用</span> </label> <label>
                            {!! Form::radio('status','N','checked',['style'=>'margin-left:10px']) !!}
                            <span class="label label-danger">未启用</span> </label>
                    @endif
                </div>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
@endsection
@section('footer')
    <script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
    <script src="/assets/js/plugins/validate/jquery.validate.min.js"></script>
    <script type="text/javascript">
        var contentBox = $(".wrapper");
        $(document).ready(function () {

            // 选择插件
            $('.chosen-select').chosen();
            contentBox.tooltip({
                selector: "[data-toggle=tooltip]",
                container: "body"
            });

        });
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
                        url: "{{url('adm/gamePackage/'.$data->id.'/')}}",
                        type: "post",
                        dataType: "json",
                        data: $(form).serialize(),
                        success: function () {
                            alert('恭喜您更改成功!');
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
@endsection