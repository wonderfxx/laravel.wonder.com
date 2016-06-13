@extends('admin.common.frame')
@section('header')
<link href="/assets/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">
<link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<link href="/assets/css/reset.css" rel="stylesheet">
<link href="/assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
@endsection
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>操作日志</h5>
        </div>
        <div class="ibox-content">
            <div class="row row-lg">
                <div class="col-sm-12">
                    <form role="form" class="form-inline"  >
                        <div class="form-group">
                            <select class="form-control chosen-select" id="user_id" name="user_id">
                                <option value="1">请选择用户</option>
                                {!-foreach from=$users item=value key=k-!}
                                <option value="{!-$value.user_id-!}"
                                        {!-if $value.user_id == $user_id -!}
                                        selected='selected'
                                        {!-/if-!}
                                >{!-$value.user_name|urldecode-!}
                                </option>
                                {!-/foreach-!}
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control chosen-select" id="oper_table" name="oper_table">
                                <option value="0">请选择操作表</option>
                                {!-foreach from=$tables item=value key=k-!}
                                <option value="{!-$value-!}">{!-$value-!}</option>
                                {!-/foreach-!}
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control chosen-select " id="oper_type" name="oper_type">
                                <option value="0">请选择操作类型</option>
                                <option value="Insert">添加</option>
                                <option value="Update">编辑</option>
                                <option value="Delete">删除</option>
                            </select>
                        </div>
                        <div class="form-group" id="data_1">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="add_time" id="add_time" type="text" value="" placeholder="选择操作时间" class="form-control calendar calendar-time">
                            </div>
                        </div>
                        <button class="btn btn-sm btn-success" type="button" id='searchButton' style="margin-bottom: 0;margin-left:10px;">查询</button>
                    </form>
                    <table id="dataTableLabel" data-show-columns="true" data-height="550" data-mobile-responsive="true"></table>
                </div>
                <div class="clearfix hidden-xs"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight"></div>
    </div>
</div>
@endsection
@section('footer')
<script src="/assets/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="/assets/js/plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script>
<script src="/assets/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
<script src="/assets/js/plugins/bootstrap-table/export/bootstrap-table-export.js"></script>
<script src="/assets/js/plugins/bootstrap-table/export/table-export.js"></script>
<script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
<script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    var columns = {!-$headers-!},tableHandler = $('#dataTableLabel');
    $(document).ready(function() {

        //日期
        $("#data_1 .input-group.date").datepicker({
            todayBtn: "linked",
            keyboardNavigation: !1,
            forceParse: !1,
            calendarWeeks: !0,
            autoclose: !0
        })

        // 选择插件
        $('.chosen-select').chosen();

        // table 数据
        tableHandler.bootstrapTable({

            // server
            sidePagination: "server", //服务端请求
            method: 'post',
            dataType: "json",
            contentType: "application/x-www-form-urlencoded",
            url: "/admin/AccessLog/getData",
            queryParams: queryParams,
            responseHandler: responseHandler,

            // page
            pagination: true,
            queryParamsType: "pageSize,pageNumber,user_id,oper_table,oper_type,add_time",
            pageSize: 10,
            pageNumber:1,
            pageList: [],

            // setting
            singleSelect: false,
            search: false,
            maintainSelected:false,
            strictSearch:false,
            clickToSelect: false,

            showToggle:true,
            showColumns: true,
            showRefresh: false,
            showExport: true,

            striped: true,
            toolbar: "#dataTableLabelToolbar",
            iconSize: "outline",
            icons: {refresh: "glyphicon-repeat", toggle: "glyphicon-list-alt", columns: "glyphicon-list",export:"glyphicon-export"},
            columns: columns
        });

        // 查询条件
        $('#searchButton').click(function () {
            tableHandler.bootstrapTable('refresh');
        });
        $("#myModal").on("hidden.bs.modal", function() {
            $(this).removeData("bs.modal");
        });
    });
    //接受返回参数
    function responseHandler(resultStr) {
        return {
            "rows": resultStr.records,
            "total": resultStr.totalCount
        }
    }

    //传递的参数
    function queryParams(params) {
        return {
            pageSize: params.pageSize,
            pageNumber: params.pageNumber,
            user_id:$('#user_id').val(),
            oper_table:$('#oper_table').val(),
            oper_type:$('#oper_type').val(),
            add_time:$('#add_time').val()
        }
    }

    function logInfo(obj)
    {
        //console.log(obj);
        var info = $(this).attr('name');
        console.log(info);
        swal(
                "您确定要删除这条信息吗"

        );
    }

</script>
@endsection