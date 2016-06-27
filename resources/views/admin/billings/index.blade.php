@extends('admin.common.body')@section('nav_title','订单列表')@section('page_address','/billings/')
@section('page_search_params','fg_order_id,channel_order_id,user_id,send_coins_status,channel_status')
@section('body_section')
    {!! Form::open([
        'role'=>'form',
        'class'=>'form-inline'
    ]) !!}
    <div class="form-group">
        <input type="text" class="form-control" placeholder="请输入平台订单号" value="" id="fg_order_id"
               name="fg_order_id">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="请输入渠道订单号" value=""
               id="channel_order_id" name="channel_order_id">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="请输入用户ID" value="" id="user_id"
               name="user_id">
    </div>
    <div class="form-group">
        {!! Form::select(
            'send_coins_status',$sendStatus,
            '',
            [
            'id'=> 'send_coins_status',
            'class' => 'form-control chosen-select',
            ]) !!}
    </div>
    <div class="form-group">
        {!! Form::select(
            'channel_status',$payStatus,
            '',
            [
            'id'=> 'channel_status',
            'class' => 'form-control chosen-select',
            ]) !!}
    </div>
    <button class="btn btn-sm btn-success" type="button" id='searchButton'
            style="margin-bottom: 0;margin-left:10px;">订单查询
    </button>
    {!! Form::close() !!}
@endsection