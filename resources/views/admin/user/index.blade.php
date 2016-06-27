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
                <h5>后台用户管理</h5>
            </div>
            <div class="ibox-content">
                <div class="row row-lg">
                    <div class="col-sm-12">
                        <form role="form" class="form-inline">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="请输入用户ID" value="" id="userid"
                                       name="userid">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="请输入用户名" value="" id="username"
                                       name="username">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="请输入用户邮箱" value="" id="email"
                                       name="email">
                            </div>
                            <div class="form-group">
                                <select class="form-control chosen-select " id="status" name="status">
                                    <option value="0">请选择状态</option>
                                    <option value="N">禁用账号</option>
                                    <option value="P">等待审核</option>
                                    <option value="Y">审核通过</option>
                                </select>
                            </div>
                            <button class="btn btn-sm btn-success" type="button" id='searchButton'
                                    style="margin-bottom: 0;margin-left:10px;">用户查询
                            </button>
                        </form>
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
                url: "/adm/page/user",
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
                username: $('#username').val(),
                userid: $('#userid').val(),
                email: $('#email').val(),
                status: $('#status').val()

            }
        }

    </script>
@endsection