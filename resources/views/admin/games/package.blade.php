@extends('admin.common.body')@section('nav_title','套餐列表')@section('page_address','/gamePackage/')@section('page_search_params','game_code,channel_code,id,status')
@section('body_section')
    {!! Form::open([
        'role'=>'form',
        'class'=>'form-inline'
    ]) !!}
    <div class="form-group">
        <input type="text" class="form-control" placeholder="请输入游戏简写" value="" id="game_code" name="game_code">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="请输入渠道简写" value="" id="channel_code" name="channel_code">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="请输入套餐ID" value="" id="id" name="id">
    </div>
    <div class="form-group">
        <select class="form-control chosen-select " id="status" name="status">
            <option value="0">请选择启用状态</option>
            <option value="Y">已启用</option>
            <option value="N">未启用</option>
        </select>
    </div>
    <button class="btn btn-sm btn-success" type="button" id='searchButton' style="margin-bottom: 0;margin-left:10px;">
        套餐查询
    </button>
    {!! Form::close() !!}
@endsection