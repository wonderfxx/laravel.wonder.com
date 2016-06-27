@extends('admin.common.frame')
@section('body_style_class','gray-bg mini-navbar pace-done')
@section('header')
    <link href="/assets/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
    <link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="/assets/css/reset.css" rel="stylesheet">
@endsection
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>订单补发</h5>
            </div>
            <div class="ibox-content">
                <div class="row row-lg">
                    <div class="col-sm-12">
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
                        <button class="btn btn-sm btn-success" type="button" id='searchButton'
                                style="margin-bottom: 0;margin-left:10px;">订单查询
                        </button>
                        {!! Form::close() !!}
                        <table id="dataTableLabel" data-show-columns="true" data-mobile-responsive="true"></table>
                    </div>
                    <div class="clearfix hidden-xs"></div>
                </div>
            </div>
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
    <script type="text/javascript">
        var columns = {!! $headers !!},
                tableHandler = $('#dataTableLabel');
        $(document).ready(function () {

            // 选择插件
            $('.chosen-select').chosen();

            // table 数据
            tableHandler.bootstrapTable({

                // server
                sidePagination: "server", //服务端请求
                method: 'get',
                dataType: "json",
                url: "/adm/page/billingLost",
                queryParams: queryParams,
                responseHandler: responseHandler,

                // page
                pagination: true,
                queryParamsType: "pageSize,pageNumber,menu_status,menu_parent_id",
                pageSize: 10,
                pageNumber: 1,
                pageList: [],

                // setting
                height: $(document).outerHeight - 120,
                singleSelect: false,
                search: false,
                maintainSelected: false,
                strictSearch: false,
                clickToSelect: false,

                showToggle: true,
                showColumns: true,
                showRefresh: false,
                showExport: true,

                striped: true,
                toolbar: "#dataTableLabelToolbar",
                iconSize: "outline",
                icons: {
                    refresh: "glyphicon-repeat",
                    toggle: "glyphicon-list-alt",
                    columns: "glyphicon-list",
                    export: "glyphicon-export"
                },
                columns: columns
            });

            // 查询条件
            $('#searchButton').click(function () {
                tableHandler.bootstrapTable('refresh');
            });

        });

        //接受返回参数
        function responseHandler(resultStr) {
            return {
                "rows": resultStr.data,
                "total": resultStr.total
            }
        }

        //传递的参数
        function queryParams(params) {
            return {
                pageSize: params.pageSize,
                pageNumber: params.pageNumber,
                fg_order_id: $('#fg_order_id').val(),
                channel_order_id: $('#channel_order_id').val(),
                user_id: $('#user_id').val(),
                send_coins_status: $('#send_coins_status').val(),
                channel_status: $('#channel_status').val()
            }
        }

        /**
         * resend
         * @param order_id
         */
        function resend(order_id) {
            $.ajax({
                url: "{{url('adm/billingResend')}}",
                type: "post",
                dataType: "json",
                data: {'order_id': order_id, '_token': '{!! csrf_token() !!}'},
                success: function (data) {
                    alert(data.msg);
                    tableHandler.bootstrapTable('refresh');
                },
                error: function (data) {
                    var errors = data.responseJSON;
                    switch (data.status) {
                        case 302:
                            alert(errors.msg);
                            break;
                        default:
                    }
                }
            });
        }
    </script>
@endsection