<style>
    .inmodal .modal-header {
        padding: 15px;
    }

    .modal-header .close {
        margin-top: 3px;
    }

    .inmodal .modal-title {
        font-weight: bold;
        font-size: 20px;
    }

    .modal-body .form-group {
        margin: 10px;
    }
</style>

{!! Form::open([
    'id'        =>'add',
    'class'     =>'',
    'url'       =>url('adm/menu'),
    'method'    =>'post'
]) !!}

<div class="modal-header">
    <button data-dismiss="modal" class="close" type="button">
        <span aria-hidden="true">×</span> <span class="sr-only">关闭</span>
    </button>
    <h6 class="modal-title">新增菜单</h6>
</div>
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            <label class="control-label col-sm-3">{!! $headerInfo['menu_name']['title'] !!}：</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" required="" value="" id="menu_name" name="menu_name">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <label class="control-label col-sm-3">{!! $headerInfo['menu_parent_id']['title'] !!}：</label>
            <div class="col-sm-8">
                {!! Form::select('menu_parent_id',$parentNames,'',['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="control-label col-sm-3">{!! $headerInfo['menu_address']['title'] !!}：</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" required="" value="" id="menu_address" name="menu_address">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="control-label col-sm-3">{!! $headerInfo['menu_order']['title'] !!}：</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" required="" value="" id="menu_order" name="menu_order">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <label class="control-label col-sm-3">{!! $headerInfo['menu_status']['title'] !!}：</label>
            <div class="col-sm-8">
                <label style="margin-right:10px;color: green"> <input type="radio" value="Y" checked="checked"
                                                                      name="menu_status"> 启用 </label> <label
                        style="margin-right:10px;color: red"> <input type="radio" value="N" name="menu_status"> 关闭
                </label>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button data-dismiss="modal" class="btn btn-white btn-sm" type="button">关闭</button>
    <button class="btn btn-primary btn-sm" type="submit">保存</button>
</div>{!! Form::close() !!}


