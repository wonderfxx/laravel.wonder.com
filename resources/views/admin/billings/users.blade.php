@extends('admin.common.body')@section('nav_title','用户列表')@section('page_address','/billingUsers/')
@section('page_search_params','email,user_id')
@section('body_section')
    {!! Form::open([
      'role'=>'form',
      'class'=>'form-inline'
    ]) !!}
    <div class="form-group">
        <input type="text" class="form-control" placeholder="请输入用户邮箱" value="" id="email" name="email">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="请输入用户ID" value="" id="user_id" name="user_id">
    </div>
    <button class="btn btn-sm btn-success" type="button" id='searchButton' style="margin-bottom: 0;margin-left:10px;">
        用户查询
    </button>
    {!! Form::close() !!}
@endsection