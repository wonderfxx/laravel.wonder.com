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
            <h5>汇率查询管理</h5>
        </div>
        <div class="ibox-content">
            <div class="row row-lg">
                <div class="col-sm-12">
                    <form role="form" class="form-inline"  >
                        <div class="form-group">
                            <div class="input-group">
                                <input name="currency_code" id="currency_code" type="text" value="" placeholder="选择查询的货币" class="form-control ">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="update_date" id="update_date" type="text" value="" placeholder="选择时间" class="form-control calendar calendar-time">
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control chosen-select " id="is_auto_update" name="is_auto_update">
                                <option value="0">请选择更新状态</option>
                                <option value="N">手动更新</option>
                                <option value="Y">自动更新</option>
                            </select>
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
<script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
<script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    var columns = {!-$headers-!},tableHandler = $('#dataTableLabel');
    var setting = {

        // server
        sidePagination: "server", //服务端请求
        method: 'post',
        dataType: "json",
        contentType: "application/x-www-form-urlencoded",
        url: "/admin/currencyRate/getData",
        queryParams: queryParams,
        responseHandler: responseHandler,

        // page
        pagination: true,
        queryParamsType: "pageSize,pageNumber,update_date,is_auto_update,currency_code",
        pageSize: 9,
        pageNumber:1,
        pageList: [],

        // setting
        height: $(document).outerHeight-120,
        singleSelect: false,
        search: false,
        maintainSelected:false,
        strictSearch:false,
        clickToSelect: false,

        showToggle:true,
        showColumns: true,
        showRefresh: false,

        striped: true,
        toolbar: "#dataTableLabelToolbar",
        iconSize: "outline",
        icons: {refresh: "glyphicon-repeat", toggle: "glyphicon-list-alt", columns: "glyphicon-list",export:"glyphicon-export"},
        columns: columns
    };

    $(document).ready(function() {

        // 选择插件
        $('.chosen-select').chosen();
        $(".date").datepicker({
            todayBtn: "linked",
            keyboardNavigation: !1,
            forceParse: !1,
            calendarWeeks: !0,
            autoclose: !0
        });

        // table 数据
        tableHandler.bootstrapTable(setting);

        // 查询条件
        $('#searchButton').click(function () {
//            tableHandler.bootstrapTable('resetView');
            tableHandler.bootstrapTable('refresh');
        });

        $("#myModal").on("hidden.bs.modal", function() {
            $(this).removeData("bs.modal");
        });
    });

    //删除
    function delMenu(ids)
    {
        swal({
            title: "您确定要删除这条信息吗",
            text: "删除后将无法恢复，请谨慎操作！",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "删除",
            cancelButtonText: "取消",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                url: '/admin/menu/deleteAction',
                type:'post',
                dataType: 'json',
                data: {menu_id: ids},
                success: function (data) {
                    if (data.status == 'OK') {
                        swal("删除成功！", "您已经永久删除了这条信息。", "success");
                        $('#searchButton').click();
                    } else { //删除失败
                        swal("删除失败！", "删除失败了，请重新尝试。", "error");
                    }
                }
            });
        });
    }

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
            currency_code:$('#currency_code').val(),
            update_date:$('#update_date').val(),
            is_auto_update:$('#is_auto_update').val()
        }
    }

</script>
@endsection