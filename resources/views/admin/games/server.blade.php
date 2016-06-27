@extends('admin.common.body')@section('nav_title','服务器列表')@section('page_address','/gameServer/')@section('page_search_params','game_code,server_id,status')
@section('body_section')
    {!! Form::open([
        'role'=>'form',
        'class'=>'form-inline'
    ]) !!}
    <div class="form-group">
        <input type="text" class="form-control" placeholder="请输入游戏简写" value="" id="game_code" name="game_code">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="请输入服务器ID" value="" id="server_id" name="server_id">
    </div>
    <div class="form-group">
        <select class="form-control chosen-select " id="status" name="status">
            <option value="0">请选择启用状态</option>
            <option value="Y">已启用</option>
            <option value="N">未启用</option>
        </select>
    </div>
    <button class="btn btn-sm btn-success" type="button" id='searchButton' style="margin-bottom: 0;margin-left:10px;">
        服务器查询
    </button>
    {!! Form::close() !!}
    <div class="btn-group hidden-xs" id="dataTableLabelToolbar" role="group">
        <a class="btn btn-primary " href="javascript:add()">
            <i class="glyphicon glyphicon-plus " aria-hidden="true"></i>
        </a>
    </div>
@endsection