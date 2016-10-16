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
                'method'=>'PUT',
            ]) !!}
            <div class="form-group">
                <div class="col-xs-6">
                    {!! Form::input('text','game_code',$data->game_code,[
                       'placeholder' =>  "请输入".$headers['game_code']['title'],
                        "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['game_code']['title'],
                        'required'      => '',
                       'class' => 'form-control'
                    ]) !!}
                </div>
                <div class="col-xs-6">
                    {!! Form::input('text','game_name',$data->game_name,[
                       'placeholder' =>  "请输入".$headers['game_name']['title'],
                        "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['game_name']['title'],
                        'required'      => '',
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-6">
                    {!! Form::input('text','game_coins_name',$data->game_coins_name,[
                       'placeholder' =>  "请输入".$headers['game_coins_name']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['game_coins_name']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
                <div class="col-xs-6">
                    {!! Form::select('game_type',$game_types,$data->game_type,[
                        'class' => 'form-control chosen-select'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-6">
                    {!! Form::input('text','game_logo',$data->game_logo,[
                       'placeholder' =>  "请输入".$headers['game_logo']['title'],
                        "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['game_logo']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
                <div class="col-xs-6">
                    {!! Form::input('text','proportion_usd',$data->proportion_usd,[
                       'placeholder' =>  "请输入".$headers['proportion_usd']['title'],
                        "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['proportion_usd']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-6">
                    {!! Form::input('text','proportion_local',$data->proportion_local,[
                       'placeholder' =>  "请输入".$headers['proportion_local']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['proportion_local']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
                <div class="col-xs-6">
                    {!! Form::input('text','proportion_local_currency',$data->proportion_local_currency,[
                       'placeholder' =>  "请输入".$headers['proportion_local_currency']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['proportion_local_currency']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-6">
                    {!! Form::input('text','proportion_cp',$data->proportion_cp,[
                       'placeholder' =>  "请输入".$headers['proportion_cp']['title'],
                        "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['proportion_cp']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
                <div class="col-xs-6">
                    {!! Form::input('text','proportion_cp_currency',$data->proportion_cp_currency,[
                       'placeholder' =>  "请输入".$headers['proportion_cp_currency']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['proportion_cp_currency']['title'],
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-6">
                    {!! Form::textarea('recharge_api',$data->recharge_api,[
                       'placeholder' =>  "请输入".$headers['recharge_api']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['recharge_api']['title'],
                       'rows' =>'2',
                       'class' => 'form-control',
                    ]) !!}
                </div>
                <div class="col-xs-6">
                    {!! Form::textarea('charge_back_api',$data->charge_back_api,[
                       'placeholder' =>  "请输入".$headers['charge_back_api']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['charge_back_api']['title'],
                       'rows' =>'2',
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-6">
                    {!! Form::textarea('server_list_api',$data->server_list_api,[
                       'placeholder' =>  "请输入".$headers['server_list_api']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['server_list_api']['title'],
                       'rows' =>'2',
                       'class' => 'form-control',
                    ]) !!}
                </div>
                <div class="col-xs-6">
                    {!! Form::textarea('charge_back_api',$data->user_role_api,[
                       'placeholder' =>  "请输入".$headers['user_role_api']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['user_role_api']['title'],
                       'rows' =>'2',
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-6">
                    {!! Form::textarea('kongregate_api_key',$data->kongregate_api_key,[
                       'placeholder' =>  "请输入".$headers['kongregate_api_key']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['kongregate_api_key']['title'],
                       'rows' =>'2',
                       'class' => 'form-control'
                    ]) !!}
                </div>
                <div class="col-xs-6">
                    {!! Form::textarea('kongregate_api_gid',$data->kongregate_api_gid,[
                       'placeholder' =>  "请输入".$headers['kongregate_api_gid']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['kongregate_api_gid']['title'],
                       'rows' =>'2',
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-6">
                    {!! Form::textarea('kongregate_guest_key',$data->kongregate_guest_key,[
                       'placeholder' =>  "请输入".$headers['kongregate_guest_key']['title'],
                       "data-placement"    =>"top",
                        "data-toggle"       =>"tooltip" ,
                        "data-original-title"=>"请输入".$headers['kongregate_guest_key']['title'],
                       'rows' =>'2',
                       'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-6">
                    {!! Form::select('game_status',$game_status,$data->game_status,[
                        'class' => 'form-control chosen-select'
                    ]) !!}
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
                        url: "{{url('adm/games/'.$data->id.'/')}}",
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
@endsection()
