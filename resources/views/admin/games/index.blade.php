@extends('admin.common.body')@section('nav_title','游戏列表')@section('page_address','/games/')
@section('page_search_params','game_code,game_type,game_status')
@section('body_section')
    {!! Form::open([
        'role'=>'form',
        'class'=>'form-inline'
    ]) !!}
    <div class="form-group">
        <input type="text" class="form-control" placeholder="请输入游戏简写" value="" id="game_code" name="game_code">
    </div>
    <div class="form-group">
        {!! Form::select('game_type',$game_types,'0',[
            'class' => 'form-control chosen-select'
        ]) !!}
    </div>
    <div class="form-group">
        {!! Form::select('game_status',$game_status,'0',[
            'class' => 'form-control chosen-select'
        ]) !!}
    </div>
    <button class="btn btn-sm btn-success" type="button" id='searchButton' style="margin-bottom: 0;margin-left:10px;">
        游戏查询
    </button>
    {!! Form::close() !!}
    <div class="btn-group hidden-xs" id="dataTableLabelToolbar" role="group">
        <a class="btn btn-primary " href="javascript:add()">
            <i class="glyphicon glyphicon-plus " aria-hidden="true"></i>
        </a>
    </div>
@endsection